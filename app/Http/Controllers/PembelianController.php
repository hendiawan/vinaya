<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Penjualan;
use App\Pelanggan;
use App\Karyawan; 
use App\Barang;
use App\MenuDetail;
use App\Stok;
use App\Paket;
use App\Http\Controllers\MenuDetailController;
use App\Harga;
use App\PenjualanDetail;
use App\Pembelian;
use App\Http\Controllers\HargaController;
use App\Supplier;
use Illuminate\Support\Facades\Session;

class PembelianController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
 
     public function getPembelianTable(Pembelian $pembelian)
     {
        $data   =   $pembelian->orderBy('id','desc')->with([
                            'barang',
                            'sales' ])
                        ->get();
//        dd($data);
        return DataTables::of($data)
            ->addColumn('action', function ($data) {return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                               
                             <a href="javascript:void(0)" class="icon-button icon-color-red tooltips popovers" data-original-title="Hapus Data" data-content=\'<p>Apakah Anda Yakin?</p>
                                <a class="btn btn-red btn-sm po-delete-pembelian" id="'.$data->id.'" href="#">Yakin</a> 
                                    <button class="btn btn-dark-grey po-close">Tidak</button>\' data-toggle="tooltip" data-placement="top">
                                    <i class="fa fa-ban"></i>
                              </a> 

                                 <a href="detail-pembelian/'.$data->id.'" class="icon-button icon-color-green">
                                    <i class="fa fa-edit"></i>
                                 </a>
                            </div>';
            })
            ->make(true);
    }
    
    public  function create (Request $request,Pembelian $pembelian,Stok $stok)
    {
//         dd($request); 
        $data  = $request->all();   
        $harga_pokok       = $this->konversiAngka($data['harga_pokok']); 
        $data_pembelian = $pembelian->create([
            'tgl_beli'       =>date('Y-m-d',strtotime($data['tgl_transaksi'])),
            'barang_id'  =>$data['barang_id'],
            'qty'               =>$data['qty'],
            'sales_id'      =>$data['sales_id'],
            'supplier_id'=>$data['supplier_id'], 
            'stok'       =>$data['takaran'], 
            'harga_pokok'=>$this->konversiAngka($data['harga_pokok']), 
        ]);
        
        $data_stok = $stok->create([
            'tgl'                    =>date('Y-m-d',strtotime($data['tgl_transaksi'])),
            'sales_id'          =>$data['sales_id'],
            'barang_id'      =>$data['barang_id'], 
            'stok_in'           =>$data['stok_saji'], 
            'type'                =>'pembelian',  
            'type_id'           =>$data_pembelian['id'],  
        ]);
        
        Session::flash('msgupdate','Pembelian baru berhasil ditambahkan');
        return redirect('/tabel-pembelian');
        
    }
    
    public function konversiAngka($angka)
    {
         $angka= str_replace(".", "", $angka);
         
         return $angka;
    }
    
    public function showPembelianById($id)
    { 
        $supplier               = Supplier::get(); 
         $data                       = Pembelian::with('sales','barang','supplier')->findOrFail($id);  
         return view('formPembelianEdit',compact('data','supplier'));
    }
    
    public function update(Request $request,Pembelian $pembelian, Stok $stok)
    {
//        dd($request); 
        $pembelian->barang_id     =$request->get('barang_id');
        $pembelian->qty                   =$request->get('qty');
        $pembelian->sales_id          =$request->get('sales_id');
        $pembelian->supplier_id   =$request->get('supplier_id');
        $pembelian->stok                  =$request->get('takaran');
        $pembelian->harga_pokok=$request->get('harga_pokok');
        $pembelian->save();
        
        
          $data_stok = $stok->where([
                    ['type_id',$pembelian['id']],
//                    ['sales_id',$request->get('sales_id')],
                    ['type','pembelian'], 
          ])
             ->update([ 
                    'sales_id'          =>$request->get('sales_id'),
                    'barang_id'      =>$request->get('barang_id'), 
                    'stok_in'           =>$request->get('stok_saji'), 
                    'type'                =>'pembelian',  
                    'type_id'           =>$pembelian['id'],  
        ]);
          
        return back();
    }
    
    public function delete(Request $request, Pembelian $pembelian)
    {
//          
//         dd($pembelian);
            $pembelian->delete(); 
           
            $delete_stok   = Stok::where([
                ['type_id',$pembelian->id],
                ['type','pembelian'],
            ])->delete();
            
            return response()->json(true);
    }
}
