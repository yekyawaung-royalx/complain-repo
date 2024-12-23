@extends('layouts.app1')
@section('content')
    <style>
        .float-right {
            display: flex;
            float: right;
            margin: 10px;
        }

        .dash-card {
            height: 90%;
        }

        .session-by-channel-legend ul li {
            list-style-type: none;
            color: #9c9fa6;
            font-size: .75rem;
        }

        .session-by-channel-legend li {
            margin-top: 1rem;

        }

        .session-by-channel-legend {
            padding-left: 22px;
            /* margin-top: 5rem; */
            margin-bottom: 0;
        }

        .legend-dots {
            width: 1rem;
            height: 1rem;
            border-radius: 100%;
            display: inline-block;
            vertical-align: text-bottom;
            margin-right: .5rem;
        }

        .ps-x1 {
            padding-left: 1.25rem;
        }

        .py-1 {
            padding-top: 0.25rem !important;
            padding-bottom: 0.25rem;
        }

        .avatar-xl {
            height: 2rem;
            width: 2rem;
        }

        .avatar {
            position: relative;
            display: inline-block;
        }

        .avatar .avatar-name {
            background-color: var(--falcon-avatar-name-bg);
            position: absolute;
            text-align: center;
            color: #fff;
            font-weight: bold;
            text-transform: uppercase;
            display: block;
            width: 100%;
            height: 100%;
        }

        .avatar .avatar-name>span {
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate3d(-50%, -50%, 0);
            transform: translate3d(-50%, -50%, 0);
        }

        .py-1 {
            padding-top: 0.25rem !important;
            padding-bottom: 0.25rem !important;
        }

        .pe-x1 {
            padding-right: 1.25rem;
        }

        .flex-end-center {
            -webkit-box-pack: end;
            -ms-flex-pack: end;
            justify-content: flex-end;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
        }

        .stretched-link {
            color: black;
        }
    </style>
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center justify-content-md-start">
                            <div class="mb-3 mb-xl-0 pr-1">
                                <form action="{{ url('/dashboard') }}" method="POST" enctype="multipart/form-data"
                                    id="form-submit">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted">Start Date</label>
                                            <input class="form-control year-filter" type="date" data-language="en"
                                                min="2024" name="date_from" value="{{ $start_date }}" id="date_from">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted">End Date</label>
                                            <input class="form-control year-filter" type="date" data-language="en"
                                                min="2024" name="date_to" value="{{ $end_date }}" id="date_to">
                                        </div>

                                    </div>
                                </form>
                            </div>
                            <div class="pr-1 mb-3 mr-2 mb-xl-0">
                                <form action="{{ url('/export-complaints') }}" method="GET" enctype="multipart/form-data">
                                    @csrf
                                    <div class="">
                                        <input class="form-control year-filter" type="hidden" data-language="en"
                                            min="2024" name="date_from" value="{{ $start_date }}" id="date_from">
                                        <input class="form-control year-filter" type="hidden" data-language="en"
                                            min="2024" name="date_to" value="{{ $end_date }}" id="date_to">
                                        <button type="submit" class="btn btn-outline-primary float-right">Export<svg
                                                fill="#000000" width="20px" height="20px" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M8.71,7.71,11,5.41V15a1,1,0,0,0,2,0V5.41l2.29,2.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42l-4-4a1,1,0,0,0-.33-.21,1,1,0,0,0-.76,0,1,1,0,0,0-.33.21l-4,4A1,1,0,1,0,8.71,7.71ZM21,14a1,1,0,0,0-1,1v4a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V15a1,1,0,0,0-2,0v4a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V15A1,1,0,0,0,21,14Z" />
                                            </svg></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"> <a class="home-item"><i data-feather="home"></i></a>
                            </li>
                            <li class="breadcrumb-item"> Dashboard</li>
                            <li class="breadcrumb-item active"> Default</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid default-dash">
            <div class="row">
                <div class="col-lg-3">
                    <div class="card o-hidden dash-card">
                        <div class="card-header pb-0">
                            <h4 class="card-title mb-0">
                                Loss & Damage Types</h4>
                        </div>
                        <div class="card-body">
                            <div class="media static-widget">
                                @if ($complaints->isNotEmpty())
                                    @foreach ($complaints->groupBy('main_group') as $mainGroup => $groupComplaints)
                                        @if ($mainGroup == 'Loss & Damage Types')
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Qty</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($groupComplaints as $index => $complaint)
                                                        <tr>
                                                            <td>{{ $complaint->case_type_name }}</td>
                                                            <td>{{ $complaint->num }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            @if ($mainGroup !== 'Service Complaint Types')
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Other</th>
                                                            <th scope="col">Qty</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>No data available</td>
                                                            <td>0</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            @endif
                                        @endif
                                    @endforeach
                                @else
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Loss & Damage Types</th>
                                                <th scope="col">Qty</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>No data available</td>
                                                <td>0</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card o-hidden dash-card">
                        <div class="card-header pb-0">
                            <h4 class="card-title mb-0">
                                Service Complaint Types</h4>
                        </div>
                        <div class="card-body">
                            <div class="media static-widget">
                                @if ($complaints->isNotEmpty())
                                    @foreach ($complaints->groupBy('main_group') as $mainGroup => $groupComplaints)
                                        @if ($mainGroup == 'Service Complaint Types')
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Qty</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($groupComplaints as $index => $complaint)
                                                        <tr>
                                                            <td>{{ $complaint->case_type_name }}</td>
                                                            <td>{{ $complaint->num }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            @if ($mainGroup !== 'Loss & Damage Types')
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Other</th>
                                                            <th scope="col">Qty</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>No data available</td>
                                                            <td>0</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            @endif
                                        @endif
                                    @endforeach
                                @else
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Service Complaint Types</th>
                                                <th scope="col">Qty</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>No data available</td>
                                                <td>0</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card o-hidden dash-card">
                        <div class="card-header pb-0">
                            <h4 class="card-title mb-0">
                                Refund Amount Status</h4>
                        </div>
                        <div class="card-body">
                            <div class="media static-widget">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Branch</th>
                                            <th scope="col">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>YGN Branch</td>
                                            <td>{{ $ygnBranchTotal }}</td>
                                        </tr>
                                        <tr>
                                            <td>ROP Branch</td>
                                            <td>{{ $RopTotal }}</td>
                                        </tr>
                                        <tr>
                                            <td>Other Branch</td>
                                            <td>{{ $otherBranchTotal }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card o-hidden dash-card">
                        <div class="card-header pb-0">
                            <h4 class="card-title mb-0">
                                Complaint Status</h4>
                        </div>
                        <div class="card-body">
                            <div class="media static-widget">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Status</th>
                                            <th scope="col">Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><a class="text-800 stretched-link"
                                                    href="{{ url('complaints/status/pending') }}">Pending</a></td>
                                            <td>{{ $pending }}</td>
                                        </tr>
                                        <tr>
                                            <td><a class="text-800 stretched-link"
                                                    href="{{ url('complaints/status/follow-up') }}">Handled</a></td>
                                            <td>{{ $follow }}</td>
                                        </tr>
                                        <tr>
                                            <td><a class="text-800 stretched-link"
                                                    href="{{ url('complaints/status/assigned') }}">Assigned</a></td>
                                            <td>{{ $assigned }}</td>
                                        </tr>
                                        <tr>
                                            <td><a class="text-800 stretched-link"
                                                    href="{{ url('complaints/status/progress') }}">Progress</a></td>
                                            <td>{{ $progress }}</td>
                                        </tr>
                                        <tr>
                                            <td><a class="text-800 stretched-link"
                                                    href="{{ url('complaints/status/completed') }}">Completed</a></td>
                                            <td>{{ $completed }}</td>
                                        </tr>
                                        <tr>
                                            <td><a class="text-800 stretched-link"
                                                    href="{{ url('complaints/status/rejected') }}">Rejected</a></td>
                                            <td>{{ $rejected }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card o-hidden dash-card">
                        <div class="card-header pb-0">
                            <h4 class="card-title mb-0">
                                Loss & Damage Types(Chart)</h4>
                        </div>
                        <div class="card-body">
                            <div class="media static-widget">
                                <div class="mb-3" style="width:100%;margin:auto">
                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card o-hidden dash-card">
                        <div class="card-header pb-0">
                            <h4 class="card-title mb-0">
                                Refund Amount(Pie)</h4>
                        </div>
                        <div class="card-body">
                            <div class="media static-widget">
                                <div class="" style="width:300px;margin:auto">
                                    <canvas id="myPie"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>
    </div>
@endsection
<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
    $(document).ready(function() {
        const ctx = document.getElementById('myChart').getContext('2d');

        const myChart = new Chart(ctx, {
            // chart config
            type: 'bar',
            data: {
                labels: {!! json_encode($label) !!},
                datasets: {!! json_encode($datasetsIn) !!}
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: "#8b8a96",
                            font: {
                                size: 12,
                                weight: 20,
                            },
                        },
                    },
                },
                layout: {
                    padding: {
                        bottom: 10,
                    },
                },
            },
        });
        var cty = document.getElementById("myPie").getContext('2d');
        var myPie = new Chart(cty, {
            type: 'pie',
            data: {!! json_encode($chartData) !!},

            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: "#8b8a96",
                            font: {
                                size: 10,
                                weight: 600,
                            },
                        },
                    },
                },
                layout: {
                    padding: {
                        bottom: 10,
                    },
                },
            },
        });

        $('.year-filter').on('change', function() {
            const search_form = $('#form-submit');
            search_form.submit();
            //alert(year)
        })
    });
</script>
