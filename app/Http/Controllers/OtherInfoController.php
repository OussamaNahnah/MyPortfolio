<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OtherInfo;
use App\Http\Resources\OtherInfoResource;
use Validator;
class OtherInfoController extends Controller
{

    public function __construct(){
        $this->middleware('auth:api',[
            'except'=>['index','show'],
        
        ]);

    }

    /**
     * Display a listing of the resource.
     */
    public function show($user_id)
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
        $other_info = OtherInfo::where('user_id', $user_id)->first();

        if($other_info==null){
            return response()->json( [
                'message'=>$user_id.' havent other info',
               ],400);
 
        }
        return response()->json(
            [
             'message'=>'Get Phone Number Successfully',
             'other_info'=>new OtherInfoResource($other_info),
            ],200);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            'id' => auth()->user()->id
        ];
    
        $validator = Validator::make($data, [
            'id'=>'required|numeric|unique:other_infos,user_id',
        ]);

         if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);

        }

         $validator=Validator::make($request->all(),[
           
            'description'=>'required|string ',
           
        ]);
             
        if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);
        }
        
        // insert the new edu
        $other_info =OtherInfo ::create(array_merge(
            $validator-> validated(),
            ['user_id'=>auth()->user()->id]
        ));

       

        return response()->json(
           [
            'message'=>'Phone Numbers successfully registred',
            'other_info'=>new OtherInfoResource($other_info),
           ],200);

    }
 
   
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {   
       
            $validator=Validator::make($request->all(),[
                'description'=>'required|string ',

        ]);
             
        if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);
        }
        $user_id=auth()->user()->id;
        $other_info = OtherInfo::where('user_id',$user_id )->first();
        

        if($other_info==null){
           return response()->json( [
               'message'=>'you havent other info',
              ],400);

       }
    
       $other_info->description=$request->input('description');
       $other_info->save();
       

        return response()->json(
           [
            'message'=>'Educaion successfully updated',
            'other_info'=>new OtherInfoResource($other_info),
           ],200);





    }
    
    
   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy( )
    {   
  
        
        $other_info = OtherInfo::where('user_id', auth()->user()->id)->first();
        

         if($other_info==null){
            return response()->json( [
                'message'=>'you have no other info',
               ],400);

        }
        $other_info->delete();
        return response()->json(
            [
             'message'=>'other_info id='.auth()->user()->id.' Deleted successfully',
            ],200);
    }
}
