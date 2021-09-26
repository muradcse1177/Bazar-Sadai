@extends('frontend.layout')
@section('title', 'Shop || Bazar-Sadai.com Best online Shop in Bangladesh')
@section('shop', 'active')
@section('css')
    <link rel='stylesheet' type="text/css" href="{{url('public/asset/woolmart/css/style.min.css')}}">
    <style>
        .submit {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 4px 8px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <hr class="divider">
    <!-- Start of Main -->
    <main class="main">
        <!-- Start of Breadcrumb -->
{{--        <nav class="breadcrumb-nav">--}}
{{--            <div class="container">--}}
{{--                <ul class="breadcrumb bb-no">--}}
{{--                    <li><a href="{{url('/')}}">Home</a></li>--}}
{{--                    <li>Shop</li>--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--        </nav>--}}
        <!-- End of Breadcrumb -->

        <!-- Start of Page Content -->
        <div class="page-content">
            <div class="container">
                <!-- Start of Shop Banner -->
                <div class="shop-default-banner banner d-flex align-items-center mb-5 br-xs"
                     style="background-image: url(public/asset/woolmart/images/shop/banner1.jpg); background-color: #FFC74E;">
                    <div class="banner-content">
                        <h4 class="banner-subtitle font-weight-bold">Accessories Collection</h4>
                        <h3 class="banner-title text-white text-uppercase font-weight-bolder ls-normal">Smart Wrist
                            Watches</h3>
                        <a href="#" class="btn btn-dark btn-rounded btn-icon-right">Discover
                            Now<i class="w-icon-long-arrow-right"></i></a>
                    </div>
                </div>
                <!-- End of Shop Banner -->
                <section class="category-ellipse-section services s_shop" style="background-color: #f3f3f3;">
                    <h2 class="title title-center mb-5">সেবাসমুহ</h2>
                    <div class="container mt-1 mb-2">
                        <div class="row cols-xl-6 cols-lg-5 cols-md-4 cols-sm-3 cols-2">
                            <?php
                            $url_arr = array(
                                "serviceSubCategoryToursNTravel",
                                "courier",
                                "serviceSubCategoryMedical",
                                "serviceSubCategoryHomeAssistant",
                                "transportService",
                            );
                            $i=0;
                            ?>
                            @foreach($ser_categories as $ser_cat)
                                <div class="category category-ellipse">
                                    <figure class="category-media">
                                        <a href="{{url($url_arr[$i].'/'.$ser_cat->id)}}">
                                            <img src="{{url($ser_cat->image)}}" alt="Categroy"
                                                 width="190" height="190" style="background-color: #5C92C0;" />
                                        </a>
                                    </figure>
                                    <div class="category-content">
                                        <h4 class="category-name">
                                            <a href="{{url($url_arr[$i].'/'.$ser_cat->id)}}">{{$ser_cat->name}}</a>
                                        </h4>
                                    </div>
                                </div>
                                <?php
                                $i++;
                                ?>
                            @endforeach
                            <div class="category category-ellipse">
                                <figure class="category-media">
                                    <a href="{{url('forHumanity')}}">
                                        <img src="{{url('public/humanity.jpg')}}" alt="Categroy"
                                             width="190" height="190" style="background-color: #5C92C0;" />
                                    </a>
                                </figure>
                                <div class="category-content">
                                    <h4 class="category-name">
                                        <a href="{{url('forHumanity')}}">মানুষ মানুষের জন্য</a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Start of Shop Content -->
                <div class="shop-content row gutter-lg mb-10">
                    <!-- Start of Sidebar, Shop Sidebar -->
                    <aside class="sidebar shop-sidebar sticky-sidebar-wrapper sidebar-fixed">
                        <!-- Start of Sidebar Overlay -->
                        <div class="sidebar-overlay"></div>
                        <a class="sidebar-close" href="#"><i class="close-icon"></i></a>

                        <!-- Start of Sidebar Content -->
                        <div class="sidebar-content scrollable">
                            <!-- Start of Sticky Sidebar -->
                            <div class="sticky-sidebar">
                                <div class="filter-actions">
                                    <label>ফিল্টার :</label>
                                    <a href="#" class="btn btn-dark btn-link filter-clean">রিসেট</a>
                                </div>
                                <!-- Start of Collapsible widget -->
                                <div class="widget widget-collapsible">
                                    <h3 class="widget-title"><label>সকল ক্যাটেগরি</label></h3>
                                    <ul class="widget-body filter-items search-ul">
                                        @foreach($pro_categories as $pro_cat)
                                            <li><a href="{{url('shop-by-cat/'.$pro_cat->id)}}">{{$pro_cat->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <!-- End of Collapsible Widget -->

                                <!-- Start of Collapsible Widget -->
                                <div class="widget widget-collapsible">
                                    <h3 class="widget-title"><label>দাম</label></h3>
                                    <div class="widget-body">
                                        <ul class="filter-items search-ul">
                                            <li><a href="{{url('shop-by-price/1-1000')}}">1.00 - 1000.00 টাকা</a></li>
                                            <li><a href="{{url('shop-by-price/1000-10000')}}">1000.00 - 10000.00 টাকা</a></li>
                                            <li><a href="{{url('shop-by-price/10000-50000')}}">10000.00 - 50000.00 টাকা</a></li>
                                            <li><a href="{{url('shop-by-price/50000-100000')}}">50000.00 - 100000.00 টাকা</a></li>
                                            <li><a href="{{url('shop-by-price/100000-un')}}">100000.00+  টাকা</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- End of Sidebar Content -->
                        </div>
                        <!-- End of Sidebar Content -->
                    </aside>

                    <!-- Start of Shop Main Content -->
                    <div class="main-content">
                        <nav class="toolbox">
                            <div class="toolbox-left">
                                <a href="#" class="btn btn-primary btn-outline btn-rounded left-sidebar-toggle
                                        btn-icon-left d-block d-lg-none"><i
                                        class="w-icon-category"></i><span>Filters</span></a>
                            </div>
                            <div class="toolbox-right">

                                <div class="toolbox-item toolbox-layout">
                                    <a href="#" class="icon-mode-grid btn-layout active">
                                        <i class="w-icon-grid"></i>
                                    </a>

                                </div>
                            </div>
                        </nav>
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
                        <div class="product-wrapper row cols-md-4 cols-sm-2 cols-2">
                            @foreach($products as $product)
                                @php
                                if($status['status']==1)  $price = $product->edit_price;
                                if($status['status']==0)  $price = $product->price;
                                $Image ="";
                                   if(!empty($product->photo))
                                       $Image =url('/').'/'.$product->photo;
                                   else
                                       $Image =url('/')."/public/asset/no_image.jpg";
                            @endphp
                                <div class="product-wrap">
                                    <div class="product product-simple text-center">
                                        <form class="form-inline" id="{{$product->id.'productForm'}}">
                                            <figure class="product-media">
                                                <a href="{{url('product-by-id/'.$product->id)}}">
                                                    <img src="{{$Image}}" alt="Product"
                                                         width="330" height="338" />
                                                </a>
                                                <div class="product-action-vertical">
                                                    <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"
                                                       title="Add to wishlist"></a>
                                                    <a href="#" class="btn-product-icon btn-compare w-icon-compare"
                                                       title="Add to Compare"></a>
                                                </div>
                                                <div class="product-action">
                                                    <a href="{{url('product-by-id/'.$product->id)}}" class="btn-product btn-quickview" title="Quick View">Quick
                                                        View</a>
                                                </div>
                                            </figure>
                                            <div class="product-details">
                                                <h4 class="product-name">
                                                    <a href="">{{$product->unit}}</a>
                                                </h4>
                                                <h3 class="product-name">
                                                    <a href="{{url('product-by-id/'.$product->id)}}">{{$product->name}}</a>
                                                </h3>
                                                <div class="product-pa-wrapper">
                                                    <input type="hidden" name="quantity" id="{{$product->id.'q'}}" value="{{$product->minqty}}">
                                                    <div class="product-price">
                                                        <ins class="new-price">{{$price.' টাকা'}}</ins><del class="old-price">{{$price.' টাকা'}}</del>
                                                    </div>
                                                    <div class="product-action">
                                                        <button type="submit" data-id="{{$product->id}}" id="{{'bg'.$product->id}}" class="submit">Add To Cart</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-center">
                            {!!  $products->links() !!}
                        </div>
                    </div>
                    <!-- End of Shop Main Content -->
                </div>
                <!-- End of Shop Content -->
            </div>
        </div>
        <!-- End of Page Content -->
    </main>
    <!-- End of Main -->

@endsection
@section('js')
@endsection
