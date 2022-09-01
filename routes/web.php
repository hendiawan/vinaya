<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/updateapp', function()
{
    Artisan::call('dump-autoload');
    echo 'dump-autoload complete';
});

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});

Route::get('/', function () {
//    return view('welcome');
//    return view('index');
    return redirect('/login');
});

Route::get('/form', function () {
//    return view('welcome');
    return view('form');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
Route::get('/dashboard-pelanggan', 'PelangganController@dashboard')->name('dashboard.pelanggan');
Route::get('/dashboard-sales', 'SalesController@dashboard');

Route::get('/penjualan','PenjualanController@index')->name('index');

Route::get('/data-penjualan', 'PenjualanController@penjualan')->name('penjualan');
Route::get('/karyawan', 'PenjualanController@karyawan')->name('karyawan');

Route::get('/getdata-penjulan', 'PenjualanController@getPenjualanTable');
Route::get('/getdata-pelanggan', 'PelangganController@getPelangganTable');
Route::get('/getdata-barang', 'BarangController@getBarangTable');
Route::get('/getdata-karyawan', 'KaryawanController@getKaryawanTable');
Route::get('/getdata-coach', 'SalesController@getSalesTable');
Route::get('/getdata-harga', 'HargaController@getHargaTable');
Route::get('/getdata-pembelian', 'PembelianController@getPembelianTable');
Route::get('/getdata-menu', 'MenuDetailController@getMenuTable');
Route::get('/getdata-menu-detail', 'MenuDetailController@getMenuDetailTable');
Route::get('/getdata-menu-detail/{id}', 'MenuDetailController@getMenuDetailTableById');
Route::get('/getdata-paket', 'PaketController@getPaketTable');
Route::get('/getdata-hutang', 'HutangController@getHutangTable');


Route::get('/tabel-penjualan', function () {
    return view('tabelPenjualan');
});
Route::get('/tabel-pelanggan', function () {
    return view('tabelPelanggan');
});
Route::get('/tabel-barang', function () {
    return view('tabelBarang');
});
Route::get('/tabel-karyawan', function () {
    return view('tabelKaryawan');
});
Route::get('/tabel-sales', function () {
    return view('tabelCoach');
});
Route::get('/tabel-harga', function () {
    return view('tabelHarga');
});
Route::get('/tabel-pembelian', function () {
    return view('tabelPembelian');
});
Route::get('/tabel-menu', function () {
    return view('tabelMenu');
});
Route::get('/tabel-menu-detail', function () {
    return view('tabelMenuDetail');
});
Route::get('/list-menu-detail', function () {
    return view('tabelListMenuDetail');
});
Route::get('/tabel-paket', function () {
    return view('tabelPaket');
});
Route::get('/tabel-hutang', function () {
    return view('tabelHutang');
});


Route::get('/pilih-coach', 'PelangganController@pilihCoach')->name('pilihcoach');
Route::get('/pelanggan', 'PelangganController@pelanggan')->name('pelanggan');
Route::get('/cek-pelanggan', 'PelangganController@cekpelanggan')->name('pelanggan');
Route::get('/cek-karyawan', 'KaryawanController@cekkaryawan')->name('cekkaryawan');
Route::post('/create-sales', 'SalesController@create')->name('createsales');
Route::get('/non-pelanggan', 'PelangganController@nonpelanggan')->name('nonpelanggan');
Route::get('/penggunaan-paket', 'PelangganController@penggunaanPaket')->name('penggunaan');

Route::get('/cek-stok', 'BarangController@cekStokBarang')->name('cekstok');
Route::get('/cek-harga', 'HargaController@cekHargaPokok')->name('cekharga');

Route::post('/create-penjualan', 'PenjualanController@create')->name('cekharga');
Route::post('/create-pelanggan', 'PelangganController@create')->name('cekharga');



Route::get('/pilih-barang', 'HargaController@cekHargaPokokBarang');
Route::get('/barang', function () { 
    return view('formBarang');
});
Route::get('/menu', function () { 
    return view('formMenu');
});
Route::get('/menudetail', function () { 
    return view('formMenuDetail');
});

Route::get('/pembelian', function () { 
    return view('formPembelian');
});
Route::get('/paket', function () { 
    return view('formPaket');
});
Route::get('/karyawan-add', function () { 
    return view('formKaryawan');
});
Route::get('/pelanggan-add','PelangganController@index');
Route::get('/sales-add','SalesController@index');
Route::get('/harga-add','HargaController@index');
Route::get('/hutang','HutangController@index');

Route::post('/create-pembelian', 'PembelianController@create')->name('save');
Route::post('/create-barang', 'BarangController@create')->name('save');
Route::post('/create-menu', 'MenuDetailController@create')->name('save');
Route::post('/create-menu-detail', 'MenuDetailController@createMenuDetail')->name('save');
Route::post('/create-paket', 'PaketController@createPaket')->name('save');
Route::post('/create-karyawan', 'KaryawanController@create')->name('save');
Route::post('/create-harga', 'HargaController@create')->name('save');
Route::post('/create-bayar-hutang', 'HutangController@create')->name('save');
Route::get('/cari-barang', 'BarangController@cariBarang')->name('save');
Route::get('/pilih-menu', 'MenuDetailController@pilihMenu')->name('pilihmenu');
Route::get('/cek-paket-pelanggan', 'HutangController@pelanggan')->name('pilihmenu');

Route::get('/detail-barang/{barang}', 'BarangController@showBarangById');
Route::put('/detail-barang/{barang}', 'BarangController@update');


Route::get('/detail-pelanggan/{pelanggan}', 'PelangganController@showPelangganById');
Route::put('/detail-pelanggan/{pelanggan}', 'PelangganController@update');

Route::get('/detail-karyawan/{karyawan}', 'KaryawanController@showKaryawanById');
Route::put('/detail-karyawan/{karyawan}', 'KaryawanController@update');

Route::get('/detail-sales/{sales}', 'SalesController@showSalesById');
Route::put('/detail-sales/{sales}', 'SalesController@update');

Route::get('/detail-harga/{harga}', 'hargaController@showHargaById');
Route::put('/detail-harga/{harga}', 'hargaController@update');

Route::get('/detail-penjualan-Scan/{penjualan}', 'PenjualanController@showPenjualanQrScan');
Route::get('/detail-penjualan/{penjualan}', 'PenjualanController@showPenjualanById');
Route::put('/detail-penjualan/{penjualan}', 'PenjualanController@update');

Route::get('/detail-pembelian/{pembelian}', 'PembelianController@showPembelianById');
Route::put('/detail-pembelian/{pembelian}', 'PembelianController@update');

Route::get('/detail-menu/{menu}', 'MenuDetailController@showMenuById');
Route::put('/detail-menu/{menu}', 'MenuDetailController@update');

Route::get('/detail-menudetail/{menudetail}', 'MenuDetailController@showMenuDetailById');
Route::put('/detail-menudetail/{menudetail}', 'MenuDetailController@updateMenuDetail');

Route::get('/detail-paket/{paket}', 'PaketController@showPaketById');
Route::put('/detail-paket/{paket}', 'PaketController@update');

Route::get('/detail-hutang/{hutang}', 'HutangController@showHutangById');
Route::put('/detail-hutang/{hutang}', 'HutangController@update');

Route::get('qr-code', function () {
  
    \QrCode::size(500)
            ->format('png')
            ->generate('ItSolutionStuff.com', public_path('images/qrcode.png'));
    
  return view('qrCode');
    
});
Route::get('qrcode', function () {
//    phpinfo();
//     return QrCode::format('png')->size(300)->generate('A basic example of QR code! Nicesnippets.com');
    return view('qrCode');
     
 });
 
 
Route::get('qr-code', function () 
{$data="Hello";
  return QrCode::format('svg')->merge('https://www.nicesnippets.com/image/imgpsh_fullsize.png', .17, true)->size(300)->errorCorrection('H')->generate($data);
});
 
 Route::get('qrcode-with-image', function () {
         $image = \QrCode::format('png')
                         ->merge('https://www.nicesnippets.com/image/imgpsh_fullsize.png', 0.5, true)
                         ->size(500)->errorCorrection('H')
                         ->generate('A simple example of QR code!');
      return response($image)->header('Content-type','image/png');
 });

 
 Route::get('/laporan', 'LaporanController@index'); 
 Route::post('/cetak-laporan-coach-detail', 'LaporanController@reportCoachDetail'); 
 Route::post('/cetak-laporan-stok-detail', 'LaporanController@reportStokDetail'); 
 Route::post('/cetak-laporan-penggunaan-paket', 'LaporanController@reportPenggunaanPaketDetail'); 
 Route::post('/cetak-laporan-penerimaan-uang', 'LaporanController@reportPenerimaanUang'); 
 Route::get('/getdata-detail-penjualan-coach/{id}/{startDate}/{endDate}', 'LaporanController@getDetailPenjualanCoach'); 
 Route::get('/getdata-detail-stok-coach/{id}/{startDate}/{endDate}','LaporanController@getStokBarangSales'); 
 Route::get('/getdata-detail-paket/{id}/{startDate}/{endDate}','LaporanController@getPenggunaanPaket'); 
 Route::get('/getdata-penerimaan-uang/{id}/{startDate}/{endDate}','LaporanController@getPenerimaanUang'); 
  Route::get('/profile-pengguna', 'HomeController@profile'); 
  Route::get('/ganti-password', 'HomeController@gantiPassword'); 
  Route::post('/ganti-password', 'HomeController@updatePassword');
  
  
  Route::get('/getdata-pelanggan/{id}/{endDate}','LaporanController@getDataPelanggan'); 
  Route::post('/cetak-laporan-pelanggan', 'LaporanController@reportDataPelanggan'); 
  
  Route::get('/TambahPengguna', 'HomeController@formUser');
  Route::post('/tambah-pengguna', 'HomeController@insertUser');
  Route::get('/getdata-user', 'HomeController@getUserList'); 
  Route::get('managemen-user', function () {
//    phpinfo();
//     return QrCode::format('png')->size(300)->generate('A basic example of QR code! Nicesnippets.com');
    return view('profileManajemenUser');
     
 });
 
 Route::post('/update-status-user', 'HomeController@updateStatus');
 Route::post('/update-pengguna/{user}', 'HomeController@EditUserDetail');
 Route::get('/detail-pengguna/{id}', 'HomeController@detailPengguna');
 Route::get('/edit-pengguna/{id}', 'HomeController@UpdateUser');
 
 Route::get('/delete-data-penjualan/{penjualan}', 'PenjualanController@delete');
 Route::get('/delete-barang/{barang}', 'BarangController@delete');
 Route::get('/delete-pelanggan/{pelanggan}', 'PelangganController@delete');
 Route::get('/delete-sales/{sales}', 'SalesController@delete');
 Route::get('/delete-karyawan/{karyawan}', 'KaryawanController@delete');
 Route::get('/delete-harga/{harga}', 'HargaController@delete');
 Route::get('/delete-pembelian/{pembelian}', 'PembelianController@delete');
 Route::get('/delete-menu/{menu}', 'MenuDetailController@delete');
 Route::get('/delete-menu-detail/{menudetail}', 'MenuDetailController@deleteMenuDetail');
 Route::get('/delete-paket/{paket}', 'PaketController@delete');
 Route::get('/delete-hutang/{hutang}', 'HutangController@delete');
 

 
  