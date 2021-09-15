@extends('frontend.layout')
@section('title', 'Checkout || Bazar-Sadai.com Best online Shop in Bangladesh')
@section('checkout', 'active')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{url('public/asset/woolmart/css/style.min.css')}}">
    <style>
        .addDiv{
            margin-top: 10px;
        }
        .befAddDiv{
            margin-bottom: 10px;
        }
    </style>
@endsection
@section('content')
    <hr class="divider">

    <!-- Start of Main -->
    <main class="main order">
        <!-- Start of Breadcrumb -->
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb shop-breadcrumb bb-no">
                    <li class="passed"><a href="{{url('cart')}}">Shopping Cart</a></li>
                    <li class="passed"><a href="">Checkout</a></li>
                    <li class="active"><a href="">Order Complete</a></li>
                </ul>
            </div>
        </nav>
        <!-- End of Breadcrumb -->

        <!-- Start of PageContent -->
        <div class="page-content mb-10 pb-2">
            <div class="container">
                <div class="order-success text-center font-weight-bolder text-dark">
                    <i class="fas fa-check"></i>
                    Thank you. Your order has been received.
                </div>

                <a href="{{url('')}}" class="btn btn-dark btn-rounded btn-icon-left btn-back mt-6"><i class="w-icon-long-arrow-left"></i>Back To home</a>
            </div>
        </div>
        <!-- End of PageContent -->
    </main>
    <!-- End of Main -->

@endsection
@section('js')

    <script>
    </script>
@endsection
