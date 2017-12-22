<?php

namespace App\Http\Controllers;

use App\User;
use App\Spend;
use App\Part;
use App\Balance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class SpendController extends Controller
{

    protected $user;
    protected $trip_id;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user= Auth::user();
            if($this->user->trip_id == null){
                return redirect('/trip/create');
            }
            else{
                $this->trip_id = $this->user->trip_id;
            }
            return $next($request);
        });
    }
    
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $spends = Spend::orderBy('created_at', 'desc')->where('trip_id' ,'=', $this->trip_id)->paginate(5);

        $users = User::with(['spends' => function ($query) {
            $query->selectRaw('SUM(`spend_user`.`price`) as `total`, `spends`.*')
            ->groupBy("user_id");
        }])->where('trip_id' ,'=', $this->trip_id)->get();
       
        return view("back.dashboard", compact('spends', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('trip_id' ,'=', $this->trip_id)->get();
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
        
        // get total part price
        $totalPrice = 0;
        foreach ($request->prices as $price) {
            $totalPrice += $price;
        }
        
        if ($totalPrice == $request->price) {
            $spend = Spend::create($request->all());
            $spend->update([ 'trip_id' => $this->trip_id]);
            // attach part price to user
            for ($i=0; $i < count($request->users_id); $i++) {
                $spend->users()->attach( $request->users_id[$i], ["price"=> $request->prices[$i]]);
            }
            session()->flash('flashMessage', 'Spend added !');
            
            return redirect()->route('spend.index');
        } else {
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
        $users = User::where('trip_id' ,'=', $this->trip_id)->get();
        
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

    /**
     * Calculette balances for users
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function balance(){
        
      

        // get total spend by one user
        $usersSpend = array();
        
        $expiresAt = Carbon::now()->addMinutes(10);
        // get total spend by all users
        $spends = Spend::where('trip_id' ,'=', $this->trip_id)->get();
        $refreshing = true;
        $totalSpend = $spends->sum('price');
        
       
        $key = \Route::getCurrentRoute()->getName();

        if(Cache::has($key.'.spendCount')){
            $spendCount = Cache::get($key.'.spendCount');
            $refreshing = ($spendCount != count($spends)) ? true : false;
        }else{
            Cache::put($key.'.spendCount', count($spends), $expiresAt);
        }
        
        
        

        if(Cache::has($key.'.users') && Cache::has($key.'.parts')){
           $users = Cache::get($key.'.users');
           $parts = Cache::get($key.'.parts');
         
        }else{
            $parts = Part::all();
            $users = User::with(['spends' => function ($query) {
                $query->selectRaw('SUM(`spend_user`.`price`) as `total`, `spends`.*')
                ->groupBy("user_id");
            }, 'part'])->where('trip_id' ,'=', $this->trip_id)->get();
            
            Cache::put($key.'.users', $users, $expiresAt);
            Cache::put($key.'.parts', $parts, $expiresAt);
           
        }      

        
        // get part
        $totalParts = 0;
        foreach($parts as $part){
            $totalParts += intval($part->day);
        }
        

        // get parts for 1 users from total spend
        $partSpend = ($totalSpend != 0) ? $totalSpend / $totalParts : null;

        
        if($partSpend != null){
            $inc = 0;
            foreach($users as $user){
                foreach($user->spends as $spend){
                    $usersSpend[$inc]['name'] = $user->name;
                    $usersSpend[$inc]['due'] = $spend->total - ($partSpend * intval($user->part->day));
                    $usersSpend[$inc]['part'] = intval($user->part->day);
                }
                if($refreshing){
                    $balance = Balance::find($user->id);
                    if($balance){
                        $balance->due = $usersSpend[$inc]['due'];
                        $balance->save();
                    }
                    else{
                        $balance = new Balance;
                        $balance->user_id = $user->id;
                        $balance->trip_id = $this->trip_id;
                        $balance->due = $usersSpend[$inc]['due'];
                        $balance->save();
                    }
                    Cache::put($key.'.spendCount', count($spends), $expiresAt);
                }
                $inc ++;
            }
        }
        

        $balances = Balance::with('user')->where('trip_id' ,'=', $this->trip_id)->get();
        $suggestions = array();
        $inc = 0;
        for ($i=0; $i < count($usersSpend); $i++) { 
            $j = 0;
            while($usersSpend[$i]['due'] < 0){
                if($j >= count($usersSpend)){
                    break;
                }
                if($usersSpend[$j]['due'] > 0){
                    $due = $usersSpend[$j]['due'] + $usersSpend[$i]['due'];

                    // if positive add to j
                    if($due > 0){
                        $suggestions[$inc]['price'] = abs($usersSpend[$i]['due']);
                        $usersSpend[$j]['due'] = $due;
                        $usersSpend[$i]['due'] = 0;
                        
                    // if negative add to i
                    }else{
                        $suggestions[$inc]['price'] = $usersSpend[$j]['due'];
                        $usersSpend[$i]['due'] = $due;
                        $usersSpend[$j]['due'] = 0;
                    }
                    
                    $suggestions[$inc]['name'] = $usersSpend[$i]['name'];
                    $suggestions[$inc]['to'] = $usersSpend[$j]['name'];
                }
                $j++;
                $inc++;
            }
        }
        
        // update db
        return view('back.balance', compact('users', 'balances', 'suggestions', 'totalSpend'));
    }
}
