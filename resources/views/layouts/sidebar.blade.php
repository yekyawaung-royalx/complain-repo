<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper"><a href="#"><img class="img-fluid for-light"
                    src="{{ asset('assets/images/logo.jpg') }}" alt=""><img class="img-fluid for-dark"
                    src="" alt=""></a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
        </div>
        <div class="logo-icon-wrapper"><a href="index.html"><img class="img-fluid"
                    src="{{ asset('assets/images/logo.jpg') }}" alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"><a href="#"><img class="img-fluid" src="" alt=""></a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"> </i></div>
                    </li>
                    @if (Auth::user()->isAdmin() || Auth::user()->isDev() || Auth::user()->isHod())
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}"
                                href="{{ url('dashboard') }}">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                        <g>
                                            <path d="M9.07861 16.1355H14.8936" stroke="#130F26" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M2.3999 13.713C2.3999 8.082 3.0139 8.475 6.3189 5.41C7.7649 4.246 10.0149 2 11.9579 2C13.8999 2 16.1949 4.235 17.6539 5.41C20.9589 8.475 21.5719 8.082 21.5719 13.713C21.5719 22 19.6129 22 11.9859 22C4.3589 22 2.3999 22 2.3999 13.713Z"
                                                stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                        </g>
                                    </g>
                                </svg><span class="lan-3">Dashboard</span></a>
                        </li>
                    @else
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav {{ request()->is('user-dashboard') ? 'active' : '' }}"
                                href="{{ url('user-dashboard') }}">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                        <g>
                                            <path d="M9.07861 16.1355H14.8936" stroke="#130F26" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M2.3999 13.713C2.3999 8.082 3.0139 8.475 6.3189 5.41C7.7649 4.246 10.0149 2 11.9579 2C13.8999 2 16.1949 4.235 17.6539 5.41C20.9589 8.475 21.5719 8.082 21.5719 13.713C21.5719 22 19.6129 22 11.9859 22C4.3589 22 2.3999 22 2.3999 13.713Z"
                                                stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                        </g>
                                    </g>
                                </svg><span class="lan-3">Dashboard</span></a>
                        </li>
                    @endif
                    <li class="sidebar-list"><a
                            class="sidebar-link sidebar-title link-nav {{ request()->is('complaints/all-status/all') ? 'active' : '' }}"
                            href="{{ url('complaints/all-status/all') }}">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <g>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M2.75024 12C2.75024 5.063 5.06324 2.75 12.0002 2.75C18.9372 2.75 21.2502 5.063 21.2502 12C21.2502 18.937 18.9372 21.25 12.0002 21.25C5.06324 21.25 2.75024 18.937 2.75024 12Z"
                                            stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                        <path d="M15.2045 13.8999H15.2135" stroke="#130F26" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M12.2045 9.8999H12.2135" stroke="#130F26" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M9.19557 13.8999H9.20457" stroke="#130F26" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                    </g>
                                </g>
                            </svg> <span>Complaints</span></a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <g>
                                        <path d="M11.1437 17.8829H4.67114" stroke="#130F26" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M15.205 17.8839C15.205 19.9257 15.8859 20.6057 17.9267 20.6057C19.9676 20.6057 20.6485 19.9257 20.6485 17.8839C20.6485 15.8421 19.9676 15.1621 17.9267 15.1621C15.8859 15.1621 15.205 15.8421 15.205 17.8839Z"
                                            stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                        <path d="M14.1765 7.39439H20.6481" stroke="#130F26" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M10.1153 7.39293C10.1153 5.35204 9.43436 4.67114 7.39346 4.67114C5.35167 4.67114 4.67078 5.35204 4.67078 7.39293C4.67078 9.43472 5.35167 10.1147 7.39346 10.1147C9.43436 10.1147 10.1153 9.43472 10.1153 7.39293Z"
                                            stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                    </g>
                                </g>
                            </svg>
                            <span class="--lan-6">Complaints Status</span></a>
                        <ul class="sidebar-submenu">
                            {{-- <li><a href="{{ url('complaints/status/pending') }}">Pending</a></li>
                            <li><a href="{{ url('complaints/status/handled') }}">Handled</a></li>
                            <li><a href="{{ url('complaints/status/assigned') }}">Assigned</a></li>
                            <li><a href="{{ url('complaints/status/operation-reply') }}">Operation Reply</a></li>
                            <li><a href="{{ url('complaints/status/completed') }}">Completed</a></li> --}}
                            <li><a href="{{ url('complaints/status/pending') }}">Pending</a></li>
                            <li><a href="{{ url('complaints/status/follow-up') }}">Handled</a></li>
                            <li><a href="{{ url('complaints/status/assigned') }}">Assigned</a></li>
                            <li><a href="{{ url('complaints/status/progress') }}">Progress</a></li>
                            <li><a href="{{ url('complaints/status/completed') }}">Completed</a></li>
                            <li><a href="{{ url('complaints/status/rejected') }}">Reject</a></li>
                        </ul>
                    </li>

                    {{-- <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="#">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <g>
                                        <path d="M11.1437 17.8829H4.67114" stroke="#130F26" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M15.205 17.8839C15.205 19.9257 15.8859 20.6057 17.9267 20.6057C19.9676 20.6057 20.6485 19.9257 20.6485 17.8839C20.6485 15.8421 19.9676 15.1621 17.9267 15.1621C15.8859 15.1621 15.205 15.8421 15.205 17.8839Z"
                                            stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                        <path d="M14.1765 7.39439H20.6481" stroke="#130F26" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M10.1153 7.39293C10.1153 5.35204 9.43436 4.67114 7.39346 4.67114C5.35167 4.67114 4.67078 5.35204 4.67078 7.39293C4.67078 9.43472 5.35167 10.1147 7.39346 10.1147C9.43436 10.1147 10.1153 9.43472 10.1153 7.39293Z"
                                            stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                    </g>
                                </g>
                            </svg><span>Case Types</span></a>
                    </li> --}}
                    @if (Auth::user()->isDev())
                        <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                        <g>
                                            <path d="M7.4831 10.261V16.9547" stroke="#130F26" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M12.0368 7.05737V16.9553" stroke="#130F26" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M16.5158 13.7983V16.9552" stroke="#130F26" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M2.30005 12.0369C2.30005 4.73479 4.73479 2.30005 12.0369 2.30005C19.339 2.30005 21.7737 4.73479 21.7737 12.0369C21.7737 19.339 19.339 21.7737 12.0369 21.7737C4.73479 21.7737 2.30005 19.339 2.30005 12.0369Z"
                                                stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                        </g>
                                    </g>
                                </svg><span>Users</span></a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ url('/cx-team') }}">CX Team</a></li>
                                <li><a href="#">Operations</a></li>
                            </ul>
                        </li>
                    @endif
                    {{-- <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <g>
                                        <path d="M7.4831 10.261V16.9547" stroke="#130F26" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M12.0368 7.05737V16.9553" stroke="#130F26" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M16.5158 13.7983V16.9552" stroke="#130F26" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M2.30005 12.0369C2.30005 4.73479 4.73479 2.30005 12.0369 2.30005C19.339 2.30005 21.7737 4.73479 21.7737 12.0369C21.7737 19.339 19.339 21.7737 12.0369 21.7737C4.73479 21.7737 2.30005 19.339 2.30005 12.0369Z"
                                            stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                    </g>
                                </g>
                            </svg><span>More</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="#">Branches</a></li>
                            <li><a href="#">Employees</a></li>
                        </ul>
                    </li> --}}
                    {{-- <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                            href="support-ticket.html">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <g>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M21.4399 13.9939C18.7789 13.9939 18.7789 9.87952 21.4399 9.87952C21.4399 5.11236 21.4399 3.41089 12.0449 3.41089C2.6499 3.41089 2.6499 5.11236 2.6499 9.87952C5.3109 9.87952 5.3109 13.9939 2.6499 13.9939C2.6499 18.762 2.6499 20.4635 12.0449 20.4635C21.4399 20.4635 21.4399 18.762 21.4399 13.9939Z"
                                            stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M12.0449 9.17114C11.3619 9.17114 11.2969 10.2606 10.8909 10.6462C10.4839 11.0308 9.22087 10.5912 9.04487 11.2743C8.86987 11.9583 10.0069 12.1904 10.1479 12.7768C10.2879 13.3632 9.59387 14.1875 10.1869 14.5986C10.7809 15.0079 11.4199 14.0804 12.0449 14.0804C12.6699 14.0804 13.3089 15.0079 13.9029 14.5986C14.4969 14.1875 13.8019 13.3632 13.9419 12.7768C14.0829 12.1904 15.2199 11.9583 15.0449 11.2743C14.8689 10.5912 13.6059 11.0308 13.1989 10.6462C12.7929 10.2606 12.7279 9.17114 12.0449 9.17114Z"
                                            stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                    </g>
                                </g>
                            </svg><span>Support Ticket</span></a></li> --}}
                </ul>
                {{-- <div class="sidebar-img-section">
                    <div class="sidebar-img-content"><img class="img-fluid"
                            src="{{ asset('assets/images/side-bar.png') }}" alt="">
                        <h4>Need Help ?</h4><a class="txt" href="{{ url('customer') }}">Raise ticket at
                            "info@royalx.net"</a>
                        <a class="btn btn-secondary"
                            href="">Buy Now</a>
                    </div>
                </div> --}}
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
