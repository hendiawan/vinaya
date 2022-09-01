<?php

namespace App;

use Illuminate\Database\Eloquent\Model; 
use App\Menu;

class MenuDetail extends Model
{
  
    
    protected $fillable =   [
        'menu_id',
        'barang_id',
        'takaran'
    ];
    
    public function menu()
    {
        return $this->belongsTo(Menu::class)->with('paket');
    }
    
    public  function barang()
    {
        return $this->belongsTo(Barang::class)->with('harga');
    }
    
}
