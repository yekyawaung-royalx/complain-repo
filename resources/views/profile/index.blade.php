@extends('layouts.app1')
@section('content')
    <style>
        .progressSection .holder {
            display: flex;
            flex-direction: column;
            margin-bottom: 1em;
        }

        .progressSection .holder>div {
            display: flex;
            justify-content: space-between;
        }

        .star-light {
            color: #bbb5 !important
        }


        .text-warning {
            color: rgb(250, 143, 43) !important
        }


        .submit_star {
            cursor: pointer;
        }
    </style>
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h3>Profile Detail</h3>
                    </div>
                    <div class="col-12 col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"> <a class="home-item" href="index.html">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid default-dash">
            <div class="container">
                <div class="main-body">

                    <!-- Breadcrumb -->
                    <!-- /Breadcrumb -->

                    <div class="row gutters-sm">
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"
                                            class="rounded-circle" width="150">
                                        <div class="mt-3">
                                            <h4>John Doe</h4>
                                            <p class="text-secondary mb-1">Full Stack Developer</p>
                                            <p class="text-muted font-size-sm">Bay Area, San Francisco, CA</p>
                                            <button class="btn btn-primary">Follow</button>
                                            <button class="btn btn-outline-primary">Message</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mt-3">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-globe mr-2 icon-inline">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="2" y1="12" x2="22" y2="12"></line>
                                                <path
                                                    d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
                                                </path>
                                            </svg>Website</h6>
                                        <span class="text-secondary">https://bootdey.com</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-github mr-2 icon-inline">
                                                <path
                                                    d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22">
                                                </path>
                                            </svg>Github</h6>
                                        <span class="text-secondary">bootdey</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-twitter mr-2 icon-inline text-info">
                                                <path
                                                    d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z">
                                                </path>
                                            </svg>Twitter</h6>
                                        <span class="text-secondary">@bootdey</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-instagram mr-2 icon-inline text-danger">
                                                <rect x="2" y="2" width="20" height="20" rx="5"
                                                    ry="5"></rect>
                                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5">
                                                </line>
                                            </svg>Instagram</h6>
                                        <span class="text-secondary">bootdey</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-facebook mr-2 icon-inline text-primary">
                                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z">
                                                </path>
                                            </svg>Facebook</h6>
                                        <span class="text-secondary">bootdey</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
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
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <a class="btn btn-info " target="__blank" href="#">Edit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row gutters-sm">
                                <div class="col-sm-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="d-flex align-items-center mb-3"><i
                                                    class="material-icons text-info mr-2">assignment</i>Project Status</h6>
                                            <div class="progressSection">
                                                <div class='holder'>
                                                    <div>
                                                        <div class="progress-label-left">
                                                            <b>5</b> <i class="fa fa-star mr-1 text-warning"></i>
                                                        </div>
                                                        <div class="progress-label-right">
                                                            <span id="total_five_star_review"> 0 </span> Reviews
                                                        </div>

                                                    </div>

                                                    <div class="progress">
                                                        <div class="progress-bar bg-warning" id='five_star_progress'>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='holder'>
                                                    <div>
                                                        <div class="progress-label-left">
                                                            <b>4</b> <i class="fa fa-star mr-1 text-warning"></i>
                                                        </div>
                                                        <div class="progress-label-right">
                                                            <span id="total_four_star_review"> 0 </span> Reviews
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-warning" id='four_star_progress'>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='holder'>
                                                    <div>
                                                        <div class="progress-label-left">
                                                            <b>3</b> <i class="fa fa-star mr-1 text-warning"></i>
                                                        </div>
                                                        <div class="progress-label-right">
                                                            <span id="total_three_star_review"> 0 </span> Reviews
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-warning" id='three_star_progress'>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='holder'>
                                                    <div>
                                                        <div class="progress-label-left">
                                                            <b>2</b> <i class="fa fa-star mr-1 text-warning"></i>
                                                        </div>
                                                        <div class="progress-label-right">
                                                            <span id="total_two_star_review"> 0 </span> Reviews
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-warning" id='two_star_progress'>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='holder'>
                                                    <div>
                                                        <div class="progress-label-left">
                                                            <b>1</b> <i class="fa fa-star mr-1 text-warning"></i>
                                                        </div>
                                                        <div class="progress-label-right">
                                                            <span id="total_one_star_review"> 0 </span> Reviews
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-warning" id='one_star_progress'>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="d-flex align-items-center mb-3"><i
                                                    class="material-icons text-info mr-2">assignment</i>Project Status</h6>
                                            <div class="text-center m-auto">
                                                <h1><span id="avg_rating">0.0</span>/5.0</h1>
                                                <div>
                                                    <i class="fa fa-star star-light main_star mr-1"></i>
                                                    <i class="fa fa-star star-light main_star mr-1"></i>
                                                    <i class="fa fa-star star-light main_star mr-1"></i>
                                                    <i class="fa fa-star star-light main_star mr-1"></i>
                                                    <i class="fa fa-star star-light main_star mr-1"></i>
                                                </div>
                                                <span id="total_review">0</span> Reviews
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
<input type="hidden" id="loginUser" value={{ Auth::user()->name }}>
<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
<script>
    $(document).ready(function() {
        loadData();

        function loadData() {
            var username = $("#loginUser").val();
            // alert(username)
            $.ajax({
                url: 'rating-list/' + username,
                method: "GET",
                data: {},

                success: function(data) {
                    // var parsedData = JSON.parse(data);
                    //console.log(data)
                    $('#avg_rating').text(data.avgUserRatings)
                    $('#total_review').text(data.totalReviews)
                    $('#total_five_star_review').text(data.totalRatings5)
                    $('#total_four_star_review').text(data.totalRatings4)
                    $('#total_three_star_review').text(data.totalRatings3)
                    $('#total_two_star_review').text(data.totalRatings2)
                    $('#total_one_star_review').text(data.totalRatings1)


                    $('#five_star_progress').css('width', (data.totalRatings5 / data
                        .totalReviews) * 100)
                    $('#four_star_progress').css('width', (data.totalRatings4 / data
                        .totalReviews) * 100)
                    $('#three_star_progress').css('width', (data.totalRatings3 / data
                        .totalReviews) * 100)
                    $('#two_star_progress').css('width', (data.totalRatings2 / data
                        .totalReviews) * 100)
                    $('#one_star_progress').css('width', (data.totalRatings1 / data
                        .totalReviews) * 100)


                    var countStar = 0;
                    $('.main_star').each(function() {

                        countStar++
                        console.log(Math.ceil(data.avgUserRatings))
                        if (Math.ceil(data.avgUserRatings) >= countStar) {
                            $(this).addClass('text-warning')
                            $(this).removeClass('star-light')
                        }
                    })


                    if (data.ratingsList.length > 0) {
                        var html = '';
                        for (var count = 0; count < data.ratingsList.length; count++) {
                            console.log(count)

                            html += `<div class='row mt-2'>`;
                            html += `<div class='col-1'>`;
                            html +=
                                `<h1><div class='bg-danger rounded-circle text-center text-white text-uppercase pt-2 pb-2'>${data.ratingsList[count].name.charAt(0)}</div></h1>`;
                            html += `</div>`;
                            html += `<div class='col-11'>`;
                            html += `<div class='card'>`;
                            html += `<div class='card-header'>`;
                            html += `${data.ratingsList[count].name}`;

                            html += `</div>`;
                            html += `<div class='card-body'>`;
                            for (var star = 0; star < 5; star++) {
                                if (data.ratingsList[count].rating >= star) {
                                    className = 'text-warning'
                                } else {
                                    className = 'star-light'
                                }

                                html += `<i class="fa fa-star mr-1 ${className}" ></i>`;
                            }
                            html += `<br>${data.ratingsList[count].message}`;

                            html += `</div>`;
                            html += `<div class='card-footer'>`;
                            html += `${data.ratingsList[count].datetime}`;

                            html += `</div>`;
                            html += `</div>`;
                            html += `</div>`;
                            html += `</div>`;


                        }

                    }

                    $('#display_review').html(html)

                } // success
            })
        }
    })
</script>
