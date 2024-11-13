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
        <div class="container-fluid default-dash">
            <div class="row">
                <div class="col-xl-4 col-md-4 dash-35 dash-xl-50">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h4 class="card-title mb-0">New User Form
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
                                    <label class="form-label text-muted">Name</label>
                                    <input class="form-control" type="text" name="name">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label text-muted">Email</label>
                                    <input class="form-control" type="text" name="email">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label text-muted">Password</label>
                                    <input class="form-control" type="password" name="password">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label text-muted">Confirm Password</label>
                                    <input class="form-control" type="password" name="confirmPassword">
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role1" id="role1"
                                            value="1" checked>
                                        <label class="form-check-label" for="admin_role">Admin</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role1" id="role1"
                                            value="0">
                                        <label class="form-check-label" for="user_role">User</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-footer">
                                <button class="btn btn-primary btn-block" id="save">Save</button>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-xl-4 col-md-8 dash-31 dash-xl-50">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h4 class="card-title mb-0">User Table </h4>
                            <div class="card-options"><a class="card-options-collapse" href="#"
                                    data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                    class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                        class="fe fe-x"></i></a></div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <table class="table table-bordernone">
                                    <thead>
                                        <tr>
                                            <th><span>User Name</span></th>
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
    </div>
    {{-- Edit Modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit & Update Student Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <ul id="update_msgList"></ul>

                    <input type="hidden" id="stud_id" />
                    <form id="myForm">
                        <div class="form-group mb-3">
                            <label for="">Full Name</label>
                            <input type="text" id="name" required class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Email</label>
                            <input type="text" id="email" required class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Password</label>
                            <input type="password" id="password" required class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="role" id="role"
                                    value="1">
                                <label class="form-check-label" for="admin_role">Admin</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="role" id="role"
                                    value="0">
                                <label class="form-check-label" for="user_role">User</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary update_student">Update</button>
                </div>

            </div>
        </div>
    </div>
    {{-- Edn- Edit Modal --}}
    {{-- view Modal --}}
    {{-- <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Edit & Update Student Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Full Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            Kenneth Valdez
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            fip@jukmuh.al
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Phone</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            (239) 816-9029
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Mobile</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            (320) 380-4539
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Address</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            Bay Area, San Francisco, CA
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div> --}}
    {{-- Edn- view Modal --}}
    {{-- Delete Modal --}}
    <div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Student Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>Confirm to Delete Data ?</h4>
                    <input type="hidden" id="deleteing_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary delete_student">Yes Delete</button>

                </div>
            </div>
        </div>
    </div>
    {{-- End - Delete Modal --}}
    <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/user/user.js') }}"></script>
@endsection
