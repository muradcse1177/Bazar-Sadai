@extends('frontend.layout')
@section('title', 'Profile || Bazar-Sadai.com Best online Shop in Bangladesh')
@section('myOrder', 'active')
@section('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{url('public/asset/woolmart/css/style.min.css')}}">
@endsection
@section('content')
    <main class="main">
        <!-- Start of Page Header -->
        <div class="page-header" style="margin-top: -1px;">
            <div class="container">
                <h1 class="page-title mb-0">আমার অর্ডার লিস্ট</h1>
            </div>
        </div>
        <br>
        <div class="page-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
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
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <div class="box-header with-border">
                                    <h4 class="box-title"><i class="fa fa-calendar"></i> <b>আপনার পণ্য ক্রয় লিস্ট</b></h4>
                                    <div class="box-body table-responsive">
                                        <table class="table table-bordered hop-table cart-table">
                                            <tr>
                                                <th>বিস্তারিত</th>
                                                <th>তারিখ</th>
                                                <th>অর্ডার নং</th>
                                                <th>দায়িত্ত্ব</th>
                                                <th>ফোন</th>
                                                <th>অবস্থা</th>
                                                <th>পরিমান</th>
                                            </tr>
                                            @foreach($orders as $order)
                                                <tr>
                                                    <td><button type='button' class='btn btn-secondary btn-sm btn-flat transact' data-id='{{$order['sales_id']}}'><i class='fa fa-search'></i> বিস্তারিত</button></td>
                                                    <td>{{$order['sales_date']}}</td>
                                                    <td>{{$order['pay_id']}}</td>
                                                    <td><a href='{{$order['v_id']}}'><button type='button' class='btn btn-success btn-sm btn-flat'>{{$order['v_name']}} </button></a></td>
                                                    <td><a href="tel:{{$order['deliver_phone']}}"><button type='button' class='btn btn-dark-light btn-sm btn-flat'>{{$order['deliver_phone']}} </button></a></td>
                                                    <td><button type='button' class='btn btn-primary btn-sm btn-flat u_search' data-id='{{$order['user_id']}}'>{{$order['status']}} </button></td>
                                                    <td> {{$order['amount']}}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="6" style="text-align: right"><b>মোটঃ</b></td>
                                                <td><b>{{$sum}}</b></td>
                                            </tr>
                                        </table>
                                        {{ $orders->links() }}
                                        <br>
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
                                                        <span class="pull-right">অর্ডার নম্বর: <span id="transid"></span></span>
                                                    </p>
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <th>পন্য</th>
                                                        <th>দাম</th>
                                                        <th>পরিমান</th>
                                                        <th>মোট</th>
                                                        </thead>
                                                        <tbody id="detail">
                                                        <tr>
                                                            <td colspan="3" align="right"><b> ডেলিভারি চার্জ </b></td>
                                                            <td><span id="delivery"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" align="right"><b>সর্বমোট </b></td>
                                                            <td><span id="total"></span></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-dark btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <br>
@endsection
@section('js')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script>
        $(function(){
            $(document).on('click', '.transact', function(e){
                e.preventDefault();
                $('#transaction').modal('show');
                var id = $(this).data('id');
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
                    }
                });
            });

            $("#transaction").on("hidden.bs.modal", function () {
                $('.prepend_items').remove();
            });
        });
    </script>
@endsection
