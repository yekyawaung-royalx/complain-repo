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
            $message_by = $request->operation_person . ' refund complaint to ' . $request->handled_by . '.';
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
        $complaints = DB::table('complaints')
            ->select(
                'case_type_name',
                DB::raw("
                    CASE 
                        WHEN case_type_name IN ('Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain') THEN 'Service Complaint Types'
                        WHEN case_type_name IN ('Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material') THEN 'Loss & Damage Types'
                        ELSE 'Other'
                    END as main_group
                "),
                DB::raw('count(*) as num'),
                DB::raw('GROUP_CONCAT(customer_message SEPARATOR "; ") as messages')
            )
           // ->whereBetween('created_at', [$date_from, $date_to])
            ->groupBy('main_group', 'case_type_name')
            ->get();
     // dd($date_from);
        $label = [];
        $datas = [];
        $colors = ['#ff6384','#36A2EB','#FFCE56','#8BC34A','#FF5722','#009688','#795548','#9C27B0','#2196F3','#FF9800','#CDDC39','#607D8B','#10539c','#00e8ff','#00ffd4','#ff0000'];
        $total = 0;
        
        // Initialize an array to accumulate totals by main_group
        $mainGroupData = [];
        
        // Iterate through the complaints and organize them by main_group
        foreach ($complaints as $complaint) {
            // If the main_group does not exist in the array, initialize it
            if (!isset($mainGroupData[$complaint->case_type_name])) {
                $mainGroupData[$complaint->case_type_name] = [
                    'label' => $complaint->case_type_name,
                    'data' => [],
                    'total' => 0,
                ];
            }
        
            // Add data for the specific case type under this main_group
            $mainGroupData[$complaint->case_type_name]['data'][] = $complaint->num;
            $mainGroupData[$complaint->case_type_name]['total'] += $complaint->num;  // Accumulate total
        }
        
        // Prepare the dataset
        foreach ($mainGroupData as $group) {
            array_push($label, $group['label']);
            array_push($datas, $group['total']);
        }
        
        $datasetsIn = [
            [
                'label' => 'Complaints',
                'data' => $datas,
                'backgroundColor' => $colors,
            ]
        ];
        
        //dd($complaints);
        //princing//
        $pricings = DB::table('pricing')
        ->select(
            'ygn_branch',
            'rop_branch',
            'other_branch',
            DB::raw('SUM(rop_refund) as total_rop_amount'),    // Total refund amount for the group
            DB::raw('SUM(ygn_refund) as ygn_branch_total'),    // Total for ygn_branch
            DB::raw('SUM(other_refund) as other_branch_total'), // Total for other_branch
            DB::raw('COUNT(*) as count')                       // Count of records in the group
        )
        //->whereMonth('created_at', $today)
        ->groupBy('ygn_branch', 'rop_branch', 'other_branch')
        ->get();

// Calculate overall totals for total_rop_amount, ygn_branch_total, and other_branch_total
$RopTotal = $pricings->sum('total_rop_amount');
$ygnBranchTotal = $pricings->sum('ygn_branch_total');
$otherBranchTotal = $pricings->sum('other_branch_total');

// Chart result example
$chartData = [
    'labels' => ['YGN Branch', 'Other Branch', 'Rop Branch'],  // Chart labels
    'datasets' => [
        [
            'data' => [
                $ygnBranchTotal,      // YGN branch total (9000)
                $otherBranchTotal,    // Other branch total (3500)
                $RopTotal             // Grand total (6200)
            ],
            'backgroundColor' => [
                '#FF6384',            // Color for YGN Branch Total
                '#36A2EB',            // Color for Other Branch Total
                '#FFCE56'             // Color for Grand Total
            ],
            'hoverBackgroundColor' => [
                '#FF6384',            // Hover color for YGN Branch Total
                '#36A2EB',            // Hover color for Other Branch Total
                '#FFCE56'             // Hover color for Grand Total
            ],
            'label'=>[
                'Pricing',
            ],
            'borderWidth'=>[
                '1',
            ]
        ]
            ]
];
       // dd($result);
     return view('dashboard',compact('complaints','datasetsIn','label','chartData'));
    }

    public function searchdashboard(Request $request){
        $start_date = $request->input('date_from');
        $end_date = $request->input('date_to');
        if ($start_date && $end_date) {
            $start_date = \Carbon\Carbon::parse($start_date)->format('Y-m-d');
            $end_date = \Carbon\Carbon::parse($end_date)->format('Y-m-d');
        $complaints = DB::table('complaints')
            ->select(
                'case_type_name',
                DB::raw("
                    CASE 
                        WHEN case_type_name IN ('Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain') THEN 'Service Complaint Types'
                        WHEN case_type_name IN ('Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material') THEN 'Loss & Damage Types'
                        ELSE 'Other'
                    END as main_group
                "),
                DB::raw('count(*) as num'),
                DB::raw('GROUP_CONCAT(customer_message SEPARATOR "; ") as messages')
            )
            ->whereBetween('created_at', [$start_date, $end_date]) // Add date range filter
            ->groupBy('main_group', 'case_type_name')
            ->get();
        
        $label = [];
        $datas = [];
        $colors = ['#ff6384','#36A2EB','#FFCE56','#8BC34A','#FF5722','#009688','#795548','#9C27B0','#2196F3','#FF9800','#CDDC39','#607D8B','#10539c','#00e8ff','#00ffd4','#ff0000'];
        $total = 0;
        
        // Initialize an array to accumulate totals by main_group
        $mainGroupData = [];
        
        // Iterate through the complaints and organize them by main_group
        foreach ($complaints as $complaint) {
            // If the main_group does not exist in the array, initialize it
            if (!isset($mainGroupData[$complaint->case_type_name])) {
                $mainGroupData[$complaint->case_type_name] = [
                    'label' => $complaint->case_type_name,
                    'data' => [],
                    'total' => 0,
                ];
            }
        
            // Add data for the specific case type under this main_group
            $mainGroupData[$complaint->case_type_name]['data'][] = $complaint->num;
            $mainGroupData[$complaint->case_type_name]['total'] += $complaint->num;  // Accumulate total
        }
        
        // Prepare the dataset
        foreach ($mainGroupData as $group) {
            array_push($label, $group['label']);
            array_push($datas, $group['total']);
        }
        
        $datasetsIn = [
            [
                'label' => 'Complaints',
                'data' => $datas,
                'backgroundColor' => $colors,
            ]
        ];
        
        //dd($complaints);
        //princing//
        $pricings = DB::table('pricing')
        ->select(
            'ygn_branch',
            'rop_branch',
            'other_branch',
            DB::raw('SUM(rop_refund) as total_rop_amount'),    // Total refund amount for the group
            DB::raw('SUM(ygn_refund) as ygn_branch_total'),    // Total for ygn_branch
            DB::raw('SUM(other_refund) as other_branch_total'), // Total for other_branch
            DB::raw('COUNT(*) as count')                       // Count of records in the group
        )
        ->whereBetween('created_at', [$start_date, $end_date]) // Add date range filter
        ->groupBy('ygn_branch', 'rop_branch', 'other_branch')
        ->get();

// Calculate overall totals for total_rop_amount, ygn_branch_total, and other_branch_total
$RopTotal = $pricings->sum('total_rop_amount');
$ygnBranchTotal = $pricings->sum('ygn_branch_total');
$otherBranchTotal = $pricings->sum('other_branch_total');

// Chart result example
$chartData = [
    'labels' => ['YGN Branch', 'Other Branch', 'Rop Branch'],  // Chart labels
    'datasets' => [
        [
            'data' => [
                $ygnBranchTotal,      // YGN branch total (9000)
                $otherBranchTotal,    // Other branch total (3500)
                $RopTotal             // Grand total (6200)
            ],
            'backgroundColor' => [
                '#FF6384',            // Color for YGN Branch Total
                '#36A2EB',            // Color for Other Branch Total
                '#FFCE56'             // Color for Grand Total
            ],
            'hoverBackgroundColor' => [
                '#FF6384',            // Hover color for YGN Branch Total
                '#36A2EB',            // Hover color for Other Branch Total
                '#FFCE56'             // Hover color for Grand Total
            ],
            'label'=>[
                'Pricing',
            ],
            'borderWidth'=>[
                '1',
            ]
        ]
            ]
];
            return view('dashboard',compact('complaints','datasetsIn','label','chartData'));

    }else{
        return response()->json(['error' => 'Please provide both start and end dates.'], 400);
    }
}
       
}

 