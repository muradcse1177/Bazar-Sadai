@extends('frontend.layout')
@section('title', 'Single Product || Bazar-Sadai.com Best online Shop in Bangladesh')
@section('shop', 'active')
@section('css')
    <link rel='stylesheet' type="text/css" href="{{url('public/asset/woolmart/css/style.min.css')}}">
    <style>
        .asdf {
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
    <main class="main mb-10 pb-1">
        <!-- Start of Breadcrumb -->
        <nav class="breadcrumb-nav container">
            <ul class="breadcrumb bb-no">
                <li><a href="{{url('')}}">Home</a></li>
                <li>Products</li>
            </ul>
{{--            <ul class="product-nav list-style-none">--}}
{{--                <li class="product-nav-prev">--}}
{{--                    <a href="{{url('product-increase')}}">--}}
{{--                        <i class="w-icon-angle-left"></i>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="product-nav-next">--}}
{{--                    <a href="{{url('product-decrease')}}">--}}
{{--                        <i class="w-icon-angle-right"></i>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            </ul>--}}
        </nav>
        <!-- End of Breadcrumb -->

        <!-- Start of Page Content -->
        <div class="page-content">
            <div class="container">
                <div class="row gutter-lg">
                    <div class="main-content">
                        <div class="product product-single row">
                            <div class="col-md-6 mb-6">
                                <div class="product-gallery product-gallery-sticky">
                                    <div class="product-single-carousel owl-carousel owl-theme owl-nav-inner row cols-1 gutter-no">
                                        @php
                                            if(@$products->slider){
                                                $slider = json_decode($products->slider);
                                                $photos = explode(",",$slider);
                                                array_pop($photos);
                                                $i =0;
                                            }
                                            else{
                                                $photos = array();
                                            }
                                        @endphp
                                        @foreach($photos as $photo)
                                            <figure class="product-image">
                                                <img src="{{ url($photo) }}"
                                                     data-zoom-image="{{ url($photo) }}"
                                                     alt="" width="800" height="900">
                                            </figure>
                                        @endforeach
                                    </div>
                                    <div class="product-thumbs-wrap">
                                        <div class="product-thumbs row cols-4 gutter-sm">
                                            @foreach($photos as $photo)
                                                @if($i == 0)
                                                    <div class="product-thumb active">
                                                        <img src="{{ url($photo) }}"
                                                             alt="Product Thumb" width="800" height="900">
                                                    </div>
                                                @else
                                                    <div class="product-thumb ">
                                                        <img src="{{ url($photo) }}"
                                                             alt="Product Thumb" width="800" height="900">
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        <button class="thumb-up disabled"><i class="w-icon-angle-left"></i></button>
                                        <button class="thumb-down disabled"><i
                                                class="w-icon-angle-right"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 mb-md-6">
                                <div class="product-details" data-sticky-options="{'minWidth': 767}">
                                    <form class="form-inline" id="{{$products->id.'productForm'}}">
                                        <h2 class="product-title">{{$products->name}}</h2>
                                        <hr class="product-divider">
                                        @php
                                            if($status['status']==1)  $price = $products->edit_price;
                                            if($status['status']==0)  $price = $products->price;
                                            $Image ="";
                                               if(!empty($product->photo))
                                                   $Image =url('/').'/'.$product->photo;
                                               else
                                                   $Image =url('/')."/public/asset/no_image.jpg";
                                        @endphp
                                        <div class="product-price"><ins class="new-price">{{$price.' টাকা'}}</ins></div>

                                        <div class="ratings-container">
                                            <div class="ratings-full">
                                                <span class="ratings" style="width: 80%;"></span>
                                                <span class="tooltiptext tooltip-top"></span>
                                            </div>
                                            <a href="#product-tab-reviews" class="rating-reviews scroll-to">(3
                                                Reviews)</a>
                                        </div>
                                        <div class="product-short-desc" style="text-align: justify;">
                                            {{@$products->unit}}
                                        </div>
                                        <div class="product-short-desc" style="text-align: justify;">
                                            {{@$products->type}}
                                        </div>
                                        <div class="product-short-desc" style="text-align: justify;">
                                            {{@$products->genre}}
                                        </div>
                                        <div class="product-short-desc" style="text-align: justify;">
                                            {{@$products->company}}
                                        </div>
                                        <div class="product-short-desc" style="text-align: justify;">
                                            {!! nl2br(substr($products->description, 0, 700)).'...' !!}
                                        </div>

                                        <hr class="product-divider">
                                        <div class="fix-bottom">
                                            <div class="product-form container">
                                                <div class="product-qty-form" style="margin-top: 10px;">
                                                    <div class="input-group">
                                                        <input name="quantity" id="{{$products->id}}q"  class="form-control" type="number" value="{{$products->minqty}}" readonly>
                                                        <button class="quantity-plus w-icon-plus" data-id="{{$products->id}}"></button>
                                                        <button class="quantity-minus w-icon-minus" data-id="{{$products->id}}"></button>
                                                    </div>
                                                </div>
                                                <button type="submit" data-id="{{$products->id}}" id="{{'bg'.$products->id}}" class="btn btn-primary submit">
                                                    <i class="w-icon-cart"></i><span>Add to Cart</span>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="social-links-wrapper">
                                            <div class="social-links">
                                                <div class="social-icons social-no-color border-thin">
                                                    <a href="#" class="social-icon social-facebook w-icon-facebook"></a>
                                                    <a href="#" class="social-icon social-twitter w-icon-twitter"></a>
                                                    <a href="#"
                                                       class="social-icon social-pinterest fab fa-pinterest-p"></a>
                                                    <a href="#" class="social-icon social-whatsapp fab fa-whatsapp"></a>
                                                    <a href="#"
                                                       class="social-icon social-youtube fab fa-linkedin-in"></a>
                                                </div>
                                            </div>
                                            <span class="divider d-xs-show"></span>
                                            <div class="product-link-wrapper d-flex">
                                                <a href="#"
                                                   class="btn-product-icon btn-wishlist w-icon-heart"><span></span></a>
                                                <a href="#"
                                                   class="btn-product-icon btn-compare btn-icon-left w-icon-compare"><span></span></a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab tab-nav-boxed tab-nav-underline product-tabs">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a href="#product-tab-description" class="nav-link active">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#product-tab-specification" class="nav-link">Specification</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="product-tab-description">
                                    <div class="row mb-4">
                                        <div class="col-md-12 mb-5" style="text-align: justify;">
                                            {!! nl2br($products->description) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="product-tab-specification">
                                    <div class="row mb-4">
                                        <div class="col-md-12 mb-5" style="text-align: justify;">
                                            {!! nl2br($products->specification) !!}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <section class="related-product-section">
                            <div class="title-link-wrapper mb-4">
                                <h4 class="title">Related Products</h4>
                                <a href="{{url('shop-by-cat/'.$cat_id)}}" class="btn btn-dark btn-link btn-slide-right btn-icon-right">More
                                    Products<i class="w-icon-long-arrow-right"></i></a>
                            </div>
                            <div class="product-wrapper row cols-md-4 cols-sm-2 cols-2">
                                @foreach($rel_products as $product)
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
                                                            <button type="submit" data-id="{{$product->id}}" id="{{'bg'.$product->id}}" class="submit asdf">Add To Cart</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    </div>
                    <!-- End of Main Content -->
                    <aside class="sidebar product-sidebar sidebar-fixed right-sidebar sticky-sidebar-wrapper">
                        <div class="sidebar-overlay"></div>
                        <a class="sidebar-close" href="#"><i class="close-icon"></i></a>
                        <a href="#" class="sidebar-toggle d-flex d-lg-none"><i class="fas fa-chevron-left"></i></a>
                        <div class="sidebar-content scrollable">
                            <div class="sticky-sidebar">
                                <div class="widget widget-icon-box mb-6">
                                    <div class="icon-box icon-box-side">
                                            <span class="icon-box-icon text-dark">
                                                <i class="w-icon-truck"></i>
                                            </span>
                                        <div class="icon-box-content">
                                            <h4 class="icon-box-title">Free Shipping & Returns</h4>
                                        </div>
                                    </div>
                                    <div class="icon-box icon-box-side">
                                            <span class="icon-box-icon text-dark">
                                                <i class="w-icon-bag"></i>
                                            </span>
                                        <div class="icon-box-content">
                                            <h4 class="icon-box-title">Secure Payment</h4>
                                        </div>
                                    </div>
                                    <div class="icon-box icon-box-side">
                                            <span class="icon-box-icon text-dark">
                                                <i class="w-icon-money"></i>
                                            </span>
                                        <div class="icon-box-content">
                                            <h4 class="icon-box-title">Money Back Guarantee</h4>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Widget Icon Box -->

                                <div class="widget widget-banner mb-9">
                                    <div class="banner banner-fixed br-sm">
                                        <figure>
                                            <img src="{{ url('/') }}/public/asset/woolmart/images/shop/banner3.jpg" alt="Banner" width="266"
                                                 height="220" style="background-color: #1D2D44;" />
                                        </figure>
                                        <div class="banner-content">
                                            <h4
                                                class="banner-subtitle text-white font-weight-bolder text-uppercase mb-0">
                                                Ultimate Sale</h4>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Widget Banner -->

                                <div class="widget widget-products">
                                    <div class="title-link-wrapper mb-2">
                                        <h4 class="title title-link font-weight-bold">More Products</h4>
                                    </div>

                                    <div class="owl-carousel owl-theme owl-nav-top" data-owl-options="{
                                            'nav': true,
                                            'dots': false,
                                            'items': 1,
                                            'margin': 20
                                        }">
                                        @php
                                          $a=0;
                                        @endphp
                                        @for($i=0; $i<3; $i++)
                                            <div class="widget-col">
                                                @for($j=0; $j<3; $j++)
                                                    @php
                                                        if($status['status']==1)  $price = $rel_products_desc[$a]->edit_price;
                                                        if($status['status']==0)  $price = $rel_products_desc[$a]->price;
                                                        $Image ="";
                                                           if(!empty($rel_products_desc[$a]->photo))
                                                               $Image =url('/').'/'.$rel_products_desc[$a]->photo;
                                                           else
                                                               $Image =url('/')."/public/asset/no_image.jpg";
                                                    @endphp
                                                    <div class="product product-widget">
                                                        <figure class="product-media">
                                                            <a href="{{url('product-by-id/'.$rel_products_desc[$a]->id)}}">
                                                                <img src="{{$Image}}" alt="Product"
                                                                     width="100" height="113" />
                                                            </a>
                                                        </figure>
                                                        <div class="product-details">
                                                            <h4 class="product-name">
                                                                <a href="{{url('product-by-id/'.$rel_products_desc[$a]->id)}}">{{$rel_products_desc[$a]->name}}</a>
                                                            </h4>
                                                            <div class="ratings-container">
                                                                <div class="ratings-full">
                                                                    <span class="ratings" style="width: 100%;"></span>
                                                                    <span class="tooltiptext tooltip-top"></span>
                                                                </div>
                                                            </div>
                                                            <div class="product-price">{{$price.' টাকা'}}</div>
                                                        </div>
                                                    </div>
                                                    @php
                                                        $a++;
                                                    @endphp
                                                @endfor
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </aside>
                    <!-- End of Sidebar -->
                </div>
            </div>
        </div>
        <!-- End of Page Content -->
    </main>
    <!-- End of Main -->
@endsection
@section('js')
    <script>
    </script>
@endsection
