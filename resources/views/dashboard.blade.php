@extends('layouts.app1')
@section('content')
    <style>
        .float-right {
            display: flex;
            float: right;
            margin: 10px;
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
                            <li class="breadcrumb-item"> <a class="home-item" href="index.html"><i
                                        data-feather="home"></i></a>
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
                <div class="col-lg-4">
                    <div class="card o-hidden">
                        <div class="card-body">
                            <div class="media static-widget">
                                @if ($complaints->isNotEmpty())
                                    @foreach ($complaints->groupBy('main_group') as $mainGroup => $groupComplaints)
                                        @if ($mainGroup == 'Loss & Damage Types')
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">{{ $mainGroup }}</th>
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
                <div class="col-lg-4">
                    <div class="card o-hidden">
                        <div class="card-body">
                            <div class="media static-widget">
                                @if ($complaints->isNotEmpty())
                                    @foreach ($complaints->groupBy('main_group') as $mainGroup => $groupComplaints)
                                        @if ($mainGroup == 'Service Complaint Types')
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">{{ $mainGroup }}</th>
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
                <div class="col-lg-4">
                    <div class="card o-hidden">
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
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-md-8 dash-35 dash-xl-60">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h4 class="card-title mb-0">Complaint
                                    {{-- <span class="badge badge-secondary inline-block pull-right" cursorshover="true">
                                        <span cursorshover="true"></span>
                                    </span> --}}
                                </h4>
                                {{-- <div class="card-options"><a class="card-options-collapse" href="#"
                                        data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                        class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                            class="fe fe-x"></i></a></div> --}}
                            </div>
                            <div class="card-body">
                                <div class="mb-3" style="width:100%;margin:auto">
                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xl-4 col-lg-4">
                        <div class="card o-hidden">
                            <div class="card" style="width:100%;">
                                <div class="card-header">
                                    <h4>Featured</h4>
                                </div>
                                <div class="" style="width:300px;margin:auto">
                                    <canvas id="myPie"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
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
