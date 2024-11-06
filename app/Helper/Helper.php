<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

function uuid()
{
    return strtoupper(sprintf(
        '%04x%04x',
        // 32 bits for "time_low"
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),

        // 16 bits for "time_mid"
        mt_rand(0, 0xffff),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,

        // 48 bits for "node"
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    ));
}

function groupStatus($status)
{
    if(Auth::user()->isAdmin()){
        $complaints = DB::table('complaints')
        ->orderBy('id', 'desc')
        ->paginate(50);
    }else{
        
    
    if ($status == 'pending') {
        $complaints = DB::table('complaints')->whereIn('status_name', ['pending'])
        ->Where('handle_by',Auth::user()->name)
        ->paginate(50);
        // $status_array['status'] = $complaints;
    }
    if ($status == 'follow-up') {
        $complaints = DB::table('complaints')->whereIn('status_name', ['handled'])
        ->Where('handle_by',Auth::user()->name)
        ->paginate(50);
        // $status_array['status'] = $complaints;
        # code...
    }
    if ($status == 'assigned') {
        $complaints = DB::table('complaints')->whereIn('status_name', ['assigned'])
        ->Where('handle_by',Auth::user()->name)
        ->paginate(50);
        // $status_array['status'] = $complaints;
        # code...
    }
    if ($status == 'progress') {
        $complaints = DB::table('complaints')->whereIn('status_name', ['operation-reply', 'cx-reply', 'refund', 'done'])
       ->Where('handle_by',Auth::user()->name)
        ->paginate(50);
        // $status_array['status'] = $complaints;
    }
    if ($status == 'completed') {
        $complaints = DB::table('complaints')->whereIn('status_name', ['completed','review'])
        ->Where('handle_by',Auth::user()->name)
        ->paginate(50);
        // $status_array['status'] = $complaints;
    }
}
    //return response()->json($status_array);
    return $complaints;
}

function getYesterday()
{
    $today = date('Y-m-d');
    $getLastSevenThDay = date_add(date_create($today), date_interval_create_from_date_string("-1 days"));
    $count = DB::table('complaints')
        ->whereDate('created_at', '=', $getLastSevenThDay)
        ->count();
    return $count;
    //  return $getLastSevenThDay->format('Y-m-d');
}

function getToDay()
{
    $today = date('Y-m-d');
    $count = DB::table('complaints')
        ->whereDate('created_at', '=', $today)
        ->count();
    return $count;
}
function getDifferentData()
{
    $yesterday = getYesterday();
    $today = getToDay();
    $different_count = $today - $yesterday;
    return $different_count;
}

function permission() {
    $user = Auth::user();
    if($user->role=='2'){$rolestatus='Developer';}
    elseif($user->role=='1'){$rolestatus='Admin';}
    elseif($user->role=='1'){$rolestatus='Admin';}
    else{$rolestatus='user';}
    return $rolestatus;
}

function chart(){
    $pricing=DB::table('pricing')->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
    ->whereYear('created_at',date('Y'))
    ->groupBy('month')
    ->orderBy('month')
    ->get();

    $labels=[];
    $data=[];
    $colors=['#ff6384','#36A2EB','#FFCE56','#8BC34A','#FF5722','#009688','#795548','#9C27B0','#2196F3','#FF9800','#CDDC39','#607D8B'];
    for($i=1;$i<12;$i++){
        $month=date('F',mktime(0,0,0,$i,1));
        $count=0;
        foreach($pricing as $price){
            if($price->month==$i){
                $count=$price->count;
                break;
                }
                }
                array_push($labels,$month);
                array_push($data,$count);
    }
    $datasets=[
        [
            'label'=>'Pricings',
            'data'=>$data,
            'backgroundColor'=>$colors,
        ]
        ];
       // return view('dashboard',compact('labels','datasets'));
}

?>