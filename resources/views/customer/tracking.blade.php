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
    .rating-css div {
        color: #ffe400;
        font-size: 30px;
        font-family: sans-serif;
        font-weight: 800;
        text-align: center;
        text-transform: uppercase;

        padding: 20px 0;
    }

    .rating-css input {
        display: none;
    }

    .rating-css input+label {
        font-size: 60px;
        text-shadow: 1px 1px 0 #8f8420;
        cursor: pointer;
    }

    .rating-css input:checked+label~label {
        color: #b4afaf;
    }

    .rating-css label:active {
        transform: scale(0.8);
        transition: 0.3s ease;
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
                                <li class="breadcrumb-item active"> Tracking</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid starts-->
            <div class="container-fluid default-dash">
                <div class="row">
                    <div class="col-xl-4 col-md-6 dash-35 dash-xl-50">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h4 class="card-title mb-0">Complaint ID # {{ $complaint->complaint_uuid }}

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
                                            <select class="js-example-basic-single col-sm-12" disabled>
                                                @foreach ($categories as $category)
                                                    <optgroup label="{{ $category->main_category }}">
                                                        @foreach (DB::table('case_types')->select('id', 'case_name')->where('main_category', $category->main_category)->get() as $case)
                                                            <option value="{{ $case->id }}"
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
                                <h4 class="card-title mb-0 text-center">Customer Feedback </h4>
                                <div class="card-options"><a class="card-options-collapse" href="#"
                                        data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                        class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                            class="fe fe-x"></i></a></div>
                            </div>
                            <div class="card-body">
                                <form action="{{ url('complaints/' . $complaint->id . '/update') }}" method="POST"
                                    enctype="multipart/form-data" id="form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <div class="text-center">
                                            <div class="rating-css">
                                                <div class="star-icon">
                                                    <input type="radio" value="1" name="product_rating"
                                                        checked id="rating1" class="product_rating">
                                                    <label for="rating1" class="fa fa-star"></label>
                                                    <input type="radio" value="2" name="product_rating"
                                                        id="rating2" class="product_rating">
                                                    <label for="rating2" class="fa fa-star"></label>
                                                    <input type="radio" value="3" name="product_rating"
                                                        id="rating3" class="product_rating">
                                                    <label for="rating3" class="fa fa-star"></label>
                                                    <input type="radio" value="4" name="product_rating"
                                                        id="rating4" class="product_rating">
                                                    <label for="rating4" class="fa fa-star"></label>
                                                    <input type="radio" value="5" name="product_rating"
                                                        id="rating5" class="product_rating">
                                                    <label for="rating5" class="fa fa-star"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-muted">မှတ်ချက်</label>
                                            <textarea class="form-control feedback-message" rows="4" placeholder="မှတ်ချက်ရေးရန်"></textarea>
                                        </div>
                                        <input type="hidden" name="case_status" id="case_status" value="review">
                                        <input type="hidden" name="handled-person" id="handled-person"
                                            value="{{ $complaint->handle_by }}">
                                        <input type="hidden" name="rating" id="rating" value="">

                                        <div class="form-footer">
                                            @if ($complaint->status_name == 'completed')
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
                                                    @if ($log->status_name == 'completed')
                                                        <tr>
                                                            <td>
                                                                <div class="media">
                                                                    <div class="square-box me-2"><img
                                                                            class="img-fluid b-r-5"
                                                                            src="https://admin.pixelstrap.com/zeta/assets/images/avtar/chinese.png"
                                                                            alt=""></div>
                                                                    <div class="media-body"><a
                                                                            href="user-profile.html">
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
                                @else
                                    @endif
                                    @endforeach
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-md-6">
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
                                                                        class="badge badge-light-theme-light font-theme-light pull-right">2024-10-03
                                                                        09:51:57</span></h5>
                                                            </a>
                                                            <p class="mt-2">Hnin Hnin reviews <span
                                                                    class="font-primary">★★★★☆</span> for complaint.
                                                            </p>
                                                            <div class="activity-msg bg-light-success"> <span
                                                                    class="activity-msg-box">
                                                                    အဆင်ပြေအောင်
                                                                    ဆောင်ရွက်ပေးတဲ့အတွက်ကျေးဇူးတင်ပါတယ်</span></div>
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
                    </div> --}}
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
    <script src="{{ asset('assets/js/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <!-- Sidebar jquery-->
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
    <script src="{{ asset('assets/js/knob.min.js') }}"></script>
    <script src="{{ asset('assets/js/knob-chart.js') }}"></script>
    <script src="{{ asset('assets/js/apex-chart.js') }}"></script>
    <script src="{{ asset('assets/js/stock-prices.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/default.js') }}"></script>
    <script src="{{ asset('assets/js/index.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker.en.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker.custom.js') }}"></script>
    <script src="{{ asset('assets/js/photoswipe.min.js') }}"></script>
    <script src="{{ asset('assets/js/photoswipe-ui-default.min.js') }}"></script>
    <script src="{{ asset('assets/js/photoswipe.js') }}"></script>
    <script src="{{ asset('assets/js/handlebars.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead.custom.js') }}"></script>
    <script src="{{ asset('assets/js/handlebars.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead-custom.js') }}"></script>
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
                let name = $("#case_status").val();
                var handled_by = $("#handled-person").val();
                var complaint_id = $("#complaint_id").val();
                var rating = $("#rating").val();
                console.log(rating);
                var form = this;
                var _token = $("#_token").val();
                var feedback_message = $(".feedback-message").val();
                //let _token = $('meta[name="csrf-token"]').attr('content');
                formData.append('case_status', name);
                formData.append('handled_by', handled_by);
                formData.append('complaint_id', complaint_id);
                formData.append('feedback_message', feedback_message);
                formData.append('rating', rating);
                formData.append('_token', _token);
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
                        })
                    },
                    error: (response) => {
                        console.log(response);
                    }
                });
            });
            $('input[name="product_rating"]').on('click', function() {
                var selectedRating = $(this).val();
                $("#rating").val(selectedRating)
            });
        });
    </script>
</body>

</html>
