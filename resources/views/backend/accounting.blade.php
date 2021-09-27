@extends('backend.layout')
@section('title','হিসাব')
@section('page_header', 'হিসাব ব্যবস্থাপনা')
@section('accountingLiAdd','active')
@section('content')
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
                    <h3 class="box-title rembut2" ><button type="button" class="btn btn-block btn-success btn-flat"><i class="fa fa-eye"></i> রিপোর্ট দেখুন </button></h3>
                    <h3 class="box-title" ><a href="{{url('accountName')}}" target="_blank" type="button" class="btn btn-block btn-success btn-flat"><i class="fa fa-plus-square"></i> হিসাবের নাম </a></h3>
                    <h3 class="box-title" ><a href="{{url('accountHead')}}" target="_blank" type="button" class="btn btn-block btn-success btn-flat"> <i class="fa fa-plus-square"></i> হিসাব হেড </a></button></h3>
                </div>
                <div class="divform" style="display:none">
                    {{ Form::open(array('url' => 'insertAccounting',  'method' => 'post')) }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label>হিসাবের নাম</label>
                            <select class="form-control select2 name_id" name="name_id" style="width: 100%;" required>
                                <option value="" selected>হিসাবের নাম নির্বাচন করুন</option>
                                @foreach($names as $a)
                                    <option value="{{$a->id}}">{{$a->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>হেড নাম</label>
                            <select class="form-control select2 head_id" name="head_id" style="width: 100%;" required>
                                <option value="" selected>হেড নাম নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>হিসাব ধরণ নাম</label>
                            <select class="form-control select2 type" name="type" style="width: 100%;" required>
                                <option value="" selected>হিসাব ধরণ  নির্বাচন করুন</option>
                                <option value="Cash In" >Cash In</option>
                                <option value="Cash Out" >Cash Out</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">তারিখ</label>
                            <input type="text" class="form-control date" id="date"  name="date" placeholder="তারিখ লিখুন" required>
                        </div>
                        <div class="form-group">
                            <label for="">পারপাস</label>
                            <input type="text" class="form-control purpose" id="purpose"  name="purpose" placeholder="পারপাস লিখুন" required>
                        </div>
                        <div class="form-group">
                            <label for="">প্রাপ্ত ব্যক্তি</label>
                            <input type="text" class="form-control person" id="person"  name="person" placeholder="প্রাপ্ত ব্যক্তি" required>
                        </div>
                        <div class="form-group">
                            <label for="">মোট খরচ</label>
                            <input type="number" class="form-control amount" id="amount"  name="amount" placeholder="পরিমান লিখুন" required>
                        </div>
                        <div class="form-group">
                            <label for="">পরিশোধিত টাকার পরিমান</label>
                            <input type="number" class="form-control amount1" id="amount1"  name="amount1" placeholder="পরিমান লিখুন" required>
                        </div>
                        <div class="form-group">
                            <label for="">বাকি আছে</label>
                            <input type="number" class="form-control amount2" id="amount2"  name="amount2" placeholder="পরিমান লিখুন" required>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="id" id="id" class="id">
                        <button type="submit" class="btn allButton">সেভ করুন</button>
                    </div>
                    {{ Form::close() }}
                </div>
                <div class="divform2" style="display:none;">
                    {{ Form::open(array('url' => 'getAccountingReportByDate',  'method' => 'post')) }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label>হিসাবের নাম</label>
                            <select class="form-control select2 name_id" name="name_id" style="width: 100%;" required>
                                <option value="" selected>হিসাবের নাম নির্বাচন করুন</option>
                                @foreach($names as $a)
                                    <option value="{{$a->id}}">{{$a->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>হেড নাম</label>
                            <select class="form-control select2 head_id" name="head_id" style="width: 100%;" required>
                                <option value="" selected>হেড নাম নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">ফ্রম ডেট</label>
                            <input type="text" class="form-control from_date" id="from_date"  name="from_date" placeholder="ফ্রম ডেট লিখুন" required value="@if(isset($from_date)){{$from_date}} @endif">
                        </div>
                        <div class="form-group">
                            <label for="">টু ডেট</label>
                            <input type="text" class="form-control to_date" id="to_date"  name="to_date" placeholder="টু ডেট লিখুন" required value="@if(isset($to_date)){{$to_date}} @endif">
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="id" id="id" class="id">
                        <button type="submit" class="btn allButton">সাবমিট</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">হিসাব  লিস্ট </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>টুল</th>
                            <th>তারিখ  </th>
                            <th>হিসাবের নাম </th>
                            <th>হিসাবের হেড নাম </th>
                            <th>হিসাব ধরণ  </th>
                            <th>পারপাস  </th>
                            <th>ব্যক্তি  </th>
                            <th>মোট খরচ</th>
                            <th>দেওয়া হয়েছে</th>
                            <th>বাকি আছে</th>
                        </tr>
                        @php
                          $sum=0;
                          $sum1=0;
                          $sum2=0;
                        @endphp
                        @foreach($accountings as $accounting)
                            <tr>
                                <td class="td-actions text-center">
                                    <button type="button" rel="tooltip" class="btn btn-success edit" data-id="{{$accounting->acc_id}}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </td>
                                <td style="text-align: right;"> {{$accounting-> date}} </td>
                                <td style="text-align: right;"> {{$accounting-> name}} </td>
                                <td style="text-align: right;"> {{$accounting-> head}} </td>
                                <td style="text-align: right;"> {{$accounting->type}} </td>
                                <td style="text-align: right;"> {{$accounting->purpose}} </td>
                                <td style="text-align: right;"> {{$accounting->person}} </td>
                                <td style="text-align: right;"> {{$accounting->amount}}/- </td>
                                <td style="text-align: right;"> {{$accounting->amount1}}/- </td>
                                <td style="text-align: right;"> {{$accounting->amount2}}/- </td>
                                @php
                                    $sum = $sum + $accounting->amount;
                                    $sum1 = $sum1 + $accounting->amount1;
                                    $sum2 = $sum2 + $accounting->amount2;
                                @endphp
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="7" style="text-align: right;"><b>মোটঃ-</b></td>
                            <td style="text-align: right;"><b>{{$sum}} /-</b></td>
                            <td style="text-align: right;"><b>{{$sum1}} /-</b></td>
                            <td style="text-align: right;"><b>{{$sum2}} /-</b></td>
                        </tr>
                        <tr>
                            <td colspan="7" style="text-align: right;"><b>ব্যালান্স:-</b> </td>
                            <td colspan="3" style="text-align: center;"><b>{{$sum-($sum1+$sum2)}} /-</b></td>
                        </tr>
                    </table>
                    {{ $accountings->links() }}
                </div>
            </div>
        </div>
    </div>


@endsection
@section('js')
    <script>
        $( function() {
            $('#date').datepicker({
                autoclose: true,
                dateFormat: "yy-m-dd",
            })
        } );
        $( function() {
            $('#from_date').datepicker({
                autoclose: true,
                dateFormat: "yy-m-dd",
            })
        } );
        $( function() {
            $('#to_date').datepicker({
                autoclose: true,
                dateFormat: "yy-m-dd",
            })
        } );
        $(document).ready(function(){
            $(".addbut").click(function(){
                $(".divform").show();
                $(".rembut").show();
                $(".addbut").hide();
                $(".divform2").hide();
            });
            $(".rembut").click(function(){
                $(".divform").hide();
                $(".addbut").show();
                $(".rembut").hide();
                $(".divform2").hide();
            });
            $(".rembut2").click(function(){
                $(".divform2").show();
                $(".divform").hide();
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
        });
        function getRow(id){
            $.ajax({
                type: 'POST',
                url: 'getAccountingListById',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    $('.type').val(data.type);
                    $('.date').val(data.date);
                    $('.purpose').val(data.purpose);
                    $('.amount').val(data.amount);
                    $('.person').val(data.person);
                    $('.amount1').val(data.amount1);
                    $('.amount2').val(data.amount2);
                    $('.id').val(data.id);
                    $('.select2').select2()
                }
            });
        }
        $(".name_id").change(function(){
            var id =$(this).val();
            $('.head_id').find('option:not(:first)').remove();
            $.ajax({
                type: 'GET',
                url: 'getAccountHeadListAll',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['head'];
                        $(".head_id").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
    </script>
@endsection
