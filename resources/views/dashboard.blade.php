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
            {{-- <div class="row">
                <form action="{{ url('/dashboard') }}" method="POST" enctype="multipart/form-data" id="form-submit">
                    @csrf
                    <div class="col-md-3 mb-3">
                        <label class="form-label text-muted">Filter by Year</label>
                        <input class="form-control year-filter" type="number" data-language="en"
                            value="{{ $year }}" min="2024" name="year">
                    </div>
                </form>
            </div> --}}
            <div class="row">
                @foreach ($complaints->groupBy('main_group') as $mainGroup => $groupComplaints)
                    <div class="col-sm-6 col-xl-4 col-lg-6">
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
                <div class="col-sm-6 col-xl-4 col-lg-6">
                    <div class="card o-hidden">
                        <div class="card" style="width:100%;">
                            <div class="card-header">
                                <h4>Featured</h4>
                            </div>
                            <div>
                                <canvas id="myPie"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-md-12 dash-35 dash-xl-60">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h4 class="card-title mb-0">Monthly Pricing
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
                            <div class="mb-3">
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

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js"></script>
<script>
    $(document).ready(function() {
        const ctx = document.getElementById('myChart').getContext('2d');

        const myChart = new Chart(ctx, {
            // chart config
            type: 'bar',
            data: {
                labels: {!! json_encode($label) !!},
                datasets: {!! json_encode($datasetsIn) !!}
            }
        });
        var cty = document.getElementById("myPie").getContext('2d');
        var myPie = new Chart(cty, {
            type: 'pie',
            data: {
                labels: ["M", "T", "W", "T", "F"],
                datasets: [{
                    backgroundColor: [
                        "#2ecc71",
                        "#3498db",
                        "#95a5a6",
                        "#9b59b6",
                        "#f1c40f",
                        "#e74c3c",
                        "#34495e"
                    ],
                    data: [12, 19, 3, 17, 28]
                }]
            }
        });

        $(".year-filter").on('change', function() {
            const search_form = $('#form-submit');
            search_form.submit();
        })
    });
</script>
