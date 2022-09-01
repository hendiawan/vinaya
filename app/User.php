<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Post;
use App\Penjualan;
use Auth;
use App\Karyawan;
use App\Pelanggan;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email', 
        'password',
        'pelanggan_id',
        'karyawan_id',
        'role',
        'is_active',
        'jenis_user',
        'api_token' 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
          'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function posts(){
        return $this->hasMany(Post::class);
    }
    
    public function penjualan(){
        //relasi One to Many yang terbentuk antara tabel user dengan tabel Penjualan
        return $this->hasMany(Penjualan::class);
    }
    
    public function ownsPost(Post $post)
    {
        return auth()->id()== $post->user->id;
    }
    
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }
    
}
