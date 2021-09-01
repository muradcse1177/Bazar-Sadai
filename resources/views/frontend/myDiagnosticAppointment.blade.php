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
                                    <h4 class="box-title"><i class="fa fa-calendar"></i> <b>আপনার ডায়াগনস্টিক এপয়েনমেনট লিস্ট</b></h4>
                                    <div class="box-body table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>তারিখ</th>
                                                <th>ডায়াগনস্টিক নাম</th>
                                                <th>ডায়াগনস্টিক সেন্টার</th>
                                                <th>পেশেন্ট নাম</th>
                                                <th>পেশেন্ট ফোন</th>
                                                <th>পেশেন্ট বয়স</th>
                                                <th>সিরিয়াল</th>
                                                <th>ঠিকানা</th>
                                                <th>সমস্যা</th>
                                                <th>ফিস</th>
                                            </tr>
                                            <?php
                                            $sum =0;
                                            ?>
                                            @foreach($diagnosticReports as $diagnosticReport)
                                                @php
                                                    $sum= $sum +$diagnosticReport->price;
                                                @endphp

                                                <tr>
                                                    <td> {{$diagnosticReport-> date}} </td>
                                                    <td> {{$diagnosticReport->name}} </td>
                                                    <td> {{$diagnosticReport->center_name}} </td>
                                                    <td> {{$diagnosticReport->patient_name}} </td>
                                                    <td> {{$diagnosticReport->phone}} </td>
                                                    <td> {{$diagnosticReport->age}} </td>
                                                    <td> {{$diagnosticReport->serial}} </td>
                                                    <td> {{$diagnosticReport->address}} </td>
                                                    <td> {{$diagnosticReport->problem}} </td>
                                                    <td> {{$diagnosticReport->price.'/-'}} </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="9" style="text-align: right"><b>মোটঃ</b></td>
                                                <td><b>{{$sum.'/-'}}</b></td>
                                            </tr>
                                        </table>
                                        {{ $diagnosticReports->links() }}
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
