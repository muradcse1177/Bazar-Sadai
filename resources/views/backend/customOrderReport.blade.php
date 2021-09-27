@extends('backend.layout')
@section('title', 'বিক্রয় রিপোর্ট')
@section('page_header', 'বিক্রয় রিপোর্ট ব্যবস্থাপনা')
@section('customOrderReport','active')
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
                    {{ Form::open(array('url' => 'customOrderReportListByDate',  'method' => 'get')) }}
                    {{ csrf_field() }}
                    <div class="box-body">
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
                        <button type="submit" class="btn btn-primary">সাবমিট</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">বিক্রয় রিপোর্ট</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>অর্ডার নং</th>
                            <th>ছবি</th>
                            <th>ডেলিভারি তারিখ</th>
                            <th>অবস্থা</th>
                            <th>নাম</th>
                            <th>ফোন</th>
                            <th>ক্যাটেগরি</th>
                            <th>সাব ক্যাটেগরি</th>
                            <th>এপ্রুভাল</th>
                            <th>ঠিকানা</th>
                            <th>বিস্তারিত</th>
                            <th>পরিমান</th>
                            <th>দাম</th>
                        </tr>
                        @foreach($bookings as $booking)
                            <tr>
                                <td>{{$booking['id']}}</td>
                                <td><img src="{{$booking['image']}}" width="100" height="100"></td>
                                <td>{{$booking['date']}}</td>
                                <td style="background-color: #0f253c;">
                                    <div class="form-group">
                                        <select class="form-control  status" name="status" style="width: 100%;" required>
                                            <option value="Processing&{{$booking['id']}}" @if($booking['status'] == 'Processing'){{'Selected'}} @endif>Processing</option>
                                            <option value="Shipped&{{$booking['id']}}" @if($booking['status'] == 'Shipped'){{'Selected'}} @endif>Shipped</option>
                                            <option value="Delivered&{{$booking['id']}}" @if($booking['status'] == 'Delivered'){{'Selected'}} @endif>Delivered</option>
                                            <option value="Canceled&{{$booking['id']}}" @if($booking['status'] == 'Canceled'){{'Selected'}} @endif>Canceled</option>
                                        </select>
                                    </div>
                                </td>

                                <td>{{$booking['name']}}</td>
                                <td>{{$booking['phone']}}</td>
                                <td>{{$booking['category']}}</td>
                                <td>{{$booking['sub_category']}}</td>
                                <td>
                                    @if($booking['seller_id'])
                                        <button class="btn btn-success">{{$booking['seller_id']}}</button>
                                    @else
                                        <button class="btn btn-danger take"  data-id="{{$booking['id']}}">গ্রহণ করুন</button>
                                    @endif
                                </td>
                                <td> {{ $booking['add_part1'].', '.$booking['add_part2'].', '.$booking['add_part3'].', '.$booking['add_part4'].', '.$booking['add_part5'].', '.$booking['address'] }} </td>
                                <td>{!! nl2br($booking['details']) !!}</td>
                                <td><b>{{$booking['amount']}}</b></td>
                                <td><b>{{$booking['price'].' /-'}}</b></td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $bookings->links() }}
                </div>
                <div class="modal modal-danger fade" id="modal-danger">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">আপনি কি অর্ডারটি গ্রহণ করতে চান</h4>
                            </div>
                            <div class="modal-body">
                                <center><p>আপনি কি অর্ডারটি গ্রহণ করতে চান?</p></center>
                            </div>
                            <div class="modal-footer">
                                {{ Form::open(array('url' => 'ConfirmSellerOrder',  'method' => 'post')) }}
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

@endsection
@section('js')
    <script>
        $(function(){
            $(document).on('click', '.take', function(e){
                e.preventDefault();
                $('#modal-danger').modal('show');
                var id = $(this).data('id');
                $('.id').val(id);
            });
        });
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
        $(".status").change(function(){
            var id =$(this).val();
            $.ajax({
                type: 'GET',
                url: 'changeCustomOrderStatus',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    location.reload();
                }
            });
        });
    </script>
@endsection
