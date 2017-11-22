<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Spend;

class BackController extends Controller
{
    public function index(){

        $spends = Spend::all();

        return view("back.dashboard", compact('spends'));
    }

    public function showSpend($id){
        $spend = Spend::findOrFail($id);

        return view("back.single", compact('spend'));
    }

    public function logout(){
        Auth::logout();
        return view("auth.login");
    }


}
