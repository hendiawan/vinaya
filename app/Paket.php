<?php

namespace App;

use Illuminate\Database\Eloquent\Model; 
use App\Penjualan;
use App\Pelanggan;
use App\Hutang;
class Paket extends Model
{
    //
//    protected $table = 'penjualans';
    
    protected $fillable =   [
        'pelanggan_id',
        'tgl_beli',
        'menu_id',
        'harga',
        'qty',
        'harga_jual',
        'total_bayar',
        'status',
        'bayar',
        'masa_kadaluarsa',
        'tgl_kadaluarsa',
    ];
    
    public function penjualan()
    {
        return $this->hasMany(Penjualan::class);
    }
    
    public function  menu()
    {
        return $this->belongsTo(Menu::class)->with('menudetail');
    }
    
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class)->with('sales');
    }
    
    public function hutang()
    {
        return $this->hasMany(Hutang::class);
    }
    
}
