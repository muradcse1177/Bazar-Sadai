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
                    @foreach($results as $result)
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body" >
                                    <img src="{{$result->cover_photo}}" style="width: 100%; height: 250px; margin-bottom: 10px;"/>
                                    <h4>{{$result->name}}</h4>
                                    <p style="margin-top: -10px;">লোকেশনঃ {{$result->place}} </p>
                                    <p style="margin-top: -10px; ">পুরা ঠিকানাঃ {{$result->address}} </p>
                                    @if($result->bookingName !='ট্যুর প্যাকেজ')
                                        <a href="{{URL::to('bookingHotel?id='.$result->id)}}" class="btn btn-success">বিস্তারিত</a>
                                    @else
                                        <a href="{{URL::to('bookingTourPackage?id='.$result->id)}}" class="btn btn-success">বিস্তারিত</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{ $results->links() }}
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
@section('js')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script>
    </script>
@endsection
