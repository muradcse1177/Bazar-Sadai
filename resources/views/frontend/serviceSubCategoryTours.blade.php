@extends('frontend.layout')
@section('title', 'Tours & Travels || Bazar-Sadai.com Best online Shop in Bangladesh')
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
            margin-top: -50px;
        }
    </style>

@endsection
@section('content')
    <main class="main">
        <!-- Start of Page Header -->
        <div class="page-header" style="margin-top: -1px;">
            <div class="container">
                <h1 class="page-title mb-0"> ট্যুরস  এন্ড ট্রাভেলস</h1>
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
                        <?php
                          $i = 0;
                          $img = ['d.png','c.jpg','e.jpg','a.jpg'];
                        ?>
                        <section class="category-classic-section pt-10 pb-10">
                            <div class="container mt-1 mb-2">
                                <h2 class="title title-center mb-5">ট্যুরস ও ট্রাভেলস</h2>
                                <div class="row cols-xl-6 cols-lg-5 cols-md-4 cols-sm-3 cols-2">
                                    @foreach($tours_sub_cats as $tours_sub_cats)
                                        <div class="category category-classic category-absolute overlay-zoom br-xs">
                                            <a href='{{ URL::to('bookingPageTNT?scat_id='.$tours_sub_cats->id) }}'>
                                                <figure class="category-media">
                                                    <img src="{{url('public/'.$img[$i])}}" alt="Category"
                                                         width="190" height="184" />
                                                </figure>
                                            </a>
                                            <div class="category-content">
                                                <h4 class="category-name">{{ $tours_sub_cats->name }}</h4>
                                            </div>
                                        </div>
                                        <?php
                                        $i ++;
                                        ?>
                                    @endforeach
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </main>
@endsection
@section('js')
    <script>
    </script>
@endsection
