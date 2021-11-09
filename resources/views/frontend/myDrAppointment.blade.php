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
                                    <h4 class="box-title"><i class="fa fa-calendar"></i> <b>আপনার ডাক্তার এপয়েনমেনট লিস্ট</b></h4>
                                    <div class="box-body table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>তারিখ</th>
                                                <th>টাইপ</th>
                                                <th>আইডি</th>
                                                <th>ডাক্তার নাম</th>
                                                <th>ডাক্তার ফোন নং</th>
                                                <th>জুম লিংক</th>
                                                <th>পেশেন্ট নাম</th>
                                                <th>পেশেন্ট ফোন</th>
                                                <th>প্রেসক্রিপশন</th>
                                                <th>পেশেন্ট বয়স</th>
                                                <th>সময়</th>
                                                <th>হোয়াটস এপ </th>
                                                <th>সমস্যা</th>
                                                <th>ফিস</th>
                                            </tr>
                                            <?php
                                            $sum =0;
                                            ?>
                                            @foreach($drReports as $drReport)
                                                @php
                                                    $sum= $sum +$drReport->price;
                                                    if($drReport->zoom_link){
                                                        $link = $drReport->zoom_link;
                                                        $z_linka = 'Zoom Link';
                                                    }
                                                    else{
                                                        $link = null;
                                                         $z_link = 'Not Set Yet';
                                                    }

                                                @endphp
                                                <tr>
                                                    <td> {{$drReport-> date}} </td>
                                                    <td> {{$drReport->type}} </td>
                                                    <td> {{$drReport->a_id}} </td>
                                                    <td> {{$drReport->dr_name}} </td>
                                                    <td> {{$drReport->dr_phone}} </td>
                                                    @if($link)
                                                        <td class="td-actions">
                                                            <button type="button" rel="tooltip" class="btn btn-success link">
                                                                <a href="{{$link}}">{{$z_linka}}</a>
                                                            </button>
                                                        </td>
                                                    @else
                                                        <td class="td-actions">
                                                            <button type="button" rel="tooltip" class="btn btn-success link">
                                                               {{$z_link}}
                                                            </button>
                                                        </td>
                                                    @endif
                                                    <td> {{$drReport->patient_name}} </td>
                                                    <td> {{$drReport->p_phone}} </td>
                                                    <td class="td-actions">
                                                        {!! $drReport->prescription !!}
                                                    </td>
                                                    <td> {{$drReport->age}} </td>
                                                    <td> {{$drReport->serial}} </td>
                                                    <td> {{$drReport->w_number}} </td>
                                                    <td> {{$drReport->problem}} </td>
                                                    <td> {{$drReport->price.'/-'}} </td>
                                                </tr>
                                                <?php $link = ""; ?>
                                            @endforeach
                                            <tr>
                                                <td colspan="12" style="text-align: right"><b>মোটঃ</b></td>
                                                <td><b>{{$sum.'/-'}}</b></td>
                                            </tr>
                                        </table>
                                        {{ $drReports->links() }}
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
