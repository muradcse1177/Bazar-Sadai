@extends('backend.layout')
@section('title', 'ডাক্তার এপয়েনমেন্ট রিপোর্ট')
@section('page_header', 'ডাক্তার এপয়েনমেন্ট রিপোর্ট ব্যবস্থাপনা')
@section('doctorAppointmentLiAdd','active')
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
                    {{ Form::open(array('url' => 'getDrAppOrderListByDate',  'method' => 'post')) }}
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
                    <h3 class="box-title">ডাক্তার এপয়েনমেন্ট রিপোর্ট</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>তারিখ</th>
                            <th>ডাক্তার নাম</th>
                            <th>টাইপ</th>
                            <th>ডাক্তার ফোন নং</th>
                            <th>পেশেন্ট নাম</th>
                            <th>পেশেন্ট আইডি</th>
                            <th>পেশেন্ট ফোন</th>
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
                            @endphp
                            <tr>
                                <td> {{$drReport-> date}} </td>
                                <td> {{$drReport->dr_name}} </td>
                                <td> {{$drReport->type}} </td>
                                <td> {{$drReport->dr_phone}} </td>
                                <td> {{$drReport->patient_name}} </td>
                                <td> {{$drReport->a_id}} </td>
                                <td> {{$drReport->p_phone}} </td>
                                <td> {{$drReport->age}} </td>
                                <td> {{$drReport->serial}} </td>
                                <td> {{$drReport->w_number}} </td>
                                <td> {{$drReport->problem}} </td>
                                <td> {{$drReport->price.'/-'}} </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="8" style="text-align: right"><b>মোটঃ</b></td>
                            <td><b>{{$sum.'/-'}}</b></td>
                        </tr>
                    </table>
                    {{ $drReports->links() }}
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
    </script>
@endsection
