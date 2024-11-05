@extends('layouts.app1')
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h3>Complaints</h3>
                    </div>
                    <div class="col-12 col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"> <a class="home-item" href="index.html">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active"> Complaints</li>
                        </ol>
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
    <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var url = $("#url").val();
            var json = $("#json").val();

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
                                    '<div class="avatar-details"><a href="product-page.html">' +
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
                                    '<button class="btn btn-danger btn-sm px-2" type="button" data-bs-original-title="" title="" data-original-title="btn btn-primary-gradien"><i class="icon-trash fs-16" cursorshover="true"></i></button>' +
                                    '</td></tr>'
                                );
                            });
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
                            $("#fetched-data").append(
                                '<tr>' +
                                '<td><span class="text-muted">' + value.created_at +
                                '</span></td>' +
                                '<td><span class="waybill-no text-danger">' + value
                                .waybill_no + '</span></td>' +
                                '<td>' + (value.courier == null ? 'Anonymous' :
                                    value.courier) + '</td>' +
                                '<td class="h6 text-primary">' + (value.branch ==
                                    null ? 'Unknown' : value.branch) + '</td>' +
                                '<td>' + outbound_status(value.action_id) +
                                '</td>' +
                                '<td class="h6">' + value.qty + '</td>' +
                                '<td>' + same_day(value.same_day) + '</td>' +
                                '<td><span class="end-point-' + value.id + '">' + (
                                    value.end_point == null ? '---' : value
                                    .end_point) + '</span></td>' +
                                '<td>' +
                                '<a href="' + url + '/waybills/view/' + value
                                .waybill_no +
                                '" class="btn btn-success btn-sm btn-rounded waves-effect waves-light">' +
                                replace_icon('eye') + '</a> ' +
                                '<button class="btn btn-danger btn-sm btn-rounded waves-effect waves-light sync-odoo" data-bs-toggle="modal" data-bs-target="#sync-odoo" value=' +
                                value.waybill_no + ' id="' + value.id + '">' +
                                replace_icon('map-pin') + '</button>' +
                                '</td>' +
                                '</tr>'
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


        });
    </script>
@endsection
