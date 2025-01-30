<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Exports\ComplaintExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
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
        if ($ratings->count() > 0) {
            $rating_value = $rating_sum / $ratings->count();
        } else {
            $rating_value = 0;
        }
        $url = url('complaints-form', ['uuid' => $complaint->complaint_uuid]);
        // dd($signedUrl);
        return view('complaints.edit', compact('complaint', 'categories', 'statuses', 'branches', 'employees', 'users', 'logs', 'url', 'rating_sum', 'rating_value', 'ratings', 'ygnoperation', 'ropoperation'));
    }
    public function view($id)
    {
        $complaint = DB::table('complaints')->where('id', $id)->first();
        $ratings = DB::table('complaints')->where('id', $id)->get();
        $rating_sum = DB::table('complaints')->where('id', $id)->sum('stars_rated');
        if ($ratings->count() > 0) {
            $rating_value = $rating_sum / $ratings->count();
        } else {
            $rating_value = 0;
        }

        // dd($rating_sum);
        $categories = DB::table('case_types')->select('main_category')->groupBy('main_category')->get();
        $statuses = DB::table('statuses')->get();
        $branches = DB::table('branches')->get();
        $employees = DB::table('employees')->get();
        $users = DB::table('users')->get();
        $logs = DB::table('complaint_logs')->where('complaint_id', $id)->get();
        $pricing = DB::table('pricing')->where('complaint_id', $complaint->id)->get();
        $url = url('complaints-form', ['uuid' => $complaint->complaint_uuid]);
        // dd($pricing);
        return view('complaints.view', compact('complaint', 'categories', 'statuses', 'branches', 'employees', 'users', 'logs', 'url', 'rating_sum', 'rating_value', 'ratings', 'pricing'));
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
            $message_by = $request->operation_person . ' operation-reply complaint to ' . $request->handled_by . '.';
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
        } elseif ($request->case_status == 'rejected') {
            $message_by = $request->handled_by . ' has been rejected complaint.';
            $department = 'CX-Team';
        } else {
            $message_bimagey = '';
            $department = 'CX-Team';
        }
        //dd($today);

        $validator = \Validator::make($request->all(), [
            'image' => 'nullable|image'
        ], [
            'image.image' => 'Product file must be an image',
        ]);
        $file_name = "none";
        if ($request->file('image')) {
            $file_name = $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('files'), $file_name);
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
                'complaint_review' => $request->feedback_message,
                'company_remark' => $request->message,
                'stars_rated' => $request->rating,
                'case_type_name' => $request->case_type_name,
                'completed_at' => $request->currentDate,
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
                        'ygn_branch' => $request->ygn_branch,
                        'rop_branch' => $request->rop_branch,
                        'other_branch' => $request->other_branch,
                        'other_refund' => $request->other_amount,
                        //'image'=>$request->$file_name,
                        'negotiable_price' => $request->negotiable_price,
                        'created_at' =>  date('Y-m-d H:i:s'),
                        'updated_at' =>  date('Y-m-d H:i:s'),
                    ]);
                } else {
                    DB::table('pricing')->insert([
                        'complaint_id' => $id,
                        'status_name' => $request->case_status,
                        'ygn_refund' => $request->ygn_amount,
                        'rop_refund' => $request->rop_amount,
                        'default_value' => $request->amount,
                        'ygn_branch' => $request->ygn_branch,
                        'rop_branch' => $request->rop_branch,
                        'other_branch' => $request->other_branch,
                        'other_refund' => $request->other_amount,
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

        $status_array = groupStatus($status);
        return response()->json($status_array);
    }
    public function json_complaints($status)
    {
        if (Auth::user()->isDev()) {
            $complaints = DB::table('complaints')
                ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                ->orderBy('id', 'desc')
                ->paginate(5);
        }
        if (Auth::user()->isAdmin()) {
            $complaints = DB::table('complaints')->where('deleted_at', '0')
                ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                ->where('deleted_at', '0')
                ->orderBy('id', 'desc')
                ->paginate(20);
        }
        if (Auth::user()->isUser()) {
            $complaints = DB::table('complaints')
                ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                ->where('handle_by', Auth::user()->name)
                ->where('deleted_at', '0')
                ->orderBy('id', 'desc')
                ->paginate(20);
        }
        if (Auth::user()->isHod()) {
            $complaints = DB::table('complaints')
                ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                //->where('handle_by',Auth::user()->name)
                ->where('deleted_at', '0')
                ->orderBy('id', 'desc')
                ->paginate(20);
        }

        // dd($complaints);
        return response()->json($complaints);
    }

    //user create //
    public function cx_team()
    {
        return view('user.index');
    }

    public function cx_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required',
            'confirmPassword' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        } else {
            $newUser = new User();
            $newUser->name = $request->input('name');
            $newUser->email = $request->input('email');
            $newUser->password = Hash::make($request['password']);
            $newUser->role = $request->input('role');
            $newUser->save();
            return response()->json([
                'status' => 200,
                'message' => 'Create User Successfully.'
            ]);
        }
    }

    public function cx_list()
    {
        $users = DB::table('users')
            ->orderBy('id', 'desc')
            ->paginate(5);
        return response()->json($users);
    }

    public function cx_edit($id)
    {
        $student = User::find($id);

        if ($student) {
            return response()->json([
                'status' => 200,
                'student' => $student,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Student Found.'
            ]);
        }
    }

    public function cx_update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'email' => 'required|email',
            'password' => 'required|max:10',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()

            ]);
        } else {
            $student = User::find($id);
            if ($student) {
                $student->name = $request->input('name');
                $student->email = $request->input('email');
                $student->password = Hash::make($request['password']);
                $student->role = $request->input('role');
                $student->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'Student Updated Successfully.'
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No Student Found.'
                ]);
            }
        }
    }

    public function cx_destroy($id)
    {
        $student = User::find($id);
        if ($student) {
            $student->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Student Deleted Successfully.'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Student Found.'
            ]);
        }
    }

    public function dashboard()
    {
        $end_date = date('Y-m-d'); // Today's date
        $start_date = date('Y-m-d', strtotime('-1 month')); // One month before today
        $complaints = DB::table('complaints')
            ->select(
                'case_type_name',
                DB::raw("
                    CASE 
                        WHEN case_type_name IN ('Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain','COD Delay Refund') THEN 'Service Complaint Types'
                        WHEN case_type_name IN ('Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material') THEN 'Loss & Damage Types'
                        ELSE 'Other'
                    END as main_group
                "),
                DB::raw('count(*) as num'),
                DB::raw('GROUP_CONCAT(customer_message SEPARATOR "; ") as messages')
            )
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->groupBy('main_group', 'case_type_name')
            ->get();
        //dd($complaints);
        $serviceComplaintTotal = $complaints->where('main_group', 'Service Complaint Types')->sum('num');
        $lossDamageTotal = $complaints->where('main_group', 'Loss & Damage Types')->sum('num');
        //dd($lossDamageTotal);
        $label = [];
        $datas = [];
        $colors = ['#ff6384', '#36A2EB', '#FFCE56', '#8BC34A', '#FF5722', '#009688', '#795548', '#9C27B0', '#2196F3', '#FF9800', '#CDDC39', '#607D8B', '#10539c', '#00e8ff', '#00ffd4', '#ff0000'];
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
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
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
                        '#1d97ff',            // Color for YGN Branch Total
                        '#7dc006',            // Color for Other Branch Total
                        '#e52727'           // Color for Grand Total
                    ],
                    'hoverBackgroundColor' => [
                        '#1d97ff',            // Color for YGN Branch Total
                        '#7dc006',            // Color for Other Branch Total
                        '#e52727'           // Hover color for Grand Total
                    ],
                    'label' => [
                        'Pricing',
                    ],
                    'borderWidth' => [
                        '1',
                    ]
                ]
            ]
        ];
        //complaint status count//
        $completed = DB::table('complaints')->whereIn('status_name', ['completed', 'review'])
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->count();
        $follow = DB::table('complaints')->whereIn('status_name', ['handled'])
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->count();
        $assigned = DB::table('complaints')->whereIn('status_name', ['assigned'])
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->count();
        $progress = DB::table('complaints')->whereIn('status_name', ['operation-reply', 'cx-reply', 'refund', 'done'])
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->count();
        $pending = DB::table('complaints')->whereIn('status_name', ['pending'])
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->count();
        $rejected = DB::table('complaints')->whereIn('status_name', ['rejected'])
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->count();
        // dd($result);
        return view('dashboard', compact('complaints', 'datasetsIn', 'label', 'completed', 'pending', 'rejected', 'follow', 'assigned', 'progress', 'chartData', 'start_date', 'end_date', 'ygnBranchTotal', 'otherBranchTotal', 'RopTotal', 'serviceComplaintTotal', 'lossDamageTotal'));
    }

    public function searchdashboard(Request $request)
    {
        $start_date = $request->input('date_from');
        $end_date = $request->input('date_to');
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
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->groupBy('main_group', 'case_type_name')
            ->get();
        $serviceComplaintTotal = $complaints->where('main_group', 'Service Complaint Types')->sum('num');
        $lossDamageTotal = $complaints->where('main_group', 'Loss & Damage Types')->sum('num');
        $label = [];
        $datas = [];
        $colors = ['#ff6384', '#36A2EB', '#FFCE56', '#8BC34A', '#FF5722', '#009688', '#795548', '#9C27B0', '#2196F3', '#FF9800', '#CDDC39', '#607D8B', '#10539c', '#00e8ff', '#00ffd4', '#ff0000'];
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
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
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
                        '#1d97ff',            // Color for YGN Branch Total
                        '#7dc006',            // Color for Other Branch Total
                        '#e52727'             // Color for Grand Total
                    ],
                    'hoverBackgroundColor' => [
                        '#1d97ff',            // Hover color for YGN Branch Total
                        '#7dc006',            // Hover color for Other Branch Total
                        '#e52727'             // Hover color for Grand Total
                    ],
                    'label' => [
                        'Pricing',
                    ],
                    'borderWidth' => [
                        '1',
                    ]
                ]
            ]
        ];
        //complaint status count//
        $completed = DB::table('complaints')->whereIn('status_name', ['completed', 'review'])
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->count();
        $follow = DB::table('complaints')->whereIn('status_name', ['handled'])
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->count();
        $assigned = DB::table('complaints')->whereIn('status_name', ['assigned'])
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->count();
        $progress = DB::table('complaints')->whereIn('status_name', ['operation-reply', 'cx-reply', 'refund', 'done'])
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->count();
        $pending = DB::table('complaints')->whereIn('status_name', ['pending'])
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->count();
        $rejected = DB::table('complaints')->whereIn('status_name', ['rejected'])
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->count();
        return view('dashboard', compact('complaints', 'datasetsIn', 'label', 'completed', 'pending', 'rejected', 'follow', 'assigned', 'progress', 'chartData', 'start_date', 'end_date', 'ygnBranchTotal', 'otherBranchTotal', 'RopTotal', 'serviceComplaintTotal', 'lossDamageTotal'));
    }

    //export controller//
    public function exportComplaints(Request $request)
    {
        // Validate startDate and endDate parameters

        $startDate = $request->input('date_from');
        $endDate = $request->input('date_to');
        //dd($request->all());
        return Excel::download(new ComplaintExport($startDate, $endDate), 'complaints.xlsx');
    }


    public function destroy($id)
    {
        $complaints = DB::table('complaints')->where('id', $id)->first();

        if ($complaints) {
            if ($complaints->deleted_at == '1') {
                DB::table('complaints')
                    ->where('id', $id)
                    ->update(['deleted_at' => '0']);
            } else {
                DB::table('complaints')
                    ->where('id', $id)
                    ->update(['deleted_at' => '1']);
            }
        }

        return response()->json(['success' => 'Status changed successfully.', 'status' => '1']);
    }

    public function searchItem(Request $request)
    {
        //$search = $request->input('searchItem');
        // $searchItem = Str::upper($search);
        // dd($searchItem);
        $complaints = DB::table('complaints')
            ->where('complaint_uuid', 'LIKE', '%' . $request->search . '%')
            ->orWhere('waybill_no', 'LIKE', '%' . $request->search . '%')
            ->orWhere('customer_name', 'LIKE', '%' . $request->search . '%')
            ->orWhere('customer_mobile', 'LIKE', '%' . $request->search . '%')
            ->get();
        return response()->json($complaints);
    }

    public function update_operation(Request $request, $id)
    {
        $complaint = DB::table('complaints')->where('id', $id)->first();
        if ($request->case_status == 'operation-reply') {
            $message_by = $request->operation_person . ' operation-reply complaint to ' . $request->handled_by . '.';
            $department = $request->operation_person;
        } else {
            $message_bimagey = '';
            $department = 'CX-Team';
        }
        if ($complaint) {
            if ($complaint) {
                DB::table('complaints')->where('id', $id)->update([
                    'status_name' => $request->case_status,
                    'company_remark' => $request->message,
                    'updated_at' =>  date('Y-m-d H:i:s'),
                ]);
                DB::table('complaint_logs')->insert([
                    'complaint_id' => $id,
                    'status_name' => $request->case_status,
                    'message_by' => $message_by,
                    'department' => $department,
                    'message' => $request->message,
                    //'image'=>$request->$file_name,
                    'created_at' =>  date('Y-m-d H:i:s'),
                    'updated_at' =>  date('Y-m-d H:i:s'),
                ]);
            }
        }
    }

    public function search_filter(Request $request, $status)
    {
        //dd($status);
        //$type=$request->service;
        if (Auth::user()->isDev()) {
            if ($status == 'service') {
                $complaints = DB::table('complaints')
                    ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                    ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                    ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                    //->Where('handle_by',Auth::user()->name)
                    ->where('deleted_at', '0')
                    ->orderBy('id', 'desc')
                    ->paginate(20);
            }
            if ($status == 'loss') {
                $complaints = DB::table('complaints')
                    ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                    ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                    ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                    //->Where('handle_by',Auth::user()->name)
                    // ->where('deleted_at','0')
                    ->orderBy('id', 'desc')
                    ->paginate(20);
            }
        }
        if (Auth::user()->isAdmin()) {
            if ($status == 'service') {
                $complaints = DB::table('complaints')
                    ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                    ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                    ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                    //->Where('handle_by',Auth::user()->name)
                    ->where('deleted_at', '0')
                    ->orderBy('id', 'desc')
                    ->paginate(50);
            }
            if ($status == 'loss') {
                $complaints = DB::table('complaints')
                    ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                    ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                    ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                    //->Where('handle_by',Auth::user()->name)
                    ->where('deleted_at', '0')
                    ->orderBy('id', 'desc')
                    ->paginate(50);
            }
        }
        if (Auth::user()->isUser()) {
            if ($status == 'service') {
                $complaints = DB::table('complaints')
                    ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                    ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                    ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                    ->Where('handle_by', Auth::user()->name)
                    ->where('deleted_at', '0')
                    ->orderBy('id', 'desc')
                    ->paginate(50);
            }
            if ($status == 'loss') {
                $complaints = DB::table('complaints')
                    ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                    ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                    ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                    ->Where('handle_by', Auth::user()->name)
                    ->where('deleted_at', '0')
                    ->orderBy('id', 'desc')
                    ->paginate(50);
            }
        }
        if (Auth::user()->isHod()) {
            if ($status == 'service') {
                $complaints = DB::table('complaints')
                    ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                    ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                    ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                    //->Where('handle_by',Auth::user()->name)
                    ->where('deleted_at', '0')
                    ->orderBy('id', 'desc')
                    ->paginate(50);
            }
            if ($status == 'loss') {
                $complaints = DB::table('complaints')
                    ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                    ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                    ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                    //->Where('handle_by',Auth::user()->name)
                    ->where('deleted_at', '0')
                    ->orderBy('id', 'desc')
                    ->paginate(50);
            }
        }
        //dd($complaints);

        return response()->json($complaints);
    }

    public function search_status_filter($status, $id)
    {
        if (Auth::user()->isDev()) {
            if ($status == 'pending') {
                if ($id == 'service') {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['pending'])
                        ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        // ->where('deleted_at','0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                } else {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['pending'])
                        ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        // ->where('deleted_at','0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                }
            }
            if ($status == 'follow-up') {
                if ($id == 'service') {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['handled'])
                        ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        //  ->where('deleted_at','0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                } else {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['handled'])
                        ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        // ->where('deleted_at','0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                }
            }
            if ($status == 'assigned') {
                if ($id == 'service') {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['assigned'])
                        ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        //->where('deleted_at','0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                } else {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['assigned'])
                        ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        // ->where('deleted_at','0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                }
            }
            if ($status == 'progress') {
                if ($id == 'service') {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['operation-reply', 'cx-reply', 'refund', 'done'])
                        ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        // ->where('deleted_at','0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                } else {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['operation-reply', 'cx-reply', 'refund', 'done'])
                        ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        // ->where('deleted_at','0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                }
            }
            if ($status == 'completed') {
                if ($id == 'service') {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['completed', 'review'])
                        ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        //->where('deleted_at','0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                } else {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['completed', 'review'])
                        ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        // ->where('deleted_at','0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                }
            }
            if ($status == 'rejected') {
                if ($id == 'service') {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['rejected'])
                        ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        // ->where('deleted_at','0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                } else {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['rejected'])
                        ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        // ->where('deleted_at','0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                }
            }
        }
        if (Auth::user()->isAdmin()) {
            if ($status == 'pending') {
                if ($id == 'service') {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['pending'])
                        ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                } else {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['pending'])
                        ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                }
            }
            if ($status == 'follow-up') {
                if ($id == 'service') {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['handled'])
                        ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                } else {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['handled'])
                        ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                }
            }
            if ($status == 'assigned') {
                if ($id == 'service') {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['assigned'])
                        ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                } else {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['assigned'])
                        ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                }
            }
            if ($status == 'progress') {
                if ($id == 'service') {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['operation-reply', 'cx-reply', 'refund', 'done'])
                        ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                } else {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['operation-reply', 'cx-reply', 'refund', 'done'])
                        ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                }
            }
            if ($status == 'completed') {
                if ($id == 'service') {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['completed', 'review'])
                        ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                } else {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['completed', 'review'])
                        ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                }
            }
            if ($status == 'rejected') {
                if ($id == 'service') {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['rejected'])
                        ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                } else {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['rejected'])
                        ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                }
            }
        }
        if (Auth::user()->isUser()) {
            if ($status == 'pending') {
                if ($id == 'service') {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['pending'])
                        ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        ->Where('handle_by', Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                } else {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['pending'])
                        ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        ->Where('handle_by', Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                }
            }
            if ($status == 'follow-up') {
                if ($id == 'service') {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['handled'])
                        ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        ->Where('handle_by', Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                } else {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['handled'])
                        ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        ->Where('handle_by', Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                }
            }
            if ($status == 'assigned') {
                if ($id == 'service') {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['assigned'])
                        ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        ->Where('handle_by', Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                } else {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['assigned'])
                        ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        ->Where('handle_by', Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                }
            }
            if ($status == 'progress') {
                if ($id == 'service') {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['operation-reply', 'cx-reply', 'refund', 'done'])
                        ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        ->Where('handle_by', Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                } else {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['operation-reply', 'cx-reply', 'refund', 'done'])
                        ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        ->Where('handle_by', Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                }
            }
            if ($status == 'completed') {
                if ($id == 'service') {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['completed', 'review'])
                        ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        ->Where('handle_by', Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                } else {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['completed', 'review'])
                        ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        ->Where('handle_by', Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                }
            }
            if ($status == 'rejected') {
                if ($id == 'service') {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['rejected'])
                        ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        ->Where('handle_by', Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                } else {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['rejected'])
                        ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        ->Where('handle_by', Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                }
            }
        }
        if (Auth::user()->isHod()) {
            if ($status == 'pending') {
                if ($id == 'service') {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['pending'])
                        ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                } else {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['pending'])
                        ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                }
            }
            if ($status == 'follow-up') {
                if ($id == 'service') {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['handled'])
                        ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                } else {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['handled'])
                        ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                }
            }
            if ($status == 'assigned') {
                if ($id == 'service') {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['assigned'])
                        ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                } else {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['assigned'])
                        ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                }
            }
            if ($status == 'progress') {
                if ($id == 'service') {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['operation-reply', 'cx-reply', 'refund', 'done'])
                        ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                } else {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['operation-reply', 'cx-reply', 'refund', 'done'])
                        ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                }
            }
            if ($status == 'completed') {
                if ($id == 'service') {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['completed', 'review'])
                        ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                } else {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['completed', 'review'])
                        ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                }
            }
            if ($status == 'rejected') {
                if ($id == 'service') {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['rejected'])
                        ->whereIn('case_type_name', ['Service Complain', 'Delivery Man Complain', 'Staff Complain', 'Double Charges', 'Extra Charges', 'Delay Time', 'Wrong Transfer City', 'Parcel Wrong', 'CX Complain', 'Not Collect Pick Up Complain'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                } else {
                    $complaints = DB::table('complaints')
                        ->whereIn('status_name', ['rejected'])
                        ->whereIn('case_type_name', ['Damage', 'Loss', 'Reduce', 'Pest Control', 'Force Majeure', 'Illegal  Restricted Material'])
                        ->join('case_types', 'complaints.case_type_name', '=', 'case_types.case_name')
                        ->select('complaints.customer_name', 'complaints.id', 'complaints.complaint_uuid', 'complaints.customer_mobile', 'complaints.created_at', 'complaints.status_name', 'complaints.case_type_name', 'case_types.main_category')
                        //->Where('handle_by',Auth::user()->name)
                        ->where('deleted_at', '0')
                        ->orderBy('id', 'desc')
                        ->paginate(20);
                }
            }
        }
        return response()->json($complaints);
    }
}
