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
                    ?>
                    @foreach($doctorLists as $doctorList)
                        <div class="card">
                            <div class="card-body cardBody">
                                <div class="col-sm-3">
                                    @if($doctorList->photo)
                                        <img src="{{URL::to($doctorList->photo)}}" height="220px" width="220px">
                                    @else
                                        <img src="{{URL::to('public/asset/images/doctor.png')}}" height="220px" width="220px">
                                    @endif
                                </div>
                                <div class="col-sm-9">
                                    <h3 class="card-title">{{$doctorList->dr_name}}</h3>
                                    <p class="card-text">বর্তমান কর্মস্থলঃ {{$doctorList->current_institute}} </p>
                                    <p style="margin-top: -15px;">বিভাগ / স্পেশালিষ্টঃ {{$doctorList->name}} </p>
                                    <p style="margin-top: -15px;">পদবীঃ  {{$doctorList->designation}} </p>
                                    <p style="margin-top: -15px;">শিক্ষাঃ {{$doctorList->education}} </p>
{{--                                    <p style="margin-top: -15px;">হাস্পাতালঃ {{$doctorList->hos_name}} </p>--}}
                                    <p style="margin-top: -15px;">ঠিকানাঃ  {{$doctorList->dr_address}} </p>
                                    <a style="margin-bottom: 15px;" href="{{URL::to('doctorProfileFront/'.$doctorList->u_id.'&'.$d_type)}}" class="btn btn-success">প্রোফাইল দেখুন</a>&nbsp; &nbsp;
                                </div>
                            </div>
                        </div>
                            &nbsp; &nbsp;
                    @endforeach
                </div>
            </div>
        </div>
    </main>
@endsection
@section('js')
    <script>

    </script>
@endsection
