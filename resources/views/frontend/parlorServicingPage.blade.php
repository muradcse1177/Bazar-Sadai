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
                {{ Form::open(array('url' => 'parlorServiceBookingFront',  'method' => 'post')) }}
                {{ csrf_field() }}
                <div class="row">
                    <div class="card">
                        <div class="card-body cardBody">
                            <h5 style="text-align: center;"><b>আপনার পছন্দের পার্লার খুজে নিন।</b></h5>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="div_name" >সার্ভিস লোকেশন(যে লোকেশনে সারভিস্টি গ্রহণ করতে চান)&nbsp;</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="addressGroup"  id="zillaGroup" value="1" required> &nbsp;জেলা
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="addressGroup" id="cityGroup" value="2">&nbsp; সিটি
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-12" id="divDiv" style="display: none;">
                                <div class="form-group">
                                    <select id="div_name" name ="div_id"  class="form-control select2 div_name" style="width: 100%;" required>
                                        <option value="" selected>বিভাগ নির্বাচন করুন</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12" id= "zillaGroupId" style="display: none;">
                                <div class="form-group">
                                    <select id="dis_name" name ="disid" class="form-control select2 dis_name" style="width: 100%;" required="required">
                                        <option  value="" selected>জেলা  নির্বাচন করুন</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select id="upz_name" name ="upzid" class="form-control select2 upz_name" style="width: 100%;" required="required">
                                        <option value="" selected>উপজেলা  নির্বাচন করুন</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select id="uni_name" name ="uniid" class="form-control select2 uni_name" style="width: 100%;" required="required">
                                        <option value="" selected>ইউনিয়ন  নির্বাচন করুন</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select id="ward_name" name ="wardid" class="form-control select2 ward_name"  style="width: 100%;" required="required">
                                        <option value="" selected>ওয়ার্ড  নির্বাচন করুন</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12" id= "cityGroupId" style="display: none;" >
                                <div class="form-group">
                                    <select id="c_dis_name" name ="c_disid" class="form-control select2 city_name" style="width: 100%;" required="required">
                                        <option  value="" selected>সিটি  নির্বাচন করুন</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select id="c_upz_name" name ="c_upzid" class="form-control select2 co_name"  style="width: 100%;" required="required">
                                        <option value="" selected>সিটি - কর্পোরেশন  নির্বাচন করুন</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select id="c_uni_name" name ="c_uniid" class="form-control select2 thana_name" style="width: 100%;" required="required">
                                        <option value="" selected>থানা  নির্বাচন করুন</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select id="c_ward_name" name ="c_wardid" class="form-control select2 c_ward_name"   style=" width: 100%;" required="required">
                                        <option value="" selected>ওয়ার্ড  নির্বাচন করুন</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <select class="form-control select2 type" id="type" name="type" style="width: 100%;" required>
                                        <option value="" selected> পার্লার  ধরণ  নির্বাচন করুন</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <select class="form-control select2 gender" id="gender" name="gender" style="width: 100%;" required>
                                        <option value="" selected>জেন্ডার নির্বাচন করুন</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <select class="form-control select2 service" id="service" name="service" style="width: 100%;" required>
                                        <option value="" selected>সার্ভিস নির্বাচন করুন</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="text" class="form-control pickup_date" name="pickup_date" id="pickup_date"  readonly value="{{date("Y-m-d")}}">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="text" class="form-control time" name="time" id="time" placeholder="সময়" required>
                                </div>
                            </div>
                            <div class="priceDiv" style="display: none;">
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
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </main>
    <br>
