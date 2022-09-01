<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Level;
use App\Paket;

class Hutang extends Model
{
    
//    protected $table = 'penjualans';
    
    protected $fillable =   [
        'tgl_bayar',
        'user_id',
        'debet',
        'kredit',
        'paket_id', 
    ];
   
    public function paket()
    {
        return $this->belongsTo(Paket::class)->with('menu','pelanggan');
    }
     
}
