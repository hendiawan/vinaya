<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Barang;
use App\Sales;
use App\Supplier;

class Pembelian extends Model
{
    
//    protected $table = 'penjualans';
    
    protected $fillable =   [
        'tgl_beli',
        'barang_id',
        'qty',
        'sales_id',
        'supplier_id',
        'stok',
        'harga_pokok',
    ];
    
    public function barang()
    {
        return $this->belongsTo(Barang::class); 
    }
    
    public  function sales()
    {
       return $this->belongsTo(Sales::class)->with('karyawan');
    }
    
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }      
     
}
