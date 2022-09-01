<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Barang;
use App\Penjualan;

class PenjualanDetail extends Model
{
    
//    protected $table = 'penjualans';
    
    protected $fillable =   [
        'tgl_jual',
        'qty',
        'barang_id',
        'penjualan_id',
        'sales_id',
        'harga_pokok',
        'harga_jual',
        'laba_kotor',
        'harga_jual',
        'iuran',
        ];
    
        public  function barang()
        {
            return $this->belongsTo(Barang::class);
        }
        
        public function penjualan()
        {
            return $this->belongsTo(Penjualan::class);
        }
     
}