@endsection
@section('js')
    <script>
        $( function() {
            $('#pickup_date').datepicker({
                autoclose: true,
                minDate:0,
                dateFormat: "yy-m-dd",
            })
        } );
        //$('.select2').select2();
        $("#zillaGroup").click(function(){
            $("#zillaGroupId").show();
            $("#cityGroupId").hide();
            $("#divDiv").show();
            $('.city_name').prop('required',false);
            $('.co_name').prop('required',false);
            $('.thana_name').prop('required',false);
            $('.c_ward_name').prop('required',false);
        });
        $("#cityGroup").click(function(){
            $("#zillaGroupId").hide();
            $("#cityGroupId").show();
            $("#divDiv").show();
            $('.dis_name').prop('required',false);
            $('.upz_name').prop('required',false);
            $('.uni_name').prop('required',false);
            $('.ward_name').prop('required',false);
        });
        $(".ward_name,.c_ward_name").change(function(){
            if ($("input[name='addressGroup'][value='1']").prop("checked")){
                var main = $("#zillaGroup").val();
                var a1 = $(".div_name").val();
                var a2 = $(".dis_name").val();
                var a3 = $(".upz_name").val();
                var a4 = $(".uni_name").val();
                var a5 = $(".ward_name").val();
            }
            if ($("input[name='addressGroup'][value='2']").prop("checked")){
                var main = $("#cityGroup").val();
                var a1 = $(".div_name").val();
                var a2 = $(".city_name").val();
                var a3 = $(".co_name").val();
                var a4 = $(".thana_name").val();
                var a5 = $(".c_ward_name").val();
            }
            $('.type').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getAllParlorTypeFront',
                data: {a1:a1,a2:a2,a3:a3,a4:a4,a5:a5,main:main},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['p_type'];
                        var name = data[i]['p_type'];
                        $(".type").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".type").change(function(){
            if ($("input[name='addressGroup'][value='1']").prop("checked")){
                var main = $("#zillaGroup").val();
                var a1 = $(".div_name").val();
                var a2 = $(".dis_name").val();
                var a3 = $(".upz_name").val();
                var a4 = $(".uni_name").val();
                var a5 = $(".ward_name").val();
            }
            if ($("input[name='addressGroup'][value='2']").prop("checked")){
                var main = $("#cityGroup").val();
                var a1 = $(".div_name").val();
                var a2 = $(".city_name").val();
                var a3 = $(".co_name").val();
                var a4 = $(".thana_name").val();
                var a5 = $(".c_ward_name").val();
            }
            var type =$(this).val();
            $('.gender').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getGenderServiceNameFront',
                data: {type:type,a1:a1,a2:a2,a3:a3,a4:a4,a5:a5,main:main},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['gender_type'];
                        var name = data[i]['gender_type'];
                        $(".gender").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".gender").change(function(){
            var gender =$(this).val();
            var type =$('.type').val();
            if ($("input[name='addressGroup'][value='1']").prop("checked")){
                var main = $("#zillaGroup").val();
                var a1 = $(".div_name").val();
                var a2 = $(".dis_name").val();
                var a3 = $(".upz_name").val();
                var a4 = $(".uni_name").val();
                var a5 = $(".ward_name").val();
            }
            if ($("input[name='addressGroup'][value='2']").prop("checked")){
                var main = $("#cityGroup").val();
                var a1 = $(".div_name").val();
                var a2 = $(".city_name").val();
                var a3 = $(".co_name").val();
                var a4 = $(".thana_name").val();
                var a5 = $(".c_ward_name").val();
            }
            $('.service').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getParlorServiceNameFront',
                data: {type:type,gender:gender,a1:a1,a2:a2,a3:a3,a4:a4,a5:a5,main:main},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['service'];
                        var name = data[i]['service'];
                        $(".service").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".service").change(function(){
            if ($("input[name='addressGroup'][value='1']").prop("checked")){
                var main = $("#zillaGroup").val();
                var a1 = $(".div_name").val();
                var a2 = $(".dis_name").val();
                var a3 = $(".upz_name").val();
                var a4 = $(".uni_name").val();
                var a5 = $(".ward_name").val();
            }
            if ($("input[name='addressGroup'][value='2']").prop("checked")){
                var main = $("#cityGroup").val();
                var a1 = $(".div_name").val();
                var a2 = $(".city_name").val();
                var a3 = $(".co_name").val();
                var a4 = $(".thana_name").val();
                var a5 = $(".c_ward_name").val();
            }
            var service = $(this).val();
            var type = $("#type").val();
            var gender = $("#gender").val();
            $.ajax({
                type: 'GET',
                url: 'getParlorServicePriceFront',
                data: {service:service,type:type,gender:gender,a1:a1,a2:a2,a3:a3,a4:a4,a5:a5,main:main},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    $(".price").html('Price: '+ data.price +' tk');
                    $(".price").show();
                    $(".priceDiv").show();
                }
            });
        });
        $(document).ready(function(){
            $.ajax({
                url: 'getAllDivision',
                type: "GET",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (response) {
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".div_name").append("<option value='"+id+"'>"+name+"</option>");
                    }

                },
                failure: function (msg) {
                    alert('an error occured');
                }
            });

        });
        $(".div_name").change(function(){
            var id =$(this).val();
            $('.dis_name').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getDistrictListAll',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".dis_name").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".dis_name").change(function(){
            var id =$(this).val();
            $('.upz_name').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getUpazillaListAll',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".upz_name").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".upz_name").change(function(){
            var id =$(this).val();
            $('.uni_name').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getUnionListAll',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".uni_name").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".uni_name").change(function(){
            var id =$(this).val();
            $('.ward_name').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getWardListAll',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".ward_name").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".div_name").change(function(){
            var id =$(this).val();
            $('.city_name').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getCityListAll',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".city_name").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".city_name").change(function(){
            var id =$(this).val();
            $('.co_name').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getCityCorporationListAll',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".co_name").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".co_name").change(function(){
            var id =$(this).val();
            $('.thana_name').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getThanaListAll',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".thana_name").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(".thana_name").change(function(){
            var id =$(this).val();
            $('.c_ward_name').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getC_wardListAll',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".c_ward_name").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
    </script>
@endsection
