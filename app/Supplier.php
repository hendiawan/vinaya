<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pembelian;


class Supplier extends Model
{
   
    protected $fillable =   [
        'nama_supplier',
        'alamat_supplier',
        'telephone',
    ];
   
   public function pembelian()
   {
       //relasi yang terbentuk antara tabel supplier dengan tabel pebelian
       return $this->hasMany(Pembelian::class);
   }
    
   
}
