<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Harga;
use App\Sales;

class Level extends Model
{
    
//    protected $table = 'penjualans';
    
    protected $fillable =   [
        'lavel',
    ];
    
    public function harga()
    {
        return $this->hasMany(Harga::class);
    }
    
    public function sales()
    {
        return $this->hasMany(Sales::class);
    }
     
     
}
