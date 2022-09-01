<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Transformers;
use App\Post;
use League\Fractal\TransformerAbstract;

class PostTransformers extends TransformerAbstract {
    
    public function transform(Post $post)
    {
        return[
           'id' => $post->id, 
           'content' => $post->content, 
           'publish' => $post->created_at, 
        ];
    }
    
    
}

