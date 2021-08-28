@extends('backend.layout')
@section('title', 'পণ্য ইম্পোর্ট')
@section('page_header', 'পণ্য ইম্পোর্ট')
@section('importProduct','active')
@section('extracss')
    <style>
        .allButton{
            background-color: darkgreen;
            margin-top: 10px;
            color: white;
        }
        .medicine_text{
            color: darkgreen;
            font-size: 20px;
        }
    </style>
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
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">বাজার-সদাই পণ্য লিস্ট থেকে আপনার পণ্য ইম্পোর্ট করুন </h3>
            </div>
            {{ Form::open(array('url' => 'importSellerProduct',  'method' => 'post')) }}
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label>পণ্য ক্যাটেগরি</label>
                    <select class="form-control select2 category" name="category" style="width: 100%;" required>
                        <option value="" selected>পণ্য ক্যাটেগরি নির্বাচন করুন</option>
                    </select>
                </div>
                <div class="form-group cDiv" style="display: none;">
                    <label>কোম্পানি নাম</label>
                    <select class="form-control select2 company" name="company" style="width: 100%;" required>
                        <option value="" selected>কোম্পানি নির্বাচন করুন</option>
                    </select>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="med_order" style="display: none;">
                <div class="box-body table-responsive">
                    <table class="table table-bordered productList">
                        <tr>
                            <th>#</th>
                            <th>পরিমান </th>
                            <th>নাম </th>
                            <th>দাম</th>
                            <th>ইউনিট</th>
                            <th>টাইপ</th>
                        </tr>
                    </table>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn allButton">সেভ করুন</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        $('.select2').select2();
        $.ajax({
            url: 'getAllProductCategory',
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                var data = response.data;
                var len = data.length;
                for( var i = 0; i<len; i++){
                    var id = data[i]['id'];
                    var name = data[i]['name'];
                    $(".category").append("<option value='"+id+"'>"+name+"</option>");
                }
            },
            failure: function (msg) {
                alert('an error occured');
            }
        });
        $(".category").change(function(){
            var id =$(this).val();
            if(id == 3){
                $('.cDiv').show();
                $.ajax({
                    url: 'getAllMedicineCompany',
                    type: "GET",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function (response) {
                        var data = response.data;
                        var len = data.length;
                        for( var i = 0; i<len; i++){
                            var id = data[i]['company'];
                            var name = data[i]['company'];
                            $(".company").append("<option value='"+id+"'>"+name+"</option>");
                        }

                    },
                    failure: function (msg) {
                        alert('an error occured');
                    }
                });
            }
        });
        $(".company").change(function(){
            var id =$(this).val();
            if(id) {
                $.ajax({
                    type: 'GET',
                    url: 'selectMedicineByCompany',
                    data: {id: id},
                    dataType: 'json',
                    success: function (response) {
                        $(".productList").find("tr:gt(0)").remove();
                        var trHTML = '';
                        var data = response.data;
                        for(var  i=0; i<data.length; i++) {
                            trHTML +=
                                '<tr>' +
                                    '<td>' +
                                        '<div class="form-check">' +
                                        '<input type="checkbox" class="form-check-input medCheckbox" name="med_id[]"  value="'+ data[i].id  +'"' +
                                        '</div>' +
                                    '</td>' +
                                        '<td>' +
                                        '<div class="form-check">' +
                                        '<input type="text" class="form-check-input quantity" name="quantity[]" size="4" id="q'+data[i].id+'" ' +
                                        '</div>' +
                                    '</td>' +
                                    '<td>' + data[i].name +
                                    '</td>' +
                                    '</td>' +
                                    '<td>' + data[i].price +
                                    '</td>' +
                                    '<td>' + data[i].unit +
                                    '</td>' +
                                    '<td>' + data[i].type +
                                    '</td>' +
                                '</tr>';
                        }
                        $('.productList').append(trHTML);
                        $('.med_order').show();
                    }
                });
            }
            else{
                $.toast({
                    heading: 'দুঃখিত',
                    text: 'কোম্পানি নিরবাচন করুন',
                    showHideTransition: 'slide',
                    icon: 'error'
                })
            }
        });
        $(".category").change(function(){
            var id =$(this).val();
            $('.company').prop('required',false);
            if(id) {
                if(id != 3){
                    $.ajax({
                        type: 'GET',
                        url: 'selectProductByCategory',
                        data: {id: id},
                        dataType: 'json',
                        success: function (response) {
                            $(".productList").find("tr:gt(0)").remove();
                            var trHTML = '';
                            var data = response.data;
                            for(var  i=0; i<data.length; i++) {
                                trHTML +=
                                    '<tr>' +
                                    '<td>' +
                                    '<div class="form-check">' +
                                    '<input type="checkbox" class="form-check-input medCheckbox" name="med_id[]"  value="'+ data[i].id  +'"' +
                                    '</div>' +
                                    '</td>' +
                                    '<td>' +
                                    '<div class="form-check">' +
                                    '<input type="text" class="form-check-input quantity" name="quantity[]" size="4" id="q'+data[i].id+'" ' +
                                    '</div>' +
                                    '</td>' +
                                    '<td>' + data[i].name +
                                    '</td>' +
                                    '</td>' +
                                    '<td>' + data[i].price +
                                    '</td>' +
                                    '<td>' + data[i].unit +
                                    '</td>' +
                                    '<td>' + data[i].type +
                                    '</td>' +
                                    '</tr>';
                            }
                            $('.productList').append(trHTML);
                            $('.med_order').show();
                        }
                    });
                }
                else{
                    $(".productList").find("tr:gt(0)").remove();
                }
            }
            else{
                $.toast({
                    heading: 'দুঃখিত',
                    text: 'ক্যাটেগরি নিরবাচন করুন',
                    showHideTransition: 'slide',
                    icon: 'error'
                })
            }
        });
    </script>
@endsection
