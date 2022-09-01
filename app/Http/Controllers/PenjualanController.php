<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Penjualan;
use App\Pelanggan;
use App\Karyawan; 
use App\Barang;
use App\Menudetail;
use App\Stok;
use App\Paket;
use App\Http\Controllers\MenuDetailController;
use App\Harga;
use App\PenjualanDetail;
use App\Hutang;
use App\Http\Controllers\PelangganController;
use Illuminate\Support\Facades\Session;
use DB;
use Auth;

class PenjualanController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('ceklogin');
    }
    public function index(Pelanggan $pelanggan)
    {
        
        $data = $pelanggan::with('paket')->orWhere('nama_pelanggan','like', '%umum%')->get();
        
//                dd($data);
           if ( Auth::user()->role == 'AA'||Auth::user()->role == 'OA'||Auth::user()->role == 'SA') {
                    return view('formPenjualan',compact('data')); 
           }else{
                  abort(404);
           }   
     
    }
    
    public function penjualan(Penjualan $penjualan,$pelanggan_id,$paket_id){
    $data   =   $penjualan->with([
                            'paket',
                            'pelanggan', 
                            'sales', 
                            'user']) ->orderBy('tgl_jual','ASC');
        
//        $data->whereHas('pelanggan',function ($query){
//                $query  ->whereHas('sales',function ($query){
//                                    $query ->whereHas('karyawan',function ($query){
//                                                         $query->where('nama_karyawan','YANA');
//                        });   
//                 });   
//          });
          
        $data = $data->where([
            ['pelanggan_id',$pelanggan_id],
            ['paket_id',$paket_id],
        ]);
        $data = $data->get();
//        $barang = Barang::with(['pembelian','menudetail'])->get();
        return $data;
        
//        $data   =   $karyawan->with(['pelanggan'])->get();
//        return response()->json(['data' => $data]);
//        dd($data->nama_menu);
    }
    
    public function karyawan(Karyawan $karyawan)
    {
        $data   =   $karyawan->with(['pelanggan'])->get();
        return response()->json(['data' => $data]);
//        dd($data->nama_menu);
    }
    
     public function getPenjualanTable(Penjualan $penjualan)
     {
        $data   =   $penjualan->with([
                            'paket',
                            'pelanggan', 
                            'sales', 
                            'user'])
                        ->orderBy('tgl_jual','DESC')
                        ->limit(700) 
                        ->get();
//        dd($data);
        return DataTables::of($data) 
            ->addColumn('action', function ($data) {return ' <div class="btn-group btn-group-sm" role="group" aria-label="...">
                            <a href="javascript:void(0)" class="icon-button icon-color-red tooltips popovers" data-original-title="Hapus Data"   data-content=\'<p>Apakah Anda Yakin Menghapus Data Ini?</p>
                            <a class="btn btn-red btn-sm po-delete-penjualan" id="'.$data->id.'" href="#">Yakin</a> 
                                <button class="btn btn-dark-grey po-close">Tidak</button>\' data-toggle="tooltip" data-placement="top">
                              <i class="fa fa-ban"></i>
                            </a>
                            
                            <a href="detail-penjualan/'.$data->id.'" class="icon-button icon-color-green">
                                <i class="fa fa-edit"></i>
                            </a>
                            
                            </div> ';
            })
            ->addColumn('harga_jual', function ($data) {
                return number_format($data->harga_jual,0,',','.');
            }) 
            ->addColumn('nama_pelanggan', function ($data) {
                $nama =  $data->pelanggan->nama_pelanggan;
                if($nama=="UMUM"){$nama =  $data->non_member;}
                return $nama;
            }) 
            ->addColumn('tgl_jual',function ($data) {return date('d-m-Y',strtotime($data->tgl_jual));})
            ->make(true);
    }
    
    public  function create (Request $request,Penjualan $penjualan,Stok $stok,Harga $harga, PenjualanDetail $penjualandetail)
    {
     
        
        $tgl =$request->tgl_transaksi.date(' H:i:s');
//        dd($tgl);
//        dd(date('Y-m-d H:i:s', strtotime('+1 hour',strtotime($tgl))));
        
//        date('Y-m-d H:i:s', strtotime('+1 hour')); 
        
        $menu_detail    = new MenuDetailController(); 
        $data                   = $request->all();  
        
        //untuk mengecek apakah penggunaan paket sudah habis
        if(isset($data['nominal_penggunaan'])){
             $cekTotalPenggunaan = $data['nominal_penggunaan']+($data['harga_jual']*$data['jumlah']);
             if($cekTotalPenggunaan==$data['total_bayar']){
                 $update_paket  = Paket::where('id',$data['paket_id'])->update(['status' =>'habis']);
             }
        } 
//          dd($data); 
         $harga_pokok       = $this->konversiAngka($data['harga_pokok']); 
//         $harga_jual            = $this->konversiAngka($data['harga_jual']);  
         $harga_jual            = $data['harga_jual'];  
//                 dd($harga_jual);
        date_default_timezone_set("Asia/Jakarta");
        date('Y-m-d H:i:s',strtotime('+1 hour')); 
        $cekPenjualan = $penjualan->where('paket_id',$data['paket_id'])->OrderBy('id','desc')->first();
//       echo date('Y-m-d H:i:s').'<br>';
//       echo date('Y-m-d H:i:s',strtotime('+30 seconds',strtotime($cekPenjualan->created_at)));
//       date('Y-m-d', strtotime("+$masa month", strtotime($data['tgl_transaksi'])));
//        dd($cekPenjualan);   
//       dd(date('Y-m-d h:i:s', strtotime('+1 hour ')));
        
         $paket                                     = Paket::where('id',$data['paket_id'])->first();
         $total_penggunaan_paket = Penjualan::
                                                              where('paket_id',$paket->id)
                                                           ->whereBetween('tgl_jual',[$paket->tgl_beli,date('Y-m-d')])
                                                           ->sum('qty_jual')+$data['jumlah'];
         $sisa_paket                            = $paket->qty-$total_penggunaan_paket;
         
//     dd($total_penggunaan_paket);
         if (isset( $data['non_member'])){
             $nama_non_member = $data['non_member'];
         }else{
             $nama_non_member = "";
         }
         
//         dd($nama_non_member);
        $data_penjualan = $penjualan->create([
            'tgl_jual'                    =>date('Y-m-d H:i:s', strtotime('+1 hour',strtotime($tgl))),
            'pelanggan_id'        =>$data['pelanggan_id'],
            'user_id'                   =>1,
            'paket_id'                 =>$data['paket_id'],
            'sales_id'                  =>$data['sales_id'],
            'menu_id'                 =>$data['menu_id'],
            'qty_jual'                  =>$data['jumlah'],
            'harga_pokok'        =>$harga_pokok,
            'harga_jual'             =>$harga_jual, 
            'diskon'                    =>0,
            'qty_paket'              =>$paket->qty,
//            'total_pengunaan_paket'  =>$total_penggunaan_paket,
//            'sisa_paket'              =>$sisa_paket,
            'iuran'                       =>$data['iuran'],
            'created_at'             => date('Y-m-d H:i:s', strtotime('+1 hour',strtotime($tgl))),
            'updated_at'           =>  date('Y-m-d H:i:s', strtotime('+1 hour',strtotime($tgl))),
//            'laba_kotor'            =>$this->konversiAngka($data['harga_jual'])-$this->konversiAngka($data['harga_pokok']),
            'laba_kotor'            =>$harga_jual-$this->konversiAngka($data['harga_pokok']),
            'non_member'       =>$nama_non_member,
        ]);
        
         $menu_detail            = $menu_detail->cekMenuDetail($harga, $data['menu_id'], $data['sales_level']);   
         $sava_data                 = array();
                
         foreach ($menu_detail as $key=>$value)
         {
//             dd($value);
//             $persentase_barang      = round(($value->harga_perporsi/$harga_pokok)*100);
//             $harga_pokok_dasar     = round($harga_pokok*$persentase_barang/100);
//             $harga_pokok_jual         = round($harga_jual*$persentase_barang/100); 
             $persentase_barang      =  ($value->harga_perporsi/$harga_pokok)*100;
             $harga_pokok_dasar     =  ($harga_pokok*$persentase_barang)/100;
             $harga_pokok_jual         = ($harga_jual*$persentase_barang)/100; 
             $laba_kotor                      = $harga_pokok_jual-$harga_pokok_dasar;
            
             $save_penjualan_detail = $penjualandetail->create([
                 'tgl_jual'            =>date('Y-m-d',strtotime($data['tgl_transaksi'])),
                 'qty'                    =>$data['jumlah'],
                 'barang_id'       =>$value->barang_id, 
                 'penjualan_id' =>$data_penjualan['id'],  
                 'sales_id'          =>$data['sales_id'],  
                 'harga_pokok'=>$harga_pokok_dasar,  
                 'harga_jual'     =>$harga_pokok_jual,   
                 'laba_kotor'    =>$laba_kotor,   
                 'iuran'              =>$data['iuran']
              ]);
//              $sava_data[]=[
//                  $persentase_barang,
//                  $harga_pokok_barang,
//                  
//              ];
             
             $data_stok = $stok->create([
                 'tgl'                  =>date('Y-m-d',strtotime($data['tgl_transaksi'])),
                 'sales_id'        =>$data['sales_id'],
                 'barang_id'    =>$value->barang_id,
                 'stok_out'      =>$data['jumlah'],
                 'type'              =>'penjualan',
                 'type_id'         =>$data_penjualan['id'],
             ]); 
             
         }
//                    dd($sava_data);
          Session::flash('msgupdate','Penjualan  berhasil ditambahkan');
          return redirect('/tabel-penjualan');
        
    }
    
    public function konversiAngka($angka)
    {
         $angka= str_replace(".", "", $angka);
         
         return $angka;
    }
    
    public function showPenjualanById($id)
    {
        $class_barang                     =   new BarangController(); 
        $class_harga                        =  new HargaController(); 
        $class_harga                        =  new HargaController(); 
        $harga_model                     =  new Harga();
        $barang_model                   =  new Barang();
        $penjualan_model             =  new Penjualan();
        $data                                      = Penjualan::with('pelanggan','paket','sales')->findOrFail($id);
        $pelanggan                           = pelanggan::where('nama_pelanggan','UMUM')->get();
        $total_bayar_hutang          = Hutang::where('paket_id',$data->paket_id)->sum('kredit');
        $penggunaan                       = Penjualan::where('paket_id', $data->paket_id)->sum('qty_jual'); 
        $history_penjualan            =  $this->penjualan($penjualan_model,$data->pelanggan_id,$data->paket_id); 
//        dd($history_penjualan);
        
        $stok                                       = $class_barang->cekStokBarang($barang_model,$data->paket->menu_id,$data->sales_id);
        $stok                                       = $stok->original;
//        dd($pelanggan);
        $harga_pokok                      =   $class_harga->cekHargaPokok($harga_model, $data->paket->menu_id, $data->sales->level_id);
        $harga_pokok                      = round($harga_pokok->original);
//   dd($data);
        $compact = compact(
                            'data',
                            'pelanggan',
                            'penggunaan',
                            'history_penjualan',
                            'harga_pokok',
                            'stok',
                            'total_bayar_hutang'
                   );
        if($data->paket->status!=='umum')
        {
             return view('formPenjualanEdit',$compact);
        }else{
              return view('formPenjualanEditNonMember',$compact);
        }
     
    }
    
    public function showPenjualanQrScan($id)
    {
//        dd($request);
           $class_pelanggan              = new PelangganController();  
           $class_barang                     = new BarangController(); 
           $class_harga                       =  new HargaController();  
           $model_penjualan            = new Penjualan();  
           $no_transaksi                     = $class_pelanggan->setKodeRegistrasi($model_penjualan, 'PJ','tgl_jual');
           $pelanggan                          = new Pelanggan();
           $barang                                 =new Barang();
           $penjualan                           = new Penjualan();
           $harga                                   = new Harga();
            $cari = dekripsi($id);
//            dd($cari);
            $data = $pelanggan
                    ->where('pelanggans.id',$cari)
                    ->with([
//                        'penjualan',
                        'sales',
                        'paket']) ;
            
//          $data= $data
                       
           $data = $data->first();    
           
           $cek=!is_null($data); 
//           dd($data);
//           dd($cek=!is_null($data));
           
           if ($cek==true)
           {  
               $pelanggan_id = $data->id;
               $paket  = Paket::with('menu')->where('pelanggan_id',$pelanggan_id)
                                    ->whereIn('status',['aktif','habis'])->orderBy('id','desc')->limit(1)->get();
//                             dd($paket);     
               if (count($paket)>0){
                   
                $menu_id          = $paket[0]['menu_id']; 
                $sales_id           =  $data->sales_id; 
                $sales_iuran    =  $data->sales->iuran;  
                $level_id            = $data->sales->level_id;
//               dd($level_id); 
                $stok = $class_barang->cekStokBarang($barang,$menu_id,$sales_id);
//                dd($stok);
                $stok =$stok->original;
//                dd($stok[0]);
                $data_stok =array();
                //memasukkan nilai stok kedalam array
                foreach ($stok as $datastok=>$value)
                { 
                    $data_stok[]=$value['stok'];
                } 
                //mengambil nilai stok terendah dari array
                $stok_terkecil = (min($data_stok));
                
                $paket_id                    = $paket[0]['id'];
                $paket_qty                 = $paket[0]['qty'];
                $paket_harga_jual   = $paket[0]['harga_jual'];
                $nama_menu            = $paket[0]['menu']['nama_menu'];
                $harga_paket            = $paket[0]['harga'];
                $status_bayar            = $paket[0]['bayar'];
                $status_paket            = $paket[0]['status'];
                $tgl_kadaluarsa        = date('d-m-Y',strtotime($paket[0]['tgl_kadaluarsa']));
                $hari_ini            =   strtotime(date('Y-m-d H:i:s' ));
                $kadaluarsa     =   strtotime($tgl_kadaluarsa);
//                              dd($kadaluarsa);
                if(  $hari_ini> $kadaluarsa) {
                      $status_kadaluarsa = "Kadaluarsa";
                }else{
                      $status_kadaluarsa = "Belum";
                }
                
                
                $total_nominal_penggunaan =Penjualan::where('paket_id', $paket_id)->sum(DB::raw('harga_jual*qty_jual')); 
//                dd($total_nominal_penggunaan);
                $hitung_hutang_bayar_hutang       = Hutang::where('paket_id',$paket_id)->sum('kredit'); 
                $total_bayar_paket = $paket[0]['total_bayar']; 
//                dd($paket);
                 $history_penjualan       = $this->penjualan($penjualan, $pelanggan_id,$paket_id); 
//                dd($history_penjualan);
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
                    $pelanggan_id = $pelanggan_id;
                    $qty_paket=$paket_qty;
                    $sisa_paket=$sisa_paket;
                    $penggunaan_paket = $penggunaan;
                    $sisa_stok='2';
                    $stok=$stok;
                    $history_penjualan=$history_penjualan;
                    $harga_pokok=round($harga_pokok->original);
                    $harga_jual=$paket_harga_jual;
                    $laba_kotor=round($laba_kotor);
                    $nama_menu=$nama_menu;
                    $menu_id = $menu_id;
                    $paket_id = $paket_id;
                    $harga = round($harga_paket);   
//                    'total_bayar' =>"$total_bayar_paket; 
                    $total_bayar=$hitung_hutang_bayar_hutang;  
                    $no_transaksi=$no_transaksi;
                    $iuran=$sales_iuran;
                    $sales_level=$level_id;
                
//                dd($stok);
             
                 $compact = compact(
                                'data'    ,
                                'pelanggan_id',
                                'qty_paket' ,
                                'sisa_paket',
                                'total_nominal_penggunaan',
                                'penggunaan_paket',
                                'sisa_stok' ,
                                'stok' ,
                                'stok_terkecil' ,
                                'history_penjualan' ,
                                'harga_paket' ,
                                'harga_pokok' ,
                                'harga_jual' ,
                                'laba_kotor',
                                'nama_menu' ,
                                'menu_id' ,
                                'paket_id' ,
                                'harga', 
                                'total_bayar',   
                                'no_transaksi' ,
                                'tgl_kadaluarsa' ,
                                'status_kadaluarsa' ,
                                'status_paket' ,
                                'status_bayar' ,
                                'iuran' ,
                                'sales_level' 
                      );
//               return response()->json($data_tabel);
               return view('formPenjualanByQr',$compact);
   
               }        
               
            }else{
                return  redirect('/dashboard')->with('message','Paket anda tidak terdaftar atau sudah Habis, Silahkan Registrasi Paket kembali');
            }
    }
    
    public function update(Request $request, Penjualan $penjualan)
    {
        
//                $data_penjualan= Penjualan::findOrFail();
//             dd($request->tgl_transaksi);
        
                 $menu_detail        = new MenuDetailController(); 
                 $harga                     = new Harga(); 
                 $penjualandetail  = new PenjualanDetail(); 
                 $stok                        = new Stok(); 
                 $data                        = $request->all();   
                 
                    if (isset( $data['non_member'])){
                        $nama_non_member = $data['non_member'];
                    }else{
                        $nama_non_member = "";
                    }
                 
                 $harga_pokok       = $data['harga_pokok'];
                 $harga_jual            = $data['harga_jual'];   
                 
                 $paket                                     = Paket::where('id',$data['paket_id'])->first();
                 $total_penggunaan_paket = Penjualan::
                                                              where('paket_id',$paket->id)
                                                           ->whereBetween('tgl_jual',[$paket->tgl_beli,$penjualan->tgl_jual])
                                                           ->sum('qty_jual')+$data['jumlah']-$penjualan->qty_jual;
                 $sisa_paket                            = $paket->qty-$total_penggunaan_paket;
      
//                    dd($total_penggunaan_paket);
                 $tgl =$data['tgl_transaksi'].date(' H:i:s');
//                 dd($tgl);
                 $penjualan-> tgl_jual=date('Y-m-d',strtotime($tgl));
                 $penjualan->pelanggan_id=$data['pelanggan_id'];
                 $penjualan->user_id=1;
                 $penjualan->non_member=$nama_non_member;
                 $penjualan->paket_id=$data['paket_id'];
                 $penjualan->menu_id=$data['menu_id'];
                 $penjualan->sales_id=$data['sales_id'];
                 $penjualan->qty_jual=$data['jumlah'];
                 $penjualan->harga_pokok=$harga_pokok;
                 $penjualan->harga_jual=$harga_jual; 
                 $penjualan->diskon=0;
                 $penjualan->qty_paket=$paket->qty;
//                 $penjualan->total_pengunaan_paket=$total_penggunaan_paket;
//                 $penjualan->sisa_paket=$sisa_paket;
                 $penjualan->iuran=$data['iuran'];
                 $penjualan->laba_kotor=$data['harga_jual']-$data['harga_pokok'];
                 $penjualan->updated_at=  date('Y-m-d H:i:s', strtotime('+1 hour',strtotime($tgl)));
                 $penjualan->save();

        
         $menu_detail       = $menu_detail->cekMenuDetail($harga, $data['menu_id'], $data['sales_level']);   
         
         
         foreach ($menu_detail as $key=>$value)
         {
//             dd($value);
             
//             $persentase_barang     = round(($value->harga_perporsi/$harga_pokok)*100);
//             $harga_pokok_dasar     = round($harga_pokok*$persentase_barang/100);
//             $harga_pokok_jual         = round($harga_jual*$persentase_barang/100); 
//             $laba_kotor                      = $harga_pokok_jual-$harga_pokok_dasar;
             
             $persentase_barang      =  ($value->harga_perporsi/$harga_pokok)*100;
            
             $harga_pokok_dasar     =  ($harga_pokok*$persentase_barang)/100;
             $harga_pokok_jual         = ($harga_jual*$persentase_barang)/100; 
//              dd($harga_pokok_jual);
             $laba_kotor                      = $harga_pokok_jual-$harga_pokok_dasar;
        
             //update untuk detail penjualan
             $save_penjualan_detail = $penjualandetail->where(
                     [
                        [   'penjualan_id',$penjualan['id']],
                        [   'barang_id',$value->barang_id],
                        [   'sales_id',$data['sales_id']]
                     ] 
                     )
                 ->update([
                        'tgl_jual'          =>date('Y-m-d',strtotime($tgl)),
                        'qty'                   =>$data['jumlah'],
                        'barang_id'      =>$value->barang_id, 
                        'penjualan_id'=>$penjualan['id'],  
                        'sales_id'          =>$data['sales_id'],  
                        'harga_pokok'=>$harga_pokok_dasar,  
                        'harga_jual'     =>$harga_pokok_jual,   
                        'laba_kotor'    =>$laba_kotor,   
                        'iuran'              =>$data['iuran']
              ]); 
           
             //update untuk data stok
             $data_stok = $stok->where([
                        ['type','penjualan'],
                        ['type_id',$penjualan['id']],
                        ['barang_id',$value->barang_id],
                 ])  
                  ->update([
                        'tgl'=>date('Y-m-d',strtotime($tgl)),
                        'sales_id'=>$data['sales_id'],
                        'barang_id'=>$value->barang_id,
                        'stok_out'=>$data['jumlah'],
                        'type'=>'penjualan',
                        'type_id'=>$penjualan['id'],
             ]); 
        }
        
        return back();
    }
    
    public function delete(Request $request, Penjualan $penjualan)
    {
//            dd($penjualan);
            $update_paket = Paket::where([
                ['id',$penjualan->paket_id],
                ['status','!=','umum'],
            ])->update(['status' =>'aktif']);
            
            $penjualan->delete();
            //delete detail penjualan
            $delete_penjualan_detail        = PenjualanDetail::where('penjualan_id',$penjualan->id)->delete();
            //delete stok
            $delete_stok   = Stok::where([
                ['type_id',$penjualan->id],
                ['type','penjualan'],
            ])->delete();
            
            return response()->json(true);
    }
    
    
}
