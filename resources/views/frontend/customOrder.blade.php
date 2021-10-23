@extends('frontend.layout')
@section('title', 'Custom Order || Bazar-Sadai.com Best online Shop in Bangladesh')
@section('myOrder', 'active')
@section('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{url('public/asset/woolmart/css/style.min.css')}}">

@endsection
@section('content')
    <main class="main">
        <!-- Start of Page Header -->
        <div class="page-header" style="margin-top: -1px;">
            <div class="container">
                <h1 class="page-title mb-0">কাস্টম অর্ডার</h1>
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
                    <div class="card" style="background-color: #cccccc;">
                        <div class="card-body cardBody">
                            <h5 style="text-align: center;"><b>আপনার প্রয়োজনীয় অর্ডার টি করুন।</b></h5>
                            {{ Form::open(array('url' => 'insertCustomOrder',  'method' => 'post','enctype'=>'multipart/form-data')) }}
                            {{ csrf_field() }}
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <select class="form-control select2 category" id="category" name="category" style="width: 100%;" required>
                                        <option value="" selected> ক্যাটেগরি / চাহিদা নির্বাচন করুন</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}"> {{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-control select2 sub_category" id="sub_category" name="sub_category" style="width: 100%;">
                                        <option value="" selected> সাব ক্যাটেগরি / চাহিদা  নির্বাচন করুন</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control  name" name="name" placeholder="নাম"  required>
                                </div>
                                <div class="form-group">
                                    <input type="tel" class="form-control phone" name="phone" placeholder="ফোন নম্বর" pattern="\+?(88)?0?1[3456789][0-9]{8}\b"  required>
                                </div>
                                <div class="form-group">
                                    <label>কোথায় ডেলিভারি/সার্ভিস চান</label>
                                </div>
                                <div class="form-group">
                                    <label class="radio-inline">
                                        <input type="radio" name="addressGroup"  id="zillaGroup" value="1"  required>&nbsp; জেলা
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="addressGroup" id="cityGroup" value="2">&nbsp; সিটি
                                    </label>
                                </div>
                                <div id="divDiv" style="display: none;">
                                    <div class="form-group">
                                        <select id="div_name" name ="div_id"  class="form-control select2 div_name" style="width: 100%;" required>
                                            <option value="" selected>বিভাগ নির্বাচন করুন</option>
                                        </select>
                                    </div>
                                </div>
                                <div id= "zillaGroupId" class="zillaGroupId" style="display: none;">
                                    <div class="form-group">
                                        <select id="dis_name" name ="disid" class="form-control select2 dis_name"  style="width: 100%;" required="required">
                                            <option  value="" selected>জেলা  নির্বাচন করুন</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select id="upz_name" name ="upzid" class="form-control select2 upz_name"  style="width: 100%;" required="required">
                                            <option value="" selected>উপজেলা  নির্বাচন করুন</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select id="uni_name" name ="uniid" class="form-control select2 uni_name"  style="width: 100%;" required="required">
                                            <option value="" selected>ইউনিয়ন  নির্বাচন করুন</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select id="ward_name" name ="wardid" class="form-control select2 ward_name"  style="width: 100%;" required="required">
                                            <option value="" selected>ওয়ার্ড  নির্বাচন করুন</option>
                                        </select>
                                    </div>
                                </div>
                                <div id= "cityGroupId" class="cityGroupId" style="display: none;">
                                    <div class="form-group">
                                        <select id="c_dis_name" name ="c_disid" class="form-control select2 city_name"  style="width: 100%;" required="required">
                                            <option  value="" selected>সিটি  নির্বাচন করুন</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select id="c_upz_name" name ="c_upzid" class="form-control select2 co_name"   style="width: 100%;" required="required">
                                            <option value="" selected>সিটি - কর্পোরেশন  নির্বাচন করুন</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select id="c_uni_name" name ="c_uniid" class="form-control select2 thana_name"  style="width: 100%;" required="required">
                                            <option value="" selected>অঞ্চল/থানা  নির্বাচন করুন</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select id="c_ward_name" name ="c_wardid" class="form-control select2 c_ward_name"   style=" width: 100%;" required="required">
                                            <option value="" selected>ওয়ার্ড  নির্বাচন করুন</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="address" placeholder="ঠিকানা"  required>
                                </div>
                                <div class="form-group">
                                    <textarea type="text" class="form-control" name="details" placeholder="পন্যের / চাহিদার বিস্তারিত লিখুন" rows="8"  required></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control date" name="date" placeholder="কবে ডেলিভারি চান"  required readonly>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control amount" name="amount" placeholder="পণ্যের / চাহিদার  পরিমান"  required>
                                </div>
                                <div class="form-group">
                                    <input type="number" min="1" class="form-control price" name="price" placeholder="পণ্যের / চাহিদার  জন্য কত টাকা দিতে চান"  required>
                                </div>
                                <div class="form-group">
                                    <label>পণ্যের / চাহিদার ছবি</label>
                                </div>
                                <div class="form-group">
                                    <input type="file" class="form-control image" name="image" accept="image/*" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">অর্ডার করুন</button>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    </div>
@endsection
@section('js')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script>
        $( function() {
            $('.date').datepicker({
                autoclose: true,
                minDate:0,
                dateFormat: "yy-m-dd",
            })

        } );
        $(".category").change(function(){
            var id =$(this).val();
            $('.sub_category').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getSubcategoryByCat',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".sub_category").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
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
        $(function(){
            //$('.select2').select2();
            $("#zillaGroup").click(function(){
                $("#zillaGroupId").show();
                $("#cityGroupId").hide();
                $("#foreignGroupId").hide();
                $("#divDiv").show();
                $('.city_name').prop('required',false);
                $('.co_name').prop('required',false);
                $('.thana_name').prop('required',false);
                $('.c_ward_name').prop('required',false);
            });
            $("#cityGroup").click(function(){
                $("#zillaGroupId").hide();
                $("#cityGroupId").show();
                $("#foreignGroupId").hide();
                $("#divDiv").show();
                $('.dis_name').prop('required',false);
                $('.upz_name').prop('required',false);
                $('.uni_name').prop('required',false);
                $('.ward_name').prop('required',false);
            });


            $(".div_name").change(function(){
                var id =$(this).val();
                $('.dis_name').find('option:not(:first)').remove();
                $.ajax({
                    type: 'GET',
                    url: 'getDistrictListAll',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id
                    },
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
        });

    </script>
@endsection
