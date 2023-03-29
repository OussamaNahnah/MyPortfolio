<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Experience;
use App\Http\Resources\ExperienceResource;
use Validator;
class ExpController extends Controller
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
        $experience = Experience::where('user_id', $user_id)->get();
        return response()->json(
            [
             'message'=>'Get ProfessionalNetwork Successfully',
             'experience'=>ExperienceResource::collection($experience),
            ],200);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|string ',            
            'titlejob'=>'required|string ',
            'location'=>'required|string ',
            'startdate'=>'required|date ',
            'enddate'=>'required|date ',

           
        ]);
             
        if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);
        }
        
        // insert the new edu
        $experience =Experience ::create(array_merge(
            $validator-> validated(),
            ['user_id'=>auth()->user()->id]
        ));

       

        return response()->json(
           [
            'message'=>'ProfessionalNetworks successfully registred',
            'experience'=>new ExperienceResource($experience),
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
            'id'=>'required|numeric|exists:App\Models\Experience,id',
        ]);

         if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);

        }
        $experience = Experience::find( $id);
        return response()->json(
            [
             'message'=>'Get ProfessionalNetwork Successfully',
             'experience'=>new ExperienceResource($experience),
            ],200);
    }
   
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
       
            $validator=Validator::make($request->all(),[
            
                'name'=>'required|string ',            
                'titlejob'=>'required|string ',
                'location'=>'required|string ',
                'startdate'=>'required|date ',
                'enddate'=>'required|date ',

        ]);
             
        if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);
        }
        
        $experience = Experience::where('id', $id)->where('user_id', auth()->user()->id)->first();
        

        if($experience==null){
           return response()->json( [
               'message'=>'Your id does not exist or this item not your s',
              ],400);

       }
    
       $experience->name=$request->input('name');
       $experience->titlejob=$request->input('titlejob');          
       $experience->location=$request->input('location');   
       $experience->startdate=$request->input('startdate');
       $experience->enddate=$request->input('enddate');
       $experience->save();
       

        return response()->json(
           [
            'message'=>'Educaion successfully updated',
            'experience'=>new ExperienceResource($experience),
           ],200);





    }
    
    
   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {   
        
        $experience = Experience::where('id', $id)->where('user_id', auth()->user()->id)->first();
        

         if($experience==null){
            return response()->json( [
                'message'=>'Your id does not exist or this item not your s',
               ],400);

        }
        $experience->delete();
        return response()->json(
            [
             'message'=>'experience id='.$id.' Deleted successfully',
            ],200);
    }
}

