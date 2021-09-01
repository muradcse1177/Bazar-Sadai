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
                                                <th>অর্ডার আইডি</th>
                                                <th>মেসেজ</th>
                                                <th>স্ট্যাটাস</th>
                                                <th>ইউজার</th>
                                                <th>ফোন</th>
                                                <th>ওজন</th>
                                                <th>খরচ</th>
                                                <th>দেশ</th>
                                                <th>ফ্রম</th>
                                                <th>টু</th>
                                            </tr>
                                            @foreach($bookings as $booking)
                                                <tr>
                                                    <td> {{$booking['date']}} </td>
                                                    <td> {{$booking['tx_id']}} </td>
                                                    <td> {{$booking['status']}}</td>
                                                    <td>
                                                        <button type="button" rel="tooltip" class="btn btn-success status" data-m="{{$booking['cc_id']}}">
                                                            <i class="fa fa-eye"></i> Status
                                                        </button>
                                                    </td>
                                                    <td> {{$booking['user']}} </td>
                                                    <td> {{$booking['user_phone']}} </td>
                                                    <td> {{$booking['weight']}} </td>
                                                    <td> {{$booking['cost'].'/-'}} </td>
                                                    <td> {{$booking['n_name']}} </td>
                                                    <td> {{ $booking['add_part1'].', '.$booking['add_part2'].', '.$booking['add_part3'].', '.$booking['add_part4'] }} </td>
                                                    <td> {{ $booking['add_part1C'].', '.$booking['add_part2C'].', '.$booking['add_part3C'].', '.$booking['add_part4C'].', '.$booking['add_part5C'].', '.$booking['address'] }} </td>

                                                </tr>
                                            @endforeach
                                        </table>
                                        {{ $bookings->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade"  tabindex="-1"   id="msgStatusModal"  role="dialog">
                            <div class="modal-dialog modal-medium">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">মেসেজ স্ট্যাটাস</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="box-body">
                                            <div id="statusBody">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
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
        $(document).on('click', '.status', function(e){
            e.preventDefault();
            var msgId = $(this).data('m');
            $('#msgStatusModal').modal('show');
            $.ajax({
                type: 'GET',
                url: 'getCourierMessageBuyer',
                data: {id:msgId},
                success: function(response){
                    var data = response.output;
                    //console.log(data);
                    $('#statusBody').html(data.list);
                }
            });
        });
    </script>
@endsection
