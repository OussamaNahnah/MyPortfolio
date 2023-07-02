<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExperienceResource;
use App\Models\Experience;
use Illuminate\Http\Request;
use Validator;

class ExpController extends Controller
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
                $validator->errors()->toJson(), 422);
        }
        $experience = Experience::where('user_id', $user_id)->get();
        //return with successful operation message
        return response()->json(
            [
                'message' => 'Get Experiences Successfully',
                'experience' => ExperienceResource::collection($experience),
            ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {// validation fields
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:4|max:255 ',
            'titlejob' => 'required|string|min:4|max:255',
            'location' => 'required|string|min:4|max:255',
            'startdate' => 'required|date|date_format:Y-m ',
            'enddate' => 'date|date_format:Y-m|nullable ',

        ]);
        //return failed validation
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 422);
        }

        // insert the new experiene
        $experience = Experience::create(array_merge(
            $validator->validated(),
            ['user_id' => auth()->user()->id]
        ));
        //return with successful operation message
        return response()->json(
            [
                'message' => 'Experience successfully registred',
                'experience' => new ExperienceResource($experience),
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
            'id' => 'required|numeric|exists:App\Models\Experience,id',
        ]);
        //return failed validation
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 422);
        }
        $experience = Experience::find($id);
        //return with successful operation message
        return response()->json(
            [
                'message' => 'Get Experience Successfully',
                'experience' => new ExperienceResource($experience),
            ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {// validation fields
        $validator = Validator::make($request->all(), [

            'name' => ' string|min:4|max:255 ',
            'titlejob' => 'string|min:4|max:255  ',
            'location' => 'string|min:4|max:255  ',
            'startdate' => 'date|date_format:Y-m ',
            'enddate' => 'date|date_format:Y-m|nullable',

        ]);
        //return failed validation
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 422);
        }

        $experience = Experience::where('id', $id)->where('user_id', auth()->user()->id)->first();

        //return failed update
        if ($experience == null) {
            return response()->json([
                'message' => 'Your id does not exist or this item not your s',
            ], 422);
        }
        if ($request->has('name')) {
            $experience->name = $request->input('name');
        }
        if ($request->has('titlejob')) {
            $experience->titlejob = $request->input('titlejob');
        }
        if ($request->has('location')) {
            $experience->location = $request->input('location');
        }
        if ($request->has('startdate')) {
            $experience->startdate = $request->input('startdate');
        }
        if ($request->has('enddate')) {
            $experience->enddate = $request->input('enddate');
        }
        $experience->save();
        //return with successful operation message
        return response()->json(
            [
                'message' => 'Experience successfully updated',
                'experience' => new ExperienceResource($experience),
            ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $experience = Experience::where('id', $id)->where('user_id', auth()->user()->id)->first();

        //return failed delete
        if ($experience == null) {
            return response()->json([
                'message' => 'Your id does not exist or this item not your s',
            ], 422);
        }
        $experience->delete();
        //return with successful operation message
        return response()->json(
            [
                'message' => 'experience id='.$id.' Deleted successfully',
            ], 200);
    }
}
