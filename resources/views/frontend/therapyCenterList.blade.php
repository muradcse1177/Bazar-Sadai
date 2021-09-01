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
                    @foreach($therapyCenters as $therapyCenter)
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body cardBody">
                                    <h3 class="card-title">{{$therapyCenter->center_name}}</h3>
                                    <p>থেরাপিঃ {{$therapyCenter->name}} </p>
                                    <p style="margin-top: -15px;">ফিসঃ {{en2bn($therapyCenter->fees.' টাকা')}} </p>
                                    <p style="margin-top: -15px;">সময়ঃ {{en2bn($therapyCenter->time).'মিনিট'}} </p>
                                    <p style="margin-top: -15px;">থেরাপি নেওয়ার সময়ঃ {{$therapyCenter->intime.' '.$therapyCenter->intimezone.'-'.$therapyCenter->outtime.' '.$therapyCenter->outtimezone}} </p>
                                    <p style="margin-top: -15px;">থেরাপি নেওয়ার দিনঃ
                                        <?php
                                        $days = json_decode($therapyCenter->days);
                                        foreach ($days as $day){
                                            echo $day.','.' ';
                                        }

                                        ?>
                                    </p>
                                    <a href="{{URL::to('therapyAppointmentForm/'.$therapyCenter->tf_id)}}" class="btn btn-success">বুকিং করুন</a>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>
        </div>
    </main>
    <br>
@endsection
@section('js')
    <script>
    </script>
@endsection
