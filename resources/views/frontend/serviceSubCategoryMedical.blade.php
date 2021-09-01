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
                    <div class="col-md-12">
                        @foreach($med_services_sub_cat as $med_services_sub_cat)
                            @if($med_services_sub_cat->id==16)
                            <a href='{{ URL::to('doctorAppointmentForm') }}'>
                                <div class='col-sm-4'>
                                    <div class='box box-solid'>
                                        <div class='box-body prod-body'>
                                            <div class="alert boxBody">
                                                <center><strong>{{ $med_services_sub_cat->name }}</strong></center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @endif
                            @if($med_services_sub_cat->id==17)
                            <a href='{{ URL::to('therapyServiceForm') }}'>
                                <div class='col-sm-4'>
                                    <div class='box box-solid'>
                                        <div class='box-body prod-body'>
                                            <div class="alert boxBody">
                                                <center><strong>{{ $med_services_sub_cat->name }}</strong></center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @endif
                            @if($med_services_sub_cat->id==18)
                            <a href='{{ URL::to('diagnosticBookingForm') }}'>
                                <div class='col-sm-4'>
                                    <div class='box box-solid'>
                                        <div class='box-body prod-body'>
                                            <div class="alert boxBody">
                                                <center><strong>{{ $med_services_sub_cat->name }}</strong></center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @endif
                        @endforeach
                            <a href='{{ URL::to('medicalCampFront') }}'>
                                <div class='col-sm-4'>
                                    <div class='box box-solid'>
                                        <div class='box-body prod-body'>
                                            <div class="alert boxBody">
                                                <center><strong>{{'মেডিকেল ক্যাম্প'}}</strong></center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href='{{ URL::to('localDoctor') }}'>
                                <div class='col-sm-4'>
                                    <div class='box box-solid'>
                                        <div class='box-body prod-body'>
                                            <div class="alert boxBody">
                                                <center><strong>{{'লোকাল ডাক্তার এপয়েন্টমেন্ট'}}</strong></center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('js')
@endsection
