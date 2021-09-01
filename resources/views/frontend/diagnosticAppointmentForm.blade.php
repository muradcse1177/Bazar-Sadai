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
                <?php
                function en2bn($number) {
                    $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
                    $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
                    $bn_number = str_replace($search_array, $replace_array, $number);
                    return $bn_number;
                }
                ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body cardBody">
                                <h3 class="card-title">{{$diagnosticCenter->center_name}}</h3>
                                <p class="card-text">টেস্টঃ {{$diagnosticCenter->name}} </p>
                                <p style="margin-top: -15px;">ফিসঃ {{en2bn($diagnosticCenter->fees.' টাকা')}} </p>
                                <p style="margin-top: -15px;">টেস্ট করার সময়ঃ {{$diagnosticCenter->intime.' '.$diagnosticCenter->intimezone.'-'.$diagnosticCenter->outtime.' '.$diagnosticCenter->outtimezone}} </p>
                                <p style="margin-top: -15px;">টেস্ট করার দিনঃ
                                    <?php
                                    $days = json_decode($diagnosticCenter->days);
                                    foreach ($days as $day){
                                        echo $day.','.' ';
                                    }

                                    ?>
                                </p>
                                <h3 class="card-title">{{"এপয়েনমেন্ট ফর্ম পুরন করুন" }}</h3>
                                {{ Form::open(array('url' => 'insertDiagnosticAppointmentPayment',  'method' => 'post')) }}
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <input type="text" class="form-control date" name="date" id="date" placeholder="তারিখ নির্বাচন করুন " required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control patient_name" name="patient_name" id="patient_name" placeholder="রোগীর নাম" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control patient_address" name="patient_address" id="patient_address" placeholder="রোগীর ঠিকানা" required>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control patient_age" name="age" id="age" placeholder="বয়স" required>
                                    <input type="hidden" class="form-control" name="df_id" value="{{$diagnosticCenter->df_id}}" required>
                                    <input type="hidden" class="form-control" name="fees" value="{{$diagnosticCenter->fees}}" required>
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
