<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="Zeta admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Zeta admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="../assets/images/logo/favicon-icon.png" type="image/x-icon">
    <link rel="shortcut icon" href="../assets/images/logo/favicon-icon.png" type="image/x-icon">
    <title>Complaint Dashboard </title>
    <!-- Google font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.css') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/feather-icon.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/scrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/date-picker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/photoswipe.css') }}">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
</head>
<style>
    .checked {
        color: #ffd900;
    }
</style>

<body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
        <div class="loader">
            <div class="loader-bar"></div>
            <div class="loader-bar"></div>
            <div class="loader-bar"></div>
            <div class="loader-bar"></div>
            <div class="loader-bar"></div>
            <div class="loader-ball"></div>
        </div>
    </div>
    <!-- Loader ends-->
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->

        <!-- Page Header Ends                              -->
        <!-- Page Body Start-->
        <div class="page-body-wrapper">

            <div class="container-fluid">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <h3>View Complaint</h3>
                        </div>
                        <div class="col-12 col-sm-6">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"> <a class="home-item" href="index.html"><i
                                            data-feather="home"></i></a></li>
                                <li class="breadcrumb-item"> Dashboard</li>
                                <li class="breadcrumb-item active"> Default</li>
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
                                    <h4 class="card-title mb-0">Complaint ID # {{ $complaint->complaint_uuid }}

                                        <span class="badge badge-secondary inline-block pull-right"
                                            cursorshover="true">
                                            <span cursorshover="true"> {{ $complaint->status_name }}</span>
                                        </span>
                                    </h4>
                                    <div class="card-options"><a class="card-options-collapse" href="#"
                                            data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                            class="card-options-remove" href="#"
                                            data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
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
                                                <select class="js-example-basic-single col-sm-12 case_type_name"
                                                    disabled>
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


                        </div>
                        <div class="col-xl-4 col-md-6 dash-31 dash-xl-50">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h4 class="card-title mb-0">Complaint </h4>
                                    <div class="card-options"><a class="card-options-collapse" href="#"
                                            data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                            class="card-options-remove" href="#"
                                            data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
                                </div>
                                <div class="card-body">

                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="col-form-label text-muted">လက်ရှိအခြေအနေ</label>
                                                <select class="js-example-basic-single col-sm-12" disabled>
                                                    @foreach ($statuses as $status)
                                                        <option value="{{ $status->name }}"
                                                            {{ $status->name == $complaint->status_name ? 'selected' : '' }}>
                                                            {{ $status->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label text-muted">တာဝန်ခံသူ</label>
                                                <select class="js-example-basic-single col-sm-12 handled-person"
                                                    disabled>
                                                    <option value="">No Person</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->name }}"
                                                            {{ $user->name == $complaint->handle_by ? 'selected' : '' }}>
                                                            {{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="col-form-label text-muted">ရုံးခွဲတာဝန်ခံ</label>
                                                <select class="js-example-basic-single col-sm-12 operation-person"
                                                    disabled>
                                                    <option value="">No Person</option>
                                                    @foreach ($employees as $employee)
                                                        <option
                                                            value="{{ $employee->employee_id }}({{ $employee->employee_id }})"
                                                            {{ $employee->employee_name . '(' . $employee->employee_id . ')' == $complaint->employee_name ? 'selected' : '' }}>
                                                            {{ $employee->employee_name }}({{ $employee->employee_id }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label text-muted">ရုံးခွဲအမည်</label>
                                                <select class="js-example-basic-single col-sm-12 branch" disabled>
                                                    <option value="">No Branch</option>
                                                    @foreach ($branches as $branch)
                                                        <option value="{{ $branch->branch }}"
                                                            {{ $branch->branch == $complaint->branch_name ? 'selected' : '' }}>
                                                            {{ $branch->branch }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="col-form-label text-muted">လက်ခံရရှိသည့်နေရာ</label>
                                                <select class="js-example-basic-single col-sm-12 source" disabled>
                                                    <option value="{{ $complaint->source_platform }}">
                                                        {{ $complaint->source_platform }}</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label text-muted">ပေးလျော်သည့်ငွေပမဏ</label>
                                                <input class="form-control amount" type="text"
                                                    value="{{ $complaint->refund_amount }}" disabled>
                                            </div>
                                        </div>
                                        {{-- <div class="mb-3">
                                            <label class="form-label">ဓာတ်ပုံတင်ရန်</label>
                                            <input class="form-control" type="file" name="image"
                                                id="image">
                                        </div> --}}
                                        <div class="mb-3">
                                            <label class="form-label text-muted">မှတ်ချက်</label>
                                            <textarea class="form-control internal-message" rows="4" placeholder="မှတ်ချက်ရေးရန်"></textarea>
                                        </div>
                                        <input type="hidden" name="case_status" id="case_status"
                                            value="operation-reply">
                                        <div class="form-footer">
                                            @if ($complaint->status_name == 'assigned' || $complaint->status_name == 'cx-reply')
                                                <button class="btn btn-primary btn-block" id="save"
                                                    type="submit">Save</button>
                                            @endif
                                        </div>
                                    </div>
                </form>
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
                                                    <div class="square-box me-2"><img class="img-fluid b-r-5"
                                                            src="https://admin.pixelstrap.com/zeta/assets/images/avtar/chinese.png"
                                                            alt=""></div>
                                                    <div class="media-body"><a href="user-profile.html">
                                                            <h5>{{ $log->department }} <span
                                                                    class="badge badge-light-primary">{{ $log->status_name }}</span><span
                                                                    class="badge badge-light-theme-light font-theme-light pull-right">{{ $log->created_at }}</span>
                                                            </h5>
                                                        </a>
                                                        <p class="text-normal">{{ $log->message_by }}
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


    </div>
    </div>
    <!-- Container-fluid Ends-->

    <!-- footer start-->
    <footer class="footer m-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 footer-copyright text-center">
                    <input type="hidden" name="" id="url" value="{{ url('') }}">
                    <input type="hidden" name="" id="complaint_id" value="{{ $complaint->id }}">
                    <input type="hidden" name="" id="_token" value="{{ csrf_token() }}">
                    <p class="mb-0">Copyright 2022 © Zeta theme by pixelstrap </p>
                </div>
            </div>
        </div>
    </footer>
    </div>
    </div>
    <!-- latest jquery-->
    <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>

    <!-- Bootstrap js-->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <!-- feather icon js-->
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/feather-icon.js') }}"></script>
    <!-- scrollbar js-->
    <!-- Sidebar jquery-->
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/knob.min.js') }}"></script>
    <script src="{{ asset('assets/js/knob-chart.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/apex-chart.js') }}"></script> --}}
    <script src="{{ asset('assets/js/stock-prices.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-notify.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/default.js') }}"></script> --}}
    <script src="{{ asset('assets/js/index.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker.en.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker.custom.js') }}"></script>
    <script src="{{ asset('assets/js/photoswipe.min.js') }}"></script>
    <script src="{{ asset('assets/js/photoswipe-ui-default.min.js') }}"></script>
    <script src="{{ asset('assets/js/photoswipe.js') }}"></script>
    <script src="{{ asset('assets/js/handlebars.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/typeahead.bundle.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/typeahead.custom.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/typeahead-custom.js') }}"></script> --}}
    <script src="{{ asset('assets/js/height-equal.js') }}"></script>
    <script src="{{ asset('assets/js/select2-custom.js') }}"></script>
    <script src="{{ asset('assets/js/select2.full.min.js') }}"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/customizer.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- login js-->
    <!-- Plugin used-->
    <script>
        $(document).ready(function() {
            var url = $("#url").val();
            $('#form-data').on('submit', (e) => {
                e.preventDefault();
                var formData = new FormData();
                let name = 'operation-reply';
                // let refund_status = $("#refund_status").val();
                var handled_by = $(".handled-person").val();
                var operation_person = $(".operation-person :selected").text();
                var operation_id = $(".operation-person").val();
                var branch = $(".branch").val();
                var source = $(".source").val();
                var amount = $(".amount").val();
                var complaint_id = $("#complaint_id").val();
                var message = $(".internal-message").val();
                //var photo = $('#image').prop('files')[0];
                var form = this;
                var _token = $("#_token").val();
                var case_type_name = $(".case_type_name").val();
                formData.append('case_status', name);

                //let _token = $('meta[name="csrf-token"]').attr('content');


                //formData.append('image', photo);
                formData.append('handled_by', handled_by);
                formData.append('operation_person', operation_person);
                formData.append('operation_id', operation_id);
                formData.append('branch', branch);
                formData.append('source', source);
                formData.append('amount', amount);
                formData.append('complaint_id', complaint_id);
                formData.append('message', message);
                formData.append('_token', _token);
                formData.append('case_type_name', case_type_name);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

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
                            text: 'Operation apply has been updated successfully',
                        }).then((result) => {
                            if (result.isConfirmed == true) {
                                location.reload();
                            }
                        })

                    },
                    error: (response) => {
                        console.log(response);
                    }
                });
            });
        });
    </script>
</body>

</html>
