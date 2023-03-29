<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhoneNumber;
use App\Http\Resources\PhoNumResource;
use Validator;
class PhoNumController extends Controller
{

    public function __construct(){
        $this->middleware('auth:api',[
            'except'=>['index','show'],
        
        ]);

    }

    /**
     * Display a listing of the resource.
     */
    public function index($user_id)
    {
        $data = [
            'user_id' => $user_id
        ];
    
        $validator = Validator::make($data, [
            'user_id'=>'required|numeric|exists:App\Models\User,id',
        ]);

         if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);

        }
        $phone_number = PhoneNumber::where('user_id', $user_id)->get();
        return response()->json(
            [
             'message'=>'Get Phone Number Successfully',
             'phone_number'=>PhoNumResource::collection($phone_number),
            ],200);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

         $validator=Validator::make($request->all(),[
           
            'numberphone'=>'required|string ',
           
        ]);
             
        if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);
        }
        
        // insert the new edu
        $phone_number =PhoneNumber ::create(array_merge(
            $validator-> validated(),
            ['user_id'=>auth()->user()->id]
        ));

       

        return response()->json(
           [
            'message'=>'Phone Numbers successfully registred',
            'phone_number'=>new PhoNumResource($phone_number),
           ],200);

    }
  /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $data = [
            'id' => $id
        ];
    
        $validator = Validator::make($data, [
            'id'=>'required|numeric|exists:App\Models\PhoneNumber,id',
        ]);

         if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);

        }
        $phone_number = PhoneNumber::find( $id);
        return response()->json(
            [
             'message'=>'Get Phone Number Successfully',
             'phone_number'=>new PhoNumResource($phone_number),
            ],200);
    }
   
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
       
            $validator=Validator::make($request->all(),[
                'numberphone'=>'required|string ',

        ]);
             
        if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);
        }
        
        $phone_number = PhoneNumber::where('id', $id)->where('user_id', auth()->user()->id)->first();
        

        if($phone_number==null){
           return response()->json( [
               'message'=>'Your id does not exist or this item not your s',
              ],400);

       }
    
       $phone_number->numberphone=$request->input('numberphone');
       $phone_number->save();
       

        return response()->json(
           [
            'message'=>'Educaion successfully updated',
            'phone_number'=>new PhoNumResource($phone_number),
           ],200);





    }
    
    
   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {   
  
        
        $phone_number = PhoneNumber::where('id', $id)->where('user_id', auth()->user()->id)->first();
        

         if($phone_number==null){
            return response()->json( [
                'message'=>'Your id does not exist or this item not your s',
               ],400);

        }
        $phone_number->delete();
        return response()->json(
            [
             'message'=>'phone_number id='.$id.' Deleted successfully',
            ],200);
    }
}
