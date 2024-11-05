@extends('layouts.app1')
<style>
    .checked {
        color: #ffd900;
    }
</style>
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h3>View Complaint</h3>
                    </div>
                    <div class="col-12 col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"> <a class="home-item" href="index.html"><i data-feather="home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">View</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid default-dash">
            <div class="row">
                <div class="col-xl-4 col-md-6 dash-35 dash-xl-50">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h4 class="card-title mb-0">Complaint ID # {{ $complaint->complaint_uuid }}
                                <button class="btn btn-success pull-right" type="button" cursorshover="true">
                                    <span cursorshover="true"> {{ $complaint->status_name }}</span>
                                </button>
                            </h4>
                            <div class="card-options"><a class="card-options-collapse" href="#"
                                    data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                    class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                        class="fe fe-x"></i></a></div>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label text-muted">တိုင်ကြားချက်အသေးစိတ်</label>
                                    <div class="text-dark">{{ $complaint->customer_message }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">တိုင်ကြား / အကြံပြုသူအမည်</label>
                                    <div class="text-dark">{{ $complaint->customer_name }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">ဆက်သွယ်ရန်ဖုန်းနံပါတ်</label>
                                    <div class="text-dark">{{ $complaint->customer_mobile }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">ဖြစ်စဉ်ဖြစ်ပွားသည့်နေ့စွဲ</label>
                                    <div class="text-dark">{{ $complaint->issue_date }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">တိုင်ကြားချက်အမျိုးအစား</label>
                                    <div class="text-dark">{{ $complaint->case_type_name }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">တိုင်ကြားသူအကြံပြုချက်</label>
                                    <div class="text-dark">{{ $complaint->customer_recommendation }}</div>
                                </div>
                                <div class="form-footer">
                                    <a href="{{ url('complaints/' . $complaint->id . '/edit') }}"
                                        class="btn   btn-primary btn-block">Edit</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 dash-31 dash-xl-50">
                    <div class="card recent-activity">
                        <div class="card-header card-no-border">
                            <div class="media media-dashboard">
                                <div class="media-body">
                                    <h5 class="mb-0">Internal Activity </h5>
                                </div>
                                <div class="icon-box onhover-dropdown"><i data-feather="more-horizontal"></i>
                                    <div class="icon-box-show onhover-show-div">
                                        <ul>
                                            <li> <a>
                                                    Latest </a></li>
                                            <li> <a>
                                                    Earlist</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive custom-scrollbar">
                                <table class="table table-bordernone">
                                    <tbody>
                                        @foreach ($logs as $log)
                                            @if ($log->status_name == 'review')
                                            @else
                                                <tr>
                                                    <td>
                                                        <div class="media">
                                                            <div class="square-box me-2"><img class="img-fluid b-r-5"
                                                                    src="https://admin.pixelstrap.com/zeta/assets/images/avtar/chinese.png"
                                                                    alt=""></div>
                                                            <div class="media-body"><a href="user-profile.html">
                                                                    <h5>{{ $log->department }}<span
                                                                            class="badge badge-light-primary">{{ $log->status_name }}</span><span
                                                                            class="badge badge-light-theme-light font-theme-light pull-right">{{ $log->created_at }}</span>
                                                                    </h5>
                                                                </a>
                                                                <p>{{ $log->message_by }}</p>
                                                                @if ($log->message)
                                                                    <div class="activity-msg bg-light-success">
                                                                        <span class="activity-msg-box">
                                                                            {{ $log->message }}</span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card recent-activity">
                        <div class="card-header card-no-border">
                            <div class="media media-dashboard">
                                <div class="media-body">
                                    <h5 class="mb-0">Customer's Feedback </h5>
                                </div>
                                <div class="icon-box onhover-dropdown"><i data-feather="more-horizontal"></i>
                                    <div class="icon-box-show onhover-show-div">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive custom-scrollbar">
                                <table class="table table-bordernone">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="media">
                                                    <div class="square-box me-2"><img class="img-fluid b-r-5"
                                                            src="https://admin.pixelstrap.com/zeta/assets/images/avtar/chinese.png"
                                                            alt=""></div>
                                                    <div class="media-body"><a href="user-profile.html">

                                                            <h5>Customer<span
                                                                    class="badge badge-light-theme-light font-theme-light pull-right">{{ $complaint->updated_at }}</span>
                                                            </h5>
                                                        </a>
                                                        <p class="mt-2">
                                                            {{ $complaint->handle_by }}
                                                            reviews
                                                            @php $ratenum=number_format($rating_value) @endphp
                                                            <span class="font-primary">
                                                                @for ($i = 0; $i < $ratenum; $i++)
                                                                    <i class="fa fa-star checked"></i>
                                                                @endfor
                                                                @for ($j = $ratenum + 1; $j <= 5; $j++)
                                                                    <i class="fa fa-star"></i>
                                                                @endfor
                                                                @if ($ratenum > 0)
                                                                    {{ $ratenum }}
                                                                @else
                                                                    No Rating
                                                                @endif
                                                            </span> for complaint.
                                                        </p>
                                                        <div class="activity-msg bg-light-success"> <span
                                                                class="activity-msg-box">
                                                                @if ($complaint->stars_rated)
                                                                    {{ $complaint->complaint_review }}
                                                                @else
                                                                    No Data
                                                                @endif
                                                            </span>
                                                        </div>

                                                    </div>
                                                </div>
                                            </td>
                                            <td> </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
@endsection
