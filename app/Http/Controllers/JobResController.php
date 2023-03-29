<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobResponsibility;
use App\Models\Experience;
use App\Models\User;
use App\Http\Resources\JobResResource;
use Validator;
class JobResController extends Controller
{

    public function __construct(){
        $this->middleware('auth:api',[
            'except'=>['index','show'],
        ]);

    }

    /**
     * Display a listing of the resource.
     */
    public function index($experience_id)
    {      
        $data = [
            'experience_id' => $experience_id
        ];
    
        $validator = Validator::make($data, [
            'experience_id'=>'required|numeric|exists:App\Models\Experience,id',
        ]);

         if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);

        }
        $job_responsibility = JobResponsibility::where('experience_id', $experience_id)->get();
        return response()->json(
            [
             'message'=>'Get Job Rsponsibility Successfully',
             'JobRes'=>JobResResource::collection($job_responsibility),
            ],200);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,$experience_id)
    {
      //  return 'userid '.auth()->user()->id;
        $experience = Experience::where('id', $experience_id)->where('user_id', auth()->user()->id)->first();


        if($experience==null){
           return response()->json( [
               'message'=>'Your id does not exist or this item not your s',
              ],400);

       }

         $validator=Validator::make($request->all(),[
           
            'responsibility'=>'required|string ',
           
        ]);
             
        if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);
        }
        
        // insert the new edu
        $job_responsibility =JobResponsibility ::create(array_merge(
            $validator-> validated(),
            ['experience_id'=>$experience_id]
        ));

       

        return response()->json(
           [
            'message'=>'Job Responsibility successfully registred',
            'JobRes'=>new JobResResource($job_responsibility),
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
            'id'=>'required|numeric|exists:App\Models\JobResponsibility,id',
        ]);

         if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);

        }
        $job_responsibility = JobResponsibility::find( $id);
        return response()->json(
            [
             'message'=>'Get Job Rsponsibility Successfully',
             'JobRes'=>new JobResResource($job_responsibility),
            ],200);
    }
   
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
       // echo 'userid '.auth()->user()->id;
        $validator=Validator::make($request->all(),[
                'responsibility'=>'required|string ',
        ]);
             
        if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);
        }
        $isOwnedByUser = User::where('id','=',auth()->user()->id)->whereHas('experiences', function($q) use($id)
        {
            $q->whereHas('job_responsibilities', function($q) use($id)
            {
                $q->where('job_responsibilities.id',$id);
            });
        })->exists();

        if(!$isOwnedByUser){
            return response()->json( [
                'message'=>'Your id does not exist or this item not your s',
               ],400);
 
        }


        $job_responsibility = JobResponsibility::find($id);
       $job_responsibility->responsibility=$request->input('responsibility');
       $job_responsibility->save();
       

        return response()->json(
           [
            'message'=>'Job Rsponsibility successfully updated',
            'JobRes'=>new JobResResource($job_responsibility),
           
           ],200);





    }
    
    
   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {   
        $isOwnedByUser = User::where('id','=',auth()->user()->id)->whereHas('experiences', function($q) use($id)
        {
            $q->whereHas('job_responsibilities', function($q) use($id)
            {
                $q->where('job_responsibilities.id',$id);
            });
        })->exists();

        if(!$isOwnedByUser){
            return response()->json( [
                'message'=>'Your id does not exist or this item not your s',
               ],400);
 
        }
        
        $job_responsibility = JobResponsibility::find($id);
        $job_responsibility->delete();
        return response()->json(
            [
             'message'=>'Job Rsponsibility id='.$id.' Deleted successfully',
            ],200);
    }
}
