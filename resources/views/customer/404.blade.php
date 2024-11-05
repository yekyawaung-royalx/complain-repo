<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <style type="text/css">
        .h-100 {
            min-height: 600px;
        }

        .footer {
            width: 100% !important;
            margin-left: 0px !important;
        }
    </style>
</head>

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

                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid starts-->
            <div class="container-fluid default-dash">
                <div class="row">
                    <div class="dash-35 dash-xl-100 h-100">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h4 class="card-title mb-0">Complaint ID # {{ $tracking }}

                                </h4>
                                <div class="card-options"><a class="card-options-collapse" href="#"
                                        data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                        class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                            class="fe fe-x"></i></a></div>
                            </div>
                            <div class="card-body">

                                <div class="alert alert-warning outline" role="alert">
                                    <p class="h6">Sorry, we could not found complaint.</p>
                                </div>

                            </div>
                        </div>


                    </div>



                </div>


            </div>
        </div>
        <!-- Container-fluid Ends-->

        <!-- footer start-->
        <footer class="footer footer-fix">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 footer-copyright text-center">
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
    <!-- login js-->
    <!-- Plugin used-->
    <script type="text/javascript">
        $(document).ready(function() {
            var url = $("#url").val();


            $('#save').on("click", function search(e) {
                var handled_by = $(".handled-person").val();
                var case_status = $(".case-status").val();
                var operation_person = $(".operation-person :selected").text();
                var operation_id = $(".operation-person").val();
                var branch = $(".branch").val();
                var source = $(".source").val();
                var amount = $(".amount").val();
                var complaint_id = $("#complaint_id").val();
                var message = $(".internal-message").val();

                var _token = $("#_token").val();

                alert(operation_id);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'post',
                    url: url + '/complaints/' + complaint_id + '/update',
                    dataType: 'json',
                    data: {
                        'handled_by': handled_by,
                        'case_status': case_status,
                        'operation_person': operation_person,
                        'operation_id': operation_id,
                        'branch': branch,
                        'source': source,
                        'amount': amount,
                        'message': message,
                        '_token': _token,
                    },
                    success: function(data) {
                        $('#branch').empty();
                        $.each(data, function(i, item) {
                            $('#branch').append('<option value="' + item['id'] + '" >' +
                                item['name'] + '</option>');
                        });

                        $('#branch option[value="' + current_branch + '"]').attr("selected",
                            "selected");
                    },
                });
            });

        });
    </script>
</body>

</html>
