<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Penjualan;
use App\Pelanggan;
use App\Karyawan;

use App\Pembelian;

use App\Barang;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\HargaController;
use App\Paket;
use App\Harga;
use App\Sales;
use App\Hutang;
use Auth;
use DB;
use Illuminate\Support\Facades\Session;
use datetime;

class PelangganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {

        $paket = Paket::with('penjualan')
            ->where([
            ['pelanggan_id', Auth::user()->pelanggan_id],
            ['status', 'aktif']
        ])            //                                            ->orWhere('status','habis')
            ->orderBy('id', 'desc')
            ->first();

        


        if ($paket != null) {
            $penggunaan_paket = Penjualan::where('paket_id', $paket->id)->sum(DB::raw('harga_jual*qty_jual'));
            $saldo = Hutang::where('paket_id', $paket->id)->sum(DB::raw('kredit'));
            $saldo = $saldo - $penggunaan_paket;

            
//                               dd($saldo);

            //        dd($data_pembelian);
            $paket1xMinum = Penjualan::with('paket')->whereHas('paket', function ($query) {
                $query->where('menu_id', 1);
            })->sum('harga_jual');
            $paket10xMinum = Penjualan::with('paket')->whereHas('paket', function ($query) {
                $query->where('menu_id', 2);
            })->sum('harga_jual');
            $paket30xMinum = Penjualan::with('paket')->whereHas('paket', function ($query) {
                $query->where('menu_id', 3);
            })->sum('harga_jual');
        }
        else {
            $penggunaan_paket = 0;
            $saldo = 0;
            $paket1xMinum = 0;
            $paket10xMinum = 0;
            $paket30xMinum = 0;
        }




