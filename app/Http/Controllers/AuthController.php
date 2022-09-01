<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transformers\UserTransformers;
use Auth;
use GuzzleHttp;
use Illuminate\Validation\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //
     
    public function register(Request $request,User $user){
//               
       $validator = \Validator::make($request->all(), [
                        'username'=>'required',
                        'email'=>'required|email|unique:users',
                        'password'=>'required|min:3',
                ]);
                
//       dd( );
       if ($validator->fails()) {
            return response()->json([
                        'status' => 'error',
//                        'message' => $validasi->getMessageBag()
                        'message' => $validator->errors()->first(),
                            ]);
        }
        
        $user = $user->create([
                      'username' => $request->username,
                      'email' => $request->email,
                      'role' => $request->role,
                      'jenis_user' => $request->jenis_user,
                      'password' => bcrypt($request->password),
                      'api_token' => bcrypt($request->email),
        ]);
        
        $response= fractal()
                ->item($user)
                ->transformWith(new UserTransformers)
                ->addMeta([
                    'token' => $user->api_token
                 ])
                ->toArray();
//        $response = ["message"=>"berhasil bos",
//                                  "data"=>["pesan"=>"ulet gigih pantang menyerah"]
//                                ];
//        return response()->json($response,201);
         return response()->json([
                        'status' => 'berhasil',
                        'message' =>'Sukses input data user'
                            ]);
        
    }
    
    public function login(Request $request, User $user)
    {
        if(!Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
               return response()->json(['error'=>'Your Credential is Wrong',401]);
        }
        
        $user   =   $user->find(Auth::user()->id);
        
        return fractal()
            ->item($user)
            ->transformWith( new UserTransformers)
            ->addMeta([
                'token'  =>$user->api_token
            ])
            ->toArray();
        
    }
    
    
    
}
