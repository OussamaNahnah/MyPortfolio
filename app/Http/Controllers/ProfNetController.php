<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfessionalNetwork;

class ProfNetController extends Controller
{

    public function __construct(){
        $this->middleware('auth:api',[
            'except'=>['index','show',],
        
        ]);

    }

    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $pro_nets = ProfessionalNetwork::where('id_user', $id);
        return response()->json(
            [
             'message'=>'Get ProfessionalNetwork Successfully',
             'pro_nets'=>$pro_nets,
            ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pro_nets = ProfessionalNetwork::where('id_user', $id);
        return response()->json(
            [
             'message'=>'Get ProfessionalNetwork Successfully',
             'pro_nets'=>$pro_nets,
            ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
