<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function customer()
    {
        $branches = DB::table('branches')->get();
        $case = DB::table('case_types')
            ->select('main_category', DB::raw('count(*) as total'))
            ->groupBy('main_category')
            ->get();
        // dd($branches);
        return view('customer.index', compact('case', 'branches'));
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
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret."&response=".$input['g-recaptcha-response']);
        $response = json_decode($response,true);
        if ($response["success"] === true){
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
            $validator = \Validator::make($request->all(), [
                'image' => 'nullable|image'
            ], [
                'image.image' => 'Product file must be an image',
            ]);
    
            if (!$validator->passes()) {
                return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
            } else {
                $file_name = "none";
                if ($request->file('image')) {
                    $file_name = $request->file('image')->getClientOriginalName();
                    $request->file('image')->move(public_path('files'), $file_name);
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
                    'image' => $file_name,
                    'source_platform' => 'web',
                    'status_name' => $status->name,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                ]);
                //return response()->json(['code' => 1, 'msg' => 'Complaint Form ကိုဖြည့်သွင်းလိုက်ပါပြီးComplaint ID ဖြင့်tracking လိုက်လို့ရပါသည်', 'uuid' => $number]);
                return back()->with('success','Complaint Form ကိုဖြည့်သွင်းလိုက်ပါပြီးComplaint ID ဖြင့်tracking လိုက်လို့ရပါသည်'.$number);
            }
        }else{
            return back()->with('danger','Invalid reCAPTCHA!');
        }
    }


    public function employee(Request $request)
    {
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
        $validator = \Validator::make($request->all(), [
            'image' => 'nullable|image'
        ], [
            'image.image' => 'Product file must be an image',
        ]);

        if (!$validator->passes()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $file_name = "none";
            if ($request->file('image')) {
                $file_name = $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('files'), $file_name);
            }

            DB::table('complaints')->insert([
                'customer_name' => $customer_name,
                'complaint_uuid' =>$number,
                'customer_mobile' => $customer_phone,
                'waybill_no' => $waybill_no,
                'issue_date' => $complainant_date,
                'case_type_name' => $e_case_type,
                'customer_message' => $detail_complainant,
                'customer_recommendation' => $complainant_reco,
                'image' => $file_name,
                'employee_id'=>$employee_rex,
                'source_branch' => $branches,
                'source_platform' => $redir_message,
                'status_name' => $status->name,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);
            return back()->with('success','Complaint Form ကိုဖြည့်သွင်းလိုက်ပါပြီးComplaint ID ဖြင့်tracking လိုက်လို့ရပါသည်'.$number);
        }
    }


    public function customer_tracking(Request $request){
        //dd($request->all());
        $complaint = DB::table('complaints')->where('complaint_uuid', $request->tracking)->first();
        $categories = DB::table('case_types')->select('main_category')->groupBy('main_category')->get();
        $statuses = DB::table('statuses')->get();
        $branches = DB::table('branches')->get();
        $employees = DB::table('employees')->get();
        $users = DB::table('users')->get();
       
        if($complaint){
            $logs = DB::table('complaint_logs')->where('complaint_id', $complaint->id)->get();
           return view('customer.tracking',compact('complaint','categories','statuses','branches','employees','users','logs'));
          //dd($complaint->id);
            }else{
                $tracking=$request->tracking;
               // dd($tracking);
                return view('customer.404',compact('tracking'));
        }
    }

}