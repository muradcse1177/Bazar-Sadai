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
        <div class="page-header" style="margin-top: -30px;">
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
                {{ Form::open(array('url' => 'searchTourNTravels',  'method' => 'post')) }}
                {{ csrf_field() }}
                <div class="row">
                    <div class="card">
                        <div class="card-body cardBody">
                            <h5 style="text-align: center;"><b>আপনার বুকিং খুজে নিন।</b></h5>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <select class="form-control select2 country" name="country" style="width: 100%;" required>
                                        <option value="" selected>দেশ নির্বাচন করুন</option>
                                        <option value="বাংলাদেশ">বাংলাদেশ</option>
                                        <option value="বিদেশ">বিদেশ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <select class="form-control select2 place" id="place" name="place" style="width: 100%;" required>
                                        <option value="" selected> স্থান নির্বাচন করুন</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="hidden" name="bookingName" value="{{$_GET['scat_id']}}">
                                    <button type="submit" class="btn btn-success">সার্চ করুন</button>
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
        $(".country").change(function(){
            var id =$(this).val();
            $('.place').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: '{{ url('/') }}/getMainPlaceListAllFront',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['name'];
                        var name = data[i]['name'];
                        $(".place").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
    </script>
@endsection
