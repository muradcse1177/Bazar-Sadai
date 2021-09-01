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
                                                <th>কুকার নাম</th>
                                                <th>কুকার ফোন</th>
                                                <th>ধরণ</th>
                                                <th>দিন</th>
                                                <th>মিল</th>
                                                <th>জন</th>
                                                <th>সময়</th>
                                                <th>দাম</th>
                                            </tr>
                                            @foreach($cookings as $cooking)
                                                <tr>
                                                    <td>{{$cooking->date}}</td>
                                                    <td>{{$cooking->u_name}}</td>
                                                    <td>{{$cooking->u_phone}}</td>
                                                    <td>{{$cooking->name}}</td>
                                                    <td>{{$cooking->phone}}</td>
                                                    <td>{{$cooking->cooking_type}}</td>
                                                    <td>{{$cooking->days}}</td>
                                                    <td>{{$cooking->meal}}</td>
                                                    <td>{{$cooking->person}}</td>
                                                    <td>{{$cooking->time}}</td>
                                                    <td>{{$cooking->price.'/-'}}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                        {{ $cookings->links() }}
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
