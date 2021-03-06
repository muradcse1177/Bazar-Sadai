@extends('frontend.layout')
@section('title', 'Tours & Travels  || Bazar-Sadai.com Best online Shop in Bangladesh')
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
                <h1 class="page-title mb-0"> হট্যুরস  এন্ড ট্রাভেলস</h1>
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
                $j=0;
                ?>
                <div class="row">
                    @foreach($results as $result)
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body cardBody pCard" >
                                    <div class="owl-carousel owl-theme owl-nav-inner owl-nav-md row cols-1 gutter-no animation-slider"
                                         data-owl-options="{
                                                'nav': true,
                                                'dots': false
                                         }">
                                        <?php
                                        $photo = json_decode($result->photo);
                                        $photos = explode(",",$photo);
                                        array_pop($photos);
                                        $i=0;
                                        ?>
                                        @foreach($photos as $ph)
                                            <div class="banner banner-fixed intro-slide intro-slide{{$i}} br-sm" style="background-image: url({{$ph}}); height: 250px; background-color: #262729;"></div>
                                        @endforeach
                                        <?php
                                        $i++;
                                        ?>
                                    </div>
                                    <h4>{{$result->name}}</h4>
                                    <p class="card-text">পুরা ঠিকানাঃ {{$result->address}} </p>
                                    <p style="margin-top: -15px;">ধরণঃ  {{$result->t_type}} </p>
                                    <p style="margin-top: -15px;">খরচঃ {{$result->price}} </p>
                                    <div style="text-align: justify; margin-top: -15px;">বিবরনঃ {!! nl2br($result->description) !!} </div>
                                    <div style="text-align: justify; margin-bottom: 15px;">সুযোগ সুবিধাঃ {!! nl2br($result->facilities) !!} </div>
                                    {{ Form::open(array('url' => 'insertTourPackagePayment',  'method' => 'post')) }}
                                    {{ csrf_field() }}
                                        <div class="form-check" style="margin-bottom: 15px;">
                                            <input class="form-check-input" type="checkbox" value="1" name="cod">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Cash on Presence
                                            </label>
                                        </div>
                                        @if(Cookie::get('user_id'))
                                            <div class="form-group">
                                                <input type="hidden" name="main_id" value="{{$result->t_id}}">
                                                <input type="hidden" name="name_id" value="{{$_GET['id']}}">
                                                <input type="hidden" name="price" id="price" value="{{$result->price}}">
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
                        <?php  $j++; ?>
                    @endforeach
                    {{ $results->links() }}
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
