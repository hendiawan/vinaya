<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Penjualan;
use App\Pelanggan;
use App\Karyawan; 
use App\Pembelian; 
use App\Barang;
use App\Stok;
use App\MenuDetail;
use Illuminate\Support\Facades\DB;
use App\Sales;
use Illuminate\Support\Facades\Session;

class BarangController extends Controller
{
    //
      public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request, Barang $barang)
    {

      $data = $request->all(); 
      $simpan_barang = $barang->create([
            'nama_barang'=>$data['nama_barang'],
            'netto'=>$data['netto'],
            'satuan'=>$data['satuan'],
            'takaran'=>$data['takaran'], 
            'jenisbarang_id'=>$data['jenis_barang']
      ]);
       
        Session::flash('msgupdate','Barang baru berhasil ditambahkan');
        return redirect('/tabel-barang');
        
 
    }
    
    public function cariBarang(Request $request,  Barang $barang)
    {
        $cari = $request->q;
        $data = $barang->where('id',$cari)->get();
        
        return json_encode($data);
    }

    public function cekStokBarang(Barang $barang,$menu_id,$sales_id)
    {
        //ambil barang_id berdasarkan menu yang dipilih
         $data_menu = MenuDetail::select('barang_id')->where('menu_id',$menu_id)->get();
         $barang_id = array();
//            dd($data_menu);
         //simpan id dalam satu array penampungan
         foreach ($data_menu as $data)
         {
             $barang_id[]= $data->barang_id;
         }

//         dd($barang_id);
//         
         //menampilkan data barang berdasarkan menu
         $data_barang = $barang->whereIn('id',$barang_id)->get(); 
         $stok = array();
         $qty   = 5; 
//                    dd($data_barang);
         foreach ($data_barang as $key=>$val)
         {
                    $stokbarang= Stok::
                            where([ 
                            ['sales_id',$sales_id],
                            ['barang_id',$val->id]
                    ])->sum(DB::raw("stok_in-stok_out"));
                
        
//                  $stok_in= Stok::where([
//                                [ 'type','pembelian'],  
//                                ['sales_id',$sales_id],
//                                ['barang_id',$val->id]
//                    ])->sum('stok_in');
////                    
//
////                    
//                    $stok_out= Stok::where([
//                                [ 'type','penjualan'],  
//                                ['sales_id',$sales_id],
//                                ['barang_id',$val->id]
//                    ])->sum('stok_out');
//                                        dd($val->id);
                    $total_stok =  $stokbarang;
                    
                   
                    $porsi   = $total_stok%$val->takaran;
                    $kaleng = ($total_stok-$porsi)/$val->takaran;
                            
                    if ($total_stok>$qty){$status="tersedia";}else{$status="tidak";}
                    
                    $stok[]=[
                        "barang_id"        => $val->id,
                        "sales_id"            => $sales_id,
                        "nama_barang" => $val->nama_barang,
                        "stok"                   => $total_stok,
                        "kebutuhan"       => $qty,
                        "status"                => $status,
                        "takaran"             => $val->takaran,
                        "porsi"                 => $porsi,
                        "kaleng"              => $kaleng,
                    ];
                   
         }
         
//         dd($stok);
         
         return response()->json($stok);
    }

    public function getBarangTable(Barang $barang)
    {
        $data   =  $barang->orderBy('id','desc')->get();
//        dd($data);
        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                              
                             <a href="javascript:void(0)" class="icon-button icon-color-red tooltips popovers" data-original-title="<strong>Hapus Data</strong>" data-content=\'<p>Apakah Anda Yakin?</p>
                                <a class="btn btn-red btn-sm po-delete-barang" id="'.$data->id.'" href="#">Yakin</a> 
                                    <button class="btn btn-dark-grey po-close">Tidak</button>\' data-toggle="tooltip" data-placement="top">
                                    <i class="fa fa-ban"></i>
                              </a> 
                               
                            <a href="detail-barang/'.$data->id.'" class="icon-button icon-color-green">
                                    <i class="fa fa-edit"></i>
                                </a> 
                                
                            </div>'; 
                
            })
            ->make(true);
    }
    
    public function showBarangById($id)
    { 
        $data = Barang::where('id',$id)->first();
//         dd($data);
        return view('formBarangEdit',compact('data'));
    }
    
    public function cekStokBarangBySales(Barang $barang,$sales_id)
    { 
        
        
         $data_sales = Sales::get();
          
         $data_barang = $barang->get(); 
         $stok = array();
         $qty   = 5; 
//                    dd($barang_id);
         foreach ($data_barang as $key=>$val)
         {  
                     $total_stok= Stok::where([
                                [ 'type','pembelian'],  
                                ['sales_id',$sales_id],
                                ['barang_id',$val->id]
                       ])->sum(DB::raw("stok_in-stok_out"));
//                    
 
                    $porsi   = $total_stok%$val->takaran;
                    $kaleng = ($total_stok-$porsi)/$val->takaran;
                            
                    if ($total_stok>$qty){$status="tersedia";}else{$status="tidak";}
                    
                    $stok[]=[
                        "barang_id"        => $val->id,
                        "sales_id"            => $sales_id,
                        "nama_barang" => $val->nama_barang,
                        "stok"                   => $total_stok,
                        "kebutuhan"       => $qty,
                        "status"                => $status,
                        "takaran"             => $val->takaran,
                        "porsi"                 => $porsi,
                        "kaleng"              => $kaleng,
                    ];
                   
         }
         
//         dd($stok);
         
         return $stok;
    }
    
    public function update(Request $request,barang $barang)
    {
//        dd($request); 
            $barang->nama_barang = $request->get('nama_barang',$barang->nama_barang);
            $barang->netto                  = $request->get('netto',$barang->netto);
            $barang->satuan               = $request->get('satuan',$barang->satuan);
            $barang->takaran            = $request->get('takaran',$barang->takaran);
            $barang->jenisbarang_id  = $request->get('jenis_barang',$barang->jenis_barang);
            $barang->save();
            return back();
    }
   
     public function delete(Request $request, Barang $barang)
     { 
            $barang->delete(); 
            return response()->json(true);
     }
    
}
