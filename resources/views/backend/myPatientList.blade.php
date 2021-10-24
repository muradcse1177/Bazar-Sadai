@extends('backend.layout')
@section('title', 'পেশেন্ট')
@section('page_header', 'পেশেন্ট ব্যবস্থাপনা')
@section('myPatientList','active')
@section('extracss')
@endsection
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
                    {{ Form::open(array('url' => 'myPatientListByDate',  'method' => 'post')) }}
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
                    <h3 class="box-title">পেশেন্ট লিস্ট </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>তারিখ</th>
                            <th>আইডি</th>
                            <th>জুম লিংক</th>
                            <th>প্রেসক্রিপশন</th>
                            <th>পেশেন্ট নাম</th>
                            <th>পেশেন্ট ফোন</th>
                            <th>পেশেন্ট বয়স</th>
                            <th>সময়</th>
                            <th>হোয়াটস এপ </th>
                            <th>সমস্যা</th>
                            <th>ফিস</th>
                        </tr>
                        @foreach($drReports as $drReport)
                            <tr>
                                <td> {{$drReport-> date}} </td>
                                <td> {{$drReport-> a_id}} </td>
                                <td class="td-actions">
                                    <button type="button" rel="tooltip" class="btn btn-success link" data-id="{{$drReport->a_id}}">
                                        <i class="fa fa-video-camera"></i>
                                    </button>
                                </td>
                                <td class="td-actions">
                                    <button type="button" rel="tooltip" class="btn btn-success prescription" data-id="{{$drReport->a_id}}">
                                        Prescription
                                    </button>
                                </td>
                                <td> {{$drReport->patient_name}} </td>
                                <td> {{$drReport->p_phone}} </td>
                                <td> {{$drReport->age}} </td>
                                <td> {{$drReport->serial}} </td>
                                <td> {{$drReport->w_number}} </td>
                                <td> {{$drReport->problem}} </td>
                                <td> {{$drReport->price.'/-'}} </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $drReports->links() }}
                </div>
                <div class="modal fade"  tabindex="-1"   id="distance"  role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">জুম লিংক</h4>
                            </div>
                            {{ Form::open(array('url' => 'updateZoomLink',  'method' => 'post')) }}
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <input class="form-control" name="link" id="link" placeholder="জুম লিংক সেট করুন">
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="id" id="id" class="id">
                                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">সেভ করুন</button>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                <div class="modal fade"  tabindex="-1"   id="pr_modal"  role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">প্রেসক্রিপশন</h4>
                            </div>
                            {{ Form::open(array('url' => 'updatePrescription',  'method' => 'post')) }}
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <textarea class="form-control pre" name="pre" id="pre" rows="7" placeholder="প্রেসক্রিপশন লিখুন"></textarea>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="idPre" id="idPre" class="idPre">
                                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">সেভ করুন</button>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
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
        $(document).on('click', '.link', function(e){
            e.preventDefault();
            var id = $(this).data('id');
            $('.id').val(id);
            $('#distance').modal('show');
        });
        $(document).on('click', '.prescription', function(e){
            e.preventDefault();
            var id = $(this).data('id');
            $('.idPre').val(id);
            $('#pr_modal').modal('show');
            getRow(id);
        });
        function getRow(id){
            $.ajax({
                type: 'POST',
                url: 'getPrescriptionList',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    $('.pre').html(data.prescription);

                }
            });
        }
    </script>
@endsection
