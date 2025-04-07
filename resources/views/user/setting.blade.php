@extends('layouts.app1')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .page-wrapper .page-body-wrapper .page-title .breadcrumb {
        justify-content: flex-start;
    }
</style>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"> <a class="home-item" href="index.html">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active"> CX Team</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid default-dash">
        <div class="row">
            <div class="col-xl-4 col-md-4 dash-35 dash-xl-50">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4 class="card-title mb-0">New Case Types
                            {{-- <span class="badge badge-secondary inline-block pull-right" cursorshover="true">
                                <span cursorshover="true"></span>
                            </span> --}}
                        </h4>
                        <div class="card-options"><a class="card-options-collapse" href="#"
                                data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                    class="fe fe-x"></i></a></div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <ul id="save_msgList"></ul>
                            <div class="col-md-12">
                                <label class="form-label text-muted">Main Category</label>
                                <input class="form-control" type="text" name="main_category">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label text-muted">Case Name</label>
                                <input class="form-control" type="text" name="case_name">
                            </div>
                            
                        </div>
                        <div class="form-footer">
                            <button class="btn btn-primary btn-block" id="submit-btn">Save</button>
                        </div>
                    </div>
                </div>


            </div>
            <div class="col-xl-4 col-md-4 dash-35 dash-xl-50">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4 class="card-title mb-0">Add Employee
                            {{-- <span class="badge badge-secondary inline-block pull-right" cursorshover="true">
                                <span cursorshover="true"></span>
                            </span> --}}
                        </h4>
                        <div class="card-options"><a class="card-options-collapse" href="#"
                                data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                    class="fe fe-x"></i></a></div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <ul id="save_msgList"></ul>
                            <div class="col-md-12">
                                <label class="form-label text-muted">REX ID</label>
                                <input class="form-control" type="text" name="rex_no">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label text-muted">Employee Name</label>
                                <input class="form-control" type="text" name="employee_name">
                            </div>
                            
                        </div>
                        <div class="form-footer">
                            <button class="btn btn-primary btn-block" id="submit-rex">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/user/user.js') }}"></script>
@endsection