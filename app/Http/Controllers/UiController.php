<?php

namespace App\Http\Controllers;

use App\Models\User;
use PDF;

class UiController extends Controller
{
    public function index()
    {
        $users = User::paginate(4);

        return view('index', ['users' => $users]);
    }

    public function user($id)
    {
        $user = User::find($id);

        return view('user', ['user' => $user]);
    }

    public function me()
    {
        $user = User::where('fullname', 'Oussama Nahnah')->first();

        if ($user != null) {
            return view('user', ['user' => $user]);
        }
    }

 
    public function cv($id) 
    {
    /*	$pdf = PDF::loadView('sample', [
    		'title' => 'CodeAndDeploy.com Laravel Pdf Tutorial',
    		'description' => 'This is an example Laravel pdf tutorial.',
    		'footer' => 'by <a href="https://codeanddeploy.com">codeanddeploy.com</a>'
    	]);
    
        return $pdf->download('sample.pdf');*/
        $user = User::find($id);
		return view('cv', ['user' => $user]);
    }

}
