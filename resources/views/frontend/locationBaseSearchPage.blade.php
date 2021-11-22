@extends('frontend.layout')
@section('title', 'Home || Bazar-Sadai.com Best online Shop in Bangladesh')
@section('home', 'active')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{url('public/asset/woolmart/css/demo1.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('public/asset/woolmart/css/demo3.min.css')}}">
    <style>
        .submit {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 4px 8px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <!-- Start of Main-->
    <main class="main">
        <diV class="container mainSlide">
            <div class="intro-wrapper mb-6">
                <div class="owl-carousel owl-theme owl-nav-inner owl-nav-md row cols-1 gutter-no animation-slider"
                     data-owl-options="{
                        'nav': true,
                        'dots': false
                    }">
                    <?php
                    $i =1;
                    ?>
                    @foreach($slides as $ph)
                        <div class="banner banner-fixed intro-slide intro-slide{{$i}} br-sm" style="background-image: url({{'public/asset/images/'.$ph->slide}}); background-color: #262729;"></div>
                        <?php
                        $i++;
                        ?>
                    @endforeach
                </div>
            </div>
        </diV>
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
        </div>

        <section class="container" style="background-color: #95e074; margin-bottom: 20px;"><br>
            <h2 class="title title-center mb-5">লোকেশন ভিত্তিক পণ্য সার্চ</h2>
            {{ Form::open(array('url' => 'locationBaseProductSearch',  'method' => 'get')) }}
            {{ csrf_field() }}
            <div>
                <center>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="div_name" >পণ্য লোকেশন&nbsp;</label>
                            <label class="radio-inline">
                                <input type="radio" name="addressGroup"  id="zillaGroup" value="1" required> &nbsp;জেলা
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="addressGroup" id="cityGroup" value="2">&nbsp; সিটি
                            </label>
                        </div>
                    </div>
                </center>
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
                    </div><br>
                    <div class="col-xs-4">
                        <button type="submit" value="login"  name="login" class="btn btn-primary btn-block btn-flat">সাবমিট</button>
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
                    </div><br>
                    <div class="col-xs-4">
                        <button type="submit" value="submit"  name="submit" class="btn btn-primary btn-block btn-flat">সাবমিট</button>
                    </div>
                </div>
            </div><br><br>
            {{ Form::close() }}
        </section>

    </main>
@endsection
@section('js')
    <script>
        //$(".select2").select2();
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
