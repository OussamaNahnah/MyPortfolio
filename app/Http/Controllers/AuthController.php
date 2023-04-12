<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', [
            'except' => ['register', 'login', 'show', 'index'],

        ]);
    }

    public function show($id)
    {//add the passed variable  $id to data variable to validate
        $data = [
            'id' => $id,
        ];
        // validation fields
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:App\Models\User,id',
        ]);
        //return failed validation
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 400);
        }
        $user = User::find($id);
        //return with successful operation message
        return response()->json(
            [
                'message' => 'Get user Successfully',
                'user' => new UserResource($user),
            ], 200);
    }

    public function index()
    {
        $users = User::paginate(4);
        //return with successful operation message
        return response()->json(
            [
                'message' => 'Get Users  Successfully (pagination of 4 users)',
                'user' => UserResource::collection($users),
            ], 200);
    }

    public function register(Request $request)
    {
        // validation fields
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'fullname' => 'required',
            'birthday' => 'required|date',
            'email' => 'required|string|email|unique:users',
            'location' => 'required',
            'password' => 'required|string|confirmed|min:6',
            'bio' => 'required ',

        ]);
        //return failed validation
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 400);
        }

        // insert the new user
        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));
        // insert the image if existe
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = rand().'.'.$image->getClientOriginalExtension();
            $user->addMedia($image)
            ->usingFileName($image_name)
            ->toMediaCollection('image');
        }

        //return with successful operation message
        return response()->json(
            [
                'message' => 'User successfully registred',
                //'count'=>$user->getMedia('image')->count(),
            ], 200);
    }

    public function update(Request $request)
    {
        // validation fields
        $validator = Validator::make($request->all(), [
            'username' => 'unique:users',
            'birthday' => 'date',
            'password' => 'string|confirmed|min:6',

        ]);
        //return failed validation
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 400);
        }
        // update the user
        $user = User::find(auth()->user()->id);
        if ($request->has('username')) {
            $user->username = $request->input('username');
        }
        if ($request->has('fullname')) {
            $user->fullname = $request->input('fullname');
        }
        if ($request->has('bio')) {
            $user->bio = $request->input('bio');
        }
        if ($request->has('birthday')) {
            $user->birthday = $request->input('birthday');
        }
        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        if ($request->has('location')) {
            $user->location = $request->input('location');
        }
        $user->save();

        //return with successful operation message
        return response()->json(
            [
                'message' => 'User successfully updated',
                'user' => new UserResource($user),
            ], 200);
    }

       public function updateimage(Request $request)
       {
           // image validation
           if (! $request->hasFile('image')) {
               return response()->json(
                   [
                       'message' => 'No image !',
                   ], 400);
           }
           //the the user instance
           $user = User::find(auth()->user()->id);
           //update the image
           $image = $request->file('image');
           $image_name = rand().'.'.$image->getClientOriginalExtension();
           $user->addMedia($image)
           ->usingFileName($image_name)
        ->toMediaCollection('image');

           //return with successful operation message
           return response()->json(
               [
                   'message' => 'User successfully updated',
                   'user' => new UserResource($user),
               ], 200);
       }

    public function login(Request $request)
    {
        // validation fields
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',

        ]);

        //return failed validation
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 422);
        }
        ////return failed authentication
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json([
                'errer' => 'Unauthorized',
            ], 422);
        }

        //grenerate a new authentication token and return it
        return $this->createNewToken($token);
    }

    public function createNewToken($token)
    {
        return response()->json(
            [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'user' => auth()->user(),
            ], 200);
    }

    public function profile(Request $request)
    {
        //return with successful operation message
        return response()->json(
            [
                'user' => new UserResource(auth()->user()),
            ], 200);
    }

    public function logout()
    {
        // invalidate the token
        auth()->logout();
        //return with successful operation message
        return response()->json(
            [
                'message' => 'User logged out ',
            ], 200);
    }
}
