<?php

namespace App;

use Illuminate\Database\Eloquent\Model; 
use App\Paket;
use App\MenuDetail;

class Menu extends Model
{
    //
//    protected $table = 'penjualans';
    
    protected $fillable =   [
        'nama_menu',
        'harga',
        'qty',
        'harga_jual',
        'kadaluarsa',
    ];
    
    public function paket()
    {
        return $this->hasMany(Paket::class);
    }
    
    public function menudetail()
    {
        return $this->hasMany(MenuDetail::class)->with('barang');
    }
    
}
