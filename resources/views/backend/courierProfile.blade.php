@extends('backend.layout')
@section('title','আমার প্রোফাইল প্রোফাইল')
@section('page_header', 'আমার প্রোফাইল ব্যবস্থাপনা')
@section('courierProfile','active')
@section('content')
@section('extracss')
    <style>
        .allButton{
            background-color: darkgreen;
            margin-top: 10px;
            color: white;
        }
        .medicine_text{
            color: darkgreen;
            font-size: 20px;
        }
    </style>
@endsection
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
        <div class="box box-primary">
            <div class="box-header with-border">
                <h4 class="box-title"><i class="fa fa-calendar"></i> <b>আপনার লিস্ট</b></h4>
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>তারিখ</th>
                            <th>পে আইডি</th>
                            <th>স্ট্যাটাস</th>
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
                                <td>
                                    <button type="button" rel="tooltip" class="btn btn-success edit" data-id="{{$booking['id']}}">
                                        <i class="fa fa-edit"></i>{{$booking['status']}}
                                    </button>
                                </td>
                                <td>
                                    <button type="button" rel="tooltip" class="btn btn-success msg" data-msg="{{$booking['cc_id']}}">
                                        <i class="fa fa-edit"></i> Set Message
                                    </button>
                                </td>
                                <td>
                                    <button type="button" rel="tooltip" class="btn btn-success status" data-m="{{$booking['cc_id']}}">
                                        <i class="fa fa-eye"></i> Status
                                    </button>
                                </td>
                                <td> {{$booking['user']}} </td>
                                <td> {{$booking['user_phone']}} </td>
                                <td> {{$booking['cost'].'/-'}} </td>
                                <td> {{$booking['weight']}} </td>
                                <td> {{$booking['n_name']}} </td>
                                <td> {{ $booking['add_part1'].', '.$booking['add_part2'].', '.$booking['add_part3'].', '.$booking['add_part4'] }} </td>
                                <td> {{ $booking['add_part1C'].', '.$booking['add_part2C'].', '.$booking['add_part3C'].', '.$booking['add_part4C'].', '.$booking['add_part5C'].', '.$booking['address'] }} </td>

                            </tr>
                        @endforeach
                    </table>
                    {{ $bookings->links() }}
                </div>
                <div class="modal fade"  tabindex="-1"   id="statusModal"  role="dialog">
                    <div class="modal-dialog modal-medium">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">স্ট্যাটাস</h4>
                            </div>
                            {{ Form::open(array('url' => 'changeCourierStatus',  'method' => 'post')) }}
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>স্ট্যাটাস</label>
                                        <select class="form-control select2 status" name="status" style="width: 100%;" required>
                                            <option value="" selected>স্ট্যাটাস  নির্বাচন করুন</option>
                                            <option value="On the way">On the way</option>
                                            <option value="Delivered">Delivered</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="id" id="id" class="id">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success btn-flat contact"><i class="fa fa-check-square-o"></i> Save</button>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                <div class="modal fade"  tabindex="-1"   id="msgModal"  role="dialog">
                    <div class="modal-dialog modal-medium">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">মেসেজ স্ট্যাটাস</h4>
                            </div>
                            {{ Form::open(array('url' => 'changeCourierMessage',  'method' => 'post')) }}
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="box-body">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="">মেসেজ</label>
                                            <input type="text" class="form-control message" id="message"  name="message" placeholder="মেসেজ" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="msg" id="msg" class="msg">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success btn-flat contact"><i class="fa fa-check-square-o"></i> Save</button>
                            </div>
                            {{ Form::close() }}
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
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('js')
    <script>
        $(function(){
            $(document).on('click', '.edit', function(e){
                e.preventDefault();
                $('#statusModal').modal('show');
                var id = $(this).data('id');
                $('#id').val(id);
            });
            $(document).on('click', '.msg', function(e){
                e.preventDefault();
                $('#msgModal').modal('show');
                var msg = $(this).data('msg');
                $('#msg').val(msg);
            });
            $(document).on('click', '.status', function(e){
                e.preventDefault();
                var msgId = $(this).data('m');
                $('#msgStatusModal').modal('show');
                $.ajax({
                    type: 'GET',
                    url: 'getCourierMessage',
                    data: {id:msgId},
                    success: function(response){
                        var data = response.output;
                        //console.log(data);
                        $('#statusBody').html(data.list);
                    }
                });
            });
        });

    </script>
@endsection
