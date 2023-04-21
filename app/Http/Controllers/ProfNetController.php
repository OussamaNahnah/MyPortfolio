<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfNetResource;
use App\Models\ProfessionalNetwork;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class ProfNetController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api',  'verified'], [
            'except' => ['index', 'show'],

        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index($user_id)
    {
        //add the passed variable  $user_id to data variable to validate
        $data = [
            'user_id' => $user_id,
        ];
        // validation fields
        $validator = Validator::make($data, [
            'user_id' => 'required|numeric|exists:App\Models\User,id',
        ]);
        // return failed validation
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 400);
        }
        //get the associated Professional Networks
        $pro_nets = ProfessionalNetwork::where('user_id', $user_id)->get();
        //return with successful operation message
        return response()->json(
            [
                'message' => 'Get ProfessionalNetworks Successfully',
                'pro_nets' => ProfNetResource::collection($pro_nets),
            ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validation fields

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:4|max:255 ',
            'link' => 'required|string|min:4|max:255|url',
            'isprincipal' => ['required', 'boolean', Rule::unique('professional_networks')->where(function ($query) {
                return $query->where('user_id', auth()->user()->id)->where('isprincipal', 1);
            })],

        ]);
        //return failed validation
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 400);
        }

        // insert the new professional network
        $prof_net = ProfessionalNetwork::create(array_merge(
            $validator->validated(),
            ['user_id' => auth()->user()->id]
        ));

        // check if icon existe
        if ($request->hasFile('icon')) {
            // upload the image
            $icon = $request->file('icon');
            $icon_name = rand().'.'.$icon->getClientOriginalExtension();
            $prof_net->addMedia($icon)->usingFileName($icon_name)
            ->toMediaCollection('icon');
        }

        //return with successful operation message
        return response()->json(
            [
                'message' => 'ProfessionalNetwork successfully registred',
                'pro_net' => new ProfNetResource($prof_net),
            ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = [
            'id' => $id,
        ];
        // validation fields
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:App\Models\ProfessionalNetwork,id',
        ]);
        //return failed validation
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 400);
        }
        // $pro_net = ProfessionalNetwork::where('id', $id)->first();
        $pro_net = ProfessionalNetwork::find($id);
        //return with successful operation message
        return response()->json(
            [
                'message' => 'Get ProfessionalNetwork Successfully',
                'pro_nets' => new ProfNetResource($pro_net),
            ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {// validation fields
        $validator = Validator::make($request->all(), [
            'name' => ' string|min:4|max:255 ',
            'link' => ' string|min:4|max:255|url',
            'isprincipal' => ['boolean', Rule::unique('professional_networks')->where(function ($query) {
                return $query->where('user_id', auth()->user()->id)->where('isprincipal', 1);
            })],

        ]);
        //return failed validation
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 400);
        }

        $pro_net = ProfessionalNetwork::where('id', $id)->where('user_id', auth()->user()->id)->first();
        //return failed update:because this user havent this proffessional network
        if ($pro_net == null) {
            return response()->json([
                'message' => 'Your id does not exist or this item not your s',
            ], 400);
        }
        if ($request->has('name')) {
            $pro_net->name = $request->input('name');
        }
        if ($request->has('link')) {
            $pro_net->link = $request->input('link');
        }
        if ($request->has('isprincipal')) {
            $pro_net->link = $request->input('isprincipal');
        }

        $pro_net->save();
        //return with successful operation message
        return response()->json(
            [
                'message' => 'ProfessionalNetwork successfully updated',
                'pro_net' => new ProfNetResource($pro_net),
            ], 200);
    }

    public function updateimage(Request $request, string $id)
    {
        if (! $request->hasFile('icon')) {
            return response()->json(
                [
                    'message' => 'No icon !',
                ], 400);
        }

        $pro_net = ProfessionalNetwork::where('id', $id)->where('user_id', auth()->user()->id)->first();
        //return failed update:because this user havent this proffesional network
        if ($pro_net == null) {
            return response()->json([
                'message' => 'Your id does not exist or this item not your s',
            ], 400);
        }

        $image = $request->file('icon');
        $image_name = rand().'.'.$image->getClientOriginalExtension();
        $pro_net->addMedia($image)
        ->usingFileName($image_name)
        ->toMediaCollection('icon');
        //return with successful operation message
        return response()->json(
            [
                'message' => 'ProfessionalNetwork successfully updated',
                'pro_net' => new ProfNetResource($pro_net),
            ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pro_net = ProfessionalNetwork::where('id', $id)->where('user_id', auth()->user()->id)->first();
        //return failed delete:because this user havent this proffesional network
        if ($pro_net == null) {
            return response()->json([
                'message' => 'Your id does not exist or this item not your s',
            ], 400);
        }
        $pro_net->delete();
        //return with successful operation message
        return response()->json(
            [
                'message' => 'ProfessionalNetwork id='.$id.' Deleted successfully',
            ], 200);
    }
}
