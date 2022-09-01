<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Transformers;

use App\User;
use App\Transformers\PostTransformers;
use League\Fractal\TransformerAbstract;

class UserTransformers extends TransformerAbstract {
    
    protected $availableIncludes    =   [
        'posts'
    ];
    
    public function transform(User $user)
    {
        return[
            'name'=>$user->username,
            'email'=>$user->email,
            'registered'=>$user->created_at->diffForHumans()
        ];
    }
    
    public function includePosts(User $user)
    {
        $posts = $user->posts()->latesFirst()->get();
        
        return $this->collection($posts, new PostTransformers);
        
    }
}
