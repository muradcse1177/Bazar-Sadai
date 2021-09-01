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
                                                <th>নাম</th>
                                                <th>ফোন</th>
                                                <th>হেল্পার নাম</th>
                                                <th>হেল্পার ফোন</th>
                                                <th>দিন</th>
                                                <th>ঘণ্টা</th>
                                                <th>ধরণ</th>
                                                <th>দাম</th>
                                            </tr>
                                            @foreach($washings as $washing)
                                                <tr>
                                                    <td>{{$washing->date}}</td>
                                                    <td>{{$washing->u_name}}</td>
                                                    <td>{{$washing->u_phone}}</td>
                                                    <td>{{$washing->name}}</td>
                                                    <td>{{$washing->phone}}</td>
                                                    <td>{{$washing->days}}</td>
                                                    <td>{{$washing->time}}</td>
                                                    <td>{{$washing->type}}</td>
                                                    <td>{{$washing->price.'/-'}}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                        {{ $washings->links() }}
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
