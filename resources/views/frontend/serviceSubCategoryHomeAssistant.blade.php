@extends('frontend.layout')
@section('title', 'Home Assistant || Bazar-Sadai.com Best online Shop in Bangladesh')
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
                <h1 class="page-title mb-0"> হোম এসিস্ট্যান্ট</h1>
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
                    $url_arr = array("cookingPageFront", "clothWashingPage", "cleaningPage","helpingHandPage","guardPage","productServicingPage","parlorServicingPage",'laundryServicePage');
                    $i=0;
                ?>
                <div class="row">
                    <div class="col-md-12">
                        @foreach($home_assistant_sub_cats as $home_assistant_sub_cat)
                            <a href='{{ url($url_arr[$i])}}'>
                                <div class='col-sm-4'>
                                    <div class='box box-solid'>
                                        <div class='box-body prod-body'>
                                            <div class="alert boxBody">
                                                <center><strong>{{ $home_assistant_sub_cat->name }}</strong></center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <?php $i++; ?>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>
    <br>
@endsection
@section('js')
@endsection
