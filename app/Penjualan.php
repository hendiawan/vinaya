<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Pelanggan;
use App\Menu;
use App\Karyawan;
use App\Paket;
use App\Sales;

class Penjualan extends Model
{
    
//    protected $table = 'penjualans';
    
    protected $fillable =   [
        'tgl_jual',
        'pelanggan_id',
        'user_id',
        'paket_id',
        'sales_id',
        'menu_id',
        'qty_jual',
        'harga_pokok',
        'harga_jual',
        'diskon',
        'qty_paket',
//        'total_pengunaan_paket',
//        'sisa_paket',
        'iuran',
        'laba_kotor', 
        'created_at', 
        'updated_at', 
        'non_member', 
    ];
    
    public function user()
    {
        //  return $this->belongsTo('App\Models\User', 'foreign_key');
        //  return $this->belongsTo('App\Models\User', 'foreign_key', 'owner_key');
        // relasi One to One yang terbentuk antara tabel Penjualan dengan tabel User
          return $this->belongsTo(User::class);
    }
    
    public function pelanggan()
    {
        //relasi One to One antara tabel Penjualan dengan tabel Pelanggan dengan mengincludkan tabel Sales yang ada pada model pelanggan
        return $this->belongsTo(Pelanggan::class)->with('sales','paket'); 
    }
    
    public function paket()
    {
        //relasi One to One yang terbentuk antara tabel Penjualan dengan Tabel Paket
        return $this->belongsTo(Paket::class)->with('menu','hutang');
    } 
    
    public function sales()
    {
        return $this->belongsTo(Sales::class)->with('level','karyawan');
    }
     
    
}
