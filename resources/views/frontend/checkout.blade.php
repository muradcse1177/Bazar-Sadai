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
    <main class="main checkout">
        <!-- Start of Breadcrumb -->
        <div class="row">
        </div>
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb shop-breadcrumb bb-no">
                    <li class="passed"><a href="{{url('cart')}}">Shopping Cart</a></li>
                    <li class="active"><a href="{{url('checkout')}}">Checkout</a></li>
                </ul>
            </div>
        </nav>
        <!-- End of Breadcrumb -->


        <!-- Start of PageContent -->
        <div class="page-content">
            <div class="container">
                <hr class="divider">
                <div class="row">
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
                </div>
                @if(!Cookie::get('user_id'))
                    <input type="hidden" id="sample" name="sample" value="3">
                <div class="login-toggle">
                    Returning customer? <a href="#"
                                           class="show-login font-weight-bold text-uppercase text-dark">Login</a>
                </div>
                    {{ Form::open(array('url' => 'verifyUserFromCheckout',  'method' => 'post','class' =>'login-content')) }}
                    {{ csrf_field() }}
                        <p>If you have shopped with us before, please enter your details below.
                            If you are a new customer, please proceed to the Billing section.</p>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>Phone *</label>
                                    <input type="tel" class="form-control form-control-md" name="phone" pattern="\+?(88)?0?1[3456789][0-9]{8}\b" required>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>Password *</label>
                                    <input type="password" class="form-control form-control-md" name="password" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group checkbox">
                            <input type="checkbox" class="custom-checkbox" id="remember" name="remember">
                            <label for="remember" class="mb-0 lh-2">Remember me</label>
                            <a href="{{url('forgotPasswordLink')}}" class="ml-3">Lost your password?</a>
                        </div>
                        <button class="btn btn-rounded btn-login" type="submit" value="login"  name="login">Login</button>
                    {{ Form::close() }}
                @endif
                @if($count_c > 0)
                {{ Form::open(array('url' => 'couponCheck',  'method' => 'post'))}}
                {{ csrf_field() }}
                    <div class="coupon-toggle">
                        Have a coupon? <a href="#"
                                          class="show-coupon font-weight-bold text-uppercase text-dark">Enter your
                            code</a>
                    </div>
                    <div class="coupon-content mb-4">
                        <p>If you have a coupon code, please apply it below.</p>
                        <div class="input-wrapper-inline">
                            <input type="text" name="coupon_code" class="form-control form-control-md mr-1 mb-2" placeholder="Coupon code" id="coupon_code" required>
                            <button type="submit" class="btn button btn-rounded btn-coupon mb-2" name="apply_coupon" value="Apply coupon">Apply Coupon</button>
                        </div>
                    </div>
                {{ Form::close() }}
                @endif
                {{ Form::open(array('url' => 'getPaymentCartView',  'method' => 'post')) }}
                {{ csrf_field() }}
                    <div class="row mb-9">
                        <div class="col-lg-7 pr-lg-4 mb-4">
                            <h3 class="title billing-title text-uppercase ls-10 pt-1 pb-3 mb-0">
                                Billing Details
                            </h3>
                            @if(Cookie::get('user_id'))
                            <div class="form-group mt-3">
                                <label for="order-notes">Login Address</label>
                                <div style="border-style: solid; border-color: #d9d7d6; margin-bottom: 10px;">
                                    <div class="befAddDiv" style="margin-left: 15px;">
                                        <?php
                                        if($user->address_type == 1){
                                            $a1 = 'বিভাগ';
                                            $a2 = 'জেলা';
                                            $a3 = 'উপজেলা';
                                            $a4 = 'ইউনিয়ন';
                                            $a5 = 'ওয়ার্ড';
                                        }
                                        if($user->address_type == 2){
                                            $a1 = 'বিভাগ';
                                            $a2 = 'সিটি';
                                            $a3 = 'সিটি-কর্পোরেশন';
                                            $a4 = 'থানা';
                                            $a5 = 'ওয়ার্ড';
                                        }
                                        ?>
                                        <div class="addDiv"> {{'নাম'}} : {{$user->name}}</div>
                                        <div class="addDiv"> {{'ফোন'}} : {{$user->phone}}</div>
                                        <div class="addDiv"> {{'ই-মেইল'}} : {{$user->email}}</div>
                                        <div class="addDiv"> {{$a1}} : {{$address[0]}}</div>
                                        <div class="addDiv">{{$a2}} : {{$address[1]}}</div>
                                        <div class="addDiv">{{$a3}} : {{$address[2]}}</div>
                                        <div class="addDiv">{{$a4}} : {{$address[3]}}</div>
                                        <div class="addDiv">{{$a5}} : {{$address[4]}}</div>
                                        <div class="addDiv">{{'ঠিকানা'}} : {{$user->address}}</div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(Cookie::get('user_id'))
                                <div class="form-check">
                                    <input class="form-check-input aaa" name="dif_add" type="checkbox" value="dif_add" id="ddd">
                                    <label class="form-check-label" for="ddd">
                                        Ship to a different address?
                                    </label>
                                </div>
{{--                                <div class="form-group checkbox-toggle pb-2">--}}
{{--                                    <input type="checkbox" class="custom-checkbox aaa" id="ddd"--}}
{{--                                           name="shipping-toggle">--}}
{{--                                    <label for="add">Ship to a different address?</label>--}}
{{--                                </div>--}}
                            @endif
                            <?php
                                if(!Cookie::get('user_id'))
                                      $class = '';
                                else
                                    $class = 'checkbox-content';
                            ?>
                            <div class="{{$class}}">
                                <div class="form-group">
                                    <label for="name" >নাম</label>
                                    <input type="text" class="form-control name" name="name" placeholder="নাম"  required>
                                </div>
                                <div class="form-group">
                                    <label for="name" >ই-মেইল</label>
                                    <input type="email" class="form-control email" name="email" placeholder="ই-মেইল"  required>
                                </div>
                                <div class="form-group">
                                    <label for="phone" >ফোন </label>
                                    <input type="tel" class="form-control phone" name="phone" placeholder="ফোন নম্বর" pattern="\+?(88)?0?1[3456789][0-9]{8}\b"  required>
                                </div>
                                <div class="form-group">
                                    <label for="div_name" >লিঙ্গ</label> &nbsp;&nbsp;
                                    <label class="radio-inline">
                                        <input type="radio" class="gender" name="gender"  id="male" value="M" required>&nbsp;&nbsp; পুরুষ
                                    </label>&nbsp;&nbsp;
                                    <label class="radio-inline">
                                        <input type="radio" class="gender" name="gender" id="female" value="F"> &nbsp;&nbsp;মহিলা
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="div_name">বিভাগ</label>
                                    <select id="div_name" name ="div_id"  class="form-control select2 div_name" style="width: 100%;" required="required">
                                        <option value="" selected>বিভাগ নির্বাচন করুন</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="div_name" >বসবাস</label>&nbsp;&nbsp;
                                    <label class="radio-inline">
                                        <input type="radio" name="addressGroup"  id="zillaGroup" value="1" required>&nbsp;&nbsp; জেলা
                                    </label>&nbsp;&nbsp;
                                    <label class="radio-inline">
                                        <input type="radio" name="addressGroup" id="cityGroup" value="2">&nbsp;&nbsp;সিটি
                                    </label>
                                </div>
                                <div id= "zillaGroupId" style="display: none;">
                                    <div class="form-group">
                                        <label for="dis_name" >জেলা</label>
                                        <select id="dis_name" name ="disid" class="form-control select2 dis_name" style="width: 100%;" required="required">
                                            <option  value="" selected>জেলা  নির্বাচন করুন</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="upz_name" >উপজেলা</label>
                                        <select id="upz_name" name ="upzid" class="form-control select2 upz_name" style="width: 100%;" required="required">
                                            <option value="" selected>উপজেলা  নির্বাচন করুন</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="uni_name" >ইউনিয়ন</label>
                                        <select id="uni_name" name ="uniid" class="form-control select2 uni_name" style="width: 100%;" required="required">
                                            <option value="" selected>ইউনিয়ন  নির্বাচন করুন</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="ward_name" >ওয়ার্ড</label>
                                        <select id="ward_name" name ="wardid" class="form-control select2 ward_name" style="width: 100%;" required="required">
                                            <option value="" selected>ওয়ার্ড  নির্বাচন করুন</option>
                                        </select>
                                    </div>
                                </div>
                                <div id= "cityGroupId" style="display: none;">
                                    <div class="form-group">
                                        <label for="c_dis_name" >সিটি</label>
                                        <select id="c_dis_name" name ="c_disid" class="form-control select2 city_name" style="width: 100%;" required="required">
                                            <option  value="" selected>সিটি  নির্বাচন করুন</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="c_upz_name" >সিটি - কর্পোরেশন</label>
                                        <select id="c_upz_name" name ="c_upzid" class="form-control select2 co_name"  style="width: 100%;" required="required">
                                            <option value="" selected>সিটি - কর্পোরেশন  নির্বাচন করুন</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="c_uni_name" >থানা</label>
                                        <select id="c_uni_name" name ="c_uniid" class="form-control select2 thana_name" style="width: 100%;" required="required">
                                            <option value="" selected>থানা  নির্বাচন করুন</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="c_ward_name" >ওয়ার্ড</label>
                                        <select id="c_ward_name" name ="c_wardid" class="form-control select2 c_ward_name" style="width: 100%;" required="required">
                                            <option value="" selected>ওয়ার্ড  নির্বাচন করুন</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address" >ঠিকানা</label>
                                    <input type="text" class="form-control address" name="address" placeholder="ঠিকানা"  required>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label for="order-notes">Order notes (optional)</label>
                                <textarea class="form-control mb-0" id="order-notes" name="order-notes" cols="30"
                                          rows="4"
                                          placeholder="Notes about your order, e.g special notes for delivery"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-5 mb-4 sticky-sidebar-wrapper">
                            <div class="order-summary-wrapper sticky-sidebar">
                                <h3 class="title text-uppercase ls-10">Your Order</h3>
                                <div class="order-summary">
                                    <table class="order-table">
                                        <thead>
                                            <tr>
                                                <th colspan="2">
                                                    <b>Product</b>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($output as $p)
                                                <tr class="bb-no">
                                                    <td class="product-name">{{$p[0]}} <i
                                                            class="fas fa-times"></i> <span
                                                            class="product-quantity">{{$p[2]}}</span></td>
                                                    <td class="product-total">{{$p[1].' টাকা'}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="order-total">
                                                <td>
                                                    <b>Subtotal</b>
                                                </td>
                                                <td>
                                                    <b>{{$total['s_total'].' টাকা'}}</b>
                                                </td>
                                            </tr>
                                            <tr class="order-total">
                                                <th>
                                                    <b>Shipping</b>
                                                </th>
                                                <td>
                                                    <b>{{$total['delivery'].' টাকা'}}</b>
                                                </td>
                                            </tr>
                                            @if(@$total['g_discount'])
                                            <tr class="order-total">
                                                <th>
                                                    <b>Discount</b>
                                                </th>
                                                <td>
                                                    <b>{{$total['g_discount'].' টাকা'}}</b>
                                                </td>
                                            </tr>
                                            @endif
                                            <tr class="order-total">
                                                <th>
                                                    <b>Total</b>
                                                </th>
                                                <td>
                                                    <b class="g_total_ch">{{$total['g_total'].' টাকা'}}</b>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <br>
                                    @if(Cookie::get('user_id'))
                                        <div class="form-check">
                                            <input class="form-check-input w_donate" name="w_donate" type="checkbox" value="" id="w_donate">
                                            <label class="form-check-label" for="w_donate">
                                                Do you want to donate?
                                            </label>
                                        </div>
                                    @endif
                                    <div class="payment-methods" id="payment_method">
                                        <h4 class="title font-weight-bold ls-25 pb-0 mb-1">Payment Methods</h4>
                                        <div class="accordion payment-accordion">
                                            <div class="card">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <a href="#online-tab" class="collapse online">Online Payment</a>
                                                    </div>
                                                    <div id="online-tab" class="card-body expanded">
                                                        <input type="hidden" name="online" id="online" class="online" value="">
                                                        <p class="mb-0">
                                                            You must pay vai online with debit/credit card and mobile banking.
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header">
                                                        <a href="#delivery" class="expand cash">Cash on delivery</a>
                                                    </div>
                                                    <div id="delivery" class="card-body collapsed">
                                                        <input type="hidden" name="cash" id="cash" class="cash" value="">
                                                        <p class="mb-0">
                                                            Pay with cash upon delivery.
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header">
                                                        <a href="#cash-on-delivery" class="expand bank">Direct Bank Transfor</a>
                                                    </div>
                                                    <div id="cash-on-delivery" class="card-body collapsed bank">
                                                        <input type="hidden" name="bank" id="bank" class="bank" value="">
                                                        <p class="mb-0">
                                                            Make your payment directly into our bank account.
                                                            Please use your Order ID as the payment reference.
                                                            Your order will not be shipped until the funds have cleared in our account.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if($count_c > 0)
                                    <div class="form-group place-order pt-6">
                                        <button type="submit" class="btn btn-dark btn-block btn-rounded">Place Order</button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
        <!-- End of PageContent -->
    </main>
    <!-- End of Main -->
@endsection
@section('js')

    <script>

        if($("#sample").val() == 3){
            $('.name').prop('required',true);
            $('.email').prop('required',true);
            $('.phone').prop('required',true);
            $('.gender').prop('required',true);
            $('#zillaGroup').prop('required',true);
            $('.cityGroup').prop('required',true);
            $('.div_name').prop('required',true);
            $('.address').prop('required',true);
            $('.city_name').prop('required',true);
            $('.co_name').prop('required',true);
            $('.thana_name').prop('required',true);
            $('.c_ward_name').prop('required',true);
            $('.dis_name').prop('required',true);
            $('.upz_name').prop('required',true);
            $('.uni_name').prop('required',true);
            $('.ward_name').prop('required',true);
        }
        else{
            $('.name').prop('required',false);
            $('.email').prop('required',false);
            $('.phone').prop('required',false);
            $('.gender').prop('required',false);
            $('#zillaGroup').prop('required',false);
            $('.cityGroup').prop('required',false);
            $('.div_name').prop('required',false);
            $('.address').prop('required',false);
            $('.city_name').prop('required',false);
            $('.co_name').prop('required',false);
            $('.thana_name').prop('required',false);
            $('.c_ward_name').prop('required',false);
            $('.dis_name').prop('required',false);
            $('.upz_name').prop('required',false);
            $('.uni_name').prop('required',false);
            $('.ward_name').prop('required',false);
        }
        $("#online").val('online');
        $(".online").click(function(){
            $("#online").val('online');
            $("#cash").val('');
            $("#bank").val('');
        });
        $(".cash").click(function(){
            $("#cash").val('cash');
            $("#online").val('');
            $("#bank").val('');
        });
        $(".bank").click(function(){
            $("#bank").val('bank');
            $("#online").val('');
            $("#cash").val('');
        });
        $(".w_donate").click(function() {
            if ($("#w_donate").prop('checked') == true) {
                $("#w_donate").val('w_donate');
                $.ajax({
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': 'w_donate',
                    },
                    url: '{{ url('getDonatePrice') }}',
                    dataType: 'json',
                    success: function (response) {
                        if (!response.error) {
                            var g_text = $('.g_total_ch').text();
                            var result = g_text.split(' ');
                            var result1 = result[0].split('.');
                            var final = parseInt(result1[0]);
                            var g_total = response.donate_total['g_total']
                            var g_total1 = g_total.split('.');
                            var final1 = parseInt(g_total1[0]);
                            var total = final1 + final;
                            $('.g_total_ch').html(total + '.00 টাকা');
                        }
                    }
                });
            }
            else{
                $("#w_donate").val('');
                $.ajax({
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': 'n_donate',
                    },
                    url: '{{ url('getDonatePrice') }}',
                    dataType: 'json',
                    success: function (response) {
                        if (!response.error) {
                            var g_text = $('.g_total_ch').text();
                            var result = g_text.split(' ');
                            var result1 = result[0].split('.');
                            var final = parseInt(result1[0]);
                            var g_total = response.donate_total['g_total']
                            var g_total1 = g_total.split('.');
                            var final1 = parseInt(g_total1[0]);
                            var total = final - final1;
                            $('.g_total_ch').html(total + '.00 টাকা');
                        }
                    }
                });
            }
        });
        $(".aaa").click(function(){
            if($("#ddd").prop('checked') == true){
                $(".checkbox-content").show();
                $('.name').prop('required',true);
                $('.email').prop('required',true);
                $('.phone').prop('required',true);
                $('.gender').prop('required',true);
                $('.div_name').prop('required',true);
                $('.address').prop('required',true);
            }
            else{
                $(".checkbox-content").hide();
                $('.name').prop('required',false);
                $('.email').prop('required',false);
                $('.phone').prop('required',false);
                $('.gender').prop('required',false);
                $('#zillaGroup').prop('required',false);
                $('.cityGroup').prop('required',false);
                $('.div_name').prop('required',false);
                $('.address').prop('required',false);
                $('.city_name').prop('required',false);
                $('.co_name').prop('required',false);
                $('.thana_name').prop('required',false);
                $('.c_ward_name').prop('required',false);
                $('.dis_name').prop('required',false);
                $('.upz_name').prop('required',false);
                $('.uni_name').prop('required',false);
                $('.ward_name').prop('required',false);
            }
        });
        $("#zillaGroup").click(function(){
            $("#zillaGroupId").show();
            $("#cityGroupId").hide();
            $('.city_name').prop('required',false);
            $('.co_name').prop('required',false);
            $('.thana_name').prop('required',false);
            $('.c_ward_name').prop('required',false);
        });
        $("#cityGroup").click(function(){
            $("#zillaGroupId").hide();
            $("#cityGroupId").show();
            $('.dis_name').prop('required',false);
            $('.upz_name').prop('required',false);
            $('.uni_name').prop('required',false);
            $('.ward_name').prop('required',false);
        });
        $(document).ready(function(){
            $.ajax({
                url: 'getAllDivision',
                type: "GET",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (response) {
                    var data = response.data;
                    var len = data.length;
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id'];
                        var name = data[i]['name'];
                        $(".div_name").append("<option value='"+id+"'>"+name+"</option>");
                    }

                },
                failure: function (msg) {
                    alert('an error occured');
                }
            });
        });
        $(function(){
            //$('.select2').select2();
            $(".div_name").change(function(){
                var id =$(this).val();
                $('.dis_name').find('option:not(:first)').remove();
                $.ajax({
                    type: 'GET',
                    url: 'getDistrictListAll',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        var data = response.data;
                        var len = data.length;
                        for( var i = 0; i<len; i++){
                            var id = data[i]['id'];
                            var name = data[i]['name'];
                            $(".dis_name").append("<option value='"+id+"'>"+name+"</option>");
                        }
                    }
                });
            });
            $(".dis_name").change(function(){
                var id =$(this).val();
                $('.upz_name').find('option:not(:first)').remove();
                $.ajax({
                    type: 'GET',
                    url: 'getUpazillaListAll',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        var data = response.data;
                        var len = data.length;
                        for( var i = 0; i<len; i++){
                            var id = data[i]['id'];
                            var name = data[i]['name'];
                            $(".upz_name").append("<option value='"+id+"'>"+name+"</option>");
                        }
                    }
                });
            });
            $(".upz_name").change(function(){
                var id =$(this).val();
                $('.uni_name').find('option:not(:first)').remove();
                $.ajax({
                    type: 'GET',
                    url: 'getUnionListAll',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        var data = response.data;
                        var len = data.length;
                        for( var i = 0; i<len; i++){
                            var id = data[i]['id'];
                            var name = data[i]['name'];
                            $(".uni_name").append("<option value='"+id+"'>"+name+"</option>");
                        }
                    }
                });
            });
            $(".uni_name").change(function(){
                var id =$(this).val();
                $('.ward_name').find('option:not(:first)').remove();
                $.ajax({
                    type: 'GET',
                    url: 'getWardListAll',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        var data = response.data;
                        var len = data.length;
                        for( var i = 0; i<len; i++){
                            var id = data[i]['id'];
                            var name = data[i]['name'];
                            $(".ward_name").append("<option value='"+id+"'>"+name+"</option>");
                        }
                    }
                });
            });
            $(".div_name").change(function(){
                var id =$(this).val();
                $('.city_name').find('option:not(:first)').remove();
                $.ajax({
                    type: 'GET',
                    url: 'getCityListAll',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        var data = response.data;
                        var len = data.length;
                        for( var i = 0; i<len; i++){
                            var id = data[i]['id'];
                            var name = data[i]['name'];
                            $(".city_name").append("<option value='"+id+"'>"+name+"</option>");
                        }
                    }
                });
            });
            $(".city_name").change(function(){
                var id =$(this).val();
                $('.co_name').find('option:not(:first)').remove();
                $.ajax({
                    type: 'GET',
                    url: 'getCityCorporationListAll',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        var data = response.data;
                        var len = data.length;
                        for( var i = 0; i<len; i++){
                            var id = data[i]['id'];
                            var name = data[i]['name'];
                            $(".co_name").append("<option value='"+id+"'>"+name+"</option>");
                        }
                    }
                });
            });
            $(".co_name").change(function(){
                var id =$(this).val();
                $('.thana_name').find('option:not(:first)').remove();
                $.ajax({
                    type: 'GET',
                    url: 'getThanaListAll',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        var data = response.data;
                        var len = data.length;
                        for( var i = 0; i<len; i++){
                            var id = data[i]['id'];
                            var name = data[i]['name'];
                            $(".thana_name").append("<option value='"+id+"'>"+name+"</option>");
                        }
                    }
                });
            });
            $(".thana_name").change(function(){
                var id =$(this).val();
                $('.c_ward_name').find('option:not(:first)').remove();
                $.ajax({
                    type: 'GET',
                    url: 'getC_wardListAll',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        var data = response.data;
                        var len = data.length;
                        for( var i = 0; i<len; i++){
                            var id = data[i]['id'];
                            var name = data[i]['name'];
                            $(".c_ward_name").append("<option value='"+id+"'>"+name+"</option>");
                        }
                    }
                });
            });
        });
    </script>
@endsection
