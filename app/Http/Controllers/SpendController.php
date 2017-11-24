<?php

namespace App\Http\Controllers;

use App\User;
use App\Spend;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class SpendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $spends = Spend::orderBy('created_at', 'desc')->paginate(5);
        $users = User::all();
        
        return view("back.dashboard", compact('spends', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view("back.spend.create", compact('users'));
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
            'description' => 'string',
            'price' => 'required|numeric',
            'pay_date'=> 'date',
            'users_id.*' => 'required|integer|nullable',
            'prices.*' => 'integer|nullable',
            'status' => Rule::in(['paid', 'account']),
            
        ]);
        
        $totalPrice = 0;
        foreach ($request->prices as $price) {
            $totalPrice += $price; 
        }
        
        if($totalPrice == $request->price){

            $spend = Spend::create($request->all());
            for ($i=0; $i < count($request->users_id); $i++) {
                $spend->users()->attach( $request->users_id[$i], ["price"=> $request->prices[$i]]);
            }
            session()->flash('flashMessage', 'Spend added !');
            
            return redirect()->route('spend.index');
        }else{
            session()->flash('flashMessageError', 'the price distribution is not equal to spend price !');
            return redirect('spend/create');
        }
       
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $spend = Spend::findOrFail($id);
        $users = User::all();
        
        return view("back.spend.show", compact('spend', 'users'));
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
