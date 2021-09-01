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
                                    <h4 class="box-title"><i class="fa fa-calendar"></i> <b>আপনার বুকিং লিস্ট</b></h4>
                                    <div class="box-body table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>ফটো</th>
                                                <th>তারিখ</th>
                                                <th>অর্ডার নাম্বার</th>
                                                <th>বুকিং</th>
                                                <th>নাম</th>
                                                <th>ঠিকানা</th>
                                                <th>পরিমান</th>
                                                <th>ফ্রম</th>
                                                <th>টু</th>
                                                <th>দাম</th>
                                            </tr>
                                            @foreach($orders as $order)
                                                <tr>
                                                    <td><img src="{{$order->cover_photo}}" height="50" width="50">  </td>
                                                    <td> {{$order->date}} </td>
                                                    <td> {{$order->tx_id}} </td>
                                                    <td> {{$order->bookingName}} </td>
                                                    <td> {{$order->name}} </td>
                                                    <td> {{$order->address}} </td>
                                                    <td> {{$order->room_no}} </td>
                                                    @if($order->bookingName == 'ট্যুর প্যাকেজ')
                                                        <td></td>
                                                        <td></td>
                                                    @else
                                                        <td> {{$order->startDate}} </td>
                                                        <td> {{$order->endDate}} </td>
                                                    @endif
                                                    <td> {{$order->f_price.'/-'}} </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                        {{ $orders->links() }}
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
    <script>

    </script>
@endsection
