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
                {{ Form::open(array('url' => 'guardBookingFront',  'method' => 'post')) }}
                {{ csrf_field() }}
                <div class="row">
                    <div class="card">
                        <div class="card-body cardBody">
                            <h5 style="text-align: center;"><b>আপনার পছন্দের গার্ড খুজে নিন।</b></h5>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <select class="form-control select2 type" id="type" name="type" style="width: 100%;" required>
                                        <option value="" selected> ধরণ  নির্বাচন করুন</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="number" name="days" id="days" class="form-control days" placeholder="কয় দিন" min="1" required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <select class="form-control select2 time" id="time" name="time" style="width: 100%;" required>
                                        <option value="" selected>ঘন্টা নির্বাচন করুন</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <h4 style="display: none;" class="price"> </h4>
                                </div>
                            </div>
                            <div class="col-sm-12">
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
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </main>
    <br>
@endsection
@section('js')
    <script>
        $(document).ready(function(){
            $.ajax({
                url: 'getAllGuardTypeFront',
                type: "GET",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (response) {
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['type'];
                        var name = data[i]['type'];
                        $(".type").append("<option value='"+id+"'>"+name+"</option>");
                    }

                },
                failure: function (msg) {
                    alert('an error occured');
                }
            });
        });
        $(".type").change(function(){
            var type =$(this).val();
            if(type =='মাসিক'){
                $(".days").hide();
                $('.days').prop('required',false);
            }
            else{
                $(".days").show();
                $('.days').prop('required',true);
            }
            $('.time').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getGuardTimeFront',
                data: {type:type},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['time'];
                        var name = data[i]['time'];
                        $(".time").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".time").change(function(){
            var time = $(this).val();
            var type = $("#type").val();
            $.ajax({
                type: 'GET',
                url: 'getGuardPriceFront',
                data: {time:time,type:type},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var days =$("#days").val();
                    if(days<=0) days=1;
                    $(".price").html('Price: '+ data.price*days +' tk');
                    $(".price").show();
                }
            });
        });
        $(".days").change(function(){
            var days = $(this).val();
            var time = $("#time").val();
            var type = $("#type").val();
            $.ajax({
                type: 'GET',
                url: 'getGuardPriceFront',
                data: {time:time,type:type},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    if(days<=0) days=1;
                    $(".price").html('Price: '+ data.price*days +' tk');
                    $(".price").show();
                }
            });
        });
    </script>
@endsection
