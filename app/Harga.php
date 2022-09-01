<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Level;
use App\Barang;


class Harga extends Model
{
    
//    protected $table = 'penjualans';
    
    protected $fillable =   [
        'barang_id',
        'level_id',
        'harga_pokok',
        'takaran',
        'harga_perporsi',
    ];
    
    public function level()
    {
        return $this->belongsTo(Level::class);
    }
    
    public function barang()
    {
       return $this->belongsTo(Barang::class); 
    }
     
}
