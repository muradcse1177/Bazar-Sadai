@extends('frontend.layout')
@section('title', 'Demand List || Bazar-Sadai.com Best online Shop in Bangladesh')
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
                <h1 class="page-title mb-0"> কাস্টমার ডেমান্ড লিস্ট</h1>
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
                    @foreach($orders as $order)
                        <div class="card" style="margin-bottom: 20px;">
                            <div class="card-body cardBody">
                                <div class="col-sm-3" style="margin: 0px 0px 20px 0px;">
                                    @if($order['image'])
                                        <img src="{{URL::to($order['image'])}}" height="220px" width="220px">
                                    @else
                                        <img src="{{URL::to('public/asset/no_image.png')}}" height="220px" width="220px">
                                    @endif
                                </div>
                                <div class="col-sm-9">
                                    <h3 class="card-title">Buyer Name: {{$order['name']}}</h3>
                                    <p style="margin-top: -10px;"><b>Delivery/Service Address:</b> {{$order['address']}}</p>
                                    <p style="margin-top: -10px;"><b>Expected Delivery Date: </b>Expected Delivery Date: {{$order['date']}}</p>
                                    <p style="margin-top: -10px;"><b>Amount: </b>{{$order['amount']}}</p>
                                    <p style="margin-top: -10px;"><b>Demand Price: </b>{{$order['amount']}}</p>
                                    <p style="margin-top: -10px;"><b>Status :</b><button style="background-color: #72b8a5;">{{$order['status']}}</button></p>
                                    <p style="margin-top: -10px;"><b>Product/Service Details: </b>{!! nl2br($order['details']) !!}</p>
                                    <div>
                                        <div class="" style="margin-bottom: 20px;">
                                            <button class="btn btn-success contactButton" data-id="{{$order['id']}}">Contact Buyer</button>
                                        </div>
                                        <div id="contactForm{{$order['id']}}" style="display: none; margin-bottom: 20px;">
                                            {{ Form::open(array('url' => 'insertCustomOrderRequest',  'method' => 'post')) }}
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <input type="text" class="form-control name" name="name" placeholder="Enter Name"  required>
                                            </div>
                                            <div class="form-group">
                                                <input type="email" class="form-control email" name="email" placeholder="Enter Email"  required>
                                            </div>
                                            <div class="form-group">
                                                <input type="tel" class="form-control phone" name="phone" placeholder="Enter Phone"   required>
                                            </div>
                                            <div class="form-group">
                                                <input type="number" class="form-control price" name="price" placeholder="My Demand Price"   required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control date" name="date" placeholder="My Expected Delivery date"   required>
                                            </div>
                                            <input type="hidden"  name="id" value="{{$order['id']}}">
                                            <button type="submit" class="btn btn-primary" >Send Request</button>
                                            {{ Form::close() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{$orders->links()}}
            </div>
        </div>
    </main>
    <br>
@endsection
@section('js')
    <script>
        $(document).ready(function(){
            $(".contactButton").click(function(){
                var id = $(this).data('id');
                $("#contactForm"+id).show();
            });
        });
        $( function() {
            $('.date').datepicker({
                autoclose: true,
                minDate:0,
                dateFormat: "yy-m-dd",
            })

        } );
    </script>
@endsection
