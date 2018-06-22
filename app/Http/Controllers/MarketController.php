<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Market;
use App\Country;
use Carbon\Carbon;
use App\ResourceManagement;

class MarketController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status_list = array('all', 'exist', 'done');
        $running_list = array('all', 'run', 'running');
        $markets = market::with('country_name')->get();
        

        foreach ($markets as $key => $market) {
            // GET TODAY DATE
            $date_today = Carbon::today();
            $date_bid = $date_today->copy();
            // GET MARKET TABLE DATE
            $date_market = Carbon::parse($market->date);
            // CHECK IF DAY(BID_DATE) EXIST IN MONTH (IF NOT SET THE LAST DAY OF MONTH)
            $max_day = cal_days_in_month(CAL_GREGORIAN, $date_bid->month, $date_bid->year);
            if ($market->bid_date <= $max_day)
                $date_bid->day = $market->bid_date;
            else
                $date_bid->day = $max_day;
            // UPDATE CORRECTED BID_DATE
            market::where('id', $market->id)->update(['bid_date' => $date_bid->day]);
            $market->bid_date = $date_bid->day;
            // FORMULAR STARTS
            $date_bid_this_month = $date_bid;

            if ($market->bid_date < $date_today->day) {
				$date_bid_this_month = $date_bid;
			} else {
				$date_bid_this_month = $date_bid->addMonths(1);
			}
            // FOMULAR ENDS
            if ($market->status != 'done') {
                $date_diff = $date_bid_this_month->diffInDays($date_market);
                // DIFFINDAYS ALWAYS RETURNS > 0, SO IF TODAY DATE > BID_DATE DATE_DIFF = -DATE_DIFF
                if ($date_today->gt($date_bid_this_month)) {
                    $date_diff = -$date_diff;
                }
                // FORMULA FOR CALCULATING DONE OR EXIST STATUS
                $updated_or_pending = $date_diff < 30 ? 'done' : 'exist';
                // UPDATE CALCULATED NEW CORRECT STATUS TO DB
                $market->status = $updated_or_pending;
                market::where('id', $market->id)->update(['status' => $updated_or_pending]);
            }
        }

        return view('market/index', [
            'markets' => $markets,  
            'status_list' => $status_list,
            'running_list' => $running_list
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::get();
        return view('market/create', [
            'countries' => $countries
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {     
        market::create([
            'date' => $request['date'],
            'country' => $request['country'],
            'market_name' => $request['market_name'],
            'market_id' => $request['market_id'],
            'email' => $request['email'] , 
            'password' => $request['password'] , 
            'rising_talent' => $request['rising_talent'] , 
            'test' => $request['test'] , 
            'bid_date' => $request['bid_date'] , 
            'lancer_type' => $request['lancer_type'] , 
            'security_question' => $request['security_question'] , 
            'security_answer' => $request['security_answer'] ,
            'series' => $request['series']   
        ]);

        return redirect()->intended('/market');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ResourceManagement  $resourcesManagement
     * @return \Illuminate\Http\Response
     */
    public function show(ResourceManagement $resourcesManagement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ResourceManagement  $resourcesManagement
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $market = market::find($id);
        $countries = Country::get();
        // Redirect to user list if updating user wasn't existed
        if ($market == null || $market->count() == 0) {
            return redirect()->intended('/market');
        }

        return view('market/edit', ['market' => $market, 'countries' => $countries]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ResourceManagement  $resourcesManagement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {  
        market::findOrFail($id);
        $input = [
            'date' => $request['date'],
            'country' => $request['country'],
            'market_name' => $request['market_name'],
            'market_id' => $request['market_id'],
            'email' => $request['email'] , 
            'password' => $request['password'] , 
            'rising_talent' => $request['rising_talent'] , 
            'test' => $request['test'] , 
            'bid_date' => $request['bid_date'] , 
            'lancer_type' => $request['lancer_type'] , 
            'security_question' => $request['security_question'] , 
            'security_answer' => $request['security_answer'] ,
            'series' => $request['series'] 
        ]; 

        market::where('id', $id)
            ->update($input);

        return redirect()->intended('/market');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ResourceManagement  $resourcesManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        market::where('id', $id)->delete();
        return redirect()->intended('/market');
    }

    public function toggleStatus(Request $request) {
        $date_today = Carbon::today();

        market::where('id', $request['id'])->update(['status' => 'done']);
        market::where('id', $request['id'])->update(['date' => $date_today]);
        //echo $date_today;
        return redirect()->intended('/market');
    }

    // public function doneStatus(Request $request) {
    //     $date_today = Carbon::today();

    //     market::where('id', $request['id'])->update(['status' => 'done']);
    //     market::where('id', $request['id'])->update(['date' => $date_today]);
    //     //echo $date_today;
    //     return redirect()->intended('/market');
    // }

    public function toggleRunState(Request $request) {
        $date_today = Carbon::today();

        market::where('id', $request['id'])->update(['running' => 1]);

        return redirect()->intended('/market');
    }

    public function toggleRunningState(Request $request) {
        $date_today = Carbon::today();

        market::where('id', $request['id'])->update(['running' => 0]);

        return redirect()->intended('/market');
    }
}
