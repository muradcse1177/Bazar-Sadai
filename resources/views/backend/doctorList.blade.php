@extends('backend.layout')
@section('title','ডাক্তার')
@section('page_header', 'ডাক্তার ব্যবস্থাপনা')
@section('serviceMainLi','active menu-open')
@section('medicalMainLi','active menu-open')
@section('doctorList','active')
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
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">ডাক্তার লিস্ট </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>নাম </th>
                            <th>ডিপার্টমেন্ট </th>
                            <th>হাশপাতাল </th>
                            <th>পদবী </th>
                            <th>বর্তমান কর্মস্থল  </th>
                            <th>শিক্ষা </th>
                            <th>বিশেষজ্ঞ</th>
                            <th>ফিস</th>
                            <th>টুলস</th>
                            <th>মানুষের জন্য স্ট্যাটাস</th>
                            <th>মানুষের জন্য টুলস</th>
                            <th>মানুষের জন্য ফিস</th>
                        </tr>
                        @foreach($doctorLists as $doctorList)
                            <tr>
                                <td> {{$doctorList->u_name}} </td>
                                <td> {{$doctorList->dept_name}} </td>
                                <td> {{$doctorList->hos_name}} </td>
                                <td> {{$doctorList->designation}} </td>
                                <td> {{$doctorList->current_institute}} </td>
                                <td> {{$doctorList->education}} </td>
                                <td> {{$doctorList->specialized}} </td>
                                <td> {{$doctorList->fees.' /-'}} </td>
                                <td class="td-actions text-center">
                                    <button type="button" rel="tooltip" class="btn btn-success edit" data-id="{{$doctorList->d_id}}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </td>
                                <td class="td-actions text-center">
                                    <a  href="{{url('changeM_statusDoctor?id='.$doctorList->d_id)}}" class="btn btn-success status">
                                       @if($doctorList->m_status==1) {{'Active'}} @else {{'Inactive'}} @endif
                                    </a>
                                </td>
                                <td class="td-actions text-center">
                                    <a  href="{{url('changeM_statusDoctor?id='.$doctorList->d_id)}}" class="btn btn-success status">
                                       @if($doctorList->m_status==1) {{'Active'}} @else {{'Inactive'}} @endif
                                    </a>
                                </td>
                                <td class="td-actions text-center">
                                    <button type="button" rel="tooltip" class="btn btn-danger m_edit" data-id="{{$doctorList->d_id}}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </td>
                                <td> {{@$doctorList->m_fees.' /-'}} </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $doctorLists->links() }}
                </div>
            </div>
            <div class="modal fade"  tabindex="-1"   id="priceChange"  role="dialog">
                <div class="modal-dialog modal-medium">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">ডাক্তার ফিস পরিবর্তন</h4>
                        </div>
                        <div class="modal-body">
                            <div id="modalRes">
                                {{ Form::open(array('url' => 'changeDoctorFees',  'method' => 'post')) }}
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="">নতুন ফিস</label>
                                    <input type="number" class="form-control price" id="price"  name="price" min="1" placeholder="দাম" required>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">না</button>
                            <button type="submit" class="btn btn-success" >সেভ করুন</button>
                            <input type="hidden" name="id" id="id" class="id">
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade"  tabindex="-1"   id="priceChange_m"  role="dialog">
                <div class="modal-dialog modal-medium">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">ডাক্তার(মানুষের জন্য) ফিস পরিবর্তন</h4>
                        </div>
                        <div class="modal-body">
                            <div id="modalRes">
                                {{ Form::open(array('url' => 'changeDoctorFees_m',  'method' => 'post')) }}
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="">নতুন ফিস</label>
                                    <input type="number" class="form-control price" id="price"  name="price" min="1" placeholder="নতুন ফিস" required>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">না</button>
                            <button type="submit" class="btn btn-success" >সেভ করুন</button>
                            <input type="hidden" name="id" id="id" class="id">
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
        $(function(){
            $(document).on('click', '.edit', function(e){
                e.preventDefault();
                $('#priceChange').modal('show');
                var id = $(this).data('id');
                $('.id').val(id);
            });
        });
        $(function(){
            $(document).on('click', '.m_edit', function(e){
                e.preventDefault();
                $('#priceChange_m').modal('show');
                var id = $(this).data('id');
                $('.id').val(id);
            });
        });
    </script>
@endsection
