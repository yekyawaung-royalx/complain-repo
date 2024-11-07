@extends('layouts.app1')
@section('content')
    <style>
        .float-right {
            display: flex;
            float: right;
        }
    </style>
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h3>Default</h3>
                    </div>
                    <div class="col-12 col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"> <a class="home-item" href="index.html"><i data-feather="home"></i></a>
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
            <form action="{{ url('/dashboard') }}" method="POST" enctype="multipart/form-data" id="form-submit">
                @csrf
                <div class="row">

                    <div class="col-md-3 mb-3">
                        <label class="form-label text-muted">Start Date</label>
                        <input class="form-control year-filter" type="date" data-language="en" min="2024"
                            name="date_from" value="{{ $start_date }}" id="date_from">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label text-muted">End Date</label>
                        <input class="form-control year-filter" type="date" data-language="en" min="2024"
                            name="date_to" value="{{ $end_date }}" id="date_to">
                    </div>
            </form>
        </div>
        <div class="row">
            @if ($complaints->isNotEmpty())
                @foreach ($complaints->groupBy('main_group') as $mainGroup => $groupComplaints)
                    <div class="col-sm-4 col-xl-4 col-lg-4">
                        <div class="card o-hidden">
                            <div class="card" style="width:100%;">
                                <div class="card-header">
                                    <h4>{{ $mainGroup }}</h4>
                                </div>
                                @foreach ($groupComplaints as $index => $complaint)
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">{{ $complaint->case_type_name }}<strong
                                                class="float-right">{{ $complaint->num }}</strong></li>
                                    </ul>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-sm-4 col-xl-4 col-lg-4">
                    <div class="card o-hidden">
                        <div class="card" style="width:100%;">
                            <div class="card-header">
                                <h4>Loss & Damage Types</h4>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Damage<strong class="float-right">0</strong></li>
                                <li class="list-group-item">Loss<strong class="float-right">0</strong></li>
                                <li class="list-group-item">Reduce<strong class="float-right">0</strong></li>
                                <li class="list-group-item">Pest Control<strong class="float-right">0</strong></li>
                                <li class="list-group-item">Force Majeure<strong class="float-right">0</strong></li>
                                <li class="list-group-item">Illegal Restricted Material<strong
                                        class="float-right">0</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-xl-4 col-lg-4">
                    <div class="card o-hidden">
                        <div class="card" style="width:100%;">
                            <div class="card-header">
                                <h4>Service Complaint Types</h4>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Service Complain<strong class="float-right">0</strong></li>
                                <li class="list-group-item">Delivery Man Complain<strong class="float-right">0</strong></li>
                                <li class="list-group-item">Staff Complain<strong class="float-right">0</strong></li>
                                <li class="list-group-item">Double Charges<strong class="float-right">0</strong></li>
                                <li class="list-group-item">Extra Charges<strong class="float-right">0</strong></li>
                                <li class="list-group-item">Delay Time<strong class="float-right">0</strong></li>
                                <li class="list-group-item">Wrong Transfer City<strong class="float-right">0</strong></li>
                                <li class="list-group-item">Parcel Wrong<strong class="float-right">0</strong></li>
                                <li class="list-group-item">CX Complain<strong class="float-right">0</strong></li>
                                <li class="list-group-item">Not Collect Pick Up Complain<strong
                                        class="float-right">0</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
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
        <div class="container">
            <div class="col-xl-12 col-md-12 dash-35 dash-xl-60">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4 class="card-title mb-0">Complaint
                            <span class="badge badge-secondary inline-block pull-right" cursorshover="true">
                                <span cursorshover="true"></span>
                            </span>
                        </h4>
                        <div class="card-options"><a class="card-options-collapse" href="#"
                                data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                    class="fe fe-x"></i></a></div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3" style="width:100%;margin:auto">
                            <canvas id="myChart"></canvas>
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
            type: 'doughnut',
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
