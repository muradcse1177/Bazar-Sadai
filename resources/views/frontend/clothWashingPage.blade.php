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
                {{ Form::open(array('url' => 'clothWashingBookingFront',  'method' => 'post')) }}
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-body table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th></th>
                                        <th>নাম</th>
                                        <th>পরিমান</th>
                                        <th>দাম</th>
                                    </tr>
                                    @foreach($cloths as $cloth)
                                        <tr>
                                            <td><input type="checkbox" class="form-check-input" name="cloth_id[]" value="{{$cloth->id}}"></td>
                                            <td>{{$cloth->name}}</td>
                                            <td><input type="number" class="quantity" name="quantity[]" style="width: 50px; text-align: center;" min="1" value="1"  id="{{$cloth->id}}" data-id="{{$cloth->id}}"></td>
                                            <td id="td{{$cloth->id}}">{{$cloth->price}}</td>
                                        </tr>
                                    @endforeach
                                </table><br>
                                <div class="col-md-4">
                                    @if(Cookie::get('user_id'))
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success">অর্ডার করুন</button>
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
                {{ Form::close() }}
            </div>
        </div>
    </main>
    <br>
@endsection
@section('js')
    <script>
        $(".quantity").change(function(){
            var id = $(this).data('id');
            var value = $(this).val();
            $.ajax({
                type: 'GET',
                url: 'getClothPriceByIdFront',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    $("#td"+id).html(data.price*value);
                }
            });
        });
    </script>
@endsection
