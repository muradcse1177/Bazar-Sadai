@extends('frontend.layout')
@section('title', 'Humanity || Bazar-Sadai.com Best online Shop in Bangladesh')
@section('', 'active')
@section('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{url('public/asset/woolmart/css/style.min.css')}}">
    <style>
        form, input, label, p {
            color: black !important;
        }
        .form-group > select > option{
            color: black !important;
        }
        @media screen and (max-width: 600px) {
            .main{
                margin-top: -30px;
            }
        }
        .intro-slide {
            min-height: 30rem;
        }

    </style>

@endsection
@section('content')
    <main class="main">
        <!-- Start of Page Header -->
        <div class="page-header" style="">
            <div class="container">
                <h1 class="page-title mb-0"> মেডিকেল সার্ভিস</h1>
            </div>
        </div>
        <br>

        <div class="page-content">
            <div class="container">
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
                <div class="row">
                    <div class="col-md-12">
                        <?php
                            function en2bn($number) {
                                $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
                                $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
                                $bn_number = str_replace($search_array, $replace_array, $number);
                                return $bn_number;
                            }
                            ?>
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <div class="box-header with-border">
                                    <h4 class="box-title"><i class="fa fa-calendar"></i> <b>এপর্যন্ত প্রাপ্ত দান হতে মানুষের জন্য পাওয়া গিয়েছে।</b></h4>
                                    <div class="box-body table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>পণ্য</th>
                                                <th>পরিমান</th>
                                            </tr>
                                            @foreach($products as $product)
                                                <?php
                                                    if($product->cat_id == 3)
                                                        $unit ="টি";
                                                    else
                                                        $unit = $product-> unit;
                                                ?>
                                                <tr>
                                                    <td> {{$product-> name}} </td>
                                                    <td> {{en2bn($product-> quantity).' '.$unit}} </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                    <p style="text-align: justify;"><b> মানুষের জন্য প্রাপ্ত দান হতে সাহায্য পাওয়ার জন্য বা আপনার নিকটস্থ খোঁজ পাওয়া অসহায় বা অর্থাভাবে চিকিৎসা করাতে পারছে না এমন মানুষের জন্য আমাদের সাথে যোগাযোগ করুন ।</b></p>
                                    <p style="text-align: justify;"><a href ='{{ URL::to('shop') }}'> <u>নিত্য প্রয়োজনীয় জিনিষ ডোনেট করুন।</u></a></p>
                                    <p style="text-align: justify;"><a href ='{{ URL::to('shop-by-cat/3') }}'> <u>মেডিসিন ডোনেট করুন।</u></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('js')
    <script>
    </script>
@endsection
