@extends('frontend.layout')
@section('title', 'Medical Service || Bazar-Sadai.com Best online Shop in Bangladesh')
@section('myOrder', 'active')
@section('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{url('public/asset/woolmart/css/style.min.css')}}">
    <style>
        form, input, label, p {
            color: black !important;
        }
        .form-group > select > option{
            color: black !important;
        }
        @media screen and (max-width: 600px) {
            .main{
                margin-top: -30px;
            }
        }
        .intro-slide {
            min-height: 30rem;
        }

    </style>

@endsection
@section('content')
    <main class="main">
        <!-- Start of Page Header -->
        <div class="page-header" style="">
            <div class="container">
                <h1 class="page-title mb-0"> মেডিকেল সার্ভিস</h1>
            </div>
        </div>
        <br>

        <div class="page-content">
            <div class="container">
                @if ($message = Session::get('successMessage'))
                    <div class="col-md-12 mb-4">
                        <div class="alert alert-success alert-button">
                            <a href="#" class="btn btn-success btn-rounded">Well Done</a>
                            {{ $message }}
                        </div>
                    </div>
                @endif
                @if ($message = Session::get('errorMessage'))
                    <div class="col-md-12 mb-4">
                        <div class="alert alert-warning alert-button">
                            <a href="#" class="btn btn-warning btn-rounded">Sorry</a>
                            {{ $message }}
                        </div>
                    </div>
                @endif
                <div class="row">
                    <?php
                    $noimage = 'public/asset/images/doctor.png';
                    function en2bn($number) {
                        $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
                        $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
                        $bn_number = str_replace($search_array, $replace_array, $number);
                        return $bn_number;
                    }
                    ?>
                    <div class="card">
                        <div class="card-body cardBody">
                            <div class="col-sm-3">
                                @if($doctorProfile->photo)
                                    <img src="{{URL::to($doctorProfile->photo)}}" height="220px" width="220px">
                                @else
                                    <img src="{{URL::to('public/asset/images/doctor.png')}}" height="220px" width="220px">
                                @endif
                            </div>
                            <div class="col-sm-9">
                                <h3 class="card-title">{{$doctorProfile->dr_name}}</h3>
                                <p>বর্তমান কর্মস্থলঃ {{$doctorProfile->current_institute}} </p>
                                <p style="margin-top: -15px;">স্পেশালিষ্টঃ {{$doctorProfile->name}} </p>
                                <p style="margin-top: -15px;">পদবীঃ  {{$doctorProfile->designation}} </p>
                                <p style="margin-top: -15px;">শিক্ষাঃ {{$doctorProfile->education}} </p>
                                <p style="margin-top: -15px;">হাস্পাতালঃ {{$doctorProfile->hos_name}} </p>
                                <p style="margin-top: -15px;">ঠিকানাঃ  {{$doctorProfile->dr_address}} </p>
                                <p style="margin-top: -15px;">ফিসঃ  {{en2bn($doctorProfile->fees).' টাকা'}} </p>
                                <p style="margin-top: -15px;">রোগী দেখার সময়ঃ  {{$doctorProfile->in_time.''.$doctorProfile->in_timezone.'-'.$doctorProfile->out_time.''.$doctorProfile->in_timezone}} </p>
                                <p style="margin-top: -15px;">রোগী দেখার দিন সমুহঃ
                                    <?php
                                    $days = json_decode($doctorProfile->days);
                                    foreach ($days as $day){
                                        echo $day.','.' ';
                                    }

                                    ?>
                                </p>
                                <p style="margin-top: -15px;">বিশেষ যোগ্যতাঃ  {{$doctorProfile->specialized}} </p>
                                <p style="margin-top: -15px;">অভিজ্ঞতাঃ   {{$doctorProfile->experience}} </p>
                                <p style="margin-top: -15px;">ই-মেইলঃ   {{$doctorProfile->email}} </p>
                                <h3 class="card-title">{{"এপয়েনমেন্ট ফর্ম পুরন করুন" }}</h3>
                                {{ Form::open(array('url' => 'insertLocalAppointmentPayment',  'method' => 'post')) }}
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <input type="text" class="form-control date" name="date" id="date" placeholder="তারিখ" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control patient_name" name="patient_name" id="patient_name" placeholder="রোগীর নাম" required>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control patient_name" name="age" id="age" placeholder="বয়স" required>
                                    <input type="hidden" class="form-control" name="type" value="{{$type}}" required>
                                    <input type="hidden" class="form-control" name="dr_id" value="{{$doctorProfile->u_id}}" required>
                                    <input type="hidden" class="form-control" name="fees" value="{{$doctorProfile->fees}}" required>
                                </div>
                                <div class="form-group">
                                    <textarea type="text" class="form-control problem" name="problem" id="problem" placeholder="সমস্যা" required></textarea>
                                </div>
                                @if(Cookie::get('user_id'))
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">বুকিং করুন</button>
                                    </div>
                                @endif
                                @if(Cookie::get('user_id') == null )
                                    <div class="form-group">
                                        <a href='{{url('login')}}'  class="btn btn-success">লগ ইন করুন</a>
                                    </div>
                                @endif
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <br>
@endsection
@section('js')
    <script>
        $( function() {
            $('#date').datepicker({
                autoclose: true,
                minDate:0,
                dateFormat: "yy-m-dd",
            })

        } );
    </script>
@endsection
