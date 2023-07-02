<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobResResource;
use App\Models\Experience;
use App\Models\JobResponsibility;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class JobResController extends Controller
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
    public function index($experience_id)
    {//add the passed variable  $experience_id to data variable to validate
        $data = [
            'experience_id' => $experience_id,
        ];
        // validation fields
        $validator = Validator::make($data, [
            'experience_id' => 'required|numeric|exists:App\Models\Experience,id',
        ]);
        //return failed validation
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 422);
        }
        $job_responsibility = JobResponsibility::where('experience_id', $experience_id)->get();
        //return with successful operation message
        return response()->json(
            [
                'message' => 'Get JobResponsibilitys Successfully',
                'JobRes' => JobResResource::collection($job_responsibility),
            ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $experience_id)
    {
        $experience = Experience::where('id', $experience_id)->where('user_id', auth()->user()->id)->first();

        //return failed store:because this user havent this expirence
        if ($experience == null) {
            return response()->json([
                'message' => 'Your id does not exist or this item not your s',
            ], 422);
        }
        // validation fields
        $validator = Validator::make($request->all(), [

            'responsibility' => 'required|string|min:4|max:255 ',

        ]);
        //return failed validation
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 422);
        }

        // insert the new job responsibility
        $job_responsibility = JobResponsibility::create(array_merge(
            $validator->validated(),
            ['experience_id' => $experience_id]
        ));
        //return with successful operation message
        return response()->json(
            [
                'message' => 'JobResponsibility successfully registred',
                'JobRes' => new JobResResource($job_responsibility),
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
            'id' => 'required|numeric|exists:App\Models\JobResponsibility,id',
        ]);
        //return failed validation
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 422);
        }
        $job_responsibility = JobResponsibility::find($id);
        //return with successful operation message
        return response()->json(
            [
                'message' => 'Get JobResponsibility Successfully',
                'JobRes' => new JobResResource($job_responsibility),
            ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validation fields
        $validator = Validator::make($request->all(), [
            'responsibility' => 'required|string|min:4|max:255 ',
        ]);
        //return failed validation
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 422);
        }
        $isOwnedByUser = User::where('id', '=', auth()->user()->id)->whereHas('experiences', function ($q) use ($id) {
            $q->whereHas('job_responsibilities', function ($q) use ($id) {
                $q->where('job_responsibilities.id', $id);
            });
        })->exists();
        //return failed update:because this user havent this responsibility
        if (! $isOwnedByUser) {
            return response()->json([
                'message' => 'Your id does not exist or this item not your s',
            ], 422);
        }

        $job_responsibility = JobResponsibility::find($id);
        $job_responsibility->responsibility = $request->input('responsibility');
        $job_responsibility->save();
        //return with successful operation message
        return response()->json(
            [
                'message' => 'JobResponsibility successfully updated',
                'JobRes' => new JobResResource($job_responsibility),

            ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $isOwnedByUser = User::where('id', '=', auth()->user()->id)->whereHas('experiences', function ($q) use ($id) {
            $q->whereHas('job_responsibilities', function ($q) use ($id) {
                $q->where('job_responsibilities.id', $id);
            });
        })->exists();
        //return failed delete:because this user havent this responsibility
        if (! $isOwnedByUser) {
            return response()->json([
                'message' => 'Your id does not exist or this item not your s',
            ], 422);
        }

        $job_responsibility = JobResponsibility::find($id);
        $job_responsibility->delete();
        //return with successful operation message
        return response()->json(
            [
                'message' => 'JobResponsibility id='.$id.' Deleted successfully',
            ], 200);
    }
}
