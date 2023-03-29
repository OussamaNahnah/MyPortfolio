<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfessionalNetwork;
use App\Http\Resources\ProfNetResource;
use Validator;
class ProfNetController extends Controller
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
        $pro_nets = ProfessionalNetwork::where('user_id', $user_id)->get();
        return response()->json(
            [
             'message'=>'Get ProfessionalNetwork Successfully',
           //  'pro_nets'=>new ProfNetCollection($pro_nets),
             'pro_nets'=>ProfNetResource::collection($pro_nets),
          //   'pro_nets'=>$pro_nets,
            ],200);
    }





    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|string ',
            'link'=>'required|url',
           
        ]);
             
        if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);
        }
        
        // icon validation
        if(!$request->hasFile('icon'))
        {
            return response()->json(
                [
                 'message'=>'No icon !',
                ],400);
            }
        // insert the new user
        $prof_net =ProfessionalNetwork::create(array_merge(
            $validator-> validated(),
            ['user_id'=>auth()->user()->id]
        ));

        // upload the image   
        $icon=$request->file('icon');
        $icon_name=  rand().'.'.$icon->getClientOriginalExtension();
        $prof_net->addMedia($icon)->usingFileName($icon_name)
        ->toMediaCollection('icon');

        return response()->json(
           [
            'message'=>'ProfessionalNetworks successfully registred',
            'pro_net'=>new ProfNetResource($prof_net),
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
            'id'=>'required|numeric|exists:App\Models\ProfessionalNetwork,id',
        ]);

         if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);

        }
       // $pro_net = ProfessionalNetwork::where('id', $id)->first();
        $pro_net = ProfessionalNetwork::find( $id);
        return response()->json(
            [
             'message'=>'Get ProfessionalNetwork Successfully',
             'pro_nets'=>new ProfNetResource($pro_net),
            ],200);
    }
   
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
       
            $validator=Validator::make($request->all(),[
            'name'=>'required|string ',
            'link'=>'required|url',

        ]);
             
        if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);
        }
        
        $pro_net = ProfessionalNetwork::where('id', $id)->where('user_id', auth()->user()->id)->first();
        

        if($pro_net==null){
           return response()->json( [
               'message'=>'Your id does not exist or this item not your s',
              ],400);

       }
    
        $pro_net->name=$request->input('name');
        $pro_net->link=$request->input('link');
        $pro_net->save();
       

        return response()->json(
           [
            'message'=>'ProfessionalNetwork successfully updated',
            'pro_net'=>new ProfNetResource($pro_net),
           ],200);





    }
    
    
    public function updateimage(Request $request, string $id)
    {
        if(!$request->hasFile('icon'))
        {
            return response()->json(
                [
                 'message'=>'No icon !',
                ],400);
            }


            $pro_net = ProfessionalNetwork::where('id', $id)->where('user_id', auth()->user()->id)->first();
        

            if($pro_net==null){
               return response()->json( [
                   'message'=>'Your id does not exist or this item not your s',
                  ],400);
    
           }
        
           $image=$request->file('icon');
           $image_name=  rand().'.'.$image->getClientOriginalExtension();
           $pro_net->addMedia($image)
           ->usingFileName($image_name)
        ->toMediaCollection('icon');

   
           return response()->json(
              [
                'message'=>'ProfessionalNetwork successfully updated',
                'pro_net'=>new ProfNetResource($pro_net),
              ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {   
  
        
        $pro_net = ProfessionalNetwork::where('id', $id)->where('user_id', auth()->user()->id)->first();
        

         if($pro_net==null){
            return response()->json( [
                'message'=>'Your id does not exist or this item not your s',
               ],400);

        }
        $pro_net->delete();
        return response()->json(
            [
             'message'=>'ProfessionalNetwork id='.$id.' Deleted successfully',
            ],200);
    }
}
