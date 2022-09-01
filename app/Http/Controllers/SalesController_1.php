<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Sales;
use App\Level;
use App\Penjualan;
use App\Paket;
use App\Hutang;
use DB;
use Auth;
use App\Pembelian;

class SalesController extends Controller {

    //
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Level $level) {
        $data = $level->get();
        return view('formSales', compact('data'));
    }

    public function dashboard() {
        $data_penjualan = Penjualan::with('sales')->whereHas('sales', function($query) {
                    $query->where('karyawan_id', Auth::user()->karyawan_id);
                })->where([[DB::raw('MONTH(tgl_jual)'), date('m')], [DB::raw('YEAR(tgl_jual)'), date('Y')],])->sum('harga_jual');
        $data_pembelian = Hutang::whereHas('paket', function($query) {
                    $query->whereHas('pelanggan', function($query) {
                        $query->whereHas('sales', function($query) {
                            $query->where('karyawan_id', Auth::user()->karyawan_id);
                        });
                    });
                })->where([[DB::raw('MONTH(tgl_bayar)'), date('m')], [DB::raw('YEAR(tgl_bayar)'), date('Y')],])->sum('kredit');
        $paket1xMinum = Penjualan::with('paket', 'sales')->whereHas('sales', function($query) {
                    $query->where('karyawan_id', Auth::user()->karyawan_id);
                })->whereHas('paket', function($query) {
                    $query->where('menu_id', 1);
                })->sum('harga_jual');
        $paket10xMinum = Penjualan::with('paket')->whereHas('sales', function($query) {
                    $query->where('karyawan_id', Auth::user()->karyawan_id);
                })->whereHas('paket', function($query) {
                    $query->where('menu_id', 2);
                })->sum('harga_jual');
        $paket30xMinum = Penjualan::with('paket')->whereHas('sales', function($query) {
                    $query->where('karyawan_id', Auth::user()->karyawan_id);
                })->whereHas('paket', function($query) {
                    $query->where('menu_id', 3);
                })->sum('harga_jual');
        $data = compact('paket1xMinum', 'paket10xMinum', 'paket30xMinum', 'data_penjualan', 'data_pembelian');
        return view('sales.dashboard', $data);
    }

    public function create(Request $request, Sales $sales) {

//        dd($request);
        $data = $request->all();
        $data_sales = $sales->create([
            'karyawan_id' => $data['karyawan_id'],
            'iuran' => $data['iuran'],
            'level_id' => $data['level'],
        ]);
        Session::flash('msgupdate', 'Coach baru berhasil ditambahkan');
        return redirect('/tabel-sales');
//        return back();
    }

    public function getSalesTable(Sales $sales) {
        $data = $sales->orderBy('id', 'desc')->with('karyawan', 'level')->get();
//        dd($data);
        return DataTables::of($data)
                        ->addColumn('action', function ($data) {
                            return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                              
                                <a href="javascript:void(0)" class="icon-button icon-color-red tooltips popovers" data-original-title="Hapus Data" data-content=\'<p>Apakah Anda Yakin?</p>
                                <a class="btn btn-red btn-sm po-delete-sales" id="' . $data->id . '" href="#">Yakin</a> 
                                    <button class="btn btn-dark-grey po-close">Tidak</button>\' data-toggle="tooltip" data-placement="top">
                                    <i class="fa fa-ban"></i>
                               </a> 

                                <a href="detail-sales/' . $data->id . '" class="icon-button icon-color-green">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>';
                        })
                        ->make(true);
    }

    public function showSalesById($id) {
        $data = Sales::with('karyawan')->findOrFail($id);
        $level = Level::get();
        return view('formSalesEdit', compact('data', 'level'));
    }

    public function update(Request $request, Sales $sales) {
//        dd($request);
        $sales->level_id = $request->get('level');
        $sales->karyawan_id = $request->get('karyawan_id');
        $sales->iuran = $request->get('iuran');
        $sales->save();

        return back();
    }

    public function delete(Request $request, Sales $sales) {
//        dd($request);
        $sales->delete();
        return response()->json(true);
    }

}
