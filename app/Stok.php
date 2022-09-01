<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Barang;
use App\Sales;

class Stok extends Model
{
    //
//    protected $table = 'penjualans';
    
    protected $fillable =   [
        'tgl',
        'sales_id',
        'barang_id',
        'type',
        'stok_in',
        'stok_out',
        'type_id',
    ];
    
   public function sales()
   {
       //relasi yang terbentuk antara tabel sales dengan tabel pelanggan
//       return $this->hasMany(Sales::class);
       return $this->belongsTo(Sales::class)->with('karyawan');
   }
   
   public function barang()
   {
          //relasi yang terbentuk antara tabel sales dengan tabel Karyawan
       return $this->belongsTo(Barang::class);
   }
    
   
}
