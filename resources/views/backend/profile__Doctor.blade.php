@extends('backend.layout')
@section('title', 'Profile')
@section('page_header', 'Profile Management')
@section('extracss')
@endsection
@section('content')

    @if ($message = Session::get('successMessage'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> ধন্যবাদ</h4>
            {{ $message }}</b>
        </div>
    @endif
    @if ($message = Session::get('errorMessage'))

        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-warning"></i> দুঃখিত!</h4>
            {{ $message }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="divform">
                    {{ Form::open(array('url' => 'updateProfile',  'method' => 'post' ,'enctype'=>'multipart/form-data')) }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="box-body">
                            <div class="form-group col-sm-4">
                                <label for="name" >নাম</label>
                                <input type="text" class="form-control name" name="name" value="{{@$profile->name}}" placeholder="নাম"  required>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="name" >ই-মেইল</label>
                                <input type="email" class="form-control email" name="email" value="{{@$profile->email}}" placeholder="ই-মেইল"  required>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="phone" >ফোন </label>
                                <input type="tel" class="form-control phone" name="phone" placeholder="ফোন নম্বর" value="{{@$profile->phone}}" pattern="\+?(88)?0?1[3456789][0-9]{8}\b"  required>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="password" >পাসওয়ার্ড</label>
                                <input type="password" class="form-control password" name="password" value="{{'.........'}}" placeholder="পাসওয়ার্ড"  required>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="div_name" >লিঙ্গ</label><br>
                                <label class="radio-inline">
                                    <input type="radio" class="gender" name="gender"  id="male" value="M" required> পুরুষ
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" class="gender" name="gender" id="female" value="F">মহিলা
                                </label>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="div_name">বিভাগ</label>
                                <select id="div_name" name ="div_id"  class="form-control select2 div_name" style="width: 100%;" required="required">
                                    <option value="" selected>বিভাগ নির্বাচন করুন</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="div_name" >বসবাস</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="addressGroup"  id="zillaGroup" value="1" required> জেলা
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="addressGroup" id="cityGroup" value="2">সিটি
                                </label>
                            </div>
                            <div id= "zillaGroupId" style="display: none;">
                                <div class="form-group col-sm-4">
                                    <label for="dis_name" >জেলা</label>
                                    <select id="dis_name" name ="disid" class="form-control select2 dis_name" style="width: 100%;" required="required">
                                        <option  value="" selected>জেলা  নির্বাচন করুন</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="upz_name" >উপজেলা</label>
                                    <select id="upz_name" name ="upzid" class="form-control select2 upz_name" style="width: 100%;" required="required">
                                        <option value="" selected>উপজেলা  নির্বাচন করুন</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="uni_name" >ইউনিয়ন</label>
                                    <select id="uni_name" name ="uniid" class="form-control select2 uni_name" style="width: 100%;" required="required">
                                        <option value="" selected>ইউনিয়ন  নির্বাচন করুন</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="ward_name" >ওয়ার্ড</label>
                                    <select id="ward_name" name ="wardid" class="form-control select2 ward_name" style="width: 100%;" required="required">
                                        <option value="" selected>ওয়ার্ড  নির্বাচন করুন</option>
                                    </select>
                                </div>
                            </div>
                            <div id= "cityGroupId" style="display: none;">
                                <div class="form-group col-sm-4">
                                    <label for="c_dis_name" >সিটি</label>
                                    <select id="c_dis_name" name ="c_disid" class="form-control select2 city_name" style="width: 100%;" required="required">
                                        <option  value="" selected>সিটি  নির্বাচন করুন</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="c_upz_name" >সিটি - কর্পোরেশন</label>
                                    <select id="c_upz_name" name ="c_upzid" class="form-control select2 co_name"  style="width: 100%;" required="required">
                                        <option value="" selected>সিটি - কর্পোরেশন  নির্বাচন করুন</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="c_uni_name" >থানা</label>
                                    <select id="c_uni_name" name ="c_uniid" class="form-control select2 thana_name" style="width: 100%;" required="required">
                                        <option value="" selected>থানা  নির্বাচন করুন</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="c_ward_name" >ওয়ার্ড</label>
                                    <select id="c_ward_name" name ="c_wardid" class="form-control select2 c_ward_name" style="width: 100%;" required="required">
                                        <option value="" selected>ওয়ার্ড  নির্বাচন করুন</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="address" >ঠিকানা</label>
                                <input type="text" class="form-control address" value="{{@$profile->address}}" name="address" placeholder="ঠিকানা"  required>
                            </div>

                            <div class="form-group col-sm-4">
                                <label for="type" >ছবি</label>
                                <input type="file" class="form-control type" accept="image/*" name="user_photo" placeholder="ছবি">
                            </div>
                            <div class="photoId" style="">
                                <div class="form-group col-sm-4">
                                    <label for="address" >এন আইডি নম্বর</label>
                                    <input type="text" class="form-control nid" value="{{@$profile->nid}}"  name="nid" placeholder="এন আইডি নম্বর">
                                </div>
                            </div>
                            <div class="doctorsForm">
                                <div class="form-group col-sm-4">
                                    <label for="type" >ডিপার্টমেন্ট </label>
                                    <select id="doc_department" name ="doc_department" class="form-control select2 doc_department" style="width: 100%;" required>
                                        <option value=""selected>ডিপার্টমেন্ট  নির্বাচন করুন </option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="type" >হাসপাতাল</label>
                                    <select id="doc_hospital" name ="doc_hospital" class="form-control select2 doc_hospital" style="width: 100%;">
                                        <option value=""selected>হাসপাতাল  নির্বাচন করুন </option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="address" >পদবী</label>
                                    <input type="text" class="form-control designation" value="{{@$df->designation}}" name="designation" placeholder="পদবী" required>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="address" >বর্তমান কর্মস্থল নাম </label>
                                    <input type="text" class="form-control" value="{{@$df->current_institute}}" name="currentInstitute" placeholder="বর্তমান কর্মস্থল নাম">
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="address" >শিক্ষাগত যোগ্যতা</label>
                                    <textarea  class="form-control" name="education"  placeholder="শিক্ষাগত যোগ্যতা">{{@$df->education}}</textarea>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="address" >বিশেষ যোগ্যতা</label>
                                    <textarea  class="form-control" name="specialized"  placeholder="বিশেষ যোগ্যতা">{{@$df->specialized}}</textarea>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="address" >অভিজ্ঞতা</label>
                                    <textarea  class="form-control" name="experience" placeholder="অভিজ্ঞতা">{{@$df->experience}}</textarea>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="">ফিস </label>
                                    <input type="number" class="form-control fees"  value="{{@$df->fees}}" id="fees"  name="fees" min="0" placeholder=" ফিস লিখুন" required>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="">রোগী দেখার ঠিকানা</label>
                                    <input type="text" class="form-control pa_address" id="pa_address" value="{{@$df->address}}"  name="pa_address" placeholder="রোগী দেখার ঠিকানা" required>
                                    <input type="hidden" class="form-control" id="" value="13"  name="user_type">
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="">ইন টাইম</label>
                                    <input type="number" class="form-control intime" id="intime" value="{{@$df->in_time}}"  name="intime" min="0" placeholder="ইন টাইম" required>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label> ইন টাইম  </label>
                                    <select class="form-control select2 intimezone" name="intimezone"  id="intimezone" style="width: 100%;" required>
                                        <option  value="" selected> ইন টাইম নির্বাচন করুন</option>
                                        <option  value="AM"  @if($df->in_timezone == 'AM') {{'Selected'}} @endif >AM</option>
                                        <option  value="PM" @if($df->in_timezone == 'PM') {{'Selected'}} @endif>PM</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="">আউট টাইম</label>
                                    <input type="number" class="form-control outtime" id="outtime" value="{{@$df->out_time}}"  name="outtime" min="0" placeholder="আউট টাইম" required>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label> আউট টাইম  </label>
                                    <select class="form-control select2 outtimezone" name="outtimezone" id="outtimezone" style="width: 100%;" required>
                                        <option  value="" selected> আউট টাইম নির্বাচন করুন</option>
                                        <option  value="AM"  @if($df->out_timezone == 'AM') {{'Selected'}} @endif >AM</option>
                                        <option  value="PM" @if($df->out_timezone == 'PM') {{'Selected'}} @endif>PM</option>
                                    </select>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label for=""> বিএমডিসি নম্বর </label>
                                    <input type="text" class="form-control bmdc" id="bmdc" value="{{@$df->bmdc}}"  name="bmdc"  placeholder=" বিএমডিসি নম্বর" required>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label> রোগী দেখার দিন সমুহ </label>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="saturday" name="days[]" value="Saturday" checked>
                                        <label class="form-check-label" for="saturday">Saturday</label>
                                        <input type="checkbox" class="form-check-input" id="sunday" name="days[]" value="Sunday" checked>
                                        <label class="form-check-label" for="sunday">Sunday</label>
                                        <input type="checkbox" class="form-check-input" id="monday" name="days[]" value="Monday" checked>
                                        <label class="form-check-label" for="monday">Monday</label>
                                        <input type="checkbox" class="form-check-input" id="tuesday" name="days[]" value="Tuesday" checked>
                                        <label class="form-check-label" for="tuesday">Tuesday</label>
                                        <input type="checkbox" class="form-check-input" id="wednesday" name="days[]" value="Wednesday" checked>
                                        <label class="form-check-label" for="wednesday">Wednesday</label>
                                        <input type="checkbox" class="form-check-input" id="thursday" name="days[]" value="Thursday" checked>
                                        <label class="form-check-label" for="thursday">Thursday</label>
                                        <input type="checkbox" class="form-check-input" id="friday" name="days[]" value="Friday" checked>
                                        <label class="form-check-label" for="friday">Friday</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label> রোগী দেখার সময় </label>
                                    <div class="form-check">
                                        @foreach($dt as $d)
                                            <div class="col-sm-3">
                                                <input type="checkbox" class="form-check-input" id="{{$d->time1.' - '.$d->time2}}" name="times[]" value="{{$d->time1.' - '.$d->time2}}">
                                                <label class="form-check-label" for="{{$d->time1.' - '.$d->time2}}">{{$d->time1.' - '.$d->time2}} </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="id" id="id" class="id">
                        <button type="submit" class="btn btn-primary">সাবমিট</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')
    <script>

        $(document).ready(function(){
            $(".addbut").click(function(){
                $(".divform").show();
                $(".rembut").show();
                $(".addbut").hide();
            });
            $(".rembut").click(function(){
                $(".divform").hide();
                $(".addbut").show();
                $(".rembut").hide();
            });
            $('#type').change(function(){
                var value = $(this).val();
                if(value==13){
                    $(".doctorsForm").show();
                }
                else{
                    $(".doctorsForm").hide();
                    $('.doc_department').prop('required',false);
                    $('.doc_hospital').prop('required',false);
                    $('.designation').prop('required',false);
                    $('.fees').prop('required',false);
                    $('.pa_address').prop('required',false);
                    $('.intime').prop('required',false);
                    $('.intimezone').prop('required',false);
                    $('.outtime').prop('required',false);
                    $('.outtimezone').prop('required',false);
                }
            });
            $("#zillaGroup").click(function(){
                $("#zillaGroupId").show();
                $("#cityGroupId").hide();
                $('.city_name').prop('required',false);
                $('.co_name').prop('required',false);
                $('.thana_name').prop('required',false);
                $('.c_ward_name').prop('required',false);
            });
            $("#cityGroup").click(function(){
                $("#zillaGroupId").hide();
                $("#cityGroupId").show();
                $('.dis_name').prop('required',false);
                $('.upz_name').prop('required',false);
                $('.uni_name').prop('required',false);
                $('.ward_name').prop('required',false);
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
            $.ajax({
                url: 'getAllUserType',
                type: "GET",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (response) {
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".type").append("<option value='"+id+"'>"+name+"</option>");
                    }

                },
                failure: function (msg) {
                    alert('an error occured');
                }
            });
            $.ajax({
                url: 'getAllMedDept',
                type: "GET",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (response) {
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".doc_department").append("<option value='"+id+"'>"+name+"</option>");
                    }

                },
                failure: function (msg) {
                    alert('an error occured');
                }
            });
        });
        $(function(){
            $('.select2').select2();
            $(document).on('click', '.edit', function(e){
                e.preventDefault();
                $('.divform').show();
                var id = $(this).data('id');
                console.log(id);
                getRow(id);
            });
            $(document).on('click', '.delete', function(e){
                e.preventDefault();
                $('#modal-danger').modal('show');
                var id = $(this).data('id');
                getRow(id);
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
        });
        function getRow(id){
            $.ajax({
                type: 'POST',
                url: 'getUserListByID',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    $('.name').val(data[0]['name']);
                    $('.phone').val(data[0]['phone']);
                    $('.email').val(data[0]['email']);
                    $('.address').val(data[0]['address']);
                    $('.id').val(data[0]['id']);
                    //$('.div_name').val(data[0]['add_part1']);
                    //$('#type').val(data[0]['user_type']);
                    $('.nid').val(data[0]['nid']);
                    if(data[0]['gender']=='M')
                        $("#male").attr('checked', 'checked');
                    else
                        $("#female").attr('checked', 'checked');
                    $('.select2').select2();
                }
            });
        }
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
        $(".doc_department").change(function(){
            var id =$(this).val();
            $('.doc_hospital').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getHospitalListAll',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".doc_hospital").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
    </script>
@endsection
