<?php

namespace App\Http\Controllers;

use App\Http\Resources\PhoNumResource;
use App\Models\PhoneNumber;
use Illuminate\Http\Request;
use Validator;

class PhoNumController extends Controller
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
    {//add the passed variable  $user_id to data variable to validate
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
        $phone_number = PhoneNumber::where('user_id', $user_id)->get();
        //return with successful operation message
        return response()->json(
            [
                'message' => 'Get PhoneNumbers Successfully',
                'phone_number' => PhoNumResource::collection($phone_number),
            ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {// validation fields
        $validator = Validator::make($request->all(), [

            'numberphone' => 'required|string ',

        ]);
        //return failed validation
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 400);
        }

        // insert the new phone number
        $phone_number = PhoneNumber::create(array_merge(
            $validator->validated(),
            ['user_id' => auth()->user()->id]
        ));
        //return with successful operation message
        return response()->json(
            [
                'message' => 'PhoneNumber successfully registred',
                'phone_number' => new PhoNumResource($phone_number),
            ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {//add the passed variable  $id to data variable to validate
        $data = [
            'id' => $id,
        ];
        // validation fields
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:App\Models\PhoneNumber,id',
        ]);
        //return failed validation
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 400);
        }
        $phone_number = PhoneNumber::find($id);
        //return with successful operation message
        return response()->json(
            [
                'message' => 'Get PhoneNumber Successfully',
                'phone_number' => new PhoNumResource($phone_number),
            ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {// validation fields
        $validator = Validator::make($request->all(), [
            'numberphone' => 'required|string ',

        ]);
        //return failed validation
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 400);
        }

        $phone_number = PhoneNumber::where('id', $id)->where('user_id', auth()->user()->id)->first();
        //return failed update:because this user havent this phone number
        if ($phone_number == null) {
            return response()->json([
                'message' => 'Your id does not exist or this item not your s',
            ], 400);
        }

        $phone_number->numberphone = $request->input('numberphone');
        $phone_number->save();
        //return with successful operation message
        return response()->json(
            [
                'message' => 'PhoneNumber successfully updated',
                'phone_number' => new PhoNumResource($phone_number),
            ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $phone_number = PhoneNumber::where('id', $id)->where('user_id', auth()->user()->id)->first();

        //return failed delete:because this user havent this phone number
        if ($phone_number == null) {
            return response()->json([
                'message' => 'Your id does not exist or this item not your s',
            ], 400);
        }
        $phone_number->delete();
        //return with successful operation message
        return response()->json(
            [
                'message' => 'PhoneNumber id='.$id.' Deleted successfully',
            ], 200);
    }
}
