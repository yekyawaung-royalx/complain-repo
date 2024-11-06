<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/customer/style.css') }}">
    <link href="{{ asset('assets/css/select2.css') }}" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"> --}}
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <title>Customer</title>
</head>

<body>

    <div class="container">
        <div class="spii">
            <div id="loading-indicator">
                <div class="lds-hourglass"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <img src="{{ asset('assets/images/bg-breadcrumb.jpeg') }}" alt="header-image" class="cld-responsive">
            </div>
            <div class="col-lg-3"></div>
        </div>
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6 wrappere">
                {{-- <img src="{{ asset('assets/images/bg-breadcrumb.jpeg') }}" alt="header-image" class="cld-responsive"> --}}
                <div class="wrappers">
                    <div class="sidHead">
                        <div class="side">
                            <input type="radio" name="nav" id="one" checked="checked">
                            <label for="one" class="camara" id="sideTab">Customer Form</label>
                            <input type="radio" name="nav" id="two">
                            <label for="two" class="senado" id="sideTab">Internal Form</label>
                            <input type="radio" name="nav" id="tree">
                            <label for="tree" class="tracking" id="sideTab">Tracking</label>
                        </div>
                    </div>
                    <form action="{{ url('customer-submit') }}" class="content-one customer-submit" id="oneSide"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row wrapper">
                            <div class="col-lg-6 input_field">
                                <label for="">တိုင်ကြား /
                                    အကြံပြုသူအမည်<strong>*</strong></label>
                                <input type="text" class="form-control mb-3" placeholder="Mg Mg"
                                    name="complainant_name" id="complainant_name">
                                <p id="name-validate"></p>
                            </div>
                            <div class="col-lg-6 input_field">
                                <label for="">ဆက်သွယ်ရန်ဖုန်းနံပါတ်<strong>*</strong></label>
                                <input type="text" class="form-control mb-3" placeholder="09xxxxxxxxx"
                                    name="complainant_phone" id="complainant_phone">
                            </div>
                            <div class="col-lg-6 input_field">
                                <label for="">ဘောင်ချာနံပါတ်(Waybill) </label>
                                <input type="text" class="form-control mb-3" placeholder="YGNxxxxxxYGN"
                                    name="waybill_no" id="waybill_no">
                            </div>
                            <div class="col-lg-6 input_field">
                                <label for="">ဖြစ်စဉ်ဖြစ်ပွားသည့်နေ့စွဲ</label>
                                <input type="date" class="form-control mb-3" name="complainant_date"
                                    id="complainant_date">
                            </div>
                            <div class="form-group">
                                <label for="">တိုင်ကြားချက်အမျိုးအစား-
                                    (တိုင်ကြားချင်သည့်သက်ဆိုင်မှု
                                    တစ်ခုကိုသာရွေးချယ်ပါ)<strong>*</strong></label>
                            </div>
                            <div class="col-lg-6">
                                <select name="main_category" id="main_category" class="js-select2">
                                    {{-- <option value="">Select Case Type</option> --}}
                                    @foreach ($case as $type)
                                        <option value="{{ $type->main_category }}">{{ $type->main_category }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <select name="case_type" id="case_type" class="js-select2">

                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label for="">တိုင်ကြားချက်အသေးစိတ်</label>
                                <textarea name="detail_complainant" id="detail_complainant" rows="5" class="form-control"></textarea>
                            </div>
                            <div class="col-lg-12">
                                <label for="">တိုင်ကြားသူအကြံပြုချက်</label>
                                <textarea name="complainant_reco" id="complainant_reco" rows="5" class="form-control"></textarea>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label for="formFileLg" class="form-label">Image Upload File</label>
                                    <input class="form-control form-control-lg" id="image" type="file"
                                        name="image">
                                </div>
                                <p><strong>* is required</strong></p>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group p-1">
                                    <button class="btn btn-danger" id="customer-submit"
                                        type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form action="{{ url('employee-submit') }}" class="content-one employee-submit" id="oneSide"
                        enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="row wrapper">
                            <div class="col-lg-4 input_field re-hide">
                                <label for="">ဝန်ထမ်းကဒ်/အိုင်ဒီနံပါတ်</label>
                                <input type="text" class="form-control mb-3" placeholder="" value=""
                                    id="employee_rex" name="employee_rex">
                            </div>
                            <div class="col-lg-4 re-hide">
                                <div class="form-group">
                                    <label for="">တိုင်ကြားမှုအရင်းမြစ်<strong>*</strong></label>
                                </div>
                                <select name="redir_message" id="redir_message" class="js-select2"
                                    style="width:100%">
                                    <option value="web">Walk In</option>
                                    <option value="messenger">Messenger</option>
                                    <option value="viber">Viber</option>
                                    <option value="phone Call">Phone Call</option>
                                </select>
                            </div>
                            <div class="col-lg-4 re-hide">
                                <div class="form-group">
                                    <label for="">ရုံးခွဲ<strong>*</strong></label>
                                </div>
                                <select name="branches" id="branches" class="js-select2" style="width:100%">
                                    {{-- <option>Select Branches</option> --}}
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->branch }}">{{ $branch->branch }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 input_field re-hide">
                                <label for="">တိုင်ကြား /
                                    အကြံပြုသူအမည်<strong>*</strong></label>
                                <input type="text" class="form-control mb-3" placeholder="Mg Mg"
                                    id="e_complainant_name" name="e_complainant_name">
                            </div>
                            <div class="col-lg-6 input_field re-hide">
                                <label for="">ဆက်သွယ်ရန်ဖုန်းနံပါတ်<strong>*</strong></label>
                                <input type="text" class="form-control mb-3" placeholder="09xxxxxxxxx"
                                    id="e_complainant_phone" name="e_complainant_phone">
                            </div>
                            <div class="col-lg-6 input_field re-hide">
                                <label for="">ဘောင်ချာနံပါတ်(Waybill) </label>
                                <input type="text" class="form-control mb-3" placeholder="YGNxxxxxxxYGN"
                                    id="waybill_no" name="waybill_no">
                            </div>
                            <div class="col-lg-6 input_field re-hide">
                                <label for="">ဖြစ်စဉ်ဖြစ်ပွားသည့်နေ့စွဲ</label>
                                <input type="date" class="form-control mb-3" name="complainant_date"
                                    id="complainant_date">
                            </div>
                            <div class="form-group re-hide">
                                <label for="">တိုင်ကြားချက်အမျိုးအစား-
                                    (တိုင်ကြားချင်သည့်သက်ဆိုင်မှု
                                    တစ်ခုကိုသာရွေးချယ်ပါ)<strong>*</strong></label>
                            </div>
                            <div class="col-lg-6 re-hide">
                                <select name="e_main_category" id="e_main_category" class="js-select2"
                                    style="width:100%">
                                    {{-- <option value="">Select Case Type</option> --}}
                                    @foreach ($case as $type)
                                        <option value="{{ $type->main_category }}">{{ $type->main_category }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 re-hide">
                                <select name="e_case_type" id="e_case_type" class="js-select2" style="width:100%">

                                </select>
                            </div>
                            <div class="col-lg-12 re-hide">
                                <label for="">တိုင်ကြားချက်အသေးစိတ်</label>
                                <textarea name="detail_complainant" id="detail_complainant" rows="5" class="form-control"></textarea>
                            </div>
                            <div class="col-lg-12 re-hide">
                                <label for="">တိုင်ကြားသူအကြံပြုချက်</label>
                                <textarea name="complainant_reco" id="complainant_reco" rows="5" class="form-control"></textarea>
                            </div>
                            <div class="col-lg-12 re-hide">
                                <div>
                                    <label for="formFileLg" class="form-label">Image Upload File</label>
                                    <input class="form-control form-control-lg" id="image" type="file"
                                        name="image">
                                </div>

                            </div>
                            <div class="mb-3">
                                <div class="g-recaptcha" data-sitekey="6LfLgnYqAAAAABbjSDHdYP9eUCD84AHkjSAjGqdk">
                                </div>
                            </div>
                            <p><strong>* is required</strong></p>
                            <div class="col-lg-3 re-hide">
                                <div class="form-group p-1">
                                    <button class="btn btn-danger" type="submit"
                                        id="employee-submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="col-lg-3"></div>
        </div>
    </div>
    <!--modal!-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h5 class="modal-title" id="exampleModalLabel"><label></label></h5> --}}
                    <label>Your Code Number</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control mb-3 rexInput" placeholder="" id="rex-no">
                    <p class="alert-error"></p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" id="">
                    <h5 class="modal-title" id="uid"></h5>
                    <h5 class="modal-title" id="diu"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="msg"></p>
                    <p id="mgs"></p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" id=>
                    {{-- <h5 class="modal-title" id="exampleModalLabel"><label></label></h5> --}}
                    <label for="">Your Complaint Tracking Number</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="drop">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('customer-tracking') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body" id="">
                        <input type="text" class="form-control mb-3 rexInput" placeholder="" id="tracking"
                            name="tracking">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end modal!-->
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="{{ asset('assets/js/customer/bootstrap-bulder-main.js') }}"></script>
    <script src="{{ asset('assets/js/customer/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/customer/jquery-min.js') }}"></script>
    <script src="{{ asset('assets/js/customer/main.js') }}"></script>
    <script src="{{ asset('assets/js/customer/select2.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
    <script type="text/javascript">
        var onloadCallback = function() {
            // alert("grecaptcha is ready!");
        };
    </script>
</body>

</html>