        $data = compact(
            'paket',
            'paket1xMinum',
            'paket10xMinum',
            'paket30xMinum',
            'penggunaan_paket',
            'saldo');
        return view('pelanggan.dashboard', $data);
    }


    public function index(Sales $sales)
    {
        $data_sales = $sales->with('karyawan')->get();
        return view('formPelanggan', compact('data_sales'));
    }

    public function create(Request $request, Pelanggan $pelanggan)
    {
        $data = $request->all();        //        dd($request);
        $data_pelanggan = $pelanggan->create([
            'nama_pelanggan' => $data['nama_pelanggan'],
            'alamat' => $data['alamat'],
            'tgl_lahir' => date('Y-m-d', strtotime($data['tgl_lahir'])),
            'telp' => $data['telp'],
            'sales_id' => $data['sales_id'],
        ]);

        Session::flash('msgupdate', 'Pelanggan baru berhasil ditambahkan');
        return redirect('/tabel-pelanggan');
    }
    //
    public function pilihCoach(Request $request, Pelanggan $pelanggan, Barang $barang_model, Penjualan $penjualan, Harga $harga, Sales $sales)
    {

        $no_transaksi = $this->setKodeRegistrasi($penjualan, 'PJ', 'tgl_jual');
        $class_barang = new BarangController();
        $class_harga = new HargaController();
        $class_penjualan = new PenjualanController();
        if ($request->has('q')) {
            $cari = $request->q;
            $data = $sales::with('karyawan');
            $data->whereHas('karyawan', function ($query) use ($cari) {
                $query->where('nama_karyawan', 'LIKE', '%' . $cari . '%');
            });
            $data = $data->get();

           // dd($request);
            if (count($data) > 0) {
                // $paket = Paket::with('menu')->where([
                //     ['status', 'umum'],
                // ])->get();
                // update untuk paket satu kali minum sesuai role terbaru 
                $paket = Paket::with('menu')->whereHas('menu', function ($query) use ($request) {
                    $query->where('id', $request->menu_id);})->get();
                
                $paket_harga_jual = $paket[0]['harga_jual'];
                $menu_id = $paket[0]['menu_id'];



                $harga_pokok = $class_harga->cekHargaPokok($harga, $menu_id, $data[0]['level_id']);

                $menu_id = $request->menu_id;
                $sales_id = $data[0]['id'];
                $sales_iuran = $data[0]['iuran'];
                $stok = $class_barang->cekStokBarang($barang_model, $menu_id, $sales_id);
                $stok = $stok->original;                //              dd($menu_id);    
//                dd($stok[0]);
                $data_stok = array();
                //memasukkan nilai stok kedalam array
                foreach ($stok as $datastok => $value) {
                    $data_stok[] = $value['stok'];
                }
                //mengambil nilai stok terendah dari array
                if (isset($request->menu_id)) {
                    $stok_terkecil = (min($data_stok));
                }
                else {
                    $stok_terkecil = 0;
                }

                
//                dd($data[0]['level_id']);
                $sales_iuran = $data[0]['iuran'];
                $data_tabel = [
                    'data' => [
                        'sales' => $data,
                        'stok_all' => $stok,
                        'stok_terkecil' => $stok_terkecil,
                        'sales_id' => $sales_id,
                        'harga_pokok' => $harga_pokok->original,
                        'harga_jual' => $paket_harga_jual,
                        'iuran' => $sales_iuran,
                        'level_id' => $data[0]['level_id'],
                        'menu_id' => $menu_id,
                    ],

                ];

                return json_encode($data_tabel);
            }
        }
    }


    public function pelanggan(Request $request, Pelanggan $pelanggan, Barang $barang, Penjualan $penjualan, Harga $harga)
    {        //        dd($request);
        $no_transaksi = $this->setKodeRegistrasi($penjualan, 'PJ', 'tgl_jual');        //            dd($no_transaksi);
        $class_barang = new BarangController();
        $class_harga = new HargaController();
        $class_penjualan = new PenjualanController();

        if ($request->has('q')) {
            $cari = $request->q;
            $data = $pelanggan
                ->where('nama_pelanggan', 'LIKE', '%' . $cari . '%')
                ->with([                //                        'penjualan',
                'sales',
                'paket']);

            
//            if ($request->jenis=='aktif'){
//                   $data->whereHas('paket',function ($query)  { 
//                             $query  ->where('status','aktif')->orWhere('status','habis')->take(1)->orderBy('id','desc');
//                       });
//            }


            $data = $data->get();
            if (count($data) > 0) {
                $pelanggan_id = $data[0]['id'];
                $paket = Paket::with('menu')->where('pelanggan_id', $pelanggan_id)
                    ->whereIn('status', ['aktif', 'habis'])->orderBy('id', 'desc')->limit(1)->get();                //                    dd($paket);      
                if (count($paket) > 0) {

                    $menu_id = $paket[0]['menu_id'];
                    $sales_id = $data[0]['sales_id'];

                    $sales_iuran = $data[0]['sales']['iuran'];
                    $level_id = $data[0]['sales']['level_id'];                    //               dd($level_id); 
                    $stok = $class_barang->cekStokBarang($barang, $menu_id, $sales_id);                    //                    dd($menu_id);     
                    $stok = $stok->original;                    //                dd($stok[0]);
                    $data_stok = array();
                    //memasukkan nilai stok kedalam array
                    foreach ($stok as $datastok => $value) {
                        $data_stok[] = $value['stok'];
                    }
                    //mengambil nilai stok terendah dari array
                    $stok_terkecil = (min($data_stok));

                    $paket_id = $paket[0]['id'];
                    $paket_qty = $paket[0]['qty'];                    //                $paket_harga_jual   = $paket[0]['harga_jual'];
                    $paket_harga_jual = $paket[0]['harga'] / $paket[0]['qty'];                    //                dd($paket_harga_jual);
                    $nama_menu = $paket[0]['menu']['nama_menu'];
                    $harga_paket = $paket[0]['harga'];
                    $status_paket = $paket[0]['status'];
                    $status_bayar = $paket[0]['bayar'];
                    $tgl_kadaluarsa = date('d-m-Y', strtotime($paket[0]['tgl_kadaluarsa']));

                    $hari_ini = strtotime(date('Y-m-d H:i:s'));
                    $kadaluarsa = strtotime($tgl_kadaluarsa);                    //                              dd($kadaluarsa);
                    if ($hari_ini > $kadaluarsa) {
                        $status_kadaluarsa = "Kadaluarsa";
                    }
                    else {
                        $status_kadaluarsa = "Belum";
                    }


                    
//                echo "hari ini ". number_format($hari_ini,0,'.',',')."<br>";
//                echo "kadaluarsa ".number_format($kadaluarsa,0,'.',',')."<br>";
// 
//                echo $kadaluarsa-$hari_ini;
//                dd($status_kadaluarsa);

                    $hitung_hutang_bayar_hutang = Hutang::where('paket_id', $paket_id)->sum('kredit');
                    $total_bayar_paket = $paket[0]['total_bayar'];

                    
//                dd($paket);
                    $history_penjualan = $class_penjualan->penjualan($penjualan, $pelanggan_id, $paket_id);
                    
//                dd($paket);
                    if (count($history_penjualan) > 0) {
                        $history_penjualan = $history_penjualan;
                    }
                    else {
                        $history_penjualan = "0";
                    }
                    //penggunaan paket yang dibeli oleh pelanggan
                    $penggunaan = Penjualan::where('paket_id', $paket_id)->sum('qty_jual');
                    $sisa_paket = $paket_qty - $penggunaan;

                    $total_nominal_penggunaan = Penjualan::where('paket_id', $paket_id)->sum(DB::raw('harga_jual*qty_jual'));
                    //cek harga pokok
//                    dd($detail_nominal_penggunaan);
//                    dd($penggunaan);
                    $harga_pokok = $class_harga->cekHargaPokok($harga, $menu_id, $level_id);

                    $laba_kotor = $paket_harga_jual - $harga_pokok->original;                    //                dd($laba_kotor);
                    $data_tabel = [
                        'data' => $data,
                        'pelanggan_id' => "$pelanggan_id",
                        'qty_paket' => "$paket_qty",
                        'sisa_paket' => "$sisa_paket",
                        'penggunaan_paket' => "$penggunaan",
                        'total_nominal_penggunaan' => "$total_nominal_penggunaan",
                        'sisa_stok' => '2',
                        'stok_all' => $stok,
                        'stok_terkecil' => $stok_terkecil,
                        'history_penjualan' => $history_penjualan,
                        'harga_pokok' => "$harga_pokok->original",
                        'harga_jual' => "$paket_harga_jual",
                        'laba_kotor' => "$laba_kotor",
                        'nama_menu' => "$nama_menu",
                        'menu_id' => "$menu_id",
                        'paket_id' => "$paket_id",
                        'harga' => "$harga_paket",
                        
//                    'total_bayar' =>"$total_bayar_paket",    
                        'total_bayar' => "$hitung_hutang_bayar_hutang",
                        'no_transaksi' => "$no_transaksi",
                        'iuran' => "$sales_iuran",
                        'status_paket' => "$status_paket",
                        'status_bayar' => "$status_bayar",
                        'tgl_kadaluarsa' => $tgl_kadaluarsa,
                        'status_kadaluarsa' => $status_kadaluarsa,
                        'sales_level' => "$level_id"
                    ];
                    //         $data = $data->get();
                    //        dd($data);
                    return response()->json($data_tabel);
                //        return response()->json($data);
                }

            }
        }
    }

    public function cekpelanggan(Request $request, Pelanggan $pelanggan)
    {        //       
        if ($request->has('q')) {
            $cari = $request->q;
            $data = $pelanggan
                ->where('nama_pelanggan', 'LIKE', '%' . $cari . '%')
                ->with([                //                        'penjualan',
                'sales',
                'paket']);
            $data = $data->get();
            if (count($data) > 0) {
                $data_tabel = [
                    'data' => $data,
                ];
                return response()->json($data_tabel);
            }
        }

    }

    public function nonpelanggan(Request $request, Pelanggan $pelanggan, Barang $barang, Penjualan $penjualan, Harga $harga)
    {

        $no_transaksi = $this->setKodeRegistrasi($penjualan, 'PJN', 'tgl_jual');        //            dd($no_transaksi);
        $class_barang = new BarangController();
        $class_harga = new HargaController();
        $class_penjualan = new PenjualanController();



        if ($request->has('q')) {
            $cari = $request->q;

            $data = $pelanggan
                ->where('nama_pelanggan', 'LIKE', '%' . $cari . '%');

            $data->whereHas('paket', function ($query) {
                $query->where('status', 'umum');
            });

            $data = $data->get();
            
//                  dd($data);

            if (count($data) > 0) {

                $pelanggan_id = $data[0]['id'];
                $paket = Paket::with('menu')->where([
                    ['status', 'umum'],
                    ['pelanggan_id', $pelanggan_id],
                ])->get();

                $menu_id = $paket[0]['menu_id'];
                $paket_id = $paket[0]['id'];
                $paket_qty = $paket[0]['qty'];
                $paket_harga_jual = $paket[0]['harga_jual'];
                $nama_menu = $paket[0]['menu']['nama_menu'];
                $harga_paket = $paket[0]['harga'];
                $total_bayar_paket = $paket[0]['total_bayar'];

                $penggunaan = Penjualan::where('paket_id', $paket_id)->sum('qty_jual');
                $sisa_paket = $paket_qty - $penggunaan;
                $data_tabel = [
                    'data' => $data,
                    'pelanggan_id' => "$pelanggan_id",
                    'qty_paket' => "$paket_qty",
                    'nama_menu' => "$nama_menu",
                    'menu_id' => "$menu_id",
                    'paket_id' => "$paket_id",
                    'harga' => "$harga_paket",
                    'total_bayar' => "$total_bayar_paket",
                    'no_transaksi' => "$no_transaksi",
                ];
                //         $data = $data->get();
                //        dd($data);
                return response()->json($data_tabel);
            //        return response()->json($data);
            }
        }
    }

    public function penggunaanPaket(Pelanggan $pelanggan)
    {
        $data = $pelanggan
            ->with([
            'penjualan',
            'sales',
            'paket'])
            ->get();
        $id_paket = $data[0]['penjualan'][0]['paket_id'];
        
//                $paket_menu_detail                           =   $data[0]['paket'][0]['menu']['detailmenu'][0]['barang'];
        $paket_menu_detail = $data[0]['paket'][0]['menu']['menudetail'];
        $databarang = array();
        $i = 0;
        foreach ($paket_menu_detail as $isi => $key) {
            $namabarang = $paket_menu_detail[$i]['barang']['nama_barang'];
            $databarang[] = [
                "$namabarang" => $key->barang_id,
            ];
            $i++;
        }

        
//                dd($data);

        $karyawan_id = $data[0]['sales']['karyawan']['id'];
        //penggunaan paket yang dibeli oleh pelanggan
        $penggunaan = Penjualan::where('paket_id', $id_paket)->sum('qty_jual');        //               dd($penggunaan);
        //cek stok agen yang tersedia
        $stokSales = Pembelian::where('sales_id', $data[0]['sales_id'])->sum('stok');
        //cek stok tersedia untuk masing masing sales
        $dataPenjualan = Penjualan::with([
            'paket',
            'pelanggan',
            'user']);

        $dataPenjualan->whereHas('pelanggan', function ($query) use ($karyawan_id) {
            $query->whereHas('sales', function ($query) use ($karyawan_id) {
                    $query->whereHas('karyawan', function ($query) use ($karyawan_id) {
                            $query->where('id', $karyawan_id);
                        }
                        );
                    }
                    );
                });        //                $dataPenjualan = $dataPenjualan->get();
        $stokTerpakai = $dataPenjualan->sum('qty_jual');
        $sisaStok = $stokSales - $stokTerpakai;

        
//                dd($sisaStok);

        
//         dd($data );

        $data_tabel = [
            'data' => $data,
            'penggunaan_paket' => $penggunaan,
            'sisa_stok' => $sisaStok,
        ];
        return response()->json($data_tabel);
    }

    public function karyawan(Karyawan $karyawan)
    {
        $data = $karyawan->with(['pelanggan'])->get();
        return response()->json(['data' => $data]);
    }

    public function getPelangganTable(Pelanggan $pelanggan)
    {
        $data = $pelanggan->orderBy('id', 'desc')->with('sales')->whereNotIn('id', [1])->get();        //        dd($data);
        return DataTables::of($data)
            ->addColumn('action', function ($data) {
            return '<div class="btn-group btn-group-sm" role="group" aria-label="...">
                               <a href="javascript:void(0)" class="icon-button icon-color-red tooltips popovers" data-original-title="<strong>Hapus Data</strong>" data-content=\'<p>Apakah Anda Yakin?</p><a class="btn btn-red btn-sm po-delete-pelanggan" id="' . $data->id . '" href="#">Yakin</a> <button class="btn btn-dark-grey po-close">Tidak</button>\' data-toggle="tooltip" data-placement="top">
                                 <i class="fa fa-ban"></i>
                               </a> 
                              
                                <a href="detail-pelanggan/' . $data->id . '" class="icon-button icon-color-green">
                                    <i class="fa fa-edit"></i>
                                </a>
                                
                            </div>';
        })
            ->make(true);
    }

    public function setKodeRegistrasi(Penjualan $penjualan, $kode, $field_tgl)
    {

        $urut = $penjualan->where(\DB::raw("(DATE_FORMAT($field_tgl,'%Y'))"), date('Y'))->get()->sum('id') + 1;
        $registrasi = "$kode" . date('ymd') . str_pad($urut, 4, '0', STR_PAD_LEFT);        //    dd($registrasi);
        return $registrasi;
    }

    public function showPelangganById($id)
    {
        $data = Pelanggan::findOrFail($id);        //           dd($data);
        $data_sales = Sales::get();        //     dd($data);
        return view('formPelangganEdit', compact('data', 'data_sales'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {        //        dd($request);
        $pelanggan->nama_pelanggan = $request->get('nama_pelanggan', $pelanggan->nama_pelanggan);
        $pelanggan->alamat = $request->get('alamat', $pelanggan->alamat);
        $pelanggan->tgl_lahir = $request->get('tgl_lahir', $pelanggan->tgl_lahir);
        $pelanggan->telp = $request->get('telp', $pelanggan->telp);
        $pelanggan->sales_id = $request->get('sales_id', $pelanggan->sales_id);
        $pelanggan->save();

        return back();

    }

    public function delete(Request $request, Pelanggan $pelanggan)
    {



        // 1.  Hapus Penjualan Hutang  
        // 2.  Hapus Penjualan Detail 
        // 3.  Hapus Penjualan
        // 4.  Hapus  paket
        // 4.  Hapus  pelanggan


        $pelanggan->delete();
        return response()->json(true);
    }




}
