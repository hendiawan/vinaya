<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pelanggan;
use App\Karyawan;
use App\Pembelian;
use App\Level;

class Sales extends Model
{
    //
//    protected $table = 'penjualans';
    
    protected $fillable =   [
        'level_id',
        'karyawan_id',
        'iuran',
    ];
    
   public function pelanggan()
   {
       //relasi yang terbentuk antara tabel sales dengan tabel pelanggan
       return $this->hasMany(Pelanggan::class);
   }
   
   public function karyawan()
   {
          //relasi yang terbentuk antara tabel sales dengan tabel Karyawan
       return $this->belongsTo(Karyawan::class);
   }
   
   public function  pembelian()
   {
       return $this->hasMany(Pembelian::class);
   }
   
   public function level()
   {
       return $this->belongsTo(Level::class)->with('harga');
   }
   
   
   
}
