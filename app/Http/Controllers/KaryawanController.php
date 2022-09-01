<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables; 
use App\Karyawan;  
use Illuminate\Support\Facades\Session;

class KaryawanController extends Controller
{
    //
        public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request, Karyawan $karyawan)
    {
//        dd($request); 
        $data = $request->all();
//        dd($data['nama_karyawan']);
        $data_karyawan = $karyawan->create([
                 'nama_karyawan'=>$data['nama_karyawan'],
                 'jabatan'=>$data['jabatan'],
                 'telp'=>$data['telp'],
                 'alamat'=>$data['alamat']
        ]);
        
        Session::flash('msgupdate','Nempeler baru berhasil ditambahkan');
        return redirect('/tabel-karyawan');
    
    }
    
     public function cekkaryawan(Request $request, Karyawan $karyawan)
    {
//       
//         dd($request);$request
        if ($request->has('q')) 
         {
            $cari = $request->q;
            $data = $karyawan
                    ->where([
                        ['nama_karyawan', 'LIKE', '%' . $cari . '%'],
                        ['jabatan', 'Sales'],
                    ]);
                     
           $data = $data->get();       
            if (count($data)>0){ 
                $data_tabel = [ 
                    'data' => $data, 
                ]; 
                return response()->json($data_tabel); 
               }         
            }
        
    }
      
    
    public function getKaryawanTable(Karyawan $karyawan)
    {
        $data   =  $karyawan->orderBy('id','desc')->get();
//        dd($data);
        return DataTables::of($data)
            ->addColumn('action', function ($data) {return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                
                                <a href="javascript:void(0)" class="icon-button icon-color-red tooltips popovers" data-original-title="<strong>Hapus Data</strong>" data-content=\'<p>Apakah Anda Yakin?</p>
                                <a class="btn btn-red btn-sm po-delete-karyawan" id="'.$data->id.'" href="#">Yakin</a> 
                                    <button class="btn btn-dark-grey po-close">Tidak</button>\' data-toggle="tooltip" data-placement="top">
                                    <i class="fa fa-ban"></i>
                              </a> 
                              
                                <a href="detail-karyawan/'.$data->id.'" class="icon-button icon-color-green">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>';
            })
            ->make(true);
    }
    
    public function showKaryawanById($id)
    {
        $data = Karyawan::findOrFail($id);
        return view('formKaryawanEdit',compact('data'));
    }
    
    public function update(Request $request,Karyawan $karyawan)
    {
//        dd($request);
        $karyawan->nama_karyawan=$request->get('nama_karyawan');
        $karyawan->jabatan=$request->get('jabatan');
        $karyawan->telp=$request->get('telp');
        $karyawan->alamat=$request->get('alamat');
        $karyawan->save();
        
        return back();
    }
    
    public function delete(Request $request, Karyawan $karyawan)
    { 
            $karyawan->delete(); 
            return response()->json(true);
    }
    
}
