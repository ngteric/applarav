<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;


class BackController extends Controller
{
  
        
    public function logout(){
        Auth::logout();
        return view("auth.login");
    }


}
