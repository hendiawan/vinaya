<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Penjualan;
use App\Sales;
use App\Karyawan;
use App\Paket;

class Pelanggan extends Model
{
    //
//    protected $table = 'penjualans';
    
    protected $fillable =   [
        'nama_pelanggan',
        'alamat',
        'tgl_lahir',
        'telp',
        'sales_id'
    ];
    
   public function penjualan()
   {
       //relasi One to Many antara tabel pelanggan dengan tabel penjualan
       return $this->hasMany(Penjualan::class);
   }
   
   public function sales()
   {
       //relasi One to One antara tabel pelanggan dengan tabel sales dengan menginclude tabel Karyawan
       return $this->belongsTo(Sales::class)->with('karyawan','level');
   }
   
   public function paket()
   {
       return $this->hasMany(Paket::class)->with('menu');
   }
    
}
