<?php

namespace App\Http\Controllers;

use App\Http\Resources\OtherInfoResource;
use App\Models\OtherInfo;
use Illuminate\Http\Request;
use Validator;

class OtherInfoController extends Controller
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
    public function show($user_id)
    {
        //add the passed variable  $user_id to data variable to validate
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
        $other_info = OtherInfo::where('user_id', $user_id)->first();
        //return failed show:because this user havent this skilltype
        if ($other_info == null) {
            return response()->json([
                'message' => $user_id.' havent other info',
            ], 400);
        }
        //return with successful operation message
        return response()->json(
            [
                'message' => 'Get OtherInfromation Successfully',
                'other_info' => new OtherInfoResource($other_info),
            ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {//add the variable  $id to data variable to validate
        $data = [
            'id' => auth()->user()->id,
        ];
        // validation fields
        $validator = Validator::make($data, [
            'id' => 'required|numeric|unique:other_infos,user_id',
        ]);
        //return failed validation
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 400);
        }

        $validator = Validator::make($request->all(), [

            'description' => 'required|string|min:4|max:255  ',

        ]);
        //return failed validation
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 400);
        }

        // insert the new other infromation
        $other_info = OtherInfo::create(array_merge(
            $validator->validated(),
            ['user_id' => auth()->user()->id]
        ));
        //return with successful operation message
        return response()->json(
            [
                'message' => 'OtherInfromation successfully registred',
                'other_info' => new OtherInfoResource($other_info),
            ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {// validation fields
        $validator = Validator::make($request->all(), [
            'description' => 'required|string|min:4|max:255  ',

        ]);
        //return failed validation
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 400);
        }
        $user_id = auth()->user()->id;
        $other_info = OtherInfo::where('user_id', $user_id)->first();
        //return failed update:because this user havent this other infromation
        if ($other_info == null) {
            return response()->json([
                'message' => 'you havent other info',
            ], 400);
        }

        $other_info->description = $request->input('description');
        $other_info->save();
        //return with successful operation message
        return response()->json(
            [
                'message' => 'OtherInfromation successfully updated',
                'other_info' => new OtherInfoResource($other_info),
            ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        $other_info = OtherInfo::where('user_id', auth()->user()->id)->first();

        if ($other_info == null) {
            return response()->json([
                'message' => 'you have no other info',
            ], 400);
        }
        $other_info->delete();
        //return with successful operation message
        return response()->json(
            [
                'message' => 'OtherInfromation id='.auth()->user()->id.' Deleted successfully',
            ], 200);
    }
}
