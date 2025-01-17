<style>
    .footer-share {
        margin: 2px;
    }

    .p-text {
        font-family: 'Aileron-Light';
        color: #D4D4D6;
    }
</style>

<body class="bg-color">

    <a href="javascript:void(0);" id="backToTop" class="back-to-top">
        <i class="arrow"></i><i class="arrow"></i>
    </a>
    <!-- Footer Start -->

    <div class="container-fluid footer wow fadeIn py-4" data-wow-delay="0.2s">
        <div class="container ">
            <div class="row g-4 activities_row">
                <div class="col-lg-3 col-md-6">
                    <h6 class="text-white mb-4">Quick Links</h6>
                    <a class="btn btn-link" href="https://www.royalx.net/our-history">About Us</a>
                    <a class="btn btn-link" href="https://www.royalx.net/price-calculator">Price Calculator</a>
                    <a class="btn btn-link" href="https://www.royalx.net/our-network">Our Network</a>
                    <a class="btn btn-link" href="https://www.royalx.net/tracking">Tracking</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="text-white mb-4">Support</h6>
                    <a class="btn btn-link" href="https://www.royalx.net/contact-us">Contact Us</a>
                    <a class="btn btn-link" href="https://www.royalx.net/user-guide">User Guide</a>
                    <a class="btn btn-link" href="https://www.royalx.net/job-opportunity">Job Opportunity</a>
                    {{-- <a class="btn btn-link" href="{{ url('post') }}">Hr Community</a> --}}
                    <a class="btn btn-link" href="{{ url('/') }}">Feedback</a>
                    <a class="btn btn-link" href="{{ url('/') }}">Frequently Asked Questions</a>
                    <a class="btn btn-link" href="{{ url('/') }}">Terms & Conditions</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="text-white mb-4">Royal Express Head Office</h6>
                    <p class="mb-2 p-text" style="font-size: 14px;"><i class="fa fa-map-marker-alt me-3"></i>No
                        (77), Corner of Amara Road
                        and Padonmar Road, (Nga) Ward, North Okkalarpa Township, Yangon, Myanmar</p>
                    <p class="mb-2 p-text" style="font-size: 14px;"><i class="fa fa-phone-alt me-3"></i>(+95)
                        9779888688</p>
                    <p class="mb-2 p-text"><i class="fa fa-envelope me-3"></i><a class="to-mail"
                            href="mailto:info@royalx.net" style="font-size: 14px;">info@royalx.net</a></p>


                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="text-white mb-4">Newsletter</h6>
                    <form action="#">
                        <div class="subscribe-widget">
                            <input type="text" placeholder="Enter your email address..." id="email"
                                required="true">
                            <input type="hidden" id="token" value="">
                            <button type="button" class="ped-btn-footer subscribe">SUBSCRIBE US</button>

                        </div>
                        <p class="" style="font-size: 12px; font-family: 'Aileron-Light';color:#D4D4D6">Get
                            latest
                            updates and offers.</p>
                    </form>
                </div>
            </div>
            <hr>
        </div>
        <div class="container">
            <h6 style="font-size: 12px;font-family:'Aileron-Bold'">GET THE ROYALAPP</h6>
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="">
                            <a href="https://apps.apple.com/us/app/royal-express-member/id1538284560"
                                target="_blank"><img src="{{ asset('assets/images/app-store.png') }}"
                                    style="height: 40px; width: 150px !important;" /></a>

                            <a href="https://play.google.com/store/apps/details?id=com.royalexpress.memberapp"
                                target="_blank"><img src="{{ asset('assets/images/google-play-store.png') }}"
                                    style="height: 40px; width: 150px !important;" /></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row activities_row">
                        <div class="footheader">
                            <a href="https://www.facebook.com/RoyalExpressMyanmar/" class="footer-share"
                                target="_blank"><i class="fa fa-facebook-square" aria-hidden="true"
                                    style="color:white;font-size:24px;"></i></a>
                            <a href="https://www.linkedin.com/company/royal-express" class="footer-share"
                                target="_blank"><i class="fa fa-linkedin-square"
                                    style="color:white;font-size:24px;"></i></a>
                            <a href="https://www.youtube.com/channel/UCinpOtElQdvB86f8_wT9mJA"class="footer-share"
                                id="" target="_blank"><i class="fa fa-instagram"
                                    style="color:white;font-size:24px;"></i></a>
                            <a href="https://www.instagram.com/royalexpress_mm" class="footer-share" target="_blank"><i
                                    class="fa fa-youtube-play" style="color:white;font-size:24px;"></i></a>
                            <a href="https://t.me/RoyalExpressMM" class="footer-share" target="_blank"><i
                                    class="fa fa-telegram" aria-hidden="true" style="color:white;font-size:24px;"
                                    target="_blank"></i></a>
                            <a href="https://bit.ly/3uVrLMv" class="footer-white" target="_blank"><i
                                    class="fa-brands fa-viber" style="color:white;font-size:24px;"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <p class="" style="font-size: 12px; font-family: 'Aileron-Light';color:#D4D4D6">Copyright ©
                RoyalExpress
                {{ date('Y') }}. All rights reserved. </p>
        </div>
    </div>
    {{-- <input type="hidden" id="url" value="{{ url('') }}">
    <input type="hidden" id="token" value="{{ csrf_token() }}">
    <input type="hidden" id="lang" value="{{ get_lang() }}"> --}}
    <!-- Footer End -->



    <script src="{{ asset('assets/js/customer/bootstrap-bulder-main.js') }}"></script>
    <script src="{{ asset('assets/js/customer/jquery-min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var lang = $("#lang").val();

            $(".set-lang").on("click", function search(e) {
                e.preventDefault();

                set_lang = $(this).val();
                url = $('#url').val();
                token = $('#token').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                $.ajax({
                    type: 'post',
                    url: url + '/changed-lang',
                    dataType: 'json',
                    data: {
                        'set_lang': set_lang,
                        '_token': token
                    },
                    success: function(data) {
                        location.reload();
                    },
                });
            });

            if (lang == 'mm') {
                $('.nav-link').addClass('mm-nav-link');
            }
        });
    </script>
