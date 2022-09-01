<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Post extends Model
{
    //
    
    protected $fillable =   [
        'user_id','content'
    ];
    
    public function scopeLatesFirst($query)
    {
        return $query->orderBy('id','DESC');
    }
 

    public function user()
    {
        //  return $this->belongsTo('App\Models\User', 'foreign_key');
        //  return $this->belongsTo('App\Models\User', 'foreign_key', 'owner_key');
        return $this->belongsTo(User::class);
    }
}
