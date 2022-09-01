<?php
namespace App\Http\ViewComposers; 

use Illuminate\View\View;
//use App\Repositories\UserRepository;
use App\Stok;
use DB;
use App\Penjualan;
use App\Paket;

use Auth;

class UserComposer
{
    public function compose(View $view)
    {
        
       if(Auth::check()==true){
             if(Auth::user()->role=='AA'||Auth::user()->role=='OA')
            {
                 $penjualan     = Penjualan::sum('qty_jual');
                 $stok                = Stok::sum(DB::raw("stok_in-stok_out"));
                 $shake             = Stok::where('barang_id','119')->sum(DB::raw("stok_in-stok_out"));
//                 dd($shake);
                 $nrg                  = Stok::where('barang_id','237')->sum(DB::raw("stok_in-stok_out"));
                 $aloe                = Stok::where('barang_id','238')->sum(DB::raw("stok_in-stok_out"));
                 
                 $view->with('penjualan_all',$penjualan);
                 $view->with('stok_all',$stok);
                 $view->with('shake',$shake);
                 $view->with('nrg',$nrg);
                 $view->with('aloe',$aloe);
            }
            else   if(Auth::user()->role=='PA')
            {
              $paket         = Paket::with('penjualan')
                                        ->where([
                                                ['pelanggan_id',Auth::user()->pelanggan_id],
                                                ['status','aktif']
                                            ])
//                                            ->orWhere('status','habis')
                                            ->orderBy('id','desc')
                                            ->first(); 
//              dd($paket);
//                $paket         = Paket::with('penjualan')->where([
//                                                ['pelanggan_id',Auth::user()->pelanggan_id],
//                                                ['status','aktif']
//                                            ])->orWhere('status','habis')
//                                        ->first(); 
//                dd($paket->status);
                 
//                  if($paket->status=='habis') 
//                  {
//                      $penjualan =0;
//                      $qtypaket  = 0;
//                  }
//                  else
//                  {
//                       $penjualan = Penjualan::where([
//                                    ['pelanggan_id',Auth::user()->pelanggan_id],
//                                    ['paket_id',$paket->id]
//                     ])->sum('qty_jual');
//                        $qtypaket = $paket->qty;
//                  }
//                                  dd($qtypaket);
            if($paket!=null){
                $penjualan = Penjualan::where([
                                    ['pelanggan_id',Auth::user()->pelanggan_id],
                                    ['paket_id',$paket->id]
                     ])->sum('qty_jual');
                   
                $qtypaket = $paket->qty; 
            }else{
                $penjualan = 0;
                $qtypaket = 0;
            }
                   
                 $view->with('penjualan_all',$penjualan);
                 $view->with('stok_all',$qtypaket-$penjualan);
            }
            else   if(Auth::user()->role=='SA')
            {
 
                    $stok= Stok::with('sales')->whereHas('sales',function($query){
                        $query->where('karyawan_id',Auth::user()->karyawan_id);
                    })->sum(DB::raw("stok_in-stok_out"));
                
                  
                  $penjualan = Penjualan::with('sales')
                                    ->whereHas('sales',function($query){
                                           $query->where('karyawan_id',Auth::user()->karyawan_id);
                                     })->sum('qty_jual');
//                dd($penjualan);
                 $view->with('penjualan_all',$penjualan);
                 $view->with('stok_all',$stok);
            }
           
       }
          
    }
}