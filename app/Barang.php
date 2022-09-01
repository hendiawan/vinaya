<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pembelian;
use App\Detailmenu;
use App\Harga;

class Barang extends Model
{ 
//    protected $table = 'penjualans'; 
    protected $fillable =   [
        'nama_barang',
        'netto',
        'satuan',
        'takaran', 
        'jenisbarang_id'
    ];
    
    public function pembelian()
    {
        return $this->hasMany(Pembelian::class);
    }
    
    public function menudetail()
    {
        return $this->hasMany(MenuDetail::class)->with('menu');
    }
    
    public function harga()
    {
        return $this->hasMany(Harga::class);
    }
     
     
}
