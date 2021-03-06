@extends('backend.layout')
@section('title','থেরাপি ফিস')
@section('page_header', 'থেরাপি ফিস ব্যবস্থাপনা')
@section('serviceMainLi','active menu-open')
@section('medicalMainLi','active menu-open')
@section('therapyFees','active')
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
                <div class="box-header with-border">
                    <h3 class="box-title addbut"><button type="button" class="btn btn-block btn-success btn-flat"><i class="fa fa-plus-square"></i> নতুন যোগ করুন </button></h3>
                    <h3 class="box-title rembut" style="display:none;"><button type="button" class="btn btn-block btn-success btn-flat"><i class="fa fa-minus-square"></i> মুছে ফেলুন </button></h3>
                </div>
                <div class="divform" style="display:none">
                    {{ Form::open(array('url' => 'insertTherapyFees',  'method' => 'post')) }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label>থেরাপি সার্ভিস নাম</label>
                            <select class="form-control select2 therapy_service_id" name="therapy_service_id" style="width: 100%;" required>
                                <option value="" selected>থেরাপি সার্ভিস  নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>থেরাপি সেন্টার নাম</label>
                            <select class="form-control select2 therapy_center_id" name="therapy_center_id" style="width: 100%;" required>
                                <option value="" selected>থেরাপি সেন্টার  নির্বাচন করুন</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">থেরাপি ফিস </label>
                            <input type="number" min="1" class="form-control fees" id="fees"  name="fees" placeholder=" ফিস লিখুন" required>
                        </div>
                        <div class="form-group">
                            <label for="">থেরাপি টাইম </label>
                            <input type="number" min="1" class="form-control time" id="time"  name="time"  placeholder=" মিনিট লিখুন" required>
                        </div>
                        <div class="form-group">
                            <label for="">থেরাপি শুরু টাইম </label>
                            <input type="number" class="form-control intime" id="intime"  name="intime" min="0" placeholder="ইন টাইম" required>
                        </div>
                        <div class="form-group">
                            <label>থেরাপি শুরু  টাইম  </label>
                            <select class="form-control select2 intimezone" name="intimezone" id="intimezone" style="width: 100%;" required>
                                <option  value="" selected> থেরাপি শুরু টাইম নির্বাচন করুন</option>
                                <option  value="AM">AM</option>
                                <option  value="PM">PM</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">থেরাপি শেষ টাইম</label>
                            <input type="number" class="form-control outtime" id="outtime"  name="outtime" min="0" placeholder="আউট টাইম" required>
                        </div>
                        <div class="form-group">
                            <label> থেরাপি শেষ টাইম  </label>
                            <select class="form-control select2 outtimezone" name="outtimezone" id="outtimezone" style="width: 100%;" required>
                                <option  value="" selected> থেরাপি শেষ টাইম নির্বাচন করুন</option>
                                <option  value="AM">AM</option>
                                <option  value="PM">PM</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label> থেরাপির দিন সমুহ </label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="saturday" name="days[]" value="Saturday" checked>
                                <label class="form-check-label" for="saturday">Saturday</label>
                                <input type="checkbox" class="form-check-input" id="sunday" name="days[]" value="Sunday" checked>
                                <label class="form-check-label" for="sunday">Sunday</label>
                                <input type="checkbox" class="form-check-input" id="monday" name="days[]" value="Monday" checked>
                                <label class="form-check-label" for="monday">Monday</label>
                                <input type="checkbox" class="form-check-input" id="tuesday" name="days[]" value="Tuesday" checked>
                                <label class="form-check-label" for="tuesday">Tuesday</label>
                                <input type="checkbox" class="form-check-input" id="wednesday" name="days[]" value="Wednesday" checked>
                                <label class="form-check-label" for="wednesday">Wednesday</label>
                                <input type="checkbox" class="form-check-input" id="thursday" name="days[]" value="Thursday" checked>
                                <label class="form-check-label" for="thursday">Thursday</label>
                                <input type="checkbox" class="form-check-input" id="friday" name="days[]" value="Friday" checked>
                                <label class="form-check-label" for="friday">Friday</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label> হোম সার্ভিস দেওয়া হয়? </label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="home" name="home" value="1">
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="id" id="id" class="id">
                        <button type="submit" class="btn btn-primary">সেভ করুন</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">থেরাপি ফিস লিস্ট </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>থেরাপি নাম </th>
                            <th>থেরাপি সেন্টার </th>
                            <th>থেরাপি ফিস </th>
                            <th>সময়(মি) </th>
                            <th>সময়(শু-শে) </th>
                            <th>টুল</th>
                        </tr>
                        @foreach($therapyFeesLists as $therapyFeesList)
                            <tr>
                                <td> {{$therapyFeesList->name}} </td>
                                <td> {{$therapyFeesList->center_name}} </td>
                                <td> {{$therapyFeesList->fees}} </td>
                                <td> {{$therapyFeesList->time}} </td>
                                <td> {{$therapyFeesList->intime.''.$therapyFeesList->intimezone .'-'.$therapyFeesList->outtime.''.$therapyFeesList->outtimezone}} </td>
                                <td class="td-actions text-center">
                                    <button type="button" rel="tooltip" class="btn btn-success edit" data-id="{{$therapyFeesList->th_id}}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" rel="tooltip"  class="btn btn-danger delete" data-id="{{$therapyFeesList->th_id}}">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $therapyFeesLists->links() }}
                    <div class="modal modal-danger fade" id="modal-danger">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">মুছে ফেলতে চান</h4>
                                </div>
                                <div class="modal-body">
                                    <center><p>মুছে ফেলতে চান?</p></center>
                                </div>
                                <div class="modal-footer">
                                    {{ Form::open(array('url' => 'deleteTherapyFees',  'method' => 'post')) }}
                                    {{ csrf_field() }}
                                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">না</button>
                                    <button type="submit" class="btn btn-outline">হ্যা</button>
                                    <input type="hidden" name="id" id="id" class="id">
                                    {{ Form::close() }}
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('js')
    <script>
        $(document).ready(function(){
            $('.select2').select2();
            $(".addbut").click(function(){
                $(".divform").show();
                $(".rembut").show();
                $(".addbut").hide();
            });
            $(".rembut").click(function(){
                $(".divform").hide();
                $(".addbut").show();
                $(".rembut").hide();
            });
            $.ajax({
                url: 'getAllTherapyServiceList',
                type: "GET",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (response) {
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".therapy_service_id").append("<option value='"+id+"'>"+name+"</option>");
                    }

                },
                failure: function (msg) {
                    alert('an error occured');
                }
            });
        });
        $(function(){
            $(document).on('click', '.edit', function(e){
                e.preventDefault();
                $('.divform').show();
                var id = $(this).data('id');
                getRow(id);
            });
            $(document).on('click', '.delete', function(e){
                e.preventDefault();
                $('#modal-danger').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });
            $(".therapy_service_id").change(function(){
                var id =$(this).val();
                $('.therapy_center_id').find('option:not(:first)').remove();
                $.ajax({
                    type: 'GET',
                    url: 'getTherapyCenterById',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        var data = response.data;
                        var len = data.length;
                        for( var i = 0; i<len; i++){
                            var id = data[i]['id'];
                            var name = data[i]['center_name'];
                            $(".therapy_center_id").append("<option value='"+id+"'>"+name+"</option>");
                        }
                    }
                });
            });
        });
        function getRow(id){
            $.ajax({
                type: 'POST',
                url: 'therapyFeesListsById',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'json',
                success: function(response){
                    var data = response.data;
                    $('.fees').val(data.fees);
                    $('.time').val(data.time);
                    $('.intime').val(data.intime);
                    $('.intimezone').val(data.intimezone);
                    $('.outtime').val(data.outtime);
                    $('.outtimezone').val(data.outtimezone);
                    $('.id').val(data.id);
                    $('.select2').select2();
                }
            });
        }
    </script>
@endsection
