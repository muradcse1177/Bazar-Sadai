@extends('backend.layout')
@section('title', 'বিক্রয় রিপোর্ট')
@section('page_header', 'বিক্রয় রিপোর্ট ব্যবস্থাপনা')
@section('salesLiAdd','active')
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
                    {{ Form::open(array('url' => 'getProductSalesOrderListByDate',  'method' => 'post')) }}
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
                            <th>তারিখ</th>
                            <th>ক্রেতার নাম</th>
                            <th>ক্রেতার ফোন</th>
                            <th>ঠিকানা</th>
                            <th>অর্ডার নং</th>
                            <th>পরিমান</th>
                            <th>দায়িত্ত্ব</th>
                            <th>ফোন</th>
                            <th>অবস্থা</th>
                            <th>বিস্তারিত</th>
                        </tr>
                        @foreach($orders as $order)
                          <tr>
                            <td>{{$order['sales_date']}}</td>
                            <td>{{$order['name']}}</td>
                            <td>{{$order['phone']}}</td>
                            <td>{{$order['address']}}</td>
                            <td>{{$order['pay_id']}}</td>
                            <td> {{$order['amount']}}</td>
                            <td>{{$order['v_name']}}</td>
                            <td>{{$order['v_phone']}}</td>
                            <td>
                                <div class="form-group">
                                    <select class="form-control  status" name="status" style="width: 100%;" required>
                                        <option value="Received&{{$order['sales_id']}}" @if($order['status'] == 'Received'){{'Selected'}} @endif>Received</option>
                                        <option value="Processing&{{$order['sales_id']}}" @if($order['status'] == 'Processing'){{'Selected'}} @endif>Processing</option>
                                        <option value="Shipped&{{$order['sales_id']}}" @if($order['status'] == 'Shipped'){{'Selected'}} @endif>Shipped</option>
                                        <option value="Delivered&{{$order['sales_id']}}" @if($order['status'] == 'Delivered'){{'Selected'}} @endif>Delivered</option>
                                    </select>
                                </div>
                            </td>
                            <td><button type='button' class='btn btn-info btn-sm btn-flat transact' data-id='{{$order['sales_id']}}'><i class='fa fa-search'></i> বিস্তারিত</button></td>
                          </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" align="right"><b>Total</b></td>
                            <td colspan="5"><b>{{$sum.'/-'}}</b> </td>
                        </tr>
                    </table>
                    {{ $orders->links() }}
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="transaction">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><b>বিস্তারিত ট্রানজেকশন</b></h4>
                </div>
                <div class="modal-body">
                    <p>
                        তারিখ: <span id="date"></span>
                        <span class="pull-right">ট্রানজেকশন: <span id="transid"></span></span>
                    </p>
                    <table class="table table-bordered">
                        <thead>
                        <th>পণ্য</th>
                        <th>দাম</th>
                        <th>পরিমান</th>
                        <th>মোট</th>
                        </thead>
                        <tbody id="detail">
                        <tr>
                            <td colspan="3" align="right"><b> ডেলিভারি চার্জ </b></td>
                            <td><span id="delivery"></span></td>
                        </tr> <tr>
                            <td colspan="3" align="right"><b> ছাড় </b></td>
                            <td><span id="discount"></span></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="right"><b>সর্বমোট </b></td>
                            <td><span id="total"></span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
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
                url: 'changeOrderStatus',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    location.reload();
                }
            });
        });
        $(function(){
            $(document).on('click', '.transact', function(e){
                e.preventDefault();
                $('#transaction').modal('show');
                var id = $(this).data('id');
                console.log(id);
                $.ajax({
                    type: 'POST',
                    url: 'transaction',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id
                    },
                    dataType: 'json',
                    success:function(response){
                        $('#date').html(response.data.date);
                        $('#transid').html(response.data.transaction);
                        $('#detail').prepend(response.data.list);
                        $('#total').html(response.data.total);
                        $('#delivery').html(response.data.delivery_charge);
                        $('#discount').html(response.data.discount);
                    }
                });
            });

            $("#transaction").on("hidden.bs.modal", function () {
                $('.prepend_items').remove();
            });
        });
    </script>
@endsection
