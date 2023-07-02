<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class ProjController extends Controller
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
        $project = Project::where('user_id', $user_id)->get();
        //return with successful operation message
        return response()->json(
            [
                'message' => 'Get Projects Successfully',
                'project' => ProjectResource::collection($project),
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
            'description' => 'required|string|min:4|max:255  ',
            'link' => 'string|min:4|max:255 |url ',
        ]);
        //return failed validation
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 422);
        }

        // insert the new project
        $project = Project::create(array_merge(
            $validator->validated(),
            ['user_id' => auth()->user()->id]
        ));
        //return with successful operation message
        return response()->json(
            [
                'message' => 'Project successfully registred',
                'project' => new ProjectResource($project),
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
            'id' => 'required|numeric|exists:App\Models\Project,id',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 422);
        }
        $project = Project::find($id);
        //return with successful operation message
        return response()->json(
            [
                'message' => 'Get Project Successfully',
                'project' => new ProjectResource($project),
            ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validation fields
        $validator = Validator::make($request->all(), [
            'name' => 'string|min:4|max:255  ',
            'description' => 'string|min:4|max:255 ',
            'link' => 'string|max:255| url ',

        ]);
        //return failed validation
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->toJson(), 422);
        }

        $project = Project::where('id', $id)->where('user_id', auth()->user()->id)->first();
        //return failed update:because this user havent this project
        if ($project == null) {
            return response()->json([
                'message' => 'Your id does not exist or this item not your s',
            ], 422);
        }
        if ($request->has('name')) {
            $project->name = $request->input('name');
        }
        if ($request->has('description')) {
            $project->description = $request->input('description');
        }
        if ($request->has('link')) {
            $project->link = $request->input('link');
        }
        $project->save();
        //return with successful operation message
        return response()->json(
            [
                'message' => 'Project successfully updated',
                'project' => new ProjectResource($project),
            ], 200);
    }

    public function addimage(Request $request, $id)
    {
        $project = Project::where('id', $id)->where('user_id', auth()->user()->id)->first();
        //return failed update:because this user havent this project
        if ($project == null) {
            return response()->json([
                'message' => 'Your id does not exist or this item not your s',
            ], 422);
        }
        //remove all the projest's images
        if (! $request->hasFile('image')) {
            return response()->json(
                [
                    'message' => 'No image !',
                ], 422);
        }

        //update the image
        $image = $request->file('image');
        $image_name = rand().'.'.$image->getClientOriginalExtension();
        $project->addMedia($image)
        ->usingFileName($image_name)
     ->toMediaCollection('images');

        //return with successful operation message
        return response()->json(
            [
                'message' => 'Project s image successfully added',
                'project' => new ProjectResource($project),
            ], 200);
    }

    public function clearimages($id)
    {
        $project = Project::where('id', $id)->where('user_id', auth()->user()->id)->first();
        //return failed update:because this user havent this project
        if ($project == null) {
            return response()->json([
                'message' => 'Your id does not exist or this item not your s',
            ], 422);
        }
        //remove all the projest's images
        $project->clearMediaCollection('images');

        //return with successful operation message
        return response()->json(
            [
                'message' => 'Project successfully updated',
                'project' => new ProjectResource($project),
            ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $project = Project::where('id', $id)->where('user_id', auth()->user()->id)->first();

        //return failed delete:because this user havent this project
        if ($project == null) {
            return response()->json([
                'message' => 'Your id does not exist or this item not your s',
            ], 422);
        }
        $project->delete();
        //return with successful operation message
        return response()->json(
            [
                'message' => 'Project id='.$id.' Deleted successfully',
            ], 200);
    }

    public function addskills($project_id, $skill_id)
    {
        $isProExist = Project::where('id', $project_id)->where('user_id', auth()->user()->id)->exists();
        //return failed skill add :because this user havent this project
        if (! $isProExist) {
            return response()->json([
                'message' => 'Your Project does not exist or its not your s',
            ], 422);
        }

        $isOwnedByUser = User::where('id', '=', auth()->user()->id)->whereHas('skill_types', function ($q) use ($skill_id) {
            $q->whereHas('skills', function ($q) use ($skill_id) {
                $q->where('skills.id', $skill_id);
            });
        })->exists();
        //return failed skill add :because this user havent this skill
        if (! $isOwnedByUser) {
            return response()->json([
                'message' => 'Your Skill does not exist or its not your s',
            ], 422);
        }

        $project = Project::find($project_id);
        $project->skills()->sync($skill_id);
        //$project->skills()->attach($skill_id);

        //return with successful operation message
        return response()->json(
            [
                'message' => 'Skill '.$skill_id.' added to project '.$project_id.' successfully',
            ], 200);
    }

    public function removeskills($project_id, $skill_id)
    {
        $isProExist = Project::where('id', $project_id)->where('user_id', auth()->user()->id)->exists();
        //return failed skill add :because this user havent this project
        if (! $isProExist) {
            return response()->json([
                'message' => 'Your Project does not exist or its not your s',
            ], 422);
        }

        $isOwnedByUser = User::where('id', '=', auth()->user()->id)->whereHas('skill_types', function ($q) use ($skill_id) {
            $q->whereHas('skills', function ($q) use ($skill_id) {
                $q->where('skills.id', $skill_id);
            });
        })->exists();
        //return failed skill add :because this user havent this skill
        if (! $isOwnedByUser) {
            return response()->json([
                'message' => 'Your Skill does not exist or its not your s',
            ], 422);
        }

        $project = Project::find($project_id);
        $project->skills()->detach($skill_id);
        //return with successful operation message
        return response()->json(
            [
                'message' => 'Skill '.$skill_id.' removed from project '.$project_id.' successfully',
            ], 200);
    }
}
