@extends('frontend.layout')
@section('title', 'Home || Bazar-Sadai.com Best online Shop in Bangladesh')
@section('home', 'active')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{url('public/asset/woolmart/css/demo1.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('public/asset/woolmart/css/demo3.min.css')}}">
    <style>
        .submit {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 4px 8px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <!-- Start of Main-->
    <main class="main">
        <diV class="container mainSlide">
            <div class="intro-wrapper mb-6">
                <div class="owl-carousel owl-theme owl-nav-inner owl-nav-md row cols-1 gutter-no animation-slider"
                     data-owl-options="{
                        'nav': true,
                        'dots': false
                    }">
                    <?php
                    $i =1;
                    ?>
                    @foreach($slides as $ph)
                        <div class="banner banner-fixed intro-slide intro-slide{{$i}} br-sm" style="background-image: url({{url('public/asset/images/'.$ph->slide)}}); background-color: #262729;"></div>
                        <?php
                        $i++;
                        ?>
                    @endforeach
                </div>
            </div>
        </diV>
        <div class="container">

        </div>
        <section class="category-ellipse-section services" style="background-color: #f3f3f3;"><br>
            <h2 class="title title-center mb-5">পণ্য ধরনসমুহ</h2>
            <div class="container">
                <div style="text-align: center;">
                    <section class="btn-section btn-block-section mb-7">
                        <div class="row">
                            <div class="col-lg-9 col">
                                <div class="btn-group row cols-sm-2">
                                    <div class="btn-wrap ml-0">
                                        <a href="{{url('locationBaseSearchPage')}}" class="btn btn-block btn-primary btn-rounded btn-icon-right">
                                            লোকেশন ভিত্তিক পন্য খুজুন<i class="w-icon-long-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="container mt-1 mb-2">
                <div class="row cols-xl-6 cols-lg-5 cols-md-4 cols-sm-3 cols-2">
                    @if($check != 0)
                        <div class="category category-ellipse">
                            <figure class="category-media">
                                <a href="{{url('marchantShop?cat_id='.$shops->cat_id)}}">
                                    <img src="{{url($shops->image)}}"
                                         width="190" height="190" style="background-color: #5C92C0;" />
                                </a>
                            </figure>
                            <div class="category-content">
                                <h4 class="category-name">
                                    <a href="{{url('marchantShop?cat_id='.$shops->cat_id)}}">{{$shops->cat_name}}</a>
                                </h4>
                            </div>
                        </div>
                    @endif
                    @foreach($sub_categories as $pro_cat)
                        <div class="category category-ellipse">
                            <figure class="category-media">
                                <a href="{{url('shop-by-subCat/'.$pro_cat->id)}}">
                                    <img src="{{url($pro_cat->image)}}" alt="Categroy"
                                         width="190" height="190" style="background-color: #5C92C0;" />
                                </a>
                            </figure>
                            <div class="category-content">
                                <h4 class="category-name">
                                    <a href="{{url('shop-by-cat/'.$pro_cat->id)}}">{{$pro_cat->name}}</a>
                                </h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

    </main>
@endsection
@section('js')
@endsection
