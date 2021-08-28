@extends('frontend.layout')
@section('title', 'Cart || Bazar-Sadai.com Best online Shop in Bangladesh')
@section('cart', 'active')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{url('public/asset/woolmart/css/style.min.css')}}">
@endsection
@section('content')
    <hr class="divider">
    <main class="main cart">
        <!-- Start of Breadcrumb -->
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb shop-breadcrumb bb-no">
                    <li class="active"><a href="{{url('cart')}}">Shopping Cart</a></li>
                    <li><a href="{{url('checkout')}}">Checkout</a></li>
                </ul>
            </div>
        </nav>
        <!-- End of Breadcrumb -->

        <!-- Start of PageContent -->
        <div class="page-content">
            <div class="container">
                <div class="row gutter-lg mb-10">
                    <div class="col-lg-8 pr-lg-4 mb-6">
                        <h2 style="text-align: center">Product List</h2>
                        <hr class="divider">
                        <table class="shop-table cart-table">
                            <thead>
                                <tr>
                                    <th class="product-name"><span>Product</span></th>
                                    <th></th>
                                    <th class="product-price"><span>Price</span></th>
                                    <th class="product-quantity"><span>Quantity</span></th>
                                    <th class="product-subtotal"><span>Subtotal</span></th>
                                </tr>
                            </thead>
                            <tbody id="tbody"></tbody>
                        </table>
                        <div class="donateArea" style="display: none;">
                            <h2 style="text-align: center">Donated Product List</h2>
                            <hr class="divider">
                            <table class="shop-table cart-table">
                                <thead>
                                <tr>
                                    <th class="product-name"><span>Product</span></th>
                                    <th></th>
                                    <th class="product-price"><span>Price</span></th>
                                    <th class="product-quantity"><span>Quantity</span></th>
                                    <th class="product-subtotal"><span>Subtotal</span></th>
                                </tr>
                                </thead>
                                <tbody id="donateTable"></tbody>
                            </table>
                        </div>
                        @if($count>0)
                            <div class="cart-action mb-6">
                                <a href="{{url('shop')}}" class="btn btn-dark btn-rounded btn-icon-left btn-shopping mr-auto"><i class="w-icon-long-arrow-left"></i>Continue Shopping</a>
                                @if(Cookie::get('user_id'))
                                    <input type="hidden" name="donateCheck" value="" id="donateCheck">
                                    <button type="submit" class="btn btn-rounded btn-success donateButton" name="donate" value="donate">Donate</button> &nbsp;&nbsp;
                                @endif
                                <button type="submit" class="btn btn-rounded btn-danger btn-clear" name="clear_cart" value="Clear Cart">Clear Cart</button>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-4 sticky-sidebar-wrapper">
                        <div class="sticky-sidebar">
                            <div class="cart-summary mb-4">
                                <h3 class="cart-title text-uppercase">Cart Totals</h3>
                                <hr class="divider mb-6">
                                <div class="order-total d-flex justify-content-between align-items-center">
                                    <label>Grand Total</label>
                                    <span class="ls-50 g_total"></span>
                                </div>
                                @if($count>0)
                                <a href="{{url('checkout')}}"
                                   class="btn btn-block btn-dark btn-icon-right btn-rounded  btn-checkout">
                                    Proceed to checkout<i class="w-icon-long-arrow-right"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of PageContent -->
    </main>
    <!-- End of Main -->

