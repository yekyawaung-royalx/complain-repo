<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta property="og:image" content="{{ asset('assets/images/favicon.png') }}" />
    <meta property="og:image:width" content="512" />
    <meta property="og:image:height" content="512" />
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/social-share-bar.css') }}">
</head>

<body>
    <!-- Libraries Stylesheet -->
    <!-- Topbar Start -->

    <div class="spinner" id="preloader">
        <img src="{{ asset('assets/images/logo.jpg') }}" alt="" style="width:110px;height:30px;">
        <div class="circle one"></div>
        <div class="circle two"></div>
        <div class="circle three"></div>
    </div>
    <div class="container-fluid bg-dark px-0 first-header">
        <div class="container">
            <div class="row g-0 d-none d-lg-flex">
                <div class="col-lg-6 text-start">
                    <div class="h-100 d-inline-flex align-items-center">
                        <a class="text-host" href=""><i class="fa fa-phone-alt me-2"></i>Hostline:
                            +(95)9779888688</a>
                    </div>
                </div>
                <div class="col-lg-6 text-end tobar-end">
                    <div
                        class="h-100 topbar-right d-inline-flex align-items-center text-white py-2 border-start border-white border-opacity-25">

                        <span class="fs-5 fw-bold me-2"><i class="fa fa-briefcase" aria-hidden="true"></i><a
                                class="" href="{{ url('job-opportunity') }}"
                                style="text-decoration: none; color:#fff;">
                                Careers</a></span>

                    </div>
                    <div
                        class="h-100 topbar-right d-inline-flex align-items-center text-white py-2 border-start border-white border-opacity-25">
                        <span class="fs-5 fw-bold me-2"><i class="fa fa-file-text" aria-hidden="true"></i><a
                                class="" href="{{ url('user-guide') }}"
                                style="text-decoration: none; color: #fff;">
                                User Guide</a></span>
                    </div>
                    <div
                        class="h-100 topbar-right d-inline-flex align-items-center text-white py-2 border-start border-end border-white border-opacity-25">

                        <span class="fs-5 fw-bold me-2"><i class="fa fa-user" aria-hidden="true"></i><a
                                href="https://member.royalx.biz/login" style="text-decoration: none;color:#fff;">
                                Login</a></span>

                    </div>
                    <div
                        class="h-100 topbar-right d-inline-flex align-items-center text-white py-2 border-end border-white border-opacity-25">
                        <div class="btn-group">
                            <button class="dropdown-toggle" type="button" id="defaultDropdown"
                                data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">

                                <img src="{{ asset('assets/images/usa.png') }}" alt="" width="20px"
                                    height="20px">EN

                            </button>
                            <ul class="dropdown-menu" aria-labelledby="defaultDropdown">

                                <li>
                                    <button class="btn btn-language1 action-button set-lang" value="mm"><img
                                            height="20px" src="{{ asset('assets/images/usa.png') }}"
                                            alt="">Myanmar</button>
                                    <input class="form-check-input set-lang " type="radio" name="flexRadioDefault"
                                        id="flexRadioDefault1" style="position: relative;top:8px;font-size:18px;">
                                </li>
                                <li>
                                    <button class="btn btn-language action-button set-lang " value="en"><img
                                            height="20px" src="{{ asset('assets/images/usa.png') }}"
                                            alt="">&nbsp;English</button>
                                    <input class="form-check-input set-lang" type="radio" name="flexRadioDefault"
                                        id="flexRadioDefault1"
                                        style="position: relative;top:6px;left:11px;font-size:18px;">

                                </li>

                            </ul>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Topbar End -->
    <!--mobile view-->
    <div class="container-fluid bg-dark second-header sticky-top px-0">
        <div class="row g-0 d-lg-flex">
            <div class="d-inline-flex">
                <div class="h-100 d-inline-flex align-items">
                    <a class="text-host" href="" style="color:#fff"><i class="fa fa-phone-alt me-2"></i>Hostline:
                        +(84)937
                        899 999</a>
                </div>
                <div
                    class="h-100 topbar-right d-inline-flex align-items text-white py-2 border-start border-end border-white border-opacity-25">

                    <span class="fs-5 fw-bold me-2"><i class="fa fa-user" aria-hidden="true"></i><a
                            href="https://member.royalx.biz/login" style="text-decoration: none;color:#fff;">
                            Login</a></span>

                </div>
                <div class="h-100 topbar-right d-inline-flex align-items text-white py-2">

                    <span class="fs-5 fw-bold me-2">
                        <img src="{{ asset('assets/images/usa.png') }}" alt="" width="20px"
                            height="20px">
                        EN
                    </span>

                </div>
            </div>
        </div>

    </div>
    <!--end mobile view-->
    <!-- Navbar Start -->
    <div class="container-fluid bg-white nav sticky-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-0 ">
                <a href="https://royalx.biz/demo" class="navbar-brand me-0">
                    <h1 class="text-white m-0"><img src="{{ asset('assets/images/logo.jpg') }}" alt=""
                            height="30px" width="100%"></h1>
                </a>
                <button type="button" class="navbar-toggler me-0" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse" class="navbarshow">
                    <div class="navbar-nav p-4 ms-auto p-lg-0">
                        <a href="{{ url('/our-history') }}"
                            class="nav-item nav-link {{ Request::is('our-history') ? 'active' : '' }}">About</a>

                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Services</a>
                            <div class="dropdown-menu bg-light m-0">
                                <a href="{{ url('/express-service') }}"
                                    class="dropdown-item nav-links {{ Request::is('express-service') ? 'active' : '' }}">Express
                                    Services</a>
                                <a href="{{ url('/dispatch-service') }}"
                                    class="dropdown-item nav-links {{ Request::is('dispatch-service') ? 'active' : '' }}">Dispatch
                                    Delivery</a>
                                <a href="{{ url('/same-day-delivery-service') }}"
                                    class="dropdown-item nav-links {{ Request::is('same-day-delivery-service') ? 'active' : '' }}">Same
                                    Day Services</a>
                                <a href="{{ url('/direct-marketing-solutions') }}"
                                    class="dropdown-item nav-links {{ Request::is('direct-marketing-solutions') ? 'active' : '' }}">Direct
                                    Marketing</a>
                                <a href="{{ url('/last-mile-delivery') }}"
                                    class="dropdown-item nav-links {{ Request::is('last-mile-delivery') ? 'active' : '' }}">Last
                                    Mile &amp; Cash on Delivery</a>
                                <a href="{{ url('/integrated-logistics-solution') }}"
                                    class="dropdown-item nav-links {{ Request::is('integrated-logistics-solution') ? 'active' : '' }}">International</a>
                                <a href="{{ url('/fulfillment-services') }}"
                                    class="dropdown-item nav-links {{ Request::is('fulfillment-services') ? 'active' : '' }}">Fulfillment
                                    and Warehousing</a>
                                <a href="{{ url('/extra-service') }}"
                                    class="dropdown-item nav-links {{ Request::is('extra-service') ? 'active' : '' }}">Extra
                                    Care Service</a>
                                {{-- <a href="{{ url('/cash-on') }}"
                                class="dropdown-item nav-links {{ Request::is('cash-on') ? 'active' : '' }}">{{ menu_locale(get_lang())['head-15'] }}</a> --}}
                                <a href="{{ url('/milk-run') }}"
                                    class="dropdown-item nav-links {{ Request::is('milk-run') ? 'active' : '' }}">Milk
                                    Run
                                    Service</a>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">News &amp;
                                Activities</a>
                            <div class="dropdown-menu bg-light m-0">

                            </div>
                        </div>
                        <a href="{{ url('/our-network') }}"
                            class="nav-item nav-link {{ Request::is('our-network') ? 'active' : '' }}">Our Network</a>

                        <a href="{{ url('price-calculator') }}"
                            class="nav-item nav-link {{ Request::is('price-calculator') ? 'active' : '' }}">Price
                            Calculator</a>
                        <a href="{{ url('/contact-us') }}"
                            class="nav-item nav-link {{ Request::is('contact-us') ? 'active' : '' }}">Contact Us</a>
                        <a href="{{ url('job-opportunity') }}" class="nav-item nav-link carrer">Careers</a>
                        <a href="{{ url('user-guide') }}" class="nav-item nav-link userguide">User Guide</a>
                        <a href="{{ url('feedback') }}" class="nav-item nav-link fedback">Feedback Form</a>
                        <a href="{{ url('term-and-condition') }}" class="nav-item nav-link temconditon">Terms &
                            Conditions</a>
                        <a href="https://member.royalx.biz/login" class="btn btn-primary login-form">Login</a>
                        <div class="row select-language py-2">
                            <div class="">

                                <button class="btn btn-language2 action-button set-lang" value="mm"><img
                                        height="20px" src="{{ asset('assets/images/myanmar.png') }}"
                                        alt="">Myanmar
                                    <input class="form-check-input set-lang" type="radio" name="flexRadioDefault"
                                        id="flexRadioDefault1"
                                        style="position: relative;top:-1px;font-size:18px;"></button>
                                <button class="btn btn-language2 action-button set-lang" value="en"><img
                                        height="20px" src="{{ asset('assets/images/usa.png') }}"
                                        alt="">English
                                    <input class="form-check-input set-lang" type="radio" name="flexRadioDefault"
                                        id="flexRadioDefault1"
                                        style="position: relative;top:-1px;left:11px;font-size:18px;"></button>
                            </div>
                        </div>

                    </div>

                    {{-- <form action="" method="POST" class="closemodal">
                        {{ csrf_field() }}
                        <div class="input-group">
                            <input type="text" placeholder="Track Your Products" name="waybill-number"
                                class="search-form-area form-control-lg form-track" id="exampleFormControlInput1"
                                required>
                            <div class="input-group-append">
                                <button id="button-addon5" type="submit" class="btn btn-danger sear-btn">Search<i
                                        class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                    <button type="button" class="btn-close close" id="close"></button> --}}

                    <a href="#" class="btn btn-primary px-3 d-none d-lg-block search-btn"
                        id="search-btn">Tracking&nbsp;<i class="fa fa-search" aria-hidden="true"></i></a>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->
    <div class="container-fluid page-header-2 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container p-1 text-center">
            <h5 class="animated slideInDown hero-title" style="">We Value<span style="color:red;">Your
                    Feedback</span>
            </h5>
        </div>
    </div>

    <div id="share-bar"></div>

    <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/website/main.js') }}"></script>
    <script src="{{ asset('assets/js/website/fontawesome.js') }}"></script>
    <script src="{{ asset('assets/js/website/jquery-social-share-bar.js') }}"></script>
    <script>
        $('#share-bar').share();
    </script>
    <script>
        $("#close").on('click', function() {
            $("body").toggleClass("search-form-open");
            $(".search-form-area").toggleClass("hide");
            $(".sear-btn").toggleClass("hide");
            $('.close').toggleClass("hide");
        })
    </script>

</body>

</html>
