<?php

namespace App\Http\Controllers;

use App\Http\Resources\SkillTypeResource;
use App\Models\SkillType;
use Illuminate\Http\Request;
use Validator;

class SkillTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', [
            'except' => ['index', 'show'],

        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index($user_id)
    {//add the passed variable  $id to data variable to validate
        $data = [
            'user_id' => $user_id,
        ];
        // validation fields
        $validator = Validator::make($data, [
            'user_id' => 'required|numeric|exists:App\Models\User,id',
        ]);
        //return failed validation

        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 400);
        }
        $skill_type = SkillType::where('user_id', $user_id)->get();
        //return with successful operation message
        return response()->json(
            [
                'message' => 'Get SkillTypes Successfully',
                'skill_type' => SkillTypeResource::collection($skill_type),
            ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validation fields
        $validator = Validator::make($request->all(), [

            'name' => 'required|string ',

        ]);
        //return failed validation
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 400);
        }

        // insert the new skill type
        $skill_type = SkillType::create(array_merge(
            $validator->validated(),
            ['user_id' => auth()->user()->id]
        ));
        //return with successful operation message
        return response()->json(
            [
                'message' => 'SkillType successfully registred',
                'skill_type' => new SkillTypeResource($skill_type),
            ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //add the passed variable $id to data variable to validate
        $data = [
            'id' => $id,
        ];
        // validation fields
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:App\Models\SkillType,id',
        ]);
        //return failed validation
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 400);
        }
        $skill_type = SkillType::find($id);
        //return with successful operation message
        return response()->json(
            [
                'message' => 'Get SkillType Successfully',
                'skill_type' => new SkillTypeResource($skill_type),
            ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {// validation fields
        $validator = Validator::make($request->all(), [
            'name' => 'required|string ',

        ]);
        //return failed validation
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 400);
        }

        $skill_type = SkillType::where('id', $id)->where('user_id', auth()->user()->id)->first();

        //return failed update:because this user havent this skilltype

        if ($skill_type == null) {
            return response()->json([
                'message' => 'Your id does not exist or this item not your s',
            ], 400);
        }

        $skill_type->name = $request->input('name');
        $skill_type->save();
        //return with successful operation message
        return response()->json(
            [
                'message' => 'SkillType successfully updated',
                'skill_type' => new SkillTypeResource($skill_type),
            ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $skill_type = SkillType::where('id', $id)->where('user_id', auth()->user()->id)->first();
        //return failed delete:because this user havent this skilltype
        if ($skill_type == null) {
            return response()->json([
                'message' => 'Your id does not exist or this item not your s',
            ], 400);
        }
        $skill_type->delete();
        //return with successful operation message
        return response()->json(
            [
                'message' => 'skill_type id='.$id.' Deleted successfully',
            ], 200);
    }
}
