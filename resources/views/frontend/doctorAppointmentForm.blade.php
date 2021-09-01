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
                {{ Form::open(array('url' => 'searchDoctorListFront',  'method' => 'post')) }}
                {{ csrf_field() }}
                <div class="row">
                    <div class="card">
                        <div class="card-body cardBody">
                            <h5 style="text-align: center;"><b>আপনার পছন্দের  ডাক্তার খুজে নিন।</b></h5>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <select class="form-control select2 type" id="type" name="type" style="width: 100%;" required>
                                        <option value="" selected> হসপিটাল/প্রাইভেট</option>
                                        <option value="Hospital"> হসপিটাল </option>
                                        <option value="Chamber"> প্রাইভেট চেম্বার</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <select class="form-control select2 department" id="department" name="department" style="width: 100%;" required>
                                        <option value="" selected> ডিপার্টমেন্ট নির্বাচন করুন</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
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
@endsection
@section('js')
    <script>
        //$('.select2').select2();
        $.ajax({
            url: 'getAllMedDepartmentFront',
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                var data = response.data;
                var len = data.length;
                for( var i = 0; i<len; i++){
                    var id = data[i]['id'];
                    var name = data[i]['name'];
                    $(".department").append("<option value='"+id+"'>"+name+"</option>");
                }

            },
            failure: function (msg) {
                alert('an error occured');
            }
        });
    </script>
@endsection
