<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UiController extends Controller
{
    public function display_me( )
    {
        return view('index');
    }
    public function display_all( )
    {
        $users=User::all();
        return view('users', ['users' => $users]);
        
    }
    public function user($id )
    {
        $user=User::find($id);
        return view('users', ['user' => $user]);
    }
    public function about()
    {
        return view('about');
    }
}
