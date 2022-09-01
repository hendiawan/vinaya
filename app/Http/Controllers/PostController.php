<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Post;
use App\Transformers\PostTransformers;
use Auth;

class PostController extends Controller
{
    //
    
    public function add(Request $request, Post $post)
    {
//        dd($post);
        $this->validate($request,[
            'content'   =>'required|min:10'
        ] );
        
        $post= $post->create([
                'user_id'   => Auth::user()->id,
                'content'   => $request->content,
        ]);
        
        $response = fractal()
                ->item($post)
                ->transformWith(new PostTransformers)
                ->toArray();
        return response()->json($response,201);
    }
    
    public function update(Request $request,Post $post)
    {//parameter $post harus sesuai dengan nama tabel, karena 
        //untuk melakukan update data otomatis akan terbaca id post tersebut
//        dd($post); 
       $this->authorize('update',$post); 
       $post->content = $request->get('content',$post->content);
       $post->save();
       
       return fractal()
       ->item($post)
       ->transformWith(new PostTransformers)
       ->toArray();
        
    }
    
    public function delete(Post $post)
    {//parameter $post harus sesuai dengan nama tabel, karena 
        //untuk melakukan delete data otomatis akan terbaca id post tersebut
        $this->authorize('delete',$post);
        $post->delete();
        
        return response()->json([
            'message'=>'Post deleted',
        ]);
    }
    
    
     
}
