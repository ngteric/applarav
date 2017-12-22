<?php

namespace App\Http\Controllers;

use App\Trip;
use App\User;
use App\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.trip.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          
        $this->validate($request, [
            'title' => 'required|max:100',
            'date' => 'required|date',
            'dayauth' => 'required|numeric',
            'name.*' => 'required|string',
            'email.*' => 'required|email',
            'day.*' => 'required|numeric',
        ]);
        // create trip
        $trip = Trip::create([
            'title' => $request->title,
        ]);
        
        // create users
        for ($i=0; $i < count($request->name) ; $i++) { 
            $user = User::create([
                'name' => $request->name[$i],
                'email' => $request->email[$i],
                'password'=> Hash::make('root'),
                'trip_id' => $trip->id,
                'role'=> 'participant',
            ]);
            Part::create([
                'started' => date('Y-m-d H:i:s', strtotime($request->date)),
                'day' => $request->day[$i],
                'trip_id' => $trip->id,
                'user_id' => $user->id,
            ]);
        }
        // update authenficate user
        $userAuth = Auth::user();
        $userAuth->update(['trip_id' => $trip->id]);
        Part::create([
            'started' => date('Y-m-d H:i:s', strtotime($request->date)),
            'day' => $request->dayauth,
            'trip_id' => $trip->id,
            'user_id' => $userAuth->id,
        ]);

        return redirect()->route('spend.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
