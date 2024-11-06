@extends('layouts.app1')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.css') }}">
@section('content')
    <style>
        .show-refund {
            display: none;
        }

        #target-1 {
            display: none;
        }
    </style>
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h3>Edit Complaint</h3>
                    </div>
                    <div class="col-12 col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"> <a class="home-item" href="index.html"><i
                                        data-feather="home"></i></a>
                            </li>
                            <li class="breadcrumb-item"> <a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a
                                    href="{{ url('complaints/' . $complaint->id . '/view') }}">View</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid default-dash">
            <form action="{{ url('complaints/' . $complaint->id . '/update') }}" method="POST"
                enctype="multipart/form-data" id="form-data">
                @csrf
                <div class="row">
                    <div class="col-xl-4 col-md-6 dash-35 dash-xl-50">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h4 class="card-title mb-0">Complaint ID #
                                    {{ $complaint->complaint_uuid }}
                                    <span class="badge badge-secondary inline-block pull-right" cursorshover="true">
                                        <span cursorshover="true"> {{ $complaint->status_name }}</span>
                                    </span>
                                </h4>
                                <div class="card-options"><a class="card-options-collapse" href="#"
                                        data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                        class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                            class="fe fe-x"></i></a></div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted">တိုင်ကြား / အကြံပြုသူအမည်</label>
                                            <input class="form-control" type="text"
                                                value="{{ $complaint->customer_name }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted">ဆက်သွယ်ရန်ဖုန်းနံပါတ်</label>
                                            <input class="form-control" type="text"
                                                value="{{ $complaint->customer_mobile }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted">ဖြစ်စဉ်ဖြစ်ပွားသည့်နေ့စွဲ</label>
                                            <input class="datepicker-here form-control digits" type="text"
                                                data-language="en" value="{{ $complaint->issue_date }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted">အမျိုးအစား</label>
                                            <select class="js-example-basic-single col-sm-12 case_type_name">
                                                @foreach ($categories as $category)
                                                    <optgroup label="{{ $category->main_category }}">
                                                        @foreach (DB::table('case_types')->select('id', 'case_name')->where('main_category', $category->main_category)->get() as $case)
                                                            <option value="{{ $case->case_name }}"
                                                                {{ $case->case_name == $complaint->case_type_name ? 'selected' : '' }}>
                                                                {{ $case->case_name }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">တိုင်ကြားချက်အသေးစိတ်</label>
                                    <textarea class="form-control" rows="4" readonly>{{ $complaint->customer_message }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <h6 class="form-label text-muted">တိုင်ကြားသူအကြံပြုချက်</h6>
                                    <textarea class="form-control" rows="4" readonly>{{ $complaint->customer_recommendation }}</textarea>
                                </div>


                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card recent-activity">
                                <div class="card-header card-no-border">
                                    <div class="media media-dashboard">
                                        <div class="media-body">
                                            <label class="form-label text-muted">operation-reply Link</label>
                                            <input type="text" class="form-control" value="{{ $url }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 dash-31 dash-xl-50">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h4 class="card-title mb-0">Complaint </h4>
                                <div class="card-options"><a class="card-options-collapse" href="#"
                                        data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                        class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                            class="fe fe-x"></i></a></div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="col-form-label text-muted">လက်ရှိအခြေအနေ</label>
                                            @if (Auth::user()->isAdmin() || Auth::user()->isDev())
                                                <select class="js-example-basic-single col-sm-12 case-status">
                                                    @foreach ($statuses as $status)
                                                        <option value="{{ $status->name }}"
                                                            {{ $status->name == $complaint->status_name ? 'selected' : '' }}>
                                                            {{ $status->name }}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <select class="js-example-basic-single col-sm-12 case-status-u">
                                                    @foreach ($statuses as $status)
                                                        @if (
                                                            $status->name == 'assigned' ||
                                                                $status->name == 'operation-reply' ||
                                                                $status->name == 'cx-reply' ||
                                                                $status->name == 'refund' ||
                                                                $status->name == 'done' ||
                                                                $status->name == 'completed')
                                                            <option value="{{ $status->name }}"
                                                                {{ $status->name == $complaint->status_name ? 'selected' : '' }}>
                                                                {{ $status->name }}</option>
                                                        @else
                                                            <option value="{{ $status->name }}"
                                                                {{ $status->name == $complaint->status_name ? 'selected' : '' }}
                                                                disabled>
                                                                {{ $status->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-form-label text-muted">တာဝန်ခံသူ</label>
                                            <select class="js-example-basic-single col-sm-12 handled-person">
                                                <option value="">No Person</option>
                                                @foreach ($users as $user)
                                                    @if (Auth::user()->isDev())
                                                        <option
                                                            value="{{ $user->name }}"{{ $user->name == $complaint->handle_by ? 'selected' : '' }}>
                                                            {{ $user->name }}</option>
                                                    @elseif(Auth::user()->isAdmin())
                                                        @if ($user->role !== '2')
                                                            <option
                                                                value="{{ $user->name }}"{{ $user->name == $complaint->handle_by ? 'selected' : '' }}>
                                                                {{ $user->name }}</option>
                                                        @endif
                                                    @else
                                                        @if ($user->name == $complaint->handle_by)
                                                            <option
                                                                value="{{ $user->name }}"{{ $user->name == $complaint->handle_by ? 'selected' : '' }}>
                                                                {{ $user->name }}</option>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="col-form-label text-muted">ရုံးခွဲတာဝန်ခံ</label>
                                            <select class="js-example-basic-single col-sm-12 operation-person">
                                                <option value="">No Person</option>
                                                @foreach ($employees as $employee)
                                                    <option
                                                        value="{{ $employee->employee_id }}({{ $employee->employee_name }})"
                                                        {{ $employee->employee_name . '(' . $employee->employee_id . ')' == $complaint->employee_name ? 'selected' : '' }}>
                                                        {{ $employee->employee_name }}({{ $employee->employee_id }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-form-label text-muted">ရုံးခွဲအမည်</label>
                                            <select class="js-example-basic-single col-sm-12 branch">
                                                <option value="">No Branch</option>
                                                @foreach ($branches as $branch)
                                                    <option value="{{ $branch->branch }}"
                                                        {{ $branch->branch == $complaint->branch_name ? 'selected' : '' }}>
                                                        {{ $branch->branch }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="col-form-label text-muted">လက်ခံရရှိသည့်နေရာ</label>
                                            <select class="js-example-basic-single col-sm-12 source">
                                                @if (permission() == 'Developer' || permission() == 'Admin')
                                                    <option value="Walk In"
                                                        {{ $complaint->source_platform == 'Walk In' ? 'selected' : '' }}>
                                                        Walk In
                                                    </option>
                                                    <option value="viber"
                                                        {{ $complaint->source_platform == 'viber' ? 'selected' : '' }}>
                                                        Viber
                                                    </option>
                                                    <option value="messenger"
                                                        {{ $complaint->source_platform == 'messenger' ? 'selected' : '' }}>
                                                        Messenger
                                                    </option>
                                                    <option value="phone call"
                                                        {{ $complaint->source_platform == 'phone call' ? 'selected' : '' }}>
                                                        Phone Call
                                                    </option>
                                                @else
                                                    <option value="{{ $complaint->source_platform }}">
                                                        {{ $complaint->source_platform }}</option>
                                                @endif
                                            </select>
                                        </div>
                                        {{-- <div class="col-md-6">
                                            <label class="col-form-label text-muted">ပေးလျော်သည့်ငွေပမဏ</label>
                                            <input class="form-control amount" type="text"
                                                value="{{ $complaint->refund_amount }}">
                                        </div> --}}
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header pb-0">
                                <h4 class="card-title mb-0">Refund Amount
                                    <button type="button"
                                        class="btn btn-primary inline-block pull-right show-refund">Show/Hide</button>
                                    <button type="button"
                                        class="btn btn-primary inline-block pull-right hide-refund">Show/Hide</button>
                                </h4>
                                <div class="card-options"><a class="card-options-collapse" href="#"
                                        data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                        class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                            class="fe fe-x"></i></a></div>
                            </div>
                            <div id="target-1">
                                <div class="card-body" id="show-hide-container-1">
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="col-form-label text-muted">YGN Operation</label>
                                                <select class="js-example-basic-single col-sm-12 ygn_branch">
                                                    <option value="">No Branch</option>
                                                    @foreach ($ygnoperation as $branch)
                                                        <option value="{{ $branch->branch }}">
                                                            {{ $branch->branch }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label text-muted">YGN Saving</label>
                                                <input class="form-control ygn_amount" type="text">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="col-form-label text-muted">ROP Operation</label>
                                                @if ($ropoperation->isNotEmpty())
                                                    <select class="js-example-basic-single col-sm-12 rop_branch">
                                                        <option value="">No Branch</option>
                                                        @foreach ($ropoperation as $cityId => $branches)
                                                            @foreach ($branches as $branch)
                                                                <option value="{{ $branch->branch }}">
                                                                    {{ $branch->branch }}
                                                                </option>
                                                            @endforeach
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <option value="">No Branch</option>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label text-muted">ROP Saving</label>
                                                <input class="form-control rop_amount" type="text">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="col-form-label text-muted">Other</label>
                                                <select class="js-example-basic-single col-sm-12 other_branch">
                                                    <option value="">No Branch</option>
                                                    <option value="Cx department">CX Department</option>
                                                    <option value="Ygn Sorting">YGN Sorting</option>
                                                    <option value="Mdy Sorting">MDY Sorting</option>
                                                    <option value="Ygn Cod">YGN COD</option>
                                                    <option value="Mdy Cod">MDY COD</option>
                                                    <option value="Admin">Admin</option>
                                                    <option value="Transport">Transport</option>
                                                    <option value="Fleet">Fleet</option>
                                                    <option value="FOC">FOC</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label text-muted">Other Saving</label>
                                                <input class="form-control other_amount" type="text">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="col-form-label text-muted">မူရင်းပစ္စည်းတန်ဖိုး</label>
                                                <input class="form-control amount" type="text">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label text-muted">Total</label>
                                                <input class="form-control negotiable_price" type="text" readonly>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card recent-activity">
                            <div class="card-header card-no-border">
                                <div class="media media-dashboard">
                                    <div class="media-body">
                                        <div class="mb-3">
                                            <label class="form-label">ဓာတ်ပုံတင်ရန်</label>
                                            <input class="form-control" type="file" name="image" id="image">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-muted">မှတ်ချက်</label>
                                            <textarea class="form-control internal-message" rows="4" placeholder="မှတ်ချက်ရေးရန်"></textarea>
                                        </div>
                                        <div class="form-footer">
                                            {{-- @if ($complaint->status_name != 'completed') --}}
                                            <button class="btn btn-primary btn-block" id="save"
                                                type="submit">Save</button>
                                            {{-- @endif --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card recent-activity">
                                <div class="card-header card-no-border">
                                    <div class="media media-dashboard">
                                        <div class="media-body">
                                            <h5 class="mb-0">Internal Activity </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="table-responsive custom-scrollbar">
                                        <table class="table table-bordernone">
                                            <tbody>
                                                @foreach ($logs as $log)
                                                    @if ($log->status_name == 'review')
                                                    @else
                                                        <tr>
                                                            <td>
                                                                <div class="media">
                                                                    <div class="square-box me-2"><img
                                                                            class="img-fluid b-r-5"
                                                                            src="https://admin.pixelstrap.com/zeta/assets/images/avtar/chinese.png"
                                                                            alt=""></div>
                                                                    <div class="media-body"><a href="user-profile.html">
                                                                            <h5>{{ $log->department }} <span
                                                                                    class="badge badge-light-primary">{{ $log->status_name }}</span><span
                                                                                    class="badge badge-light-theme-light font-theme-light pull-right">{{ $log->created_at }}</span>
                                                                            </h5>
                                                                        </a>
                                                                        <p class="text-normal">
                                                                            {{ $log->message_by }}
                                                                        </p>
                                                                        @if ($log->message)
                                                                            <div class="activity-msg bg-light-success">
                                                                                <span class="activity-msg-box">
                                                                                    {{ $log->message }}</span>
                                                                            </div>
                                                                    </div>
                                                    @endif
                                    </div>
                                    </td>
                                    <td> </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card recent-activity">
                            <div class="card-header card-no-border">
                                <div class="media media-dashboard">
                                    <div class="media-body">
                                        <h5 class="mb-0">Customer's Feedback </h5>
                                    </div>
                                    <div class="icon-box onhover-dropdown"><i data-feather="more-horizontal"></i>
                                        <div class="icon-box-show onhover-show-div">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive custom-scrollbar">
                                    <table class="table table-bordernone">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="media">
                                                        <div class="square-box me-2"><img class="img-fluid b-r-5"
                                                                src="https://admin.pixelstrap.com/zeta/assets/images/avtar/chinese.png"
                                                                alt=""></div>
                                                        <div class="media-body"><a href="user-profile.html">

                                                                <h5>Customer<span
                                                                        class="badge badge-light-theme-light font-theme-light pull-right">{{ $complaint->updated_at }}</span>
                                                                </h5>
                                                            </a>
                                                            <p class="mt-2">
                                                                {{ $complaint->handle_by }}
                                                                reviews
                                                                @php $ratenum=number_format($rating_value) @endphp
                                                                <span class="font-primary">
                                                                    @for ($i = 0; $i < $ratenum; $i++)
                                                                        <i class="fa fa-star checked"></i>
                                                                    @endfor
                                                                    @for ($j = $ratenum + 1; $j <= 5; $j++)
                                                                        <i class="fa fa-star"></i>
                                                                    @endfor
                                                                    @if ($ratenum > 0)
                                                                        {{ $ratenum }}
                                                                    @else
                                                                        No Rating
                                                                    @endif
                                                                </span> for complaint.
                                                            </p>
                                                            <div class="activity-msg bg-light-success"> <span
                                                                    class="activity-msg-box">
                                                                    @if ($complaint->stars_rated)
                                                                        {{ $complaint->complaint_review }}
                                                                    @else
                                                                        No Data
                                                                    @endif
                                                                </span>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </td>
                                                <td> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
        </div>
        </form>
    </div>
    </div>
    <!--notification validate modal-->
    <!-- feather icon js-->
@endsection
<input type="hidden" name="" id="url" value="{{ url('') }}">
<input type="hidden" name="" id="complaint_id" value="{{ $complaint->id }}">
<input type="hidden" name="" id="_token" value="{{ csrf_token() }}">
<input type="hidden" name="" id="connection" value="{{ permission() }}">
<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('assets/js/select2-custom.js') }}"></script>
<script src="{{ asset('assets/js/select2.full.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        var url = $("#url").val();
        var current_status_u = $(".case-status-u").val();
        var current_status = $(".case-status").val();
        var connection = $("#connection").val();

        $('#form-data').on('submit', (e) => {
            e.preventDefault();
            var formData = new FormData();
            // let refund_status = $("#refund_status").val();
            var handled_by = $(".handled-person").val();
            var operation_person = $(".operation-person :selected").text();
            var operation_id = $(".operation-person").val();
            var branch = $(".branch").val();
            var source = $(".source").val();
            var amount = $(".amount").val();
            var complaint_id = $("#complaint_id").val();
            var message = $(".internal-message").val();
            var photo = $('#image').prop('files')[0];
            var case_type_name = $(".case_type_name").val();
            var form = this;
            var _token = $("#_token").val();
            var ygn_branch = $(".ygn_branch").val();
            var rop_branch = $(".rop_branch").val();
            var ygn_amount = $(".ygn_amount").val();
            var rop_amount = $(".rop_amount").val();
            var other_branch = $(".other_branch").val();
            var other_amount = $(".other_amount").val();
            // var default_amount = $(".default_amount").val();
            var negotiable_price = $(".negotiable_price").val();
            //completed status insert completed date//
            if (name == 'completed') {
                var fullDate = new Date()
                var twoDigitMonth = ((fullDate.getMonth().length + 1) === 1) ? (fullDate.getMonth() +
                        1) :
                    '' + (fullDate.getMonth() + 1);
                var currentDate = fullDate.getDate() + "/" + twoDigitMonth + "/" + fullDate
                    .getFullYear();
                // alert(currentDate);
            } else {
                var currentDate = '';
                //alert(currentDate)
            }
            //completed date end//

            //user connection //
            if (connection == 'Admin' || connection == 'Developer') {

                var admin_status = $(".case-status").val();
                formData.append('case_status', admin_status);
            } else {
                var user_status = $(".case-status-u").val();
                formData.append('case_status', user_status);
            }
            //user connection end//
            formData.append('image', photo);
            formData.append('case_type_name', case_type_name);
            formData.append('handled_by', handled_by);
            formData.append('currentDate', currentDate);
            formData.append('operation_person', operation_person);
            formData.append('operation_id', operation_id);
            formData.append('branch', branch);
            formData.append('source', source);
            formData.append('amount', amount);
            formData.append('complaint_id', complaint_id);
            formData.append('message', message);
            formData.append('ygn_branch', ygn_branch);
            formData.append('rop_branch', rop_branch);
            formData.append('ygn_amount', ygn_amount);
            formData.append('rop_amount', rop_amount);
            formData.append('other_branch', other_branch);
            formData.append('other_amount', other_amount);
            //formData.append('default_amount', default_amount);
            formData.append('negotiable_price', negotiable_price);
            formData.append('_token', _token);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //alert(admin_status + 'admin status')
            //alert(user_status + 'user status')
            //same status connection //
            if (current_status == admin_status && current_status_u == user_status) {
                if (admin_status == 'refund' || user_status == 'refund') {
                    //return true; 
                    var status = 'true';
                    alert(status + 'refund');
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Your status the same ,please try again.',
                    })
                    return false;
                }

            } else {
                // return true;
                //alert('not status')
                var status = 'true';
                alert(status + 'not status');
            }
            //same status connection end//
            //start submit ajax//
            if (status == 'true') {
                $.ajax({
                    url: url + '/complaints/' + complaint_id + '/update',
                    type: 'POST',
                    contentType: 'multipart/form-data',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: (response) => {
                        Swal.fire({
                            title: 'Success!',
                            text: 'You Complaint has been updated successfully.',
                        }).then((result) => {
                            if (result.isConfirmed == true) {
                                location.reload();
                            }
                        })

                    },
                    error: (response) => {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Somethings Error not updated successfully',
                        })
                    }
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'Something Error!',
                })
            }


        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.hide-refund').click(function() {
            $('#target-1').show(500);
            $('.hide-refund').hide(0);
            $('.show-refund').show(0);
        });
        $('.show-refund').click(function() {
            $('#target-1').hide(500);
            $('.hide-refund').show(0);
            $('.show-refund').hide(0);
        });

        $(".ygn_amount,.rop_amount,.other_amount").keyup(function() {
            var ygnAmount = $(".ygn_amount").val();
            var ropAmount = $(".rop_amount").val();
            var otherAmount = $(".other_amount").val();
            // var total = parseFloat(ygnAmount) + parseFloat(ropAmount) + parseFloat(otherAmount);
            if (ygnAmount) {
                var ygn_branch = $('.ygn_branch :selected').text();

                if (ygn_branch == 'No Branch') {
                    $('#save').prop('disabled', true);
                    //alert(ygn_branch);
                }
            }
            if (ropAmount) {
                var ygn_branch = $('.rop_branch :selected').text();
                if (ygn_branch == 'No Branch') {
                    $('#save').prop('disabled', true);
                    //alert(ygn_branch);
                }
            }
            if (otherAmount) {
                var ygn_branch = $('.other_branch :selected').text();
                if (ygn_branch == 'No Branch') {
                    $('#save').prop('disabled', true);
                    //alert(ygn_branch);
                }
            }
            if (!ygnAmount) {
                ygnAmount = 0;
                var total = parseFloat(ygnAmount) + parseFloat(ropAmount) + parseFloat(otherAmount);
            }
            if (!ropAmount) {
                ropAmount = 0;
                var total = parseFloat(ygnAmount) + parseFloat(ropAmount) + parseFloat(otherAmount);
            }
            if (!otherAmount) {
                otherAmount = 0;
                var total = parseFloat(ygnAmount) + parseFloat(ropAmount) + parseFloat(otherAmount);

            } else {
                var total = parseFloat(ygnAmount) + parseFloat(ropAmount) + parseFloat(otherAmount);
            }
            $(".negotiable_price").val(total);
            //alert(keyup)
        })
        $('.ygn_branch,.rop_branch,.other_branch').on('change', function() {
            var ygn_branch = $('.ygn_branch :selected').text();
            if (ygn_branch == 'No Branch') {
                $('#save').prop('disabled', true);
            } else {
                $('#save').prop('disabled', false);
            }
        })

    })
</script>
