<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SkillType;
use App\Http\Resources\SkillTypeResource;
use Validator;
class SkillTypeController extends Controller
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
        $skill_type = SkillType::where('user_id', $user_id)->get();
        return response()->json(
            [
             'message'=>'Get Skill Type Successfully',
             'skill_type'=>SkillTypeResource::collection($skill_type),
            ],200);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
           
            'name'=>'required|string ',
           
        ]);
             
        if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);
        }
        
        // insert the new edu
        $skill_type =SkillType ::create(array_merge(
            $validator-> validated(),
            ['user_id'=>auth()->user()->id]
        ));

       

        return response()->json(
           [
            'message'=>'Skill Types successfully registred',
            'skill_type'=>new SkillTypeResource($skill_type),
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
            'id'=>'required|numeric|exists:App\Models\SkillType,id',
        ]);

         if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);

        }
        $skill_type = SkillType::find( $id);
        return response()->json(
            [
             'message'=>'Get Skill Type Successfully',
             'skill_type'=>new SkillTypeResource($skill_type),
            ],200);
    }
   
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
       
            $validator=Validator::make($request->all(),[
                'name'=>'required|string ',

        ]);
             
        if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);
        }
        
        $skill_type = SkillType::where('id', $id)->where('user_id', auth()->user()->id)->first();
        

        if($skill_type==null){
           return response()->json( [
               'message'=>'Your id does not exist or this item not your s',
              ],400);

       }
    
       $skill_type->name=$request->input('name');
       $skill_type->save();
       

        return response()->json(
           [
            'message'=>'Skill Type successfully updated',
            'skill_type'=>new SkillTypeResource($skill_type),
           ],200);





    }
    
    
   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {   
  
        
        $skill_type = SkillType::where('id', $id)->where('user_id', auth()->user()->id)->first();
        

         if($skill_type==null){
            return response()->json( [
                'message'=>'Your id does not exist or this item not your s',
               ],400);

        }
        $skill_type->delete();
        return response()->json(
            [
             'message'=>'skill_type id='.$id.' Deleted successfully',
            ],200);
    }
}
