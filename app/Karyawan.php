<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Sales;
use App\Pelanggan;

class Karyawan extends Model
{
    //
//    protected $table = 'penjualans';
    
    protected $fillable =   [
        'nama_karyawan',
        'jabatan',
        'telp',
        'alamat'
    ];
    
   public function pelanggan()
   {
       //relasi antara tabel karyawan dengan Pelanggan yang dihubungakan melaui tabel sales
       return $this->hasManyThrough(Pelanggan::class,Sales::class);
   }
   
   public function sales()
   {
         //relasi antara tabel karyawan dengan sales
       return $this->belongsTo(Sales::class);
   }
   
   
}
