@extends('layouts.app1')
@section('content')
    <style>
        .deleted_at {
            display: none;
        }

        .page-wrapper .page-body-wrapper .page-title .breadcrumb {
            justify-content: flex-start;
        }

        .checkbox-dropdown {
            width: 200px;
            border: 1px solid #aaa;
            padding: 10px;
            position: relative;
            /* margin: 0 auto; */

            user-select: none;
        }

        /* Display CSS arrow to the right of the dropdown text */
        .checkbox-dropdown:after {
            content: '';
            height: 0;
            position: absolute;
            width: 0;
            border: 6px solid transparent;
            border-top-color: #000;
            top: 50%;
            right: 10px;
            margin-top: -3px;
        }

        /* Reverse the CSS arrow when the dropdown is active */
        .checkbox-dropdown.is-active:after {
            border-bottom-color: #000;
            border-top-color: #fff;
            margin-top: -9px;
        }

        .checkbox-dropdown-list {
            list-style: none;
            margin: 0;
            padding: 0;
            position: absolute;
            top: 100%;
            /* align the dropdown right below the dropdown text */
            border: inherit;
            border-top: none;
            left: -1px;
            /* align the dropdown to the left */
            right: -1px;
            /* align the dropdown to the right */
            opacity: 0;
            /* hide the dropdown */

            transition: opacity 0.4s ease-in-out;
            height: 100px;
            overflow: scroll;
            overflow-x: hidden;
            pointer-events: none;
            background-color: #fff;
            /* avoid mouse click events inside the dropdown */
        }

        .is-active .checkbox-dropdown-list {
            opacity: 1;
            /* display the dropdown */
            pointer-events: auto;
            /* make sure that the user still can select checkboxes */
        }

        .checkbox-dropdown-list li label {
            display: block;
            border-bottom: 1px solid silver;
            padding: 10px;

            transition: all 0.2s ease-out;
        }

        .checkbox-dropdown-list li label:hover {
            background-color: #555;
            color: white;
        }
    </style>
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"> <a class="home-item">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active"> Complaints</li>
                        </ol>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="mb-1 breadcrumb-right" style="text-align: end">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button"
                                    class="btn btn-primary waves-effect waves-float waves-light pagination-btn"
                                    id="prev-btn"><i data-feather='skip-back'></i></button>
                                <button type="button"
                                    class="btn btn-primary waves-effect waves-float waves-light pagination-btn"
                                    id="next-btn"><i data-feather='skip-forward'></i></button>
                                <button type="button"
                                    class="btn btn-outline-primary waves-effect waves-float waves-light">Records: <span
                                        id="to-records">0</span> of <span id="total-records">0</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid default-dash">
            <div class="row">
                <div class="col-12">
                    <div class="card ongoing-project">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="checkbox-dropdown">
                                        Complaint Type
                                        <ul class="checkbox-dropdown-list">
                                            <li>
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    <input class="form-check-input service" type="radio"
                                                        name="flexRadioDefault" id="flexRadioDefault1"
                                                        value="service">Service
                                                    Complaint</label>
                                            </li>
                                            <li>
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                    <input class="form-check-input service" type="radio"
                                                        name="flexRadioDefault" id="flexRadioDefault2" value="loss">Loss
                                                    &
                                                    Damage</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive custom-scrollbar">
                                <table class="table table-bordernone">
                                    <thead>
                                        <tr>
                                            <th><span>Complaint Id</span></th>
                                            <th><span>Customer</span></th>
                                            <th><span>Complaint Type</span></th>
                                            <th><span>Status</span></th>
                                            <th><span>Action</span></th>
                                        </tr>
                                    </thead>
                                    <tbody id="fetched-data">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
    <!-- footer start-->
    <input type="hidden" name="" id="url" value="{{ url('') }}">
    <input type="hidden" name="" id="json" value="complaints/all-json/pending">
    <input type="hidden" name="" id="connection" value="{{ permission() }}">
    <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
    <!-- Bootstrap js-->
    <script>
        $(document).ready(function() {
            var url = $("#url").val();
            var json = $("#json").val();
            var connection = $("#connection").val();
            //declared first loaded json data
            var load_json = url + '/' + json;
            var _token = $("#_token").val();
            var fetched_data = function() {
                //  console.log(load_json);
                $.ajax({
                    url: load_json,
                    type: 'GET',
                    data: {},
                    success: function(data) {
                        if (data.total > 0) {
                            $.each(data.data, function(key, value) {
                                $("#fetched-data").append('<tr>' +
                                    '<td>' +
                                    '<h6>' + value.complaint_uuid + '</h6><span>' +
                                    value.created_at + '</span>' +
                                    '</td>' +
                                    '<td class="img-content-box">' +
                                    '<div class="media">' +
                                    '<div class="square-box me-2"><img class="img-fluid b-r-5" src="https://admin.pixelstrap.com/zeta/assets/images/avtar/chinese.png" alt=""></div>' +
                                    '<div class="media-body ps-2">' +
                                    '<div class="avatar-details"><a>' +
                                    '<span>' + value.customer_name + '</span></a><br>' +
                                    '<span>' + value.customer_mobile + '</span></div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</td>' +
                                    '<td>' +
                                    '' + value.case_type_name +
                                    '<br>' + value.main_category + '' +
                                    '</td>' +
                                    '<td>' +
                                    '<div class="badge badge-light-primary">' + value
                                    .status_name + '</div>' +
                                    '</td>' +
                                    '<td>' +
                                    '<a  href="' + url + '/complaints/' + value.id +
                                    '/view"  class="btn btn-success btn-sm px-2 me-1" ><i class="icon-eye fs-16" cursorshover="true"></i></a>' +
                                    '<a  href="' + url + '/complaints/' + value.id +
                                    '/edit"  class="btn btn-primary btn-sm px-2 me-1" ><i class="icon-pencil fs-16" cursorshover="true"></i></a>' +
                                    '<button class="btn btn-danger btn-sm px-2 deleted_at" value="' +
                                    value.id +
                                    '" type="button" data-bs-original-title="" title="" data-original-title="btn btn-primary-gradien"><i class="icon-trash fs-16" cursorshover="true"></i></button>' +
                                    '</td></tr>'
                                );
                            });
                            // Hide delete buttons if connection is set
                            if (connection == 'Developer') {
                                $(".deleted_at").show();
                            }
                            $(".data-loading").hide();

                            $("#to-records").text(data.to);
                            $("#total-records").text(data.total);

                            if (data.prev_page_url === null) {
                                $("#prev-btn").attr('disabled', true);
                            } else {
                                $("#prev-btn").attr('disabled', false);
                            }
                            if (data.next_page_url === null) {
                                $("#next-btn").attr('disabled', true);
                            } else {
                                $("#next-btn").attr('disabled', false);
                            }
                            $("#prev-btn").val(data.prev_page_url);
                            $("#next-btn").val(data.next_page_url);
                        } else {
                            $(".show-alert").show();
                            $(".pagination").hide();
                            $(".data-loading").hide();
                        }
                    }
                });
            };

            fetched_data();
            $('.pagination-btn').click(function() {
                //clicked url json data
                $(".data-loading").show();
                $("#fetched-data").empty();
                var clicked_url = $(this).val();

                $(this).siblings().removeClass('active')
                $(this).addClass('active');
                $.ajax({
                    url: clicked_url,
                    type: 'GET',
                    data: {},
                    success: function(data) {
                        $.each(data.data, function(key, value) {
                            $("#fetched-data").append('<tr>' +
                                '<td>' +
                                '<h6>' + value.complaint_uuid + '</h6><span>' +
                                value.created_at + '</span>' +
                                '</td>' +
                                '<td class="img-content-box">' +
                                '<div class="media">' +
                                '<div class="square-box me-2"><img class="img-fluid b-r-5" src="https://admin.pixelstrap.com/zeta/assets/images/avtar/chinese.png" alt=""></div>' +
                                '<div class="media-body ps-2">' +
                                '<div class="avatar-details"><a>' +
                                '<span>' + value.customer_name + '</span></a><br>' +
                                '<span>' + value.customer_mobile + '</span></div>' +
                                '</div>' +
                                '</div>' +
                                '</td>' +
                                '<td>' +
                                '' + value.case_type_name +
                                '<br>Service Complaint Types' +
                                '</td>' +
                                '<td>' +
                                '<div class="badge badge-light-primary">' + value
                                .status_name + '</div>' +
                                '</td>' +
                                '<td>' +
                                '<a  href="' + url + '/complaints/' + value.id +
                                '/view"  class="btn btn-success btn-sm px-2 me-1" ><i class="icon-eye fs-16" cursorshover="true"></i></a>' +
                                '<a  href="' + url + '/complaints/' + value.id +
                                '/edit"  class="btn btn-primary btn-sm px-2 me-1" ><i class="icon-pencil fs-16" cursorshover="true"></i></a>' +
                                '<button class="btn btn-danger btn-sm px-2 deleted_at" value="' +
                                value.id +
                                '" type="button" data-bs-original-title="" title="" data-original-title="btn btn-primary-gradien"><i class="icon-trash fs-16" cursorshover="true"></i></button>' +
                                '</td></tr>'
                            );
                        });
                        $(".data-loading").hide();


                        $("#to-records").text(data.to);
                        if (data.prev_page_url === null) {
                            $("#prev-btn").attr('disabled', true);
                        } else {
                            $("#prev-btn").attr('disabled', false);
                        }
                        if (data.next_page_url === null) {
                            $("#next-btn").attr('disabled', true);
                        } else {
                            $("#next-btn").attr('disabled', false);
                        }
                        $("#prev-btn").val(data.prev_page_url);
                        $("#next-btn").val(data.next_page_url);
                    }
                });
            });

            //delete //
            $(document).on('click', '.deleted_at', function() {
                var id = $(this).val();
                //var waybill_no = $(this).attr('waybill_no');
                var url = $("#url").val();
                var _token = $("#_token").val();
                //alert(url)
                $.ajax({
                    method: "delete",
                    url: url + '/delete/' + id, // Correct concatenation for URL
                    data: {
                        id: id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        if (data.status == '1') {

                        }
                    }
                })
            })
            $(".checkbox-dropdown").click(function() {
                $(this).toggleClass("is-active");
            });

            $(".checkbox-dropdown ul").click(function(e) {
                e.stopPropagation();
            });

            //filter search//
            $(".service").on('change', function() {
                var value = $(this).prop("checked") ? 'true' : 'false';
                var value = $(this).val();
                var url = $("#url").val();
                var _token = $("#_token").val();
                $.ajax({
                    method: "GET",
                    url: url + '/filter',
                    data: {
                        "service": value,
                    },
                    success: function(data) {
                        $("#fetched-data").empty();
                        if (data.total > 0) {
                            $.each(data.data, function(key, value) {
                                $("#fetched-data").append('<tr>' +
                                    '<td>' +
                                    '<h6>' + value.complaint_uuid + '</h6><span>' +
                                    value.created_at + '</span>' +
                                    '</td>' +
                                    '<td class="img-content-box">' +
                                    '<div class="media">' +
                                    '<div class="square-box me-2"><img class="img-fluid b-r-5" src="https://admin.pixelstrap.com/zeta/assets/images/avtar/chinese.png" alt=""></div>' +
                                    '<div class="media-body ps-2">' +
                                    '<div class="avatar-details"><a>' +
                                    '<span>' + value.customer_name +
                                    '</span></a><br>' +
                                    '<span>' + value.customer_mobile +
                                    '</span></div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</td>' +
                                    '<td>' +
                                    '' + value.case_type_name +
                                    '<br>' + value.main_category + '' +
                                    '</td>' +
                                    '<td>' +
                                    '<div class="badge badge-light-primary">' +
                                    value
                                    .status_name + '</div>' +
                                    '</td>' +
                                    '<td>' +
                                    '<a  href="' + url + '/complaints/' + value.id +
                                    '/view"  class="btn btn-success btn-sm px-2 me-1" ><i class="icon-eye fs-16" cursorshover="true"></i></a>' +
                                    '<a  href="' + url + '/complaints/' + value.id +
                                    '/edit"  class="btn btn-primary btn-sm px-2 me-1" ><i class="icon-pencil fs-16" cursorshover="true"></i></a>' +
                                    '<button class="btn btn-danger btn-sm px-2 deleted_at" value="' +
                                    value.id +
                                    '" type="button" data-bs-original-title="" title="" data-original-title="btn btn-primary-gradien"><i class="icon-trash fs-16" cursorshover="true"></i></button>' +
                                    '</td></tr>'
                                );
                            });
                            // Hide delete buttons if connection is set
                            if (connection == 'Developer') {
                                $(".deleted_at").show();
                            }
                            $(".data-loading").hide();

                            $("#to-records").text(data.to);
                            $("#total-records").text(data.total);

                            if (data.prev_page_url === null) {
                                $("#prev-btn").attr('disabled', true);
                            } else {
                                $("#prev-btn").attr('disabled', false);
                            }
                            if (data.next_page_url === null) {
                                $("#next-btn").attr('disabled', true);
                            } else {
                                $("#next-btn").attr('disabled', false);
                            }
                            $("#prev-btn").val(data.prev_page_url);
                            $("#next-btn").val(data.next_page_url);
                        } else {
                            $(".show-alert").show();
                            $(".pagination").hide();
                            $(".data-loading").hide();
                        }
                    }

                })


            })

        });
    </script>
@endsection
