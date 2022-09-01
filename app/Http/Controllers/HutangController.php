<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DataTables;
use App\Penjualan;
use App\Pelanggan;
use App\Karyawan; 
use App\Pembelian; 
use App\Barang;
use App\Stok;
use App\MenuDetail;
use Illuminate\Support\Facades\DB;
use App\Harga;
use App\Paket;
use App\Hutang;

class HutangController extends Controller
{
    //
      public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('formHutang');
    }
    
    public function create(Request $request, Hutang $hutang)
    {
//                    dd($request);
                    
                   $sisa_hutang   = $this->konversiAngka($request->sisa_hutang);
                   ($sisa_hutang>0)? $a="ya":$a="tidak";
                   
                    
                  $data                  = $request->all(); 
                  $saldo_hutang = Hutang::where('paket_id',$data['paket_id']) ->sum(DB::raw('debet-kredit'));  
//                    dd($saldo_hutang);
                  $saldo_hutang = $saldo_hutang - $data['jumlah_setor']; 
     
                  if($saldo_hutang==0){
                       $updatePaket = Paket::where('id',$data['paket_id'])->update(['bayar'=>'lunas']);
                  }
                  
             
                  if($saldo_hutang>=0){
                      
                       $updatePaket = Paket::where('id',$data['paket_id'])->update(['status'=>'aktif']);
                      
                        $setor_hutang = $hutang->create([ 
                              'tgl_bayar'     =>date('Y-m-d'),
                              'user_id'         =>1, 
                              'kredit'           =>$data['jumlah_setor'],
                              'paket_id'      =>$data['paket_id'],
                      ]); 
                     Session::flash('msgupdate','Pembayaran  berhasil ditambahkan');
                      return redirect('/tabel-hutang');
                }else{
                    if($saldo_hutang<0){ 
                        $setor_hutang = $hutang->create([ 
                              'tgl_bayar'     =>date('Y-m-d'),
                              'user_id'         =>1, 
                              'debet'           =>$data['jumlah_setor'],
                              'paket_id'      =>$data['paket_id'],
                               ]); 
                          Session::flash('msgupdate','Berhasil simpan, penarikan uang!!');
                    }else{
                          Session::flash('msgupdate','Penginputan pembayaran gagal disimpan, Saldo pembayaran melebihi jumlah hutang!!');
                    }
                       return back();
                } 

    }
 
    public function pelanggan(Request $request, Pelanggan $pelanggan, Barang $barang,Penjualan $penjualan, Harga $harga)
    { 
//            dd($no_transaksi);
           $class_barang                    =   new BarangController(); 
           $class_harga                       =  new HargaController(); 
           $class_penjualan               =  new PenjualanController();
       
         if ($request->has('q')) 
         {
            $cari = $request->q;
            $data = $pelanggan
                    ->where('nama_pelanggan', 'LIKE', '%' . $cari . '%')
                    ->with([
//                        'penjualan',
                        'sales',
                        'paket']);  
                         
           if ($request->jenis=='aktif'){
                   $data->whereHas('paket',function ($query)  { 
                             $query  ->where('status','aktif');
//                             $query  ->where('status','aktif')->orWhere('status','lunas');
                       });
            } 
            
            $data = $data->get();     
                
            if (count($data)>0){ 
//                  dd(count($data));   
               $pelanggan_id = $data[0]['id']; 
               $paket  = Paket::with('menu')->where([
                    ['status','aktif'],
                    ['pelanggan_id',$pelanggan_id],
                ]) ->get();
//                             dd($paket);     
               if (count($paket)>0){
                   
                $menu_id          = $paket[0]['menu_id']; 
                $sales_id           = $data[0]['sales_id'];
                
                $sales_iuran    = $data[0]['sales']['iuran'];
                $level_id           = $data[0]['sales']['level_id'];
//               dd($level_id); 
                $stok = $class_barang->cekStokBarang($barang,$menu_id,$sales_id);
 
                $paket_id                    = $paket[0]['id'];
                $paket_qty                 = $paket[0]['qty'];
                $paket_harga_jual   = $paket[0]['harga_jual'];
                $nama_menu            = $paket[0]['menu']['nama_menu'];
                $harga_paket            = $paket[0]['harga'];
                
                $hitung_hutang_bayar_hutang       = Hutang::where('paket_id',$paket_id)->sum('kredit'); 
                $total_bayar_paket = $paket[0]['total_bayar'];
           
         
//                dd($paket);
                 $history_penjualan       = $class_penjualan->penjualan($penjualan, $pelanggan_id,$paket_id); 
//                dd($paket);
                  if(count($history_penjualan)>0){
                      $history_penjualan = $history_penjualan;
                  }else{
                      $history_penjualan = "0";
                  }
                //penggunaan paket yang dibeli oleh pelanggan
                $penggunaan       = Penjualan::where('paket_id', $paket_id)->sum('qty_jual'); 
                $sisa_paket           = $paket_qty-$penggunaan;
                
                //cek harga pokok
//                    dd($menu_id);
                $harga_pokok        =   $class_harga->cekHargaPokok($harga, $menu_id, $level_id);
            
                $laba_kotor            =    $paket_harga_jual-$harga_pokok->original;
//                dd($laba_kotor);
                $data_tabel = [ 
                    'data' => $data,
                    'pelanggan_id' => "$pelanggan_id",
                    'qty_paket' => "$paket_qty",
                    'sisa_paket' => "$sisa_paket",
                    'penggunaan_paket' => "$penggunaan",
                    'sisa_stok' => '2', 
                    'stok_all' => $stok->original,
                    'history_penjualan' =>$history_penjualan,
                    'harga_pokok' =>"$harga_pokok->original",
                    'harga_jual' =>"$paket_harga_jual",
                    'laba_kotor' =>"$laba_kotor",
                    'nama_menu' =>"$nama_menu",
                    'menu_id' =>"$menu_id",
                    'paket_id' =>"$paket_id",
                    'harga' =>"$harga_paket",   
//                    'total_bayar' =>"$total_bayar_paket",    
                    'total_bayar' =>"$hitung_hutang_bayar_hutang",     
                    'iuran' =>"$sales_iuran",
                    'sales_level' =>"$level_id"
                ];
    //         $data = $data->get();
    //        dd($data);
                return response()->json($data_tabel);
    //        return response()->json($data);
               }        
               
            }
        }
    }
     
     public function getHutangTable(Hutang $hutang)
    {
        $data   =   $hutang->with('paket')->orderby('id','desc')->get();
//        dd($data);
        return DataTables::of($data)
            ->addColumn('action', function ($data) {return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                           
                                <a href="javascript:void(0)" class="icon-button icon-color-red tooltips popovers" data-original-title="Hapus Data" data-content=\'<p>Apakah Anda Yakin?</p>
                                <a class="btn btn-red btn-sm po-delete-hutang" id="'.$data->id.'" href="#">Yakin</a> 
                                    <button class="btn btn-dark-grey po-close">Tidak</button>\' data-toggle="tooltip" data-placement="top">
                                    <i class="fa fa-ban"></i>
                              </a> 
                                <a href="detail-hutang/'.$data->id.'" class="icon-button icon-color-green">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>';
            })
            ->make(true);
    }
 
    public function showHutangById($id)
    {
        $data = Hutang::with('paket')->findOrFail($id); 
      
        $class_barang                     =   new BarangController(); 
        $class_harga                        =  new HargaController(); 
        $class_harga                        =  new HargaController(); 
        $harga_model                     =  new Harga();
        $barang_model                   =  new Barang();
        $penjualan_model             =  new Penjualan(); 
         $penjualan_controller      = new PenjualanController();
        
        $total_bayar_hutang          = Hutang::where('paket_id',$data->paket->id)->sum('kredit'); 
        $penggunaan                       = Penjualan::where('paket_id', $data->paket->id)->sum('qty_jual'); 
        $history_penjualan            =  $penjualan_controller->penjualan($penjualan_model,$data->paket->pelanggan->id,$data->paket->id);  
        $stok                                       = $class_barang->cekStokBarang($barang_model,$data->paket->menu_id,$data->paket->pelanggan->sales_id);
        $stok                                       = $stok->original; 
        $harga_pokok                      =   $class_harga->cekHargaPokok($harga_model, $data->paket->menu_id, $data->paket->pelanggan->sales->level_id);
        $harga_pokok                      = $harga_pokok->original;
        
//        dd($harga_pokok);
        
        $compact = compact(
                        'data',
                        'pelanggan',
                        'penggunaan',
                        'history_penjualan',
                        'harga_pokok',
                        'stok',
                        'total_bayar_hutang'
               );
        return view('formHutangEdit',$compact);
    }
    
    public function update(Request $request,Hutang $hutang)
    {
//        dd($request);
    
      $data = $request->all(); 
      $setor_hutang = $hutang->update([ 
            'user_id'=>1, 
            'kredit'=>$data['jumlah_setor'],
            'paket_id'=>$data['paket_id'],
      ]);
        return back();
        
    }
    
     public function delete(Request $request, Hutang $hutang)
    { 
            $hutang->delete(); 
            return response()->json(true);
    } 
    
    public function konversiAngka($angka)
    {
         $angka= str_replace(".", "", $angka);
         
         return $angka;
    }
      
}
