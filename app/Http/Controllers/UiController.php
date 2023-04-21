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
        $user = User::find($id);
        if($user!=null){
    	$pdf = PDF::loadView('cv', ['user' => $user]);
    
         return $pdf->download('cv.pdf');
  
		//return view('cv', ['user' => $user]);
    }
    }

}
