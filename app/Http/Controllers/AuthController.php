<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Models\User;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api',[
            'except'=>['register','login',],
        
        ]);

    }
    

    public function register(Request $request){

     // fields validation
        $validator=Validator::make($request->all(),[
            'username'=>'required|unique:users',
            'fullname'=>'required',
            'birthday'=>'required|date',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|string|confirmed|min:6',
            'location'=>'required',

        ]);
             
        if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);
        }
        
     /*   // image validation
        if(!$request->hasFile('image'))
        {
            return response()->json(
                [
                 'message'=>'No image !',
                ],400);
            }
            */
        // insert the new user
        $user =User::create(array_merge(
            $validator-> validated(),
            ['password'=>bcrypt($request->password)]
        ));
        if($request->hasFile('image')){

        $image=$request->file('image');
        $image_name=  rand().'.'.$image->getClientOriginalExtension();
        $user->addMedia($image)
        ->usingFileName($image_name)
        ->toMediaCollection('image');
        }
        return response()->json(
            [
             'message'=>'User successfully registred',
             //'count'=>$user->getMedia('image')->count(),
            ],200);

       /*
       
       
       
        // upload the image   
        $image=$request->file('image');
        $image_name=  rand().'.'.$image->getClientOriginalExtension();
        $user->addMedia($image)
        ->usingFileName($image_name)
        ->toMediaCollection();

        $w1=$user->getMedia('image')->count(); // returns 1
       $r1= $user->getFirstMediaUrl();

       $image=$request->file('i');
        $image_name=  rand().'4.'.$image->getClientOriginalExtension();
        $user->addMedia($image)
        ->usingFileName($image_name)
        ->toMediaCollection();

        $w2=$user->getMedia('image')->count(); // returns 1
        $r2= $user->getFirstMediaUrl();
        return response()->json(
           [
            'message'=>'User successfully registred',
            'count'=>$w1,
            'url'=>$r1,
            'countd'=>$w2,
            'urld'=>$r2,

           ],200);*/

    }   



    public function update(Request $request){

        // fields validation
           $validator=Validator::make($request->all(),[
               'fullname'=>'required',
               'birthday'=>'required|date',
               'password'=>'required|string|confirmed|min:6',
               'location'=>'required',
   
           ]);
                
           if($validator->fails()){
               return response()->json(
                   $validator->errors()->toJson(),400);
           }
           
           $user =User::find(auth()->user()->id);
           $user->fullname=$request->input('fullname');
           $user->birthday=$request->input('birthday');
           $user->password=bcrypt($request->input('password'));
           $user->location=$request->input('location');
           $user->save();
          
   
           return response()->json(
              [
               'message'=>'User successfully updatedx',
               'user'=>new UserResource($user),
              ],200);
   
       }   



       public function updateimage(Request $request){
        if(!$request->hasFile('image'))
        {
            return response()->json(
                [
                 'message'=>'No image !',
                ],400);
            }
           $user =User::find(auth()->user()->id);

           $image=$request->file('image');
           $image_name=  rand().'.'.$image->getClientOriginalExtension();
           $user->addMedia($image)
           ->usingFileName($image_name)
        ->toMediaCollection('image');

     //   $img= $user ->addMediaFromRequest('image')
       // ->toMediaCollection('image');

        
        /* //  $user->getFirstMedia()->delete();
           $user->clearMediaCollection();

           $image=$request->file('image');
           $image_name=  rand().'.'.$image->getClientOriginalExtension();
           $user->addMedia($image)
           ->usingFileName($image_name)
           ->toMediaCollection();
         //  $user->save();
          
       //  $user->clearMediaCollectionExcept('images', $user->getFirstMedia());*/
           return response()->json(
              [
               'message'=>'User successfully updated',
               'user'=>new UserResource($user),
              ],200);
   
       }   
    public function login(Request $request){

        $validator=Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required|string|min:6'

        ]);
       
        if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),422);

        }
        if(!$token=auth()->attempt($validator->validated())){
            return response()->json([
                'errer'=>'Unauthorized'
            ],422);

        }
        
        

       
        return $this->createNewToken($token);
    }

    public function createNewToken($token){
        return response()->json(
            [
                'access_token'=>$token,
                'token_type'=>'bearer',
                'expires_in'=>auth()->factory()->getTTL()*60,
                'user'=>auth()->user()
            ],200);
    }

    public function profile(Request $request){
        $user=auth()->user();
       // $user= Auth::user();
        return response()->json(
            [
                'user'=> new UserResource($user),
             
            ]
        
          ,200);

    }   

    public function  logout( ){
       // Auth::guard('api')->logout();
       auth()->logout();

        return response()->json(
            [
                'message'=>'User logged out ',
               ]
               ,200);

    }   
   


    
}