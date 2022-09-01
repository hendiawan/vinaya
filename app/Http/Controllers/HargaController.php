<?php

namespace App\Http\Controllers; 
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use DataTables; 
use App\Harga;
use App\MenuDetail; 
use App\Http\Controllers\BarangController;
use App\Barang;
use App\Level; 

class HargaController extends Controller
{
    //
        public function __construct()
    {
        $this->middleware('auth');
    }

    public  function index(Barang $barang,Level $level)
    {
        $data = $barang->get();
        $level = $level->get(); 
         return view('formHarga',compact('data','level'));          
    } 
    
    public function create(Request $request,Harga $harga)
    {
        $data = $request->all();
        
//        dd($request);
        $data_harga = $harga->create([
                 'barang_id'=>$data['barang_id'],
                 'level_id'=>$data['level'],
                 'harga_pokok'=>$data['harga_pokok'],
                 'takaran'=>$data['takaran'],
                 'harga_perporsi'=>$data['harga_jual'], 
        ]);
			
        Session::flash('msgupdate','List Harga baru berhasil ditambahkan');
        return redirect('/tabel-harga');
		   
//        return back();
    }
    
    public function cekHargaPokok(Harga $harga,$menu_id,$level_id)
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
                    ->get()
                    ->sum('harga_perporsi'); 
                     return response()->json($data);
    } 
    
    public function cekHargaPokokBarang(Request $request, Harga $harga, Barang $barang)
    {   
//        dd($request);
          //ambil barang_id berdasarkan menu terentu
         if ($request->has('q')) 
         {  
            
            $cari=$request->q;
            $data_barang    = $barang::where('nama_barang','LIKE', '%' . $cari . '%')->get();
           
            if($request->level){
                    $level=$request->level;
                    $harga_pokok  = $harga->where([
                                                ['barang_id',$data_barang[0]['id']],
                                                ['level_id',$level]
                                            ])->first();
            }else{
                    $harga_pokok="0";
            }
        
            
            
            if (count($data_barang)>0){
             
           $data_tabel = [
                'databarang'=>[
                    'data'=>$data_barang,
                    'harga'=>$harga_pokok,
                ],
//             'harga'=>$harga_pokok
         ];
            return  json_encode($data_tabel);
            }
         }
         
        
    } 
    
    public function getHargaTable(Harga $harga)
    {
        $data   =  $harga->orderBy('id','desc')->with('barang','level')->get();
//        dd($data);
        return DataTables::of($data)
            ->addColumn('action', function ($data) {return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                
                                <a href="javascript:void(0)" class="icon-button icon-color-red tooltips popovers" data-original-title="<strong>Hapus Data</strong>" data-content=\'<p>Apakah Anda Yakin?</p>
                                <a class="btn btn-red btn-sm po-delete-harga" id="'.$data->id.'" href="#">Yakin</a> 
                                    <button class="btn btn-dark-grey po-close">Tidak</button>\' data-toggle="tooltip" data-placement="top">
                                    <i class="fa fa-ban"></i>
                              </a> 
                              
                                <a href="detail-harga/'.$data->id.'" class="icon-button icon-color-green">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>';
            })
            ->make(true);
    }
    
    public function showHargaById($id)
    {
        $data = Harga::with('barang','level')->findOrFail($id); 
        $barang = Barang::get();
        $level  = Level::get();
        return view('formHargaEdit',compact('data','barang','level'));
    }
    
    public function update(Request $request, Harga $harga)
    {
//        dd($request);
        $harga->barang_id=$request->get('barang_id');
        $harga->level_id=$request->get('level');
        $harga->harga_pokok=$request->get('harga_pokok');
        $harga->takaran=$request->get('takaran');
        $harga->harga_perporsi=$request->get('harga_jual');
        $harga->save();
        
        return back();
    }
    
      public function delete(Request $request, Harga $harga)
    { 
            $harga->delete(); 
            return response()->json(true);
    }
      
      
}
