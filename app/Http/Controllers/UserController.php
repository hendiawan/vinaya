<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Spatie\Fractal\Fractal;
use App\Transformers\UserTransformers;
use Auth;

class UserController extends Controller
{
    //
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }
    public function user(User $Users)
    {
        $user =$Users->all();
//        dd($user);
        return fractal()
        ->collection($user)
        ->transformWith(new UserTransformers())
        ->toarray();
        
    }
    
    public function test(){
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api.github.com/repos/guzzle/guzzle');
//       $response = $client->request('GET', 'http://192.168.2.56:8001/api/users'); 
//          dd($response);
//        return res;dd
//        
            echo $response->getStatusCode(); // 200
            echo $response->getHeaderLine('content-type'); // 'application/json; charset=utf8'
            echo $response->getBody(); // '{"id": 1420053, "name": "guzzle", ...}'

//$request = new \GuzzleHttp\Psr7\Request('GET', 'http://httpbin.org');
//$promise = $client->sendAsync($request)->then(function ($response) {
//    echo 'I completed! ' . $response->getBody();
//});
//$promise->wait();
        
    }
    
    
    public function profile(User $user){
        $user  = $user->find(Auth::user()->id);
        
        return fractal()
        ->item($user)
        ->transformWith(new UserTransformers) 
        ->includePosts()
        ->toArray();
    }
    
    public function profileById(User $user,$id){
        $user  = $user->find($id);
        return fractal()
        ->item($user)
        ->transformWith(new UserTransformers) 
        ->includePosts()
        ->toArray();
    }
    
    public function update(Request $request,User $user)
    {
        dd($user);
       $this->authorize('update',$post); 
       $user->password = $request->get('password',$user->password);
       $user->save();
       
       return fractal()
       ->item($post)
       ->transformWith(new PostTransformers)
       ->toArray();
        
    }
    
    
    
}
