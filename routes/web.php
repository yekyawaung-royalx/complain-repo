<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\CustomerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});
Route::get('/complaints/{id}', function () {
    return view('complaints.view');
})->middleware('auth');

Route::get('/test', function () {
    $today = date('Y-m');
    $complaints = DB::table('complaints')
    ->select(
        'case_type_name',
        DB::raw("
            CASE 
                WHEN case_type_name IN ('Service Complain','Delivery Man Complain','Staff Complain','Double Charges','Extra Charges','Delay Time','Wrong Transfer City','Parcel Wrong','CX Complain','Not Collect Pick Up Complain') THEN 'Service Complaint Types'
                WHEN case_type_name IN ('Damage','Loss','Reduce','Pest Control','Force Majeure','Illegal  Restricted Material') THEN 'Loss & Damage Types'
                ELSE 'Other'
            END as main_group
        "),
        DB::raw('count(*) as num'),
        DB::raw('GROUP_CONCAT(customer_message SEPARATOR "; ") as messages')
    )
    ->whereYear('created_at', $today)
    ->groupBy('main_group', 'case_type_name')
    ->get();

   return view('test',compact('complaints'));
})->middleware('auth');



Route::get('complaints-form/{uuid}', function ($uuid) {
    $complaint = DB::table('complaints')->where('complaint_uuid',$uuid)->first();
    $ratings = DB::table('complaints')->where('complaint_uuid', $uuid)->get();
    $rating_sum = DB::table('complaints')->where('complaint_uuid', $uuid)->sum('stars_rated');
    if($ratings->count()>0){
        $rating_value=$rating_sum/$ratings->count();
    }else{
        $rating_value=0;
    }
    if($complaint){
        $categories = DB::table('case_types')->select('main_category')->groupBy('main_category')->get();
        $statuses = DB::table('statuses')->get();
        $branches = DB::table('branches')->get();
        $employees = DB::table('employees')->get();
        $users = DB::table('users')->get();
        $logs = DB::table('complaint_logs')->where('complaint_id',$complaint->id)->get();
        
        return view('complaints.operation-form',compact('complaint','categories','statuses','branches','employees','users','logs','ratings','rating_sum','rating_value'));
    }else{
         return view('complaints.404',compact('uuid'));
    }
        

})->name('complaints-form');

// Route::get('/complaints/{id}/edit',[App\Http\Controllers\ComplaintController::class,'edit']);
// Route::get('/complaints/{id}/view',[App\Http\Controllers\ComplaintController::class,'view']);
// Route::post('/complaints/{id}/update',[App\Http\Controllers\ComplaintController::class,'update']);


Route::get('/complaints/status/{status}', function () {
    return view('complaints.listing');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/complaints/all-status/{status}', function () {
    return view('complaints.complaint');
})->middleware(['auth', 'verified'])->name('dashboard');
// Route::get('/complaints/status/{status}',[App\Http\Controllers\ComplaintController::class,'status']);
Route::get('/complaints/json/{status}',[App\Http\Controllers\ComplaintController::class,'json_status'])->middleware('auth');
Route::get('/complaints/all-json/{status}',[App\Http\Controllers\ComplaintController::class,'json_complaints'])->middleware('auth');


// Route::get('/dashboard', function () {
   
// })->middleware(['auth', 'verified'])->name('dashboard');
 
Route::get('/user-dashboard', function () {
    $complaint_count = DB::table('complaints')
   // ->Where('handle_by',Auth::user()->name)
    ->where('deleted_at','0')
    ->count();
    $completed=DB::table('complaints')->whereIn('status_name',['completed','review'])
   // ->Where('handle_by',Auth::user()->name)
    ->where('deleted_at','0')
    ->count();
    $follow=DB::table('complaints')->whereIn('status_name', ['handled'])
   // ->Where('handle_by',Auth::user()->name)
    ->where('deleted_at','0')
    ->count();
    $assigned=DB::table('complaints')->whereIn('status_name',['assigned'])
    //->Where('handle_by',Auth::user()->name)
    ->where('deleted_at','0')
    ->count();
    $progress=DB::table('complaints')->whereIn('status_name', ['operation-reply', 'cx-reply', 'refund', 'done'])
    //->Where('handle_by',Auth::user()->name)
    ->where('deleted_at','0')
    ->count();
    $complaint_review = DB::table('complaints')
    ->where('deleted_at','0')
    ->groupBy('stars_rated')
    ->count();
    return view('dashboard2',compact('complaint_count','completed','follow','assigned','progress','complaint_review'));
})->middleware(['auth', 'verified'])->name('dashboard2');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



//customer
Route::get('/customer',[CustomerController::class,'customer'])->name('customer');
Route::get('/casetype',[CustomerController::class,'CaseType'])->name('casetype');
Route::get('/search',[CustomerController::class,'RexSearch'])->name('search');
Route::post('customer-submit',[CustomerController::class,'CustomerSubmit'])->name('customer-submit');
Route::post('employee-submit',[CustomerController::class,'employee'])->name('employee-submit');
Route::post('customer-tracking',[CustomerController::class,'customer_tracking']);
Route::post('/customer/{id}/feedback',[App\Http\Controllers\ComplaintController::class,'customer_feedback']);
//user page//

Route::group(['middleware' => 'auth'], function () {
    Route::get('/cx-team',[App\Http\Controllers\ComplaintController::class,'cx_team']);
Route::post('/cx-team/store',[App\Http\Controllers\ComplaintController::class,'cx_store']);
Route::get('/cx-team/list',[App\Http\Controllers\ComplaintController::class,'cx_list']);
Route::get('/cx-team/edit/{id}',[App\Http\Controllers\ComplaintController::class,'cx_edit']);
Route::put('update-cx/{id}', [App\Http\Controllers\ComplaintController::class,'cx_update']);
Route::delete('delete-cx/{id}', [App\Http\Controllers\ComplaintController::class,'cx_destroy']);

//user profile//

Route::get('/profile',[App\Http\Controllers\ProfileController::class,'profile']);
Route::get('/rating-list/{name}',[App\Http\Controllers\ProfileController::class,'rating_list']);

//dashboard //
Route::get('/dashboard', [App\Http\Controllers\ComplaintController::class,'dashboard']);
 Route::post('/dashboard', [App\Http\Controllers\ComplaintController::class,'searchdashboard']);

 //internal assigned route//
 Route::get('/complaints/{id}/edit',[App\Http\Controllers\ComplaintController::class,'edit']);
Route::get('/complaints/{id}/view',[App\Http\Controllers\ComplaintController::class,'view']);
Route::post('/complaints/{id}/update',[App\Http\Controllers\ComplaintController::class,'update']);
Route::delete('/delete/{id}',[App\Http\Controllers\ComplaintController::class,'destroy']);

//export route//
Route::get('/export-complaints', [ComplaintController::class, 'exportComplaints']);
Route::get('/search-item', [ComplaintController::class, 'searchItem']);
Route::get('/filter', [ComplaintController::class, 'search_filter']);


});
// Route::get('/cx-team',[App\Http\Controllers\ComplaintController::class,'cx_team']);
Route::post('/complaints/{id}/update-operation',[App\Http\Controllers\ComplaintController::class,'update_operation']);