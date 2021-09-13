@extends('backend.layout')
@section('title','পার্লার সার্ভিস')
@section('page_header', 'পার্লার সার্ভিস ব্যবস্থাপনা')
@section('homeAssistantMainLi','active menu-open')
@section('parlorService','active')
@section('serviceMainLi','active menu-open')
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
                <div class="box-header with-border">
                    <h3 class="box-title addbut"><button type="button" class="btn btn-block btn-success btn-flat"><i class="fa fa-plus-square"></i> নতুন যোগ করুন </button></h3>
                    <h3 class="box-title rembut" style="display:none;"><button type="button" class="btn btn-block btn-success btn-flat"><i class="fa fa-minus-square"></i> মুছে ফেলুন </button></h3>
                </div>
                <div class="divform" style="display:none">
                    {{ Form::open(array('url' => 'insertParlourService',  'method' => 'post')) }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="div_name">বিভাগ</label>
                            <select id="div_name" name ="div_id"  class="form-control select2 div_name" style="width: 100%;" required="required">
                                <option value="" selected>বিভাগ নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="div_name" >বসবাস</label>
                            <label class="radio-inline">
                                <input type="radio" name="addressGroup"  id="zillaGroup" value="1" required> জেলা
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="addressGroup" id="cityGroup" value="2">সিটি
                            </label>
                        </div>
                        <div id= "zillaGroupId" style="display: none;">
                            <div class="form-group">
                                <label for="dis_name" >জেলা</label>
                                <select id="dis_name" name ="disid" class="form-control select2 dis_name" style="width: 100%;" required="required">
                                    <option  value="" selected>জেলা  নির্বাচন করুন</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="upz_name" >উপজেলা</label>
                                <select id="upz_name" name ="upzid" class="form-control select2 upz_name" style="width: 100%;" required="required">
                                    <option value="" selected>উপজেলা  নির্বাচন করুন</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="uni_name" >ইউনিয়ন</label>
                                <select id="uni_name" name ="uniid" class="form-control select2 uni_name" style="width: 100%;" required="required">
                                    <option value="" selected>ইউনিয়ন  নির্বাচন করুন</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ward_name" >ওয়ার্ড</label>
                                <select id="ward_name" name ="wardid" class="form-control select2 ward_name" style="width: 100%;" required="required">
                                    <option value="" selected>ওয়ার্ড  নির্বাচন করুন</option>
                                </select>
                            </div>
                        </div>
                        <div id= "cityGroupId" style="display: none;">
                            <div class="form-group">
                                <label for="c_dis_name" >সিটি</label>
                                <select id="c_dis_name" name ="c_disid" class="form-control select2 city_name" style="width: 100%;" required="required">
                                    <option  value="" selected>সিটি  নির্বাচন করুন</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="c_upz_name" >সিটি - কর্পোরেশন</label>
                                <select id="c_upz_name" name ="c_upzid" class="form-control select2 co_name"  style="width: 100%;" required="required">
                                    <option value="" selected>সিটি - কর্পোরেশন  নির্বাচন করুন</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="c_uni_name" >থানা</label>
                                <select id="c_uni_name" name ="c_uniid" class="form-control select2 thana_name" style="width: 100%;" required="required">
                                    <option value="" selected>থানা  নির্বাচন করুন</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="c_ward_name" >ওয়ার্ড</label>
                                <select id="c_ward_name" name ="c_wardid" class="form-control select2 c_ward_name" style="width: 100%;" required="required">
                                    <option value="" selected>ওয়ার্ড  নির্বাচন করুন</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>পার্লার ধরন</label>
                            <select class="form-control select2 p_type" name="p_type" style="width: 100%;" required>
                                <option value="" selected>পার্লার ধরন  নির্বাচন করুন</option>
                                <option value="ইন্সটিটিউশন">ইন্সটিটিউশন</option>
                                <option value="প্রাইভেট">প্রাইভেট</option>
                                <option value="লেডিস/জেন্টস">লেডিস/জেন্টস</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>জেন্ডার ধরন</label>
                            <select class="form-control select2 g_type" name="g_type" style="width: 100%;" required>
                                <option value="" selected>জেন্ডার ধরন  নির্বাচন করুন</option>
                                <option value="জেন্টস">জেন্টস</option>
                                <option value="লেডিস">লেডিস</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">সার্ভিস নাম</label>
                            <input type="text" class="form-control service" id="service"  name="service" placeholder="নাম লিখুন" required>
                        </div>
                        <div class="form-group">
                            <label for="">দাম </label>
                            <input type="number" class="form-control price" id="price"  name="price" placeholder="দাম লিখুন" required>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="id" id="id" class="id">
                        <button type="submit" class="btn btn-primary">সেভ করুন</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">পার্লার সার্ভিস  লিস্ট </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>ঠিকানা</th>
                            <th>পার্লার ধরন</th>
                            <th>জেন্ডার</th>
                            <th>পার্লার সার্ভিস  </th>
                            <th>দাম  </th>
                            <th>টুল</th>
                        </tr>
                        @foreach($p_services as $p_service)
                            <tr>
                                <td> {{$p_service['a1'].', '.$p_service['a2'].', '.$p_service['a3'].', '.$p_service['a4'].', '.$p_service['a5']}} </td>
                                <td> {{$p_service['p_type']}} </td>
                                <td> {{$p_service['gender_type']}} </td>
                                <td> {{$p_service['service']}} </td>
                                <td> {{$p_service['price']}} </td>
                                <td class="td-actions text-center">
                                    <button type="button" rel="tooltip" class="btn btn-success edit" data-id="{{$p_service['id']}}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" rel="tooltip"  class="btn btn-danger delete" data-id="{{$p_service['id']}}">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $p_services->links() }}
                    <div class="modal modal-danger fade" id="modal-danger">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">মুছে ফেলতে চান</h4>
                                </div>
                                <div class="modal-body">
                                    <center><p>মুছে ফেলতে চান?</p></center>
                                </div>
                                <div class="modal-footer">
                                    {{ Form::open(array('url' => 'deleteParlorService',  'method' => 'post')) }}
                                    {{ csrf_field() }}
                                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">না</button>
                                    <button type="submit" class="btn btn-outline">হ্যা</button>
                                    <input type="hidden" name="id" id="id" class="id">
                                    {{ Form::close() }}
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
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
        $(function(){
            $('.select2').select2()
            $(document).on('click', '.edit', function(e){
                e.preventDefault();
                $('.divform').show();
                var id = $(this).data('id');
                getRow(id);
            });
            $(document).on('click', '.delete', function(e){
                e.preventDefault();
                $('#modal-danger').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });
        });
        function getRow(id){
            $.ajax({
                type: 'POST',
                url: 'getParlorServiceById',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    $('.p_type').val(data.p_type);
                    $('.g_type').val(data.gender_type);
                    $('.service').val(data.service);
                    $('.price').val(data.price);
                    $('.id').val(data.id);
                    $('.select2').select2()
                }
            });
        }
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
