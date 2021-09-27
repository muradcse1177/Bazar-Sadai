@extends('backend.layout')
@section('title', ' পন্য ডেলিভারি চার্জ')
@section('page_header', 'ডেলিভারি চার্জ  ব্যবস্থাপনা')
@section('deliveryLiAdd','active')
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
                    {{ Form::open(array('url' => 'insertDeliveryCharge',  'method' => 'post')) }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="">সর্বনিম্ন টাকা</label>
                            <input type="number"  class="form-control lower" id="lower"   name="lower" placeholder="সর্বনিম্ন টাকা চার্জ লিখুন" required>
                        </div>
                        <div class="form-group">
                            <label for="">সরবোচ্চ টাকা</label>
                            <input type="number"  class="form-control higher" id="higher"   name="higher" placeholder="সরবোচ্চ টাকা চার্জ লিখুন" required>
                        </div>
                        <div class="form-group">
                            <label for="">পন্য ডেলিভারি চার্জ</label>
                            <input type="number"  class="form-control name" id="name"   name="name" placeholder="পন্য ডেলিভারি চার্জ লিখুন" required>
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
                    <h3 class="box-title">পন্য ডেলিভারি চার্জ</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>সর্বনিম্ন</th>
                            <th>সরবোচ্চ টাকা</th>
                            <th>টুল</th>
                        </tr>
                        @foreach($delivery_charges as $delivery_charge)
                            <tr>
                                <td> {{ $delivery_charge->lower }} </td>
                                <td> {{ $delivery_charge->higher }} </td>
                                <td> {{ $delivery_charge->charge }} </td>
                                <td class="td-actions text-center">
                                    <button type="button" rel="tooltip" class="btn btn-success edit" data-id="{{$delivery_charge->id}}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function(){
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

            });
        });
        $(function(){
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
                url: 'getDeliveryCharge',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    $('#name').val(data.charge);
                    $('.id').val(data.id);
                    $('.lower').val(data.lower);
                    $('.higher').val(data.higher);
                }
            });
        }
    </script>
@endsection
