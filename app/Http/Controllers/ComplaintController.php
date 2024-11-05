<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ComplaintController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function edit($id)
    {
        $complaint = DB::table('complaints')->where('id', $id)->first();
        $categories = DB::table('case_types')->select('main_category')->groupBy('main_category')->get();
        $statuses = DB::table('statuses')->get();
        $branches = DB::table('branches')->get();
        $employees = DB::table('employees')->get();
        $users = DB::table('users')->get();
        $logs = DB::table('complaint_logs')->where('complaint_id', $id)->get();
        $ratings = DB::table('complaints')->where('id', $id)->get();
        $rating_sum = DB::table('complaints')->where('id', $id)->sum('stars_rated');
        $grouped = $branches->groupBy('city_id')->sortKeys();
         $ygnoperation = $grouped->has(1) ? $grouped->get(1) : [];
         $ropoperation = $grouped->reject(function ($value, $key) {
        return $key == 1; // Exclude the group with city_id 1
    });
        if($ratings->count()>0){
            $rating_value=$rating_sum/$ratings->count();
        }else{
            $rating_value=0;
        }
        $url = url('complaints-form', ['uuid' => $complaint->complaint_uuid]);
        // dd($signedUrl);
        return view('complaints.edit', compact('complaint', 'categories', 'statuses', 'branches', 'employees', 'users', 'logs', 'url','rating_sum','rating_value','ratings','ygnoperation','ropoperation'));
    }
    public function view($id)
    {
        $complaint = DB::table('complaints')->where('id', $id)->first();
        $ratings = DB::table('complaints')->where('id', $id)->get();
        $rating_sum = DB::table('complaints')->where('id', $id)->sum('stars_rated');
        if($ratings->count()>0){
            $rating_value=$rating_sum/$ratings->count();
        }else{
            $rating_value=0;
        }
        
       // dd($rating_sum);
        $categories = DB::table('case_types')->select('main_category')->groupBy('main_category')->get();
        $statuses = DB::table('statuses')->get();
        $branches = DB::table('branches')->get();
        $employees = DB::table('employees')->get();
        $users = DB::table('users')->get();
        $logs = DB::table('complaint_logs')->where('complaint_id', $id)->get();
        $url = url('complaints-form', ['uuid' => $complaint->complaint_uuid]);
        // dd($signedUrl);
        return view('complaints.view', compact('complaint', 'categories', 'statuses', 'branches', 'employees', 'users', 'logs', 'url','rating_sum','rating_value','ratings'));
    }

    public function update(Request $request, $id)
    {
        //dd($request->product_rating);
        $complaint = DB::table('complaints')->where('id', $id)->first();
        if ($request->case_status == 'handled') {
            $message_by = $request->handled_by . ' handled for complaint.';
            $department = 'CX-Team';
        } elseif ($request->case_status == 'assigned') {
            $message_by = $request->handled_by . ' assigned complaint to ' . $request->operation_person . '.';
            $department = 'CX-Team';
        } elseif ($request->case_status == 'operation-reply') {
            $message_by = $request->operation_person . ' operation-reply complaint to ' . $request->handled_by. '.';
            $department = $request->operation_person;
        } elseif ($request->case_status == 'cx-reply') {
            $message_by = $request->handled_by . ' cx-reply complaint to ' . $request->operation_person . '.';
            $department = 'CX-Team';
        } elseif ($request->case_status == 'refund') {
            $message_by = $request->operation_person . ' cx-reply complaint to ' . $request->handled_by . '.';
            $department = $request->operation_person;
            
        } elseif ($request->case_status == 'done') {
            $message_by = $request->handled_by . ' marked as done for complaint.';
            $department = 'CX-Team';
        } elseif ($request->case_status == 'completed') {
            $message_by = $request->handled_by . ' marked as completed for complaint.';
            $department = 'CX-Team';
           // $today=$request->currentDate;
        } elseif ($request->case_status == 'review') {
            $message_by = $request->handled_by . ' review complaint to ' . $request->operation_person . '.';
            $department = 'Customer';
        } elseif ($request->case_status == 'closed') {
            $message_by = $request->handled_by . ' has been closed complaint.';
            $department = 'CX-Team';
        } else {
            $message_bimagey = '';
            $department = 'CX-Team';
        }
        //dd($today);

        $validator = \Validator::make($request->all(),[
            'image'=>'nullable|image'
         ],[
             'image.image'=>'Product file must be an image',
         ]);
            $file_name="none";
            if($request->file('image')){
               $file_name=$request->file('image')->getClientOriginalName();
               $request->file('image')->move(public_path('files'),$file_name);
           }
           //insert pricings data//
           

        if ($complaint) {
            DB::table('complaints')->where('id', $id)->update([
                'handle_by' => $request->handled_by,
                'status_name' => $request->case_status,
                //'inform_person' => '',
                'employee_name' => $request->operation_person,
                //'employee_id' => $request->operation_id,
                'branch_name' => $request->branch,
                'source_platform' => $request->source,
                'refund_amount' => $request->amount,
                'complaint_review'=>$request->feedback_message,
                'company_remark' => $request->message,
                'stars_rated'=>$request->rating,
                'case_type_name'=>$request->case_type_name,
                'completed_at' =>$request->currentDate,
                'updated_at' =>  date('Y-m-d H:i:s'),
            ]);
            DB::table('complaint_logs')->insert([
                'complaint_id' => $id,
                'status_name' => $request->case_status,
                'message_by' => $message_by,
                'department' => $department,
                'message' => $request->message,
                //'image'=>$request->$file_name,
                'attch_file' => $file_name,
                'created_at' =>  date('Y-m-d H:i:s'),
                'updated_at' =>  date('Y-m-d H:i:s'),
            ]);
            if ($request->case_status == 'refund') {
                $princing = DB::table('pricing')->where('complaint_id', $id)->first();
                if ($princing) {
                    DB::table('pricing')->where('complaint_id', $id)->update([
                    'status_name' => $request->case_status,
                    'ygn_refund' => $request->ygn_amount,
                    'rop_refund' => $request->rop_amount,
                    'default_value' => $request->amount,
                    'ygn_branch'=>$request->ygn_branch,
                    'rop_branch'=>$request->rop_branch,
                    'other_branch'=>$request->other_branch,
                    'other_refund'=>$request->other_amount,
                    //'image'=>$request->$file_name,
                    'negotiable_price' => $request->negotiable_price,
                    'created_at' =>  date('Y-m-d H:i:s'),
                    'updated_at' =>  date('Y-m-d H:i:s'),
                        ]);
                }else{
                    DB::table('pricing')->insert([
                        'complaint_id' => $id,
                        'status_name' => $request->case_status,
                        'ygn_refund' => $request->ygn_amount,
                        'rop_refund' => $request->rop_amount,
                        'default_value' => $request->amount,
                        'ygn_branch'=>$request->ygn_branch,
                        'rop_branch'=>$request->rop_branch,
                        'other_branch'=>$request->other_branch,
                        'other_refund'=>$request->other_amount,
                        //'image'=>$request->$file_name,
                        'negotiable_price' => $request->negotiable_price,
                        'created_at' =>  date('Y-m-d H:i:s'),
                        'updated_at' =>  date('Y-m-d H:i:s'),
                    ]);
                } 
               }
            return 1;
        } else {
            return 0;
        }
    }


    public function json_status($status)
    {
       
        $status_array=groupStatus($status);
        return response()->json($status_array);

    }
    public function json_complaints($status){
        if(Auth::user()->isAdmin() || Auth::user()->isDev()){
            $complaints = DB::table('complaints')
            ->orderBy('id', 'desc')
            ->paginate(50);
        }else{
            $complaints = DB::table('complaints')
            ->where('handle_by',Auth::user()->name)
            ->paginate(50);
        }
       
       // dd($complaints);
        return response()->json($complaints);
    }

       //user create //
    public function cx_team(){
        return view('user.index');
    }

    public function cx_store(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=> 'required|max:191',
            'email'=>'required|email',
            'password'=>'required',
            'role'=>'required',
            'confirmPassword'=>'required'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }

        else
        {
            $newUser = new User();
            $newUser->name = $request->input('name');
            $newUser->email = $request->input('email');
            $newUser->password = Hash::make($request['password']);
            $newUser->role = $request->input('role');
            $newUser->save();
            return response()->json([
                'status'=>200,
                'message'=>'Create User Successfully.'
            ]);
        }
    }

    public function cx_list(){
        $users = DB::table('users')
        ->orderBy('id', 'desc')
        ->paginate(5);
        return response()->json($users);
    }

    public function cx_edit($id)
    {
        $student = User::find($id);

        if($student)
        {
            return response()->json([
                'status'=>200,
                'student'=> $student,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Student Found.'
            ]);
        }

    }

    public function cx_update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'=> 'required|max:191',
            'email'=>'required|email',
            'password'=>'required|max:10',
            'role'=>'required',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()

            ]);
        }
        else
        {
            $student = User::find($id);
            if($student)
            {
                $student->name = $request->input('name');
                $student->email = $request->input('email');
                $student->password = Hash::make($request['password']);
                $student->role = $request->input('role');
                $student->update();
                return response()->json([
                    'status'=>200,
                    'message'=>'Student Updated Successfully.'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'No Student Found.'
                ]);
            }

        }
    }

    public function cx_destroy($id)
    {
        $student = User::find($id);
        if($student)
        {
            $student->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Student Deleted Successfully.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Student Found.'
            ]);
        }
    }

    public function dashboard(){
        $year=date('Y');
        $complaint_count = DB::table('complaints')->count();
        $service_complaints=DB::table('complaints')->whereIn('case_type_name',['Service Complain','Delivery Man Complain','Staff Complain','Double Charges','Extra Charges','Delay Time','Wrong Transfer City','Parcel Wrong','CX Complain','Not Collect Pick Up Complain'])->count();
        $loss_complaints=DB::table('complaints')->whereIn('case_type_name',['Damage','Losss','Reduce','Pest Control','Force Majeure','Illegal  Restricted Material'])->count();
        $complaint_review = DB::table('complaints')->groupBy('stars_rated')->count();
        $compensate=DB::table('pricing')->sum('negotiable_price');
        $yestday_count=getYesterday();
        $totalNegotiablePrice = DB::table('pricing')
        ->whereYear('created_at', $year)
        ->sum('negotiable_price');
         //chart data //
         //$date = Carbon::now()->subDays(30);
         //date filter//
       
        //end date filter
        $pricing = DB::table('pricing')
        ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count, SUM(negotiable_price) as total_price')
         ->whereYear('created_at', $year) // Filter by year if needed
        ->groupBy('year', 'month')
        ->orderBy('year')
         ->orderBy('month')
         ->get();
//dd($pricing);
        $labels=[];
        $data=[];
        $colors=['#ff6384','#36A2EB','#FFCE56','#8BC34A','#FF5722','#009688','#795548','#9C27B0','#2196F3','#FF9800','#CDDC39','#607D8B'];
        for($i=1;$i<12;$i++){
            $month=date('F',mktime(0,0,0,$i,1));
            $total_price=0;
            foreach($pricing as $price){
                if($price->month==$i){
                    $total_price=$price->total_price;
                    break;
                    }
                    }
                    array_push($labels,$month);
                    array_push($data,$total_price);
        }
        $datasets=[
            [
                'label'=>'Pricings',
                'data'=>$data,
                'backgroundColor'=>$colors,
            ]
            ];
        return view('dashboard',compact('complaint_count','service_complaints','loss_complaints','complaint_review','yestday_count','compensate','datasets','labels','year','totalNegotiablePrice'));
    }

    public function searchdashboard(Request $request){
        $complaint_count = DB::table('complaints')->count();
        $service_complaints=DB::table('complaints')->whereIn('case_type_name',['Service Complain','Delivery Man Complain','Staff Complain','Double Charges','Extra Charges','Delay Time','Wrong Transfer City','Parcel Wrong','CX Complain','Not Collect Pick Up Complain'])->count();
        $loss_complaints=DB::table('complaints')->whereIn('case_type_name',['Damage','Losss','Reduce','Pest Control','Force Majeure','Illegal  Restricted Material'])->count();
        $complaint_review = DB::table('complaints')->groupBy('stars_rated')->count();
        $compensate=DB::table('pricing')->sum('negotiable_price');
        $yestday_count=getYesterday();
        $today_count=getToDay();
        $compensate=DB::table('pricing')->sum('negotiable_price');
        $year=$request->input('year');
        $totalNegotiablePrice = DB::table('pricing')
        ->whereYear('created_at', $year)
        ->sum('negotiable_price');
        //end date filter
        $pricing = DB::table('pricing')
        ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count, SUM(negotiable_price) as total_price')
         ->whereYear('created_at', $year) // Filter by year if needed
        ->groupBy('year', 'month')
        ->orderBy('year')
         ->orderBy('month')
         ->paginate(5);
//dd($pricing);
        $labels=[];
        $data=[];
        $colors=['#ff6384','#36A2EB','#FFCE56','#8BC34A','#FF5722','#009688','#795548','#9C27B0','#2196F3','#FF9800','#CDDC39','#607D8B'];
        for($i=1;$i<12;$i++){
            $month=date('F',mktime(0,0,0,$i,1));
            $total_price=0;
            foreach($pricing as $price){
                if($price->month==$i){
                    $total_price=$price->total_price;
                    break;
                    }
                    }
                    array_push($labels,$month);
                    array_push($data,$total_price);
        }
        $datasets=[
            [
                'label'=>'Pricings',
                'data'=>$data,
                'backgroundColor'=>$colors,
            ]
            ];
        return view('dashboard',compact('complaint_count','service_complaints','loss_complaints','complaint_review','yestday_count','compensate','datasets','labels','compensate','year','totalNegotiablePrice'));

    }
       
}

 