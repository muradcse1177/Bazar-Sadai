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
                <h1 class="page-title mb-0"> ট্যুরস  এন্ড ট্রাভেলস</h1>
            </div>
        </div>
        <br>

        <div class="page-content">
            <div class="container">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body cardBody">
                                <h3 class="card-title">{{"এপয়েনমেন্ট ফর্ম পুরন করুন" }}</h3>
                                {{ Form::open(array('url' => 'insertBookingHNTPayment',  'method' => 'post')) }}
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <input type="number" class="form-control number" name="number" id="number" placeholder="রুম সংখ্যা" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control startDate" name="startDate" id="startDate" placeholder="চেক ইন " required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control endDate" name="endDate" id="endDate" placeholder="চেক আউট" required>
                                </div>

                                <div class="priceDiv" style="margin-bottom: 15px">

                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="cod">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Cash on Presence
                                    </label>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="time" value="" required>
                                </div>
                                @if(Cookie::get('user_id'))
                                    <div class="form-group">
                                        <input type="hidden" name="name_id" value="{{$_GET['name_id']}}">
                                        <input type="hidden" name="main_id" value="{{$_GET['id']}}">
                                        <input type="hidden" name="price" id="price" value="">
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
            $('#startDate').datepicker({
                autoclose: true,
                minDate:0,
                dateFormat: "yy-m-dd",
            })

        } );
        $( function() {
            $('#endDate').datepicker({
                autoclose: true,
                minDate:0,
                dateFormat: "yy-m-dd",
            })

        } );
        $(".endDate,.number").change(function(){
            var id =$('#number').val();
            var d_id = {{$_GET['id']}};
            var name_id = {{$_GET['name_id']}};
            var start= $("#startDate").datepicker("getDate");
            var end= $("#endDate").datepicker("getDate");
            days = (end- start) / (1000 * 60 * 60 * 24);
            $.ajax({
                type: 'GET',
                url: 'getHNTPrice',
                data: {id:id, d_id:d_id,days:days},
                dataType: 'json',
                success: function(response){
                    $('.priceDiv').html("বুকিং প্রাইসঃ "+ response.data+" টাকা");
                    $('#price').val(response.data);
                }
            });
        });
    </script>
@endsection
