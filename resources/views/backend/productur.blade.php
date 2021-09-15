@extends('backend.layout')
@section('title', 'আপলোড ব্যবস্থাপনা')
@section('page_header', 'আপলোড ব্যবস্থাপনা')
@section('productUploadReport','active')
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
{{--        <div class="col-md-12">--}}
{{--            <!-- general form elements -->--}}
{{--            <div class="box box-primary">--}}
{{--                <div class="box-header with-border">--}}
{{--                    <h3 class="box-title addbut"><button type="button" class="btn btn-block btn-success btn-flat"><i class="fa fa-plus-square"></i> নতুন যোগ করুন </button></h3>--}}
{{--                    <h3 class="box-title rembut" style="display:none;"><button type="button" class="btn btn-block btn-success btn-flat"><i class="fa fa-minus-square"></i> মুছে ফেলুন </button></h3>--}}
{{--                </div>--}}
{{--                <div class="divform" style="display:none">--}}
{{--                    {{ Form::open(array('url' => 'insertSellerProduct',  'method' => 'post' ,'enctype'=>'multipart/form-data')) }}--}}
{{--                    {{ csrf_field() }}--}}
{{--                    <div class="box-body">--}}
{{--                        <div class="form-group">--}}
{{--                            <label>ধরন</label>--}}
{{--                            <select class="form-control  type" name="type" style="width: 100%;" required>--}}
{{--                                <option value="" selected>ধরন  নির্বাচন করুন</option>--}}
{{--                                <option value="Animal">পশু</option>--}}
{{--                                <option value="Others">অন্যান্য</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}

{{--                        <div class="form-group">--}}
{{--                            <label for="name" >নাম</label>--}}
{{--                            <input type="text" class="form-control name" name="name" placeholder="নাম"  required>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="name" >দাম</label>--}}
{{--                            <input type="number" class="form-control price" name="price" placeholder="দাম"  required>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="name" >পরিমান</label>--}}
{{--                            <input type="number" class="form-control amount" name="amount" placeholder="পরিমান"  required>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="name" >জেলা / সিটি-করপোরেশন</label>--}}
{{--                            <input type="text" class="form-control address1" name="address1" placeholder="জেলা/সিটি-করপোরেশন"  required>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="name" >উপজেলা / থানা</label>--}}
{{--                            <input type="text" class="form-control address2" name="address2" placeholder="উপজেলা/থানা"  required>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="name" >ইউনিয়ন /ওয়ার্ড </label>--}}
{{--                            <input type="text" class="form-control address3" name="address3" placeholder="ইউনিয়ন /ওয়ার্ড"  required>--}}
{{--                        </div>--}}
{{--                        <div class="form-check deleteCheck" style="display: none;">--}}
{{--                            <input class="form-check-input" type="checkbox" name="deleteCheck" value="1">--}}
{{--                            <label class="form-check-label" for="flexCheckDefault">--}}
{{--                                আপনার আগের ছবিগুলা কি ডিলিট করতে চান?--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="type" >ছবি</label>--}}
{{--                            <input class="form-control" type="file" accept="image/*"name="photo[]" required>--}}
{{--                        </div>--}}
{{--                        <div id="newRow">--}}

{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <a type="submit" class="btn btn-primary" id="addMore"><i class="fa-fa ion-plus"></i>আরও যোগ করুন</a>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="type" >ভিডিও</label>--}}
{{--                            <input type="file" class="form-control video" accept="video/mp4,video/x-m4v,video/*" name="video" placeholder="ভিডিও">--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="type" >পণ্য মালিকের ফোন</label>--}}
{{--                            <input type="tel" class="form-control w_phone" name="w_phone" placeholder="পণ্য মালিকের ফোন">--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label>স্ট্যাটাস</label>--}}
{{--                            <select class="form-control select2 status" name="status" style="width: 100%;" required>--}}
{{--                                <option value="" selected>স্ট্যাটাস  নির্বাচন করুন</option>--}}
{{--                                <option value="Active">একটিভ</option>--}}
{{--                                <option value="Inactive">ইন একটিভ</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="">বিবরন</label>--}}
{{--                            <textarea class="textarea description" id="description" placeholder="বিবরন লিখুন" name="description"--}}
{{--                                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                    <div class="box-footer">--}}
{{--                        <input type="hidden" name="id" id="id" class="id">--}}
{{--                        <button type="submit" class="btn btn-primary">সেভ করুন</button>--}}
{{--                    </div>--}}
{{--                    {{ Form::close() }}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">লিস্ট </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>সেলার নাম</th>
                            <th>ফোন</th>
                            <th>পণ্য নাম</th>
                            <th>ইউনিট</th>
                            <th>দাম</th>
                            <th>এপ্রুভাল</th>
                        </tr>
                        @foreach($products as $product)
                            <tr>
                                <td> {{$product->u_name}} </td>
                                <td> {{$product->phone}} </td>
                                <td> {{$product->p_name}} </td>
                                <td> {{$product->unit}} </td>
                                <td> {{$product->price}} </td>

                                @if($product->approval == 1)
                                    @php
                                        $button = 'info';
                                        $approval = 'Approved';
                                    @endphp
                                @else
                                    @php
                                        $button = 'warning';
                                        $approval = 'Not Approved';
                                    @endphp
                                @endif
                                <td class="td-actions text-center">
                                    <button type="button" rel="tooltip" class="btn btn-{{$button}} approval" data-id="{{$product->p_id}}">
                                        {{$approval}}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{ $products->links() }}

                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script src="public/asset/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script>
        $(".approval").click(function(){
            var id =$(this).data();
            $.ajax({
                type: 'GET',
                url: 'approvalChange',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    location.reload();
                }
            });
        });
    </script>
@endsection
