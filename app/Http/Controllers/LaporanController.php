<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use DataTables;

use App\Sales;

use App\Level;
use App\Penjualan;
use App\Barang;
use App\Stok;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Pelanggan;
use Auth;
use App\Hutang;
use DateTime;
class LaporanController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Penjualan $penjualan, Sales $sales, Pelanggan $pelanggans)
    {
        $data = $penjualan->get();
        $coach = $sales->with('karyawan')->get();
        if (Auth::user()->role == 'AA') {
            $pelanggan = $pelanggans->where('nama_pelanggan', '!=', 'UMUM')->get();
        }
        else if (Auth::user()->role == 'SA') {
            $pelanggan = $pelanggans->with('sales')
                ->whereHas('sales', function ($query) {
                $query->where('karyawan_id', Auth::user()->karyawan_id);
            })->get();

            $coach = $sales->with('karyawan')->where('karyawan_id', Auth::user()->karyawan_id)->get();
        }
        else {
            $pelanggan = $pelanggans->where('id', Auth::user()->pelanggan_id)->get();

        } // dd($pelangan);
        $compact = compact(
            'data',
            'coach',
            'pelanggan'
        );

        if (Auth::user()->role == 'SA' || Auth::user()->role == 'OA') {
            return view('sales.laporan', $compact);
        }
        else {
            return view('laporan', $compact);
        }

    }

    public function getDetailPenjualanCoach(Request $request, Penjualan $penjualan)
    {



        
//        dd($request);

        $data = $request->all();

        $startDate = date('Y-m-d', strtotime($data['startDate']));
        ;
        $endDate = date('Y-m-d', strtotime($data['endDate'])); //        dd($startDate);

        $data = $penjualan->with([
            'paket',
            'pelanggan',
            'sales',
            'user']);
        if ($request->id != 'all') { //                $data= $data->whereHas('pelanggan',function ($query) use ($request){
//                                $query  ->whereHas('sales',function ($query)  use ($request) {
//                                                    $query ->whereHas('karyawan',function ($query)  use ($request){
//                                                                         $query->where('id',$request->id);
//                                        });   
//                                 });   
//                          });
            $data = $data->where('sales_id', $request->id);
        }

        $data = $data
            ->whereBetween('tgl_jual', [$startDate, $endDate])
            ->orderBy('tgl_jual', 'DESC')
            ->get(); //        dd($data);
        return DataTables::of($data)
            ->addColumn('tgl_jual', function ($data) {
            return date('d-m-Y', strtotime($data->tgl_jual));
        })
            ->addColumn('harga_jual', function ($data) {
            return number_format($data->harga_jual, 0, ',', '.');
        })
            ->addColumn('nama_pelanggan', function ($data) {
            $nama = $data->pelanggan->nama_pelanggan;
            if ($nama == "UMUM") {
                $nama = $data->non_member;
            }
            return $nama;
        })
            ->make(true);

    }

    public function getPenggunaanPaket(Request $request, Penjualan $penjualan)
    {

        $data = $request->all();


        
//        dd($data);
        $startDate = date('Y-m-d', strtotime($data['startDate']));
        ;
        $endDate = date('Y-m-d', strtotime($data['endDate'])); //        dd($startDate);

        $data = $penjualan->with([
            'paket',
            'pelanggan',
            'sales',
            'user']);
        if ($request->id != 'all') {
            $data = $data->where('pelanggan_id', $request->id);
        }

        $data = $data
            ->whereBetween('tgl_jual', [$startDate, $endDate])
            ->orderBy('tgl_jual', 'DESC')
            ->get(); //        dd($data);
        return DataTables::of($data)
            ->addColumn('tgl_jual', function ($data) {
            return date('d-m-Y', strtotime($data->tgl_jual));
        })
            ->addColumn('harga_jual', function ($data) {
            return number_format($data->harga_jual, 0, ',', '.');
        })
            ->make(true);

    }

    public function reportCoachDetail(Request $request, Penjualan $penjualan)
    { //        dd($request);
        $data = $request->all(); //        dd($request->sales_id);



        $startDate = date('Y-m-d', strtotime($data['startDate']));
        $endDate = date('Y-m-d', strtotime($data['endDate'])); //        dd($startDate);

        $data = $penjualan->with([
            'paket',
            'pelanggan',
            'sales',
            'user']);


        if ($request->sales_id != 'all') { //                $data= $data->whereHas('pelanggan',function ($query) use ($request){
//                                $query  ->whereHas('sales',function ($query)  use ($request) {
//                                                    $query ->whereHas('karyawan',function ($query)  use ($request){
//                                                                         $query->where('id',$request->sales_id);
//                                        });   
//                                 });   
//                          });
            $data = $data->where('sales_id', $request->sales_id);
        }

        $coach = $data
            ->whereBetween('tgl_jual', [$startDate, $endDate])
            ->orderBy('tgl_jual', 'DESC')


            
//                        ->GroupBy(['sales_id'])
            ->get();



        
//           dd($coach);

        $tglMulai = date('d-m-y', strtotime($startDate));
        $tglSelesai = date('d-m-y', strtotime($endDate));

        $sumQtyJual = 0;
        $sumHargaPokok = 0;
        $sumHargaJual = 0;
        $sumLabaKotor = 0;

        foreach ($coach as $key => $data) {
            $sumQtyJual += $data->qty_jual;
            $sumHargaPokok += $data->harga_pokok * $data->qty_jual;
            $sumHargaJual += $data->harga_jual * $data->qty_jual;
            $sumLabaKotor += $data->laba_kotor * $data->qty_jual;
        } //        


        if ($sumQtyJual > 0) {
            if ($request->sales_id != 'all') {
                $namaCoach = $coach[0]->sales->karyawan->nama_karyawan;
            }
            else {
                $namaCoach = 'All';
            }
        }
        else {
            $namaCoach = '';
        }


        $view_stok = db::CONNECTION('mysql')
            ->table('view_stok')
            ->select("*") //                ->take(200)
            ->get();



        if (isset($request->btn_sum)) {


            if ($request->sales_id != 'all') {
                $summarySales = db::CONNECTION('mysql')
                    ->select(
                    'call cek_penjualan_sales_byid(?,?,?)',
                [$startDate, $endDate, $request->sales_id]
                );
            }
            else {
                $summarySales = db::CONNECTION('mysql')
                    ->select(
                    'call cek_penjualan_sales(?,?)',
                [$startDate, $endDate]
                );
            }




            
//              dd($summarySales);

            $pdf = PDF::loadView('ReportSummaryCoach', compact(
                'namaCoach',
                'tglMulai',
                'tglSelesai',
                'summarySales'))->setPaper('a3', 'landscape');

            return $pdf->stream('laporan-summary-coach.pdf');

        }
        else {
            $pdf = PDF::loadView('ReportCoachDetail', compact(
                'namaCoach',
                'coach',
                'tglMulai',
                'tglSelesai',
                'sumQtyJual',
                'sumHargaPokok',
                'sumHargaJual',
                'sumLabaKotor'))->setPaper('a3', 'landscape');
            return $pdf->stream('laporan-coach-detail.pdf');
        }

    }


    public function reportPenggunaanPaketDetail(Request $request, Pelanggan $pelanggan, Penjualan $penjualan)
    {

        $data = $request->all(); //        dd($data);

        if ($data['pelanggan_id'] != 'all') {
            $DataPelanggan = $pelanggan->findOrfail($data['pelanggan_id']);
            $namaPelanggan = $DataPelanggan->nama_pelanggan;
        }
        else {
            $namaPelanggan = 'All';
        } //               dd($data);
        $startDate = date('Y-m-d', strtotime($data['startDate']));
        ;
        $endDate = date('Y-m-d', strtotime($data['endDate'])); //        dd($startDate);

        $data = $penjualan->with([
            'paket',
            'pelanggan',
            'sales',
            'user']);

        if ($request->pelanggan_id != 'all') {
            $data = $data->where('pelanggan_id', $request->pelanggan_id);
        }

        $data = $data->whereHas('Pelanggan', function ($query) {
            $query->where('nama_pelanggan', '!=', 'UMUM');
        });

        $pelanggan = $data
            ->whereBetween('tgl_jual', [$startDate, $endDate])
            ->orderBy('tgl_jual', 'asc')
            ->orderBy('paket_id', 'asc')
            ->get();



        
//          DD($pelanggan);

        $tglMulai = date('d-m-y', strtotime($startDate));
        $tglSelesai = date('d-m-y', strtotime($endDate));

        $sumQtyJual = 0;
        $sumHargaPokok = 0;
        $sumHargaJual = 0;
        $sumLabaKotor = 0;

        foreach ($pelanggan as $key => $data) {
            $sumQtyJual += $data->qty_jual;
            $sumHargaPokok += $data->harga_pokok * $data->qty_jual;
            $sumHargaJual += $data->harga_jual * $data->qty_jual;
            $sumLabaKotor += $data->laba_kotor * $data->qty_jual;
        } //        dd($sumQtyJual);
//        return DataTables::of($data) 
//            ->addColumn('tgl_jual',function ($data) {return date('d-m-Y',strtotime($data->tgl_jual));})
//            ->make(true);



        
//        dd($coach);
        $pdf = PDF::loadView('ReportPenggunaanPaketDetail', compact(
            'namaPelanggan',
            'pelanggan',
            'tglMulai',
            'tglSelesai',
            'sumQtyJual',
            'sumHargaPokok',
            'sumHargaJual',
            'sumLabaKotor'))->setPaper('a3', 'landscape');


        return $pdf->stream('laporan-coach-detail.pdf');

    }

    public function reportPenerimaanUang(Request $request, Hutang $hutang)
    { //         dd($request);
        $getData = $request->all();
        $startDate = date('Y-m-d', strtotime($getData['startDate']));
        ;
        $endDate = date('Y-m-d', strtotime($getData['endDate']));
        $data = $hutang->with('paket');

        if ($request->sales_id != 'all') {
            $data = $data->whereHas('paket', function ($query) use ($request) {
                $query->whereHas('pelanggan', function ($query) use ($request) {
                        $query->whereHas('sales', function ($query) use ($request) {
                                $query->where('id', $request->sales_id);
                            }
                            );
                        }
                        );
                    });
        }

        $hutang = $data
            ->whereBetween('tgl_bayar', [$startDate, $endDate])
            ->orderby('id', 'desc')
            ->get();


        
//               dd($hutang); 
        $tglMulai = date('d-m-y', strtotime($startDate));
        $tglSelesai = date('d-m-y', strtotime($endDate));

        $sumKredit = 0;
        foreach ($hutang as $key => $data) {
            $sumKredit += $data->kredit;
        }

        if ($getData['sales_id'] != 'all') {
            $namaCoach = $hutang[0]->paket->pelanggan->sales->karyawan->nama_karyawan;
        }
        else {
            $namaCoach = 'All';
        }

        $pdf = PDF::loadView('ReportPenerimaanDetail', compact(
            'namaCoach',
            'hutang',
            'tglMulai',
            'tglSelesai',
            'sumKredit'
        ))->setPaper('a3', 'landscape');

        return $pdf->stream('laporan-penerimaan-detail.pdf');

    }

    public function getPenerimaanUang(Request $request, Hutang $hutang)
    {


        
//             dd($request);
        $getData = $request->all();


        
//            dd($getData);
        $startDate = date('Y-m-d', strtotime($getData['startDate']));
        ;
        $endDate = date('Y-m-d', strtotime($getData['endDate']));
        $data = $hutang->with('paket');


        
//        dd($request); 
        if ($request->id != 'all') {
            $data = $data->whereHas('paket', function ($query) use ($getData) {
                $query->whereHas('pelanggan', function ($query) use ($getData) {
                        $query->whereHas('sales', function ($query) use ($getData) {
                                $query->where('id', $getData['id']);
                            }
                            );
                        }
                        );
                    });
        }


        
//                  dd($getData['id']);

        $data = $data
            ->whereBetween('tgl_bayar', [$startDate, $endDate])
            ->OrderBy('id', 'desc')
            ->get();


        return DataTables::of($data)
            ->addColumn('kredit', function ($data) {
            return number_format($data->kredit, 0, ',', '.');
        })
            ->make(true);
    }

    public function getStokBarangSales(Request $request)
    {

        $data = $request->all();

        $startDate = date('Y-m-d', strtotime($data['startDate']));
        ;
        $endDate = date('Y-m-d', strtotime($data['endDate']));

        $data = Stok::with('barang', 'sales')
            ->select('sales_id', 'barang_id', DB::raw("sum(stok_in-stok_out) as stok"))
            ->GroupBy(['sales_id', 'barang_id'])
            ->where([
            ($request->id != 'all') ? 
            ['sales_id', $request->id] : ['sales_id', 'like', '%%%']
        ])
            ->whereBetween('tgl', ['2020-01-01', $endDate])
            ->get(['sales_id', 'barang_id']);

        return DataTables::of($data)
            ->make(true);
    }

    public function reportStokDetail(Request $request, Penjualan $penjualan)
    {

        $data = $request->all(); //        dd($data);
//       if($data['sales_id']!='all'){
//             $namaCoach   =   $penjualan->with([ 
//                            'sales',  ])->first(); 
////             $namaCoach = $namaCoach->sales->karyawan->nama_karyawan;
//        }else{
//             $namaCoach = 'All';
//        }



        
//        dd($data);

        $startDate = date('Y-m-d', strtotime($data['startDate']));
        ;
        $endDate = date('Y-m-d', strtotime($data['endDate']));

        $data_stok = Stok::with('barang', 'sales')
            ->select('sales_id', 'barang_id', DB::raw("sum(stok_in-stok_out) as stok"))
            ->GroupBy(['sales_id', 'barang_id'])
            ->where([
            ($request->sales_id != 'all') ? 
            ['sales_id', $request->sales_id] : ['sales_id', 'like', '%%%']
        ])
            ->whereBetween('tgl', ['2020-01-01', $endDate])
            ->get(['sales_id', 'barang_id']);



        
//                 dd($data_stok);
        $tglMulai = date('d-m-y', strtotime($startDate));
        $tglSelesai = date('d-m-y', strtotime($endDate));

        $sumStok = 0;

        foreach ($data_stok as $key => $data) {
            $sumStok += $data->stok;
        }


        if ($sumStok > 1) {
            if ($request->sales_id != 'all') {
                $namaCoach = $data_stok[0]->sales->karyawan->nama_karyawan;
            }
            else {
                $namaCoach = 'All';
            }
        }
        else {
            $namaCoach = '';
        } //            dd($namaCoach);
//        return DataTables::of($data_stok) 
//            ->make(true);
        dd($data_stok);

        $pdf = PDF::loadView('ReportStokDetail', compact('report',
            'namaCoach',
            'data_stok',
            'tglMulai',
            'tglSelesai',
            'sumStok'))->setPaper('a3', 'landscape');


        return $pdf->stream('laporan-Stok-detail.pdf');
    }



    public function getDataPelanggan(Request $request)
    {

        $data = $request->all();



        
//        $startDate =date('Y-m-d',strtotime($data['startDate']));;
        $endDate = date('Y-m-d', strtotime($data['endDate']));

        $data = Pelanggan::with('sales') //                      ->select('sales_id','barang_id',DB::raw("sum(stok_in-stok_out) as stok"))
//                      ->GroupBy(['sales_id','barang_id'])
            ->where([
            ($request->id != 'all') ? 
            ['sales_id', $request->id] : ['sales_id', 'like', '%%%']
        ])
            ->where(DB::raw('MONTH(tgl_lahir)'), date('m', strtotime($endDate)))
            ->get();



        
//          dd($data);
        return DataTables::of($data)
            ->addColumn('tgl_lahir', function ($data) {
            $tanggallahir = date('d-m-Y', strtotime($data->tgl_lahir));
            return $tanggallahir;
        })
            ->addColumn('umur', function ($data) {
            return hitungUmurs($data->tgl_lahir);
        })
            ->addColumn('hari', function ($data) {
            return hitungHariLahir($data->tgl_lahir);
        })
            ->make(true);
    }

    public function reportDataPelanggan(Request $request, Pelanggan $pelanggan)
    {
        $data = $request->all(); //       dd($data);
//        $startDate =date('Y-m-d',strtotime($data['startDate']));;
        $endDate = date('Y-m-d', strtotime($data['endDate']));

        $datas = Pelanggan::with('sales')
            ->where([
            ($data['sales_id'] != 'all') ? 
            ['sales_id', $request->id] : ['sales_id', 'like', '%%%']
        ])
            ->where(DB::raw('MONTH(tgl_lahir)'), date('m', strtotime($endDate)))
            ->get();


        
//                  dd($datas);
        if ($data['sales_id'] != 'all') {
            $namaCoach = $hutang[0]->paket->pelanggan->sales->karyawan->nama_karyawan;
        }
        else {
            $namaCoach = 'All';
        }

        $pdf = PDF::loadView('ReportUltahPelanggan', compact(
            'datas',
            'namaCoach'
        ))->setPaper('a3', 'landscape');

        return $pdf->stream('laporan-ultah-pelanggan.pdf');

    }



}
