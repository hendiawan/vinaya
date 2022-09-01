<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Session;
use App\Harga;
use App\MenuDetail; 
use App\Http\Controllers\BarangController;
use App\Barang;
use App\Menu; 
class MenuDetailController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function cekMenuDetail(Harga $harga,$menu_id,$level_id)
    {   
          //ambil barang_id berdasarkan menu terentu
            $menu_detail = MenuDetail::select('barang_id')->where('menu_id',$menu_id)->get(); 
//         dd($menu_id);       
         
            $barang_id = array();
            
            //memasukkan barang_id dalam satu array
            
            foreach ($menu_detail as $data_barang)
            {
               $barang_id[]=  $data_barang->barang_id; 
            }
            
            //cek harga barang berdasarkan barang_id dan level sales
            $data = $harga
                    ->wherein('barang_id',$barang_id)
                    ->where('level_id',$level_id)
                    ->get() ;
         
            return $data;
    } 
    
    public function create(Request $request,Menu $menu)
    {
        $data = $request->all();
//        dd($request);
        
        $simpan_menu = $menu->create([
                    'nama_menu'=>$data['nama_menu'],
                    'harga'=>$data['harga'],
                    'qty'=>$data['qty'],
                    'harga_jual'=>$data['harga_jual'],
                    'kadaluarsa'=>$data['masa_kadaluarsa'],
        ]);
        
        Session::flash('msgupdate','Selanjutnya silahkan input menu detail !!');
        return redirect('/menudetail');
        
    }
      
    public function createMenuDetail(Request $request,MenuDetail $menudetail)
    {
        $data = $request->all(); 
        $simpan_menu = $menudetail->create([ 
                    'menu_id'=>$data['menu_id'],
                    'barang_id'=>$data['barang_id'],
                    'takaran'=>$data['takaran'], 
        ]); 
       Session::flash('msgupdate','Menu Detail berhasil ditambahkan');
        return redirect('/tabel-menu-detail');
    }
    
     public function pilihMenu(Menu $menu, Request $request)
    {
      
         if ($request->has('q')) 
         { 
            $cari = $request->q;
            $data = $menu::where('nama_menu','LIKE', '%' . $cari . '%')->get();     
//          dd($data);
            if (count($data)>0){
           
                $data_tabel = [  
                        'data' => $data,  
                ];  
                
                return json_encode($data_tabel); 
            }
        }
    }
    
      public function getMenuTable(Menu $menu)
     {
        $data                   =   $menu->orderBy('id','desc')->get();
     
//        dd($data);
        return DataTables::of($data)
            ->addColumn('action', function ($data) {return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                               
                                <a href="javascript:void(0)" class="icon-button icon-color-red tooltips popovers" data-original-title="Hapus Data" data-content=\'<p>Apakah Anda Yakin?</p>
                                <a class="btn btn-red btn-sm po-delete-menu" id="'.$data->id.'" href="#">Yakin</a> 
                                    <button class="btn btn-dark-grey po-close">Tidak</button>\' data-toggle="tooltip" data-placement="top">
                                    <i class="fa fa-ban"></i>
                              </a> 

                                <a href="detail-menu/'.$data->id.'" class="icon-button icon-color-green">
                                    <i class="fa fa-edit"></i>
                                </a>
                                
                                <a target="_BLANK" href="/list-menu-detail?id='.$data->id.'" class="icon-button icon-color-orange">
                                    <i class="fa fa-list"></i>
                                </a>
                                
                            </div>';
            })
            ->addColumn('total',function($data){
                $menudetail = MenuDetail::where('menu_id',$data->id)->count('id');
//                dd($menudetail);
                return  $menudetail;
            })
            ->make(true);
    }
    
      public function getMenuDetailTable(MenuDetail $menudetail)
     {
        $data   =   $menudetail->with('menu','barang')->orderBy('id','desc')->get();
//        dd($data);
        return DataTables::of($data)
            ->addColumn('action', function ($data) {return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a href="javascript:void(0)" class="icon-button icon-color-red tooltips popovers" data-original-title="Hapus Data" data-content=\'<p>Apakah Anda Yakin?</p>
                                <a class="btn btn-red btn-sm po-delete-menu-detail" id="'.$data->id.'" href="#">Yakin</a> 
                                    <button class="btn btn-dark-grey po-close">Tidak</button>\' data-toggle="tooltip" data-placement="top">
                                    <i class="fa fa-ban"></i>
                              </a> 
                               <a href="detail-menudetail/'.$data->id.'" class="icon-button icon-color-green">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>';
            })
            ->make(true);
    }
      public function getMenuDetailTableById($id,MenuDetail $menudetail)
     {
//          dd($id);
        $data   =   $menudetail->with('menu','barang')->where('menu_id',$id)->orderBy('id','desc')->get();
//        dd($data);
        return DataTables::of($data)
            ->addColumn('action', function ($data) {return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a href="javascript:void(0)" class="icon-button icon-color-red tooltips popovers" data-original-title="Hapus Data" data-content=\'<p>Apakah Anda Yakin?</p>
                                <a class="btn btn-red btn-sm po-delete-menu-detail" id="'.$data->id.'" href="#">Yakin</a> 
                                    <button class="btn btn-dark-grey po-close">Tidak</button>\' data-toggle="tooltip" data-placement="top">
                                    <i class="fa fa-ban"></i>
                              </a> 
                               <a href="detail-menudetail/'.$data->id.'" class="icon-button icon-color-green">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>';
            })
            ->make(true);
    }
    
    public function showMenuById($id)
    {
            $data = Menu::findOrFail($id); 
//            dd($data);
            return view('formMenuEdit',compact('data')); 
    }
    
    public function update(Request $request,Menu $menu)
    {
         $data = $request->all();
//        dd($request);
        
        $simpan_menu = $menu
                 ->update([
                    'nama_menu'=>$data['nama_menu'],
                    'harga'=>$data['harga'],
                    'qty'=>$data['qty'],
                    'harga_jual'=>$data['harga_jual'],
                    'kadaluarsa'=>$data['masa_kadaluarsa'],
        ]);
        
        return back();
    }

     public function showMenuDetailById($id)
    {
            $data = MenuDetail::with('menu','barang')->findOrFail($id); 
//            dd($data);
            return view('formMenuDetailEdit',compact('data')); 
    }
    
    public function updateMenuDetail(Request $request, MenuDetail $menudetail)
    { 
           $data = $request->all(); 
           $simpan_menudetail = $menudetail->update([ 
                       'menu_id'=>$data['menu_id'],
                       'barang_id'=>$data['barang_id'],
                       'takaran'=>$data['takaran'], 
           ]); 
           return back();  
    }
      
    public function delete(Request $request, Menu $menu)
    { 
            $menu->delete(); 
            return response()->json(true);
    }
    
    public function deleteMenuDetail(Request $request, MenuDetail $menudetail)
    { 
            $menudetail->delete(); 
            return response()->json(true);
    }
}
