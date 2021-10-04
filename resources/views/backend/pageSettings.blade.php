@extends('backend.layout')
@section('title','Page Settings')
@section('page_header', 'Page Settings')
@section('pageSettings','active')
@section('extracss')
    <link rel="stylesheet" href="public/asset/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
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
                    {{ Form::open(array('url' => 'insertPrivacy',  'method' => 'post','enctype'=>'multipart/form-data')) }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="">Privacy Policy </label>
                            <textarea class="textarea privacy" id="privacy" placeholder="Write Here..." name="text"
                                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="id" value="1">
                        <button type="submit" class="btn btn-primary">সেভ করুন</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
            <div class="box box-primary">
                <div class="divform">
                    {{ Form::open(array('url' => 'insertPrivacy',  'method' => 'post','enctype'=>'multipart/form-data')) }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="">Term and Conditions</label>
                            <textarea class="textarea terms" id="terms" placeholder="Write Here..." name="text"
                                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="id" value="2">
                        <button type="submit" class="btn btn-primary">সেভ করুন</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
            <div class="box box-primary">
                <div class="divform">
                    {{ Form::open(array('url' => 'insertPrivacy',  'method' => 'post','enctype'=>'multipart/form-data')) }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="">Payment Methods</label>
                            <textarea class="textarea payment" id="payment" placeholder="Write Here..." name="text"
                                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="id" value="3">
                        <button type="submit" class="btn btn-primary">সেভ করুন</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
            <div class="box box-primary">
                <div class="divform">
                    {{ Form::open(array('url' => 'insertPrivacy',  'method' => 'post','enctype'=>'multipart/form-data')) }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="">Money-back guarantee!</label>
                            <textarea class="textarea money" id="money" placeholder="Write Here..." name="text"
                                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="id" value="4">
                        <button type="submit" class="btn btn-primary">সেভ করুন</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
            <div class="box box-primary">
                <div class="divform">
                    {{ Form::open(array('url' => 'insertPrivacy',  'method' => 'post','enctype'=>'multipart/form-data')) }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="">Return Policy</label>
                            <textarea class="textarea return" id="return" placeholder="Write Here..." name="text"
                                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="id" value="5">
                        <button type="submit" class="btn btn-primary">সেভ করুন</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
            <div class="box box-primary">
                <div class="divform">
                    {{ Form::open(array('url' => 'insertPrivacy',  'method' => 'post','enctype'=>'multipart/form-data')) }}
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="">Shipping Method Policy</label>
                            <textarea class="textarea shipping" id="shipping" placeholder="Write Here..." name="text"
                                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="id" value="6">
                        <button type="submit" class="btn btn-primary">সেভ করুন</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>


@endsection
@section('js')
    <script src="public/asset/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.textarea').wysihtml5();
            $.ajax({
                url: 'getAllPagesText',
                type: "GET",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (response) {
                    var data = response.data;
                    $('#privacy ~ iframe').contents().find('.wysihtml5-editor').html(data[0].pages);
                    $('#terms ~ iframe').contents().find('.wysihtml5-editor').html(data[1].pages);
                    $('#payment ~ iframe').contents().find('.wysihtml5-editor').html(data[2].pages);
                    $('#money ~ iframe').contents().find('.wysihtml5-editor').html(data[3].pages);
                    $('#return ~ iframe').contents().find('.wysihtml5-editor').html(data[4].pages);
                    $('#shipping ~ iframe').contents().find('.wysihtml5-editor').html(data[5].pages);
                },
                failure: function (msg) {
                    alert('an error occured');
                }
            });
        });
    </script>
@endsection