@endsection
@section('js')
    <script>
        $(document).on('click', '.donateButton', function(e){
            e.preventDefault();
            $(".donateArea").show();
            $("#donateCheck").val(1);
            $.ajax({
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id': 'want_donate'
                },
                url: '{{ url('/') }}/product/cart_details',
                dataType: 'json',
                success: function(response){
                    if(!response.error){
                        $('#donateTable').html(response.output_donate);
                        var g_text = $('.g_total').text();
                        var result = g_text.split(' ');
                        var result1 = result[0].split('.');
                        var final = parseInt(result1[0]);
                        var g_total = response.donate_total['g_total']
                        var g_total1 = g_total.split('.');
                        var final1 = parseInt(g_total1[0]);
                        var total = final1 + final;
                        $('.g_total').html(total+'.00 টাকা');
                        $(".donateButton").hide();
                    }
                }
            });
        });
        $(document).on('click', '.cart_delete_donate', function(e){
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id':id,
                },
                url: '{{ url('/') }}/product/cart_delete_donate',
                dataType: 'json',
                success: function(response){
                    var msg= response.output;
                    if(!response.error){
                        $.toast({
                            heading: 'ধন্যবাদ',
                            text: 'Donated Item Deleted',
                            showHideTransition: 'slide',
                            icon: 'success',
                            position: {
                                left: 0,
                                top: 300
                            },
                            stack: false
                        })
                        $('#donateTable').html(response.output_donate);
                        var g_total = response.donate_total['g_total']
                        var g_total1 = g_total.split('.');
                        var final1 = parseInt(g_total1[0]);
                        var total = final1;
                        $('.g_total').html(total+'.00 টাকা');
                    }
                }
            });
        });
        $(document).on('click', '.quantity-plus-donate', function(e){
            e.preventDefault();
            var parts = location.href.split('/');
            var lastSegment = parts.pop() || parts.pop();
            var id = $(this).data('id');
            var quantity = $("#"+id+"d").val();
            $.ajax({
                type: 'POST',
                url: '{{ url('/') }}/getProductMiqty',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'json',
                success: function(response){
                    var products = response.products;
                    var minqty = products.minqty;
                    quantity = parseInt(quantity) + parseInt(minqty);
                    $("#"+id+"d").val(quantity);
                    if(lastSegment == 'cart'){
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('/') }}/productQuantityChangeDonate',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": id,
                                "quantity": quantity
                            },
                            dataType: 'json',
                            success: function(response){
                                if(!response.error){
                                    $.toast({
                                        heading: 'Thanks',
                                        text: 'Cart Updated Sucessfully',
                                        showHideTransition: 'slide',
                                        icon: 'success',
                                        position: {
                                            left: 0,
                                            top: 300
                                        },
                                        stack: false
                                    })
                                    $('#donateTable').html(response.output_donate);
                                    var g_total = response.donate_total['g_total']
                                    var g_total1 = g_total.split('.');
                                    var final1 = parseInt(g_total1[0]);
                                    var total = final1;
                                    $('.g_total').html(total+'.00 টাকা');
                                }
                            }
                        });
                    }
                }
            });
        });
        $(document).on('click', '.quantity-minus-donate', function(e){
            e.preventDefault();
            var id = $(this).data('id');
            var quantity = $("#"+id+"d").val();
            var parts = location.href.split('/');
            var lastSegment = parts.pop() || parts.pop();
            $.ajax({
                type: 'POST',
                url: '{{ url('/') }}/getProductMiqty',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'json',
                success: function(response){
                    var products = response.products;
                    var minqty = products.minqty;
                    if(quantity > parseInt(minqty)){
                        quantity = parseInt(quantity) - parseInt(minqty);
                    }
                    $("#"+id+"d").val(quantity);
                    if(lastSegment == 'cart'){
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('/') }}/productQuantityChangeDonate',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": id,
                                "quantity": quantity
                            },
                            dataType: 'json',
                            success: function(response){
                                if(!response.error){
                                    $.toast({
                                        heading: 'Thanks',
                                        text: 'Cart Updated Sucessfully',
                                        showHideTransition: 'slide',
                                        icon: 'success',
                                        position: {
                                            left: 0,
                                            top: 300
                                        },
                                        stack: false
                                    })
                                    $('#donateTable').html(response.output_donate);
                                    var g_total = response.donate_total['g_total']
                                    var g_total1 = g_total.split('.');
                                    var final1 = parseInt(g_total1[0]);
                                    var total = final1;
                                    $('.g_total').html(total+'.00 টাকা');
                                }
                            }
                        });
                    }
                }
            });

        });
        $(document).on('click', '.btn-clear', function(e){
            e.preventDefault();
            var value = $(this).val();
            $.ajax({
                type: 'POST',
                url: '{{ url('/') }}/clear_cart',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "value": value
                },
                dataType: 'json',
                success: function(response){
                    if(!response.error){
                        $.toast({
                            heading: 'Thanks',
                            text: 'Cart Cleared Sucessfully',
                            showHideTransition: 'slide',
                            icon: 'success',
                            position: {
                                left: 0,
                                top: 300
                            },
                            stack: false
                        })
                        window.location.href = '{{ url('/') }}/shop';
                    }
                }
            });

        });
    </script>
@endsection
