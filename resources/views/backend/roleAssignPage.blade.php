@extends('backend.layout')
@section('title', 'রোল এসাইন')
@section('page_header', 'রোল এসাইন')
@section('roleAssign','active')
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
        <div class="col-sm-12">
            <div class="box box-success">
                {{ Form::open(array('url' => 'insertUserRole',  'method' => 'post')) }}
                {{ csrf_field() }}
                    <div class="box-body">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>ইউজার </label>
                                <select class="form-control  user" name="user" style="width: 100%;" required>
                                    <option value="" selected>ইউজার  নির্বাচন করুন</option>
                                    @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>রোল এসাইন করুন</label><hr style="border-top: 2px solid green;">
                            </div>
                        </div>
                        @foreach($attributes as $attribute)
                        <div class="col-sm-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="role[]" id="{{$attribute->id}}" value="{{$attribute->id}}">
                                <label class="form-check-label" for="{{$attribute->id}}">
                                    {{$attribute->name}}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="id" id="id" class="id">
                        <button type="submit" class="btn btn-success">সেভ করুন</button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"> রোল সমূহ</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>রোল </th>
                            <th>রোল ডিটেলস </th>
                            <th>টুল</th>
                        </tr>
                        @foreach($r_as as $r_a)
                            <tr>
                                <td>
                                    <?php
                                    $result = DB::table('user_type')
                                        ->where('id', $r_a->user_type)->first();
                                    ?>
                                    {{$result->name}}
                                </td>
                                <td>
                                    <?php
                                    $result = DB::table('role_assign')
                                        ->where('user_type', $r_a->user_type)->first();
                                    $rows = json_decode($result->role);
                                    $i =1;
                                    ?>
                                    @foreach($rows as $row)
                                            <?php
                                            $result = DB::table('attribute')
                                                ->where('id',$row)->first();
                                            ?>
                                        <div class="col-sm-3">{{$i.'.'.$result->name}}</div>
                                       <?php $i++; ?>
                                    @endforeach
                                </td>
                                <td class="td-actions text-center">
                                    <a href="{{url('roleAssignEditPage?id='.$r_a->id)}}">
                                        <button type="button" rel="tooltip" class="btn btn-success edit" data-id="{{$r_a->id}}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>

    </script>
@endsection
