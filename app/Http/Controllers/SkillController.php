<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;
use App\Models\SkillType;
use App\Models\User;
use App\Http\Resources\SkillResource;
use Validator;
class SkillController extends Controller
{

    public function __construct(){
        $this->middleware('auth:api',[
            'except'=>['index','show'],
        ]);

    }

    /**
     * Display a listing of the resource.
     */
    public function index($skill_type_id)
    {      
        $data = [
            'skill_type_id' => $skill_type_id
        ];
    
        $validator = Validator::make($data, [
            'skill_type_id'=>'required|numeric|exists:App\Models\SkillType,id',
        ]);

         if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);

        }
        $skill = Skill::where('skill_type_id', $skill_type_id)->get();
        return response()->json(
            [
             'message'=>'Get Skill Successfully',
             'JobRes'=>SkillResource::collection($skill),
            ],200);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,$skill_type_id)
    {
      //  return 'userid '.auth()->user()->id;
        $skill_type = SkillType::where('id', $skill_type_id)->where('user_id', auth()->user()->id)->first();


        if($skill_type==null){
           return response()->json( [
               'message'=>'Your id does not exist or this item not your s',
              ],400);

       }

         $validator=Validator::make($request->all(),[
           
            'name'=>'required|string ',
           
        ]);
             
        if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);
        }
        
        // insert the new edu
        $skill =Skill ::create(array_merge(
            $validator-> validated(),
            ['skill_type_id'=>$skill_type_id]
        ));

       

        return response()->json(
           [
            'message'=>'Skill successfully registred',
            'JobRes'=>new SkillResource($skill),
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
            'id'=>'required|numeric|exists:App\Models\Skill,id',
        ]);
         if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);

        }
        $skill = Skill::find( $id);
        return response()->json(
            [
             'message'=>'Get Skill Successfully',
             'JobRes'=>new SkillResource($skill),
            ],200);
    }
   
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
       // echo 'userid '.auth()->user()->id;
        $validator=Validator::make($request->all(),[
                'name'=>'required|string ',
        ]);
             
        if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);
        }
        $isOwnedByUser = User::where('id','=',auth()->user()->id)->whereHas('skill_types', function($q) use($id)
        {
            $q->whereHas('skills', function($q) use($id)
            {
                $q->where('skills.id',$id);
            });
        })->exists();

        if(!$isOwnedByUser){
            return response()->json( [
                'message'=>'Your id does not exist or this item not your s',
               ],400);
 
        }


       $skill = Skill::find($id);
       $skill->name=$request->input('name');
       $skill->save();
       

        return response()->json(
           [
            'message'=>'Skill  successfully updated',
            'JobRes'=>new SkillResource($skill),
           
           ],200);





    }
    
    
   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {   
        $isOwnedByUser = User::where('id','=',auth()->user()->id)->whereHas('skill_types', function($q) use($id)
        {
            $q->whereHas('skills', function($q) use($id)
            {
                $q->where('skills.id',$id);
            });
        })->exists();

        if(!$isOwnedByUser){
            return response()->json( [
                'message'=>'Your id does not exist or this item not your s',
               ],400);
 
        }
        
        $skill = Skill::find($id);
        $skill->delete();
        return response()->json(
            [
             'message'=>'Skillid='.$id.' Deleted successfully',
            ],200);
    }
}
