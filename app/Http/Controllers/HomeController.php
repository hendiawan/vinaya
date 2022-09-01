<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Penjualan;
use App\Pembelian;
use DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Sales;
use App\Karyawan;
use App\Pelanggan;
use App\Hutang;
use Hash;
use Session;
use DataTables;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    { 
          if ( Auth::user()->role == 'AA'||Auth::user()->role == 'OA') {
                  return redirect('/dashboard'); 
           }   
          if ( Auth::user()->role == 'PA') {
                  return redirect('/dashboard-pelanggan'); 
           }   
          if ( Auth::user()->role == 'SA') {
                  return redirect('/dashboard-sales'); 
           }   
    }
    
    public function dashboard()
    {
  
        $data_penjualan     = Penjualan::where
                                                    ([ 
                                                        [DB::raw('MONTH(tgl_jual)'), date('m')],
                                                        [DB::raw('YEAR(tgl_jual)'), date('Y')],
                                                     ])->sum(DB::raw('harga_jual*qty_jual')); 
        
//        $data_pembelian    = Pembelian::sum('harga_pokok');
        $data_pembelian    = Hutang::where
                                                    ([ 
                                                        [DB::raw('MONTH(tgl_bayar)'), date('m')],
                                                        [DB::raw('YEAR(tgl_bayar)'), date('Y')],
                                                     ])->sum('kredit');
        
        $paket1xMinum     = Penjualan::with('paket')->whereHas('paket',function($query){
                                                     $query->where('menu_id',1);
                                                })->where ([ 
                                                        [DB::raw('MONTH(tgl_jual)'), date('m')],
                                                        [DB::raw('YEAR(tgl_jual)'), date('Y')],
                                                     ])->sum(DB::raw('harga_jual*qty_jual')); 
                                                
        $paket10xMinum   = Penjualan::with('paket')->whereHas('paket',function($query){
                                                     $query->where('menu_id',2);
                                                })->where ([ 
                                                        [DB::raw('MONTH(tgl_jual)'), date('m')],
                                                        [DB::raw('YEAR(tgl_jual)'), date('Y')],
                                                     ])->sum(DB::raw('harga_jual*qty_jual')); 
                                                
        $paket30xMinum   = Penjualan::with('paket')->whereHas('paket',function($query){
                                                     $query->where('menu_id',3);
                                                })->where ([ 
                                                        [DB::raw('MONTH(tgl_jual)'), date('m')],
                                                        [DB::raw('YEAR(tgl_jual)'), date('Y')],
                                                     ])->sum(DB::raw('harga_jual*qty_jual')); 

        $data = compact(
                'paket1xMinum',
                'paket10xMinum',
                'paket30xMinum',
                'data_penjualan',
                'data_pembelian');
        return view('dashboard',$data);
    }
    
    public function profile()
    {

        $user = User::with('karyawan')->findOrFail(Auth::user()->id);
//        $karyawan = Karyawan::whereHas('')
//        dd($user);
        return view('profil', compact('user'));
    }
    
    public function gantiPassword()
    {
        return view('profilGantiPassword');
    }
    
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ]);
        $data = $request->all();
        $user = User::findOrFail(Auth::user()->id);

        if(!Hash::check($data['current_password'], $user->password)){
            Session::flash('msgalert','Password sekarang (current password) yang anda masukkan tidak sesuai');
            return redirect('/ganti-password');
        }else{
            $user = User::where('email',Auth::user()->email)
                            ->update(['password' => bcrypt($data['password'])]);
        }

        Session::flash('msgupdate','Anda berhasil melakukan update password');
        return redirect('/ganti-password');
    }
    
    
     public function editUser($id)
    {
        
        $user = User::findOrFail($id);
        $agen = Agen::where('user_id', $id)->first();
        return view('profilEditPengguna', compact('user','agen'));
    }
    
    
    public function formUser()
    {
        $data_karyawan = Karyawan::get();
        $data_pelanggan = Pelanggan::get();
//        dd($data_karyawan);
        return view('profileTambahPengguna',compact('data_karyawan','data_pelanggan'));
    }
    public function UpdateUser($id)
    {
        $data_karyawan = Karyawan::get();
        $data_pelanggan = Pelanggan::get();
        $user                       =user::findOrFail($id);
//        dd($data_karyawan);
        return view('profileEditPengguna',compact('data_karyawan','data_pelanggan','user'));
    }
    public function EditUserDetail(Request $request,User $user)
    {
        
//        dd($request); 
        
        $data = $request->all();  
        if ($data['jenis_user']=='karyawan')
        {
               $user = $user->update([
                    'username'      => $data['username'], 
                    'email'     => $data['email'], 
                    'jenis_user'     => $data['jenis_user'], 
                    'karyawan_id'     => $data['karyawan_id'], 
//                    'password'  => bcrypt('password123'),
                    'api_token'  => bcrypt($data['email']),
                    'role'      => $data['role'],
                    'is_active'      => 1,
                ]);
        }else{
              $user = $user->update([
                    'username'      => $data['username'], 
                    'email'     => $data['email'], 
                    'jenis_user'     => $data['jenis_user'], 
                    'pelanggan_id'     => $data['pelanggan_id'], 
//                    'password'  => bcrypt('password123'),
                    'api_token'  => bcrypt($data['email']),
                    'role'      => $data['role'],
                    'is_active'      => 1,
                ]);
        }
       
        Session::flash('msgupdate','Pengguna berhasil diubah');
        return redirect('/managemen-user');
    }
    public function insertUser(Request $request)
    {
//        
//        dd($request);

        $this->validate($request, [
            'jenis_user' => 'required',
            'username' => 'required|unique:users', 
            'email' => 'required|email|max:255|unique:users',
        ]);

        $data = $request->all();
        
//        dd($data);
        
        if ($data['jenis_user']=='karyawan')
        {
               $user = User::create([
                    'username'      => $data['username'], 
                    'email'     => $data['email'], 
                    'jenis_user'     => $data['jenis_user'], 
                    'karyawan_id'     => $data['karyawan_id'], 
                    'password'  => bcrypt('password123'),
                    'api_token'  => bcrypt($data['email']),
                    'role'      => $data['role'],
                    'is_active'      => 1,
                ]);
        }else{
              $user = User::create([
                    'username'      => $data['username'], 
                    'email'     => $data['email'], 
                    'jenis_user'     => $data['jenis_user'], 
                    'pelanggan_id'     => $data['pelanggan_id'], 
                    'password'  => bcrypt('password123'),
                    'api_token'  => bcrypt($data['email']),
                    'role'      => $data['role'],
                    'is_active'      => 1,
                ]);
        }
       
        Session::flash('msgupdate','Pengguna baru berhasil di tambahkan');
        return redirect('/managemen-user');
    }
    
    
    public function getUserList(){

        $user = User::orderBy('id','desc')->get();

        return Datatables::of($user)
            ->addColumn('action', function ($user) {
                return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a href="edit-pengguna/'.$user->id.'" class="icon-button icon-color-blue">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="detail-pengguna/'.$user->id.'" class="icon-button icon-color-grey">
                                    <i class="fa fa-search"></i>
                                </a>
                            </div>';
            })
            ->make(true);
    }
    
    
    public function updateStatus(Request $request)
    {
        $data = $request->all();
        $user = User::findOrFail($data['id']);

        if($data['is_active']=='true'){
            $user->is_active = '0';
        }else{ 
            $user->is_active = '1';
        }

        $user->save();

        return response()->json(compact('user'));
    }
    
      public function detailPengguna($id)
    { 
        $user = User::findOrFail($id); 
        return view('profil', compact('user'));
    }
    
}
