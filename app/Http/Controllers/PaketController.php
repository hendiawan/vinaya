<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Paket;
use App\Hutang;
use App\Penjualan;
use App\Stok;
use Illuminate\Support\Facades\DB; 
//use App\Http\Controllers\MenuDetailController;
use App\Harga;
use App\Http\Controllers\HargaController;
use App\PenjualanDetail;
use Illuminate\Support\Facades\Session;

class PaketController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function createPaket(Request $request,Paket $paket, Hutang $hutang)
    {
            $data               =  $request->all();
//            dd($data);
            $masa             =  $data['masa_kadaluarsa']; 
            $tgl_akhir      =   date('Y-m-d', strtotime("+$masa month", strtotime($data['tgl_transaksi'])));
        
        
        $simpan_paket = $paket->create([
            'pelanggan_id'=>$data['pelanggan_id'],
            'tgl_beli'=>date('Y-m-d',strtotime($data['tgl_transaksi'])),
            'menu_id'=>$data['menu_id'],
            'harga'=>$data['harga'],
            'qty'=>$data['qty'],
            'harga_jual'=>$data['harga_jual'],
            'total_bayar'=>$data['total_bayar'],
            'status'=>$data['status_paket'],
            'masa_kadaluarsa'=>$data['masa_kadaluarsa'],
            'tgl_kadaluarsa'=>$tgl_akhir,
            'bayar'=>$data['status_bayar'],
        ]);
        
        $simpan_hutang = $hutang->create([
                    'tgl_bayar'=>date('Y-m-d',strtotime($data['tgl_transaksi'])),
                    'user_id'=>'1',
                    'debet'=>$data['harga'],
                    'kredit'=>$data['total_bayar'],
                    'paket_id'=>$simpan_paket['id'],
        ]);
        
     Session::flash('msgupdate','Paket baru berhasil ditambahkan');
     return redirect('/tabel-paket');
    }
     
    public function getPaketTable(Paket $paket)
    {
        $data             =   $paket->with('menu','pelanggan')->whereNotIn('id', [1])->orderby('tgl_beli','desc')->get();
     
         
//        dd($data);
        return DataTables::of($data)
            ->addColumn('action', function ($data) {return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                           
                            <a href="javascript:void(0)" class="icon-button icon-color-red tooltips popovers" data-original-title="Hapus Data" data-content=\'<p>Apakah Anda Yakin?</p>
                                <a class="btn btn-red btn-sm po-delete-paket" id="'.$data->id.'" href="#">Yakin</a> 
                                    <button class="btn btn-dark-grey po-close">Tidak</button>\' data-toggle="tooltip" data-placement="top">
                                    <i class="fa fa-ban"></i>
                              </a>   

                            <a href="detail-paket/'.$data->id.'" class="icon-button icon-color-green">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>';  })
             ->addColumn('totalbayar',function($data){
                 $totalBayar = Hutang::where('paket_id',$data->id)->sum('kredit'); 
                 return $totalBayar;
             })
            ->make(true);
    }
    
    public function showPaketById($id)
    {
            $data = Paket::with('menu','pelanggan')->findOrFail($id); 
//            dd($data);
            return view('formPaketEdit',compact('data')); 
    }
    
    public function update(Request $request, Paket $paket)
    { 
           $data               = $request->all(); 
//           dd($data);
//           echo $data['qty'];
//           $saldo_hutang = Hutang::where('paket_id',$paket->id) ->sum(DB::raw('debet-kredit'));  
//           dd($saldo_hutang);
           //cek jika qty paket baru lebih besar dari paket lama maka status bayarnya menjadi "hutang"
           if($data['qty']>$paket->qty){$statusbayar="hutang";}else{$statusbayar=$data['status_bayar'];}
           
           $hutang          = new Hutang(); 
           $masa             =  $data['masa_kadaluarsa']; 
           $tgl_akhir      =   date('Y-m-d', strtotime("+$masa month", strtotime($paket->tgl_beli)));
           
           $this->updateDetailPaketPenjualan($paket,$request);
//            dd($data_penjualan); 
        $simpan_paket = $paket->update([
            'pelanggan_id'  =>$data['pelanggan_id'],
            'tgl_beli'=>date('Y-m-d',strtotime($data['tgl_transaksi'])),
            'menu_id'          =>$data['menu_id'],
            'harga'               =>$data['harga'],
            'qty'                    =>$data['qty'],
            'harga_jual'      =>$data['harga_jual'],
//            'total_bayar'=>$data['total_bayar'],
            'status'              =>$data['status_paket'],
            'masa_kadaluarsa'=>$data['masa_kadaluarsa'],
            'tgl_kadaluarsa'=>$tgl_akhir,
            'bayar'=>$statusbayar,
        ]);
         
          
//        $tgl_beli_paket = date('Y-m-d', strtotime($data['tgl_transaksi'])); 
//        dd($tgl_beli_paket);
        $tgl_beli_paket = date('Y-m-d', strtotime($paket->tgl_beli)); 
//        dd($tgl_beli_paket);
//        dd($tgl_beli_paket);
      
        $update_ = $hutang->where([
                    ['tgl_bayar',$tgl_beli_paket],
                    ['paket_id',$paket->id],
                    ['debet','>',0],
                ])->first();
        
//        dd($update_);
        $update_hutang = $hutang->where([
                    ['tgl_bayar',$tgl_beli_paket],
                    ['paket_id',$paket->id],
                    ['debet','>',0],
                ])
                 ->update([ 
                    'user_id'=>'1',
                    'debet'=>$data['harga'],
                    'tgl_bayar'=>date('Y-m-d', strtotime($data['tgl_transaksi'])),
//                    'kredit'=>$data['total_bayar'],
                    'paket_id'=>$paket->id,
        ]);
        
          Session::flash('msgupdate','Paket Berhasil diupdate !');
//           return back();  
           return  redirect('/tabel-paket');;  
    }
    
    public function updateDetailPaketPenjualan($paket,$request)
    {
           $harga                    = new Harga(); 
           $menudetail         = new MenuDetailController(); 
           $class_harga         =  new HargaController();  
           $penjualandetail  = new PenjualanDetail(); 
           $data_penjualan   = Penjualan::with('sales')->where('paket_id',$paket->id)->get();  
           
         
           foreach ($data_penjualan as $data)
           { 
               
//                 dd($data->sales->level_id); 
                 $harga_pokok       = $class_harga->cekHargaPokok($harga, $data->menu_id, $data->sales->level_id);
                 $harga_pokok        = round($harga_pokok->original);
                 $harga_jual             = $request->harga_jual;    
                 $laba_kotor            = $harga_jual - $harga_pokok; 
//                          dd($data->sales->level_id); 
                 $menu_detail         = $menudetail->cekMenuDetail($harga, $data->menu_id, $data->sales->level_id);   
//                 dd($penjualan);
                 $penjualan             = Penjualan::where('id',$data->id)
                                                    ->update([ 
                                                                   'harga_pokok'=>$harga_pokok,  
                                                                   'harga_jual'     =>$harga_jual,   
                                                                   'laba_kotor'    =>$laba_kotor,    
                                                         ]); 
                 
//                 $harga_pokok       =   $class_harga->cekHargaPokok($harga, $data->menu_id, $data->sales->level_id); 
//                        dd($harga_pokok);
                              foreach ($menu_detail as $key=>$value)
                             { 
                                $persentase_barang      =  ($value->harga_perporsi/$harga_pokok)*100; 
                                $harga_pokok_dasar     =  ($harga_pokok*$persentase_barang)/100;
                                $harga_pokok_jual         = ($harga_jual*$persentase_barang)/100; 
//                                 dd($data);
                                $laba_kotor                      = $harga_pokok_jual-$harga_pokok_dasar;

                                //update untuk detail penjualan
                                $save_penjualan_detail = $penjualandetail->where(
                                        [
                                           [   'penjualan_id',$data->id],
                                           [   'barang_id',$value->barang_id], 
                                        ] 
                                        )
                                    ->update([ 
                                           'harga_pokok'=>$harga_pokok_dasar,  
                                           'harga_jual'     =>$harga_pokok_jual,   
                                           'laba_kotor'    =>$laba_kotor,    
                                 ]);  
                            
                           }
           }
    }
    
    
    public function delete(Request $request, Paket $paket)
    { 
          //hapus penerimaan uang/hutang
            $hutang         = Hutang::where('paket_id',$paket->id)->delete();  
          //hapus stok barang
            $penjualan   = Penjualan::where('paket_id',$paket->id)->get();
            $this->hapus_detail_penjualan_dan_stok($penjualan,$paket->id);
          //hapus penjualan 
            $penjualan   = Penjualan::where('paket_id',$paket->id)->delete();
            //hapus paket
            $paket->delete();  
            
            return response()->json(true);
    }
    
    
    public function hapus_detail_penjualan_dan_stok($penjualan){
        foreach ($penjualan as $data)
        {  
            $delete_stok   = Stok::where([
                ['type_id',$data->id],
                ['type','penjualan'],
            ])->delete(); 
            $penjualan   = Penjualan::where('penjualan_id',$data->id)->delete();
        }
    }
    
    
}
