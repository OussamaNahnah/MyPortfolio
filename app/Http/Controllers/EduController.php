<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Education;
use App\Http\Resources\EducationResource;
use Validator;
class EduController extends Controller
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
        $education = Education::where('user_id', $user_id)->get();
        return response()->json(
            [
             'message'=>'Get ProfessionalNetwork Successfully',
             'education'=>EducationResource::collection($education),
            ],200);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
           
            'nameschool'=>'required|string ',
            'specialization'=>'required|string ',
            'startdate'=>'required|date ',
            'enddate'=>'required|date ',
           
        ]);
             
        if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);
        }
        
        // insert the new edu
        $education =Education ::create(array_merge(
            $validator-> validated(),
            ['user_id'=>auth()->user()->id]
        ));

       

        return response()->json(
           [
            'message'=>'ProfessionalNetworks successfully registred',
            'education'=>new EducationResource($education),
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
            'id'=>'required|numeric|exists:App\Models\Education,id',
        ]);

         if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);

        }
        $education = Education::find( $id);
        return response()->json(
            [
             'message'=>'Get ProfessionalNetwork Successfully',
             'education'=>new EducationResource($education),
            ],200);
    }
   
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
       
            $validator=Validator::make($request->all(),[
                'nameschool'=>'required|string ',
                'specialization'=>'required|string ',
                'startdate'=>'required|date ',
                'enddate'=>'required|date ',

        ]);
             
        if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);
        }
        
        $education = Education::where('id', $id)->where('user_id', auth()->user()->id)->first();
        

        if($education==null){
           return response()->json( [
               'message'=>'Your id does not exist or this item not your s',
              ],400);

       }
    
       $education->nameschool=$request->input('nameschool');
       $education->specialization=$request->input('specialization');   
       $education->startdate=$request->input('startdate');
       $education->enddate=$request->input('enddate');
       $education->save();
       

        return response()->json(
           [
            'message'=>'Educaion successfully updated',
            'education'=>new EducationResource($education),
           ],200);





    }
    
    
   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {   
  
        
        $education = Education::where('id', $id)->where('user_id', auth()->user()->id)->first();
        

         if($education==null){
            return response()->json( [
                'message'=>'Your id does not exist or this item not your s',
               ],400);

        }
        $education->delete();
        return response()->json(
            [
             'message'=>'education id='.$id.' Deleted successfully',
            ],200);
    }
}
