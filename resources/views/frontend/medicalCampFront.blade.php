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
                    @foreach($medCamps as $medCamp)
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body cardBody">
                                    <h3 class="card-title"> {{$medCamp['name']}}</h3>
                                    <p class="card-text">ঠিকানাঃ {{$medCamp['add_part1'].', '.$medCamp['add_part2'].', '.$medCamp['add_part3'].', '.$medCamp['add_part4'].', '.$medCamp['add_part5'].', '.$medCamp['address'] }} </p>
                                    <p style="margin-top: -15px;">যোগাযোগঃ {{$medCamp['email'].' ,'.$medCamp['phone']}} </p>
                                    <p style="margin-top: -15px;">উদ্দেশ্যঃ {{$medCamp['purpose']}} </p>
                                    <p style="margin-top: -15px;">শুরুঃ {{$medCamp['start_date']}} </p>
                                    <p style="margin-top: -15px;">শেষঃ {{$medCamp['end_date']}} </p>
                                    <p style="margin-top: -15px;">ওপেনারঃ {{$medCamp['user']}} </p>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{$medCamps->links()}}
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
