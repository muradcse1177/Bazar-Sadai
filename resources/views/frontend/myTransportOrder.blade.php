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
                                    <h4 class="box-title"><i class="fa fa-calendar"></i> <b>আপনার লিস্ট</b></h4>
                                    <div class="box-body table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>তারিখ</th>
                                                <th>যানবহন</th>
                                                <th>ইউজার</th>
                                                <th>ফ্রম</th>
                                                <th>টু</th>
                                                <th>ইউজার দুরত্ত্ব</th>
                                                <th>ইউজার খরচ</th>
                                                <th>রাইডার দুরত্ত্ব</th>
                                                <th>রাইডার খরচ</th>
                                            </tr>
                                            @foreach($bookings as $booking)
                                                <tr>
                                                    <td> {{$booking['date']}} </td>
                                                    <td> {{$booking['transport']}} </td>
                                                    <td> {{$booking['user']}} </td>
                                                    <td> {{ $booking['add_part1'].', '.$booking['add_part2'].', '.$booking['add_part3'].', '.$booking['add_part4'] }} </td>
                                                    <td> {{ $booking['add_partp1'].', '.$booking['add_partp2'].', '.$booking['add_partp3'].', '.$booking['add_partp4'] }} </td>
                                                    <td> {{$booking['c_distance']}} </td>
                                                    <td> {{$booking['c_cost']}} </td>
                                                    <td> {{$booking['r_distance']}} </td>
                                                    <td> {{$booking['r_cost']}} </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                        {{ $bookings->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('js')
    <script>

    </script>
@endsection
