<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function customer()
    {
        $branchs = DB::table('branches')->get();
        $case = DB::table('case_types')
            ->select('main_category', DB::raw('count(*) as total'))
            ->groupBy('main_category')
            ->get();
        // dd($branches);
        return view('customer.index', compact('case', 'branchs'));
    }


    public function CaseType(Request $request)
    {
        $selected = $request->selected;
        $case = DB::table('case_types')
            ->where('main_category', $selected)
            ->get();
        return response()->json($case);
        // dd($selected);
    }

    public function RexSearch(Request $request)
    {
        $search = $request->keyword;
        $rex = DB::table('employees')
            ->where("employee_id", "LIKE", "%{$search}%")
            ->get();

        return response()->json($rex);
    }

    public function CustomerSubmit(Request $request)
    {
        $input = $request->all();
        $recaptcha_secret = '6LcilHYqAAAAAGGx4ZUFgAdjnwO8nTau5QC3bfmX';
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret . "&response=" . $input['g-recaptcha-response']);
        $response = json_decode($response, true);
        if ($response["success"] === true) {
            $status = DB::table('statuses')->where('id', 1)->first();
            //dd($complaint->name);
            $number = uuid();
            $customer_name = $request->complainant_name;
            $customer_phone = $request->complainant_phone;
            $waybill_no = $request->waybill_no;
            $complainant_date = $request->complainant_date;
            // $main_category=$request->main_category;
            $case_type = $request->case_type;
            $detail_complainant = $request->detail_complainant;
            $complainant_reco = $request->complainant_reco;
            $image = array();
            if ($images = $request->file('image')) {
                foreach ($images as $file) {
                    $image_name = md5(rand(1000, 10000));
                    $ext = strtolower($file->getClientOriginalExtension());
                    $image_full_name = $image_name . '.' . $ext;
                    $upload_path = public_path('files/');
                    $image_url = $image_full_name;
                    $file = $file->move($upload_path, $image_full_name);
                    $image[] = $image_url;
                }
            }
            //dd($request->file('image'));
            DB::table('complaints')->insert([
                'customer_name' => $customer_name,
                'complaint_uuid' => $number,
                'customer_mobile' => $customer_phone,
                'waybill_no' => $waybill_no,
                'issue_date' => $complainant_date,
                'case_type_name' => $case_type,
                'customer_message' => $detail_complainant,
                'customer_recommendation' => $complainant_reco,
                'image' => implode('|', $image),
                'source_platform' => 'Walk In',
                'status_name' => $status->name,
                'created_at' => Carbon::now()->setTimezone('Asia/Yangon'), // Myanmar Timezone
                'updated_at' => Carbon::now()->setTimezone('Asia/Yangon'),
            ]);
            //return response()->json(['code' => 1, 'msg' => 'Complaint Form ကိုဖြည့်သွင်းလိုက်ပါပြီးComplaint ID ဖြင့်tracking လိုက်လို့ရပါသည်', 'uuid' => $number]);
            return back()->with('success', 'Complaint Form ကိုဖြည့်သွင်းလိုက်ပါပြီးComplaint ID ဖြင့်tracking လိုက်လို့ရပါသည်၊၊ Complaint ID No-' . $number);
        } else {
            return back()->with('danger', 'Invalid reCAPTCHA!');
        }
    }


    public function employee(Request $request)
    {
        // $input = $request->all();
        // $recaptcha_secret = '6LcilHYqAAAAAGGx4ZUFgAdjnwO8nTau5QC3bfmX'; 
        // $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret."&response=".$input['g-recaptcha-response']);
        // $response = json_decode($response,true);
        // if ($response["success"] === true){
        $status = DB::table('statuses')->where('id', 1)->first();
        $number = uuid();
        $branches = $request->branches;
        $employee_rex = $request->employee_rex;
        $redir_message = $request->redir_message;
        $customer_name = $request->e_complainant_name;
        $customer_phone = $request->e_complainant_phone;
        $waybill_no = $request->waybill_no;
        $complainant_date = $request->complainant_date;
        // $main_category=$request->main_category;
        $e_case_type = $request->e_case_type;
        $detail_complainant = $request->detail_complainant;
        $complainant_reco = $request->complainant_reco;
        //validation phone number//
        $validator = Validator::make($request->all(), [
            'e_complainant_phone' => [
                'required',
                'regex:/^[0-9]+$/', // Only digits, no limit
            ],
            [
                'e_complainant_phone.regex' => 'The phone number must contain exactly 10 digits.',
            ],

        ]);

        if ($validator->fails()) {
            return back()->with('danger', $validator->messages());
        }
        //end validation phone number//
        $image = array();
        if ($images = $request->file('image')) {
            foreach ($images as $file) {
                $image_name = md5(rand(1000, 10000));
                $ext = strtolower($file->getClientOriginalExtension());
                $image_full_name = $image_name . '.' . $ext;
                $upload_path = public_path('files/');
                $image_url = $image_full_name;
                $file = $file->move($upload_path, $image_full_name);
                $image[] = $image_url;
            }
        }
        DB::table('complaints')->insert([
            'customer_name' => $customer_name,
            'complaint_uuid' => $number,
            'customer_mobile' => $customer_phone,
            'waybill_no' => $waybill_no,
            'issue_date' => $complainant_date,
            'case_type_name' => $e_case_type,
            'customer_message' => $detail_complainant,
            'customer_recommendation' => $complainant_reco,
            'image' => implode('|', $image),
            'employee_id' => $employee_rex,
            'source_branch' => $branches,
            'source_platform' => $redir_message,
            'status_name' => $status->name,
            'created_at' => Carbon::now()->setTimezone('Asia/Yangon'), // Myanmar Timezone
            'updated_at' => Carbon::now()->setTimezone('Asia/Yangon'),
        ]);
        return back()->with('success', 'Complaint Form ကိုဖြည့်သွင်းလိုက်ပါပြီးComplaint ID ဖြင့်tracking လိုက်လို့ရပါသည်၊၊ Complaint ID No-' . $number);
        // }else{
        //     return back()->with('danger','Invalid reCAPTCHA!');
        // }
    }


    public function customer_tracking(Request $request)
    {
        //dd($request->all());
        $complaint = DB::table('complaints')->where('complaint_uuid', $request->tracking)->first();
        $categories = DB::table('case_types')->select('main_category')->groupBy('main_category')->get();
        $statuses = DB::table('statuses')->get();
        $branches = DB::table('branches')->get();
        $employees = DB::table('employees')->get();
        $users = DB::table('users')->get();

        if ($complaint) {
            $logs = DB::table('complaint_logs')->where('complaint_id', $complaint->id)->get();
            return view('customer.tracking', compact('complaint', 'categories', 'statuses', 'branches', 'employees', 'users', 'logs'));
            //dd($complaint->id);
        } else {
            $tracking = $request->tracking;
            // dd($tracking);
            return view('customer.404', compact('tracking'));
        }
    }
}
