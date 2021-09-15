@extends('backend.layout')
@section('title', 'সেলার')
@section('page_header', 'সেলার ব্যবস্থাপনা')
@section('mySaleProduct','active')
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
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">লিস্ট </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>অর্ডার তারিখ</th>
                            <th>ছবি</th>
                            <th>অর্ডার নং</th>
                            <th>নাম</th>
                            <th>পরিমান</th>
                            <th>দাম</th>
                        </tr>
                        @foreach($products as $product)
                            <?php $noImage ="public/asset/no_image.jpg"; ?>
                            <tr>
                                <td> {{$product->sales_date}} </td>
                                <td>
                                    @if($product->photo)
                                        <div class="text-left">
                                            <img src="{{ $product->photo }}" class="rounded" height="50px" width="50px">
                                        </div>
                                    @else
                                        <div class="text-left">
                                            <img src="{{$noImage}}" class="rounded" height="50px" width="50px">
                                        </div>
                                    @endif
                                </td>
                                <td> {{$product->pay_id}} </td>
                                <td> {{$product->name}} </td>
                                <td> {{$product->quantity}} </td>
                                <td> {{$product->price}} </td>
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
    <script>

    </script>
@endsection
