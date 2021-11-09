<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Middleware\courier;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use smasif\ShurjopayLaravelPackage\ShurjopayService;

class FrontController extends Controller
{
    public function homepageManager(Request $request){
        try{
//            $firebaseToken =  DB::table('users')->select('device_token')->where('id',Cookie::get('user_id'))->first();
//
//            $SERVER_API_KEY = 'AAAA3gEyg8M:APA91bE6ClEoshglugNTdxTMNXMyMdyUywdq5_NWI7j3dlLlYeWJzgNXrF-QKQhv-Npa6fSWDXwc09MyL5YtmrmxM0XMt3yCoE4KdFmqIX_AB-RxQbarCE5YPW-Wr-9-0mjG2_czWw8q';
//            $dd = array();
//            $dd = [''.$firebaseToken->device_token.''];
//            $data = [
//                "registration_ids" => $dd,
//                "notification" => [
//                    "title" => 'title',
//                    "body" => 'body',
//                    "content_available" => true,
//                    "priority" => "high",
//                ]
//            ];
//            $dataString = json_encode($data);
//
//            $headers = [
//                'Authorization: key=' . $SERVER_API_KEY,
//                'Content-Type: application/json',
//            ];
//            $ch = curl_init();
//            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
//            curl_setopt($ch, CURLOPT_POST, true);
//            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
//
//            $response = curl_exec($ch);
//
//            dd($response);

            $slide= DB::table('slide')
                ->orderBy('id', 'DESC')
                ->take(10)->get();
            $service_cat = DB::table('categories')
                ->where('type', 2)
                ->where('status', 1)
                ->orderBy('id', 'DESC')->get();
            $product_cat = DB::table('categories')
                ->where('type','1')
                ->where('status','1')
                ->orWhere('type','3')
                ->where('status','1')
                ->orderBy('id', 'ASC')->get();
            if(Cookie::get('user_id') != null) {
                $customer = DB::table('users')
                    ->where('id',Cookie::get('user_id'))
                    ->first();
                $dealer = DB::table('users')
                    ->where('add_part1',$customer->add_part1)
                    ->where('add_part2',$customer->add_part2)
                    ->where('add_part3',$customer->add_part3)
                    ->where('address_type',$customer->address_type)
                    ->where('user_type',7)
                    ->first();
                if(!empty($dealer)) {
                    $dealer_product_1 = DB::table('products')
                        ->select('*', 'product_assign.id as p_a_id', 'products.id as id')
                        ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                        ->where('products.cat_id', 1)
                        ->where('products.status', 1)
                        ->where('product_assign.dealer_id', $dealer->id)
                        ->orderBy('products.id', 'ASC')->take(30)->get();

                    if($dealer_product_1->count()>0){
                        $dealer_status_1['status'] = 1;
                    }
                }
                else{
                    $dealer_product_1 = DB::table('products')
                        ->where('cat_id', 1)
                        ->where('status', 1)
                        ->orderBy('id', 'ASC')->take(30)->get();
                    $dealer_status_1['status'] = 0;
                }
            }
            else {
                $dealer_product_1 = DB::table('products')
                    ->where('cat_id', 1)
                    ->where('status', 1)
                    ->orderBy('id', 'ASC')->take(30)->get();
                $dealer_status_1['status'] = 0;

            }
            if(Cookie::get('user_id') != null) {
                $customer = DB::table('users')
                    ->where('id',Cookie::get('user_id'))
                    ->first();
                $dealer = DB::table('users')
                    ->where('add_part1',$customer->add_part1)
                    ->where('add_part2',$customer->add_part2)
                    ->where('add_part3',$customer->add_part3)
                    ->where('address_type',$customer->address_type)
                    ->where('user_type',7)
                    ->first();
                if(!empty($dealer)) {
                    $dealer_product_2 = DB::table('products')
                        ->select('*', 'product_assign.id as p_a_id', 'products.id as id')
                        ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                        ->where('products.cat_id', 2)
                        ->where('products.status', 1)
                        ->where('product_assign.dealer_id', $dealer->id)
                        ->orderBy('products.id', 'ASC')->take(30)->get();
                    if($dealer_product_2->count()>0){
                        $dealer_status_2['status'] = 1;
                    }
                }
                else{
                    $dealer_product_2 = DB::table('products')
                        ->where('cat_id', 2)
                        ->where('status', 1)
                        ->orderBy('id', 'ASC')->take(30)->get();
                    $dealer_status_2['status'] = 0;
                }
            }
            else {
                $dealer_product_2 = DB::table('products')
                    ->where('cat_id', 2)
                    ->where('status', 1)
                    ->orderBy('id', 'ASC')->take(30)->get();
                $dealer_status_2['status'] = 0;

            }
            if(Cookie::get('user_id') != null) {
                $customer = DB::table('users')
                    ->where('id',Cookie::get('user_id'))
                    ->first();
                $dealer = DB::table('users')
                    ->where('add_part1',$customer->add_part1)
                    ->where('add_part2',$customer->add_part2)
                    ->where('add_part3',$customer->add_part3)
                    ->where('address_type',$customer->address_type)
                    ->where('user_type',7)
                    ->first();
                if(!empty($dealer)) {
                    $dealer_product_3 = DB::table('products')
                        ->select('*', 'product_assign.id as p_a_id', 'products.id as id')
                        ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                        ->where('products.cat_id', 3)
                        ->where('products.status', 1)
                        ->where('product_assign.dealer_id', $dealer->id)
                        ->orderBy('products.id', 'Asc')->take(30)->get();
                    if($dealer_product_3->count()>0){
                        $dealer_status_3['status'] = 1;
                    }
                }
                else{
                    $dealer_product_3 = DB::table('products')
                        ->where('cat_id', 3)
                        ->where('status', 1)
                        ->orderBy('id', 'Asc')->take(30)->get();
                    $dealer_status_3['status'] = 0;
                }
            }
            else {
                $dealer_product_3 = DB::table('products')
                    ->where('cat_id', 3)
                    ->where('status', 1)
                    ->orderBy('id', 'Asc')->take(30)->get();
                $dealer_status_3['status'] = 0;

            }
            //dd($dealer_product_1);
            return view('frontend.n_index',
                [
                    'ser_categories' => $service_cat,
                    'pro_categories' => $product_cat,
                    'slides' => $slide,
                    'products_1' => $dealer_product_1 ,
                    'status_1' =>$dealer_status_1,
                    'products_2' => $dealer_product_2 ,
                    'status_2' =>$dealer_status_2,
                    'products_3' => $dealer_product_3 ,
                    'status_3' =>$dealer_status_3
                ]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function shop(Request $request){
        try{
            $service_cat = DB::table('categories')
                ->where('type', 2)
                ->where('status', 1)
                ->orderBy('id', 'DESC')->get();
            $product_cat = DB::table('categories')
                ->where('type', 1)
                ->where('status', 1)
                ->orderBy('id', 'ASC')->get();
            if(Cookie::get('user_id') != null) {
                $customer = DB::table('users')
                    ->where('id',Cookie::get('user_id'))
                    ->first();
                $dealer = DB::table('users')
                    ->where('add_part1',$customer->add_part1)
                    ->where('add_part2',$customer->add_part2)
                    ->where('add_part3',$customer->add_part3)
                    ->where('address_type',$customer->address_type)
                    ->where('user_type',7)
                    ->first();
                if(!empty($dealer)) {
                    $dealer_product_1 = DB::table('products')
                        ->select('*', 'product_assign.id as p_a_id', 'products.id as id')
                        ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                        ->where('products.status', 1)
                        ->where('product_assign.dealer_id', $dealer->id)
                        ->orderBy('products.id', 'ASC')->paginate(60);
                    if($dealer_product_1->count()>0){
                        $dealer_status_1['status'] = 1;
                    }
                }
                else{
                    $dealer_product_1 = DB::table('products')
                        ->where('status', 1)
                        ->orderBy('id', 'ASC')->paginate(60);
                    $dealer_status_1['status'] = 0;
                }
            }
            else {
                $dealer_product_1 = DB::table('products')
                    ->where('status', 1)
                    ->orderBy('id', 'ASC')->paginate(60);
                $dealer_status_1['status'] = 0;
            }

            //dd($dealer_product_1);
            return view('frontend.shop',
                [
                    'pro_categories' => $product_cat,
                    'ser_categories' => $service_cat,
                    'products' => $dealer_product_1 ,
                    'status' =>$dealer_status_1,
                ]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function productById($id){
        try{
            $category = DB::table('products')
                ->where('id',$id)
                ->first();
            if(Cookie::get('user_id') != null) {
                $customer = DB::table('users')
                    ->where('id',Cookie::get('user_id'))
                    ->first();
                $dealer = DB::table('users')
                    ->where('add_part1',$customer->add_part1)
                    ->where('add_part2',$customer->add_part2)
                    ->where('add_part3',$customer->add_part3)
                    ->where('address_type',$customer->address_type)
                    ->where('user_type',7)
                    ->first();
                if(!empty($dealer)) {
                    $dealer_product_1 = DB::table('products')
                        ->select('*', 'product_assign.id as p_a_id', 'products.id as id')
                        ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                        ->where('products.status', 1)
                        ->where('products.id', $id)
                        ->where('product_assign.dealer_id', $dealer->id)->first();
                    $related_product = DB::table('products')
                        ->select('*', 'product_assign.id as p_a_id', 'products.id as id')
                        ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                        ->where('products.cat_id', $category->cat_id)
                        ->where('products.status', 1)
                        ->where('product_assign.dealer_id', $dealer->id)
                        ->orderBy('products.id','Asc')
                        ->take(10)->get();
                    $related_product_desc = DB::table('products')
                        ->select('*', 'product_assign.id as p_a_id', 'products.id as id')
                        ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                        ->where('products.cat_id', $category->cat_id)
                        ->where('products.status', 1)
                        ->where('product_assign.dealer_id', $dealer->id)
                        ->orderBy('products.id','DESC')
                        ->take(10)->get();
                    if($dealer_product_1){
                        $dealer_status_1['status'] = 1;
                    }
                }
                else{
                    $dealer_product_1 = DB::table('products')
                        ->where('products.id', $id)->first();
                    $related_product = DB::table('products')
                        ->where('products.cat_id', $category->cat_id)
                        ->where('products.status', 1)
                        ->orderBy('products.id','Asc')
                        ->take(10)
                        ->get();
                    $related_product_desc = DB::table('products')
                        ->where('products.cat_id', $category->cat_id)
                        ->where('products.status', 1)
                        ->orderBy('products.id','DESC')
                        ->take(10)
                        ->get();
                    $dealer_status_1['status'] = 0;
                }
            }
            else {
                $dealer_product_1 = DB::table('products')
                    ->where('products.id', $id)->first();
                $related_product = DB::table('products')
                    ->where('products.cat_id', $category->cat_id)
                    ->where('products.status', 1)
                    ->orderBy('products.id','Asc')
                    ->take(10)
                    ->get();
                $related_product_desc = DB::table('products')
                    ->where('products.cat_id', $category->cat_id)
                    ->where('products.status', 1)
                    ->orderBy('products.id','DESC')
                    ->take(10)
                    ->get();
                $dealer_status_1['status'] = 0;
            }
            //dd($dealer_product_1);
            return view('frontend.singleProduct',
                [
                    'products' => $dealer_product_1 ,
                    'rel_products' => $related_product ,
                    'rel_products_desc' => $related_product_desc ,
                    'status' =>$dealer_status_1,
                    'cat_id' =>$category->cat_id,
                ]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function shopBySubCat(Request $request){
        try{
            $product_cat = DB::table('categories')
                ->where('type', 1)
                ->where('status', 1)
                ->orderBy('id', 'ASC')->get();
            $service_cat = DB::table('categories')
                ->where('type', 2)
                ->where('status', 1)
                ->orderBy('id', 'DESC')->get();
            if(Cookie::get('user_id') != null) {
                $customer = DB::table('users')
                    ->where('id',Cookie::get('user_id'))
                    ->first();
                $dealer = DB::table('users')
                    ->where('add_part1',$customer->add_part1)
                    ->where('add_part2',$customer->add_part2)
                    ->where('add_part3',$customer->add_part3)
                    ->where('address_type',$customer->address_type)
                    ->where('user_type',7)
                    ->first();
                if(!empty($dealer)) {
                    $dealer_product = DB::table('products')
                        ->select('*', 'product_assign.id as p_a_id', 'products.id as id')
                        ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                        ->where('products.cat_id', $request->cat_id)
                        ->where('products.sub_cat_id', $request->sub_cat_id)
                        ->where('products.status', 1)
                        ->where('product_assign.dealer_id', $dealer->id)
                        ->orderBy('products.id', 'ASC')->paginate(100);
                    //dd($dealer_product);
                    if($dealer_product->count()>0){
                        $dealer_status['status'] = 1;
                        //dd($dealer_product);
                        return view('frontend.shop',
                            [
                                'products' => $dealer_product ,
                                'status' =>$dealer_status,
                                'ser_categories' => $service_cat,
                                'pro_categories' => $product_cat,
                            ]);
                    }
                }
                else{
                    $dealer_product = DB::table('products')
                        //->where('products.cat_id', $request->cat_id)
                        ->where('products.sub_cat_id', $request->sub_cat_id)
                        ->where('status', 1)
                        ->orderBy('id', 'ASC')->paginate(100);
                    $dealer_status['status'] = 0;
                    return view('frontend.shop',
                        [
                            'products' => $dealer_product ,
                            'status' =>$dealer_status,
                            'ser_categories' => $service_cat,
                            'pro_categories' => $product_cat,
                        ]);
                }
            }
            else {
                $dealer_product = DB::table('products')
                    ->where('products.cat_id', $request->cat_id)
                    ->where('products.sub_cat_id', $request->sub_cat_id)
                    ->where('status', 1)
                    ->orderBy('id', 'ASC')->paginate(100);
                $dealer_status['status'] = 0;
                return view('frontend.shop',
                    [
                        'products' => $dealer_product ,
                        'status' =>$dealer_status,
                        'ser_categories' => $service_cat,
                        'pro_categories' => $product_cat,
                    ]);
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function shopByPrice($id){
        try{
            $get_price  = explode('-',$id);
            $min_price = (int)$get_price[0];
            $max_price = (int)$get_price[1];
            if($max_price == 'un')
                $max_price = 10000000;
            $product_cat = DB::table('categories')
                ->where('type', 1)
                ->where('status', 1)
                ->orderBy('id', 'ASC')->get();
            $service_cat = DB::table('categories')
                ->where('type', 2)
                ->where('status', 1)
                ->orderBy('id', 'DESC')->get();
            if(Cookie::get('user_id') != null) {
                $customer = DB::table('users')
                    ->where('id',Cookie::get('user_id'))
                    ->first();
                $dealer = DB::table('users')
                    ->where('add_part1',$customer->add_part1)
                    ->where('add_part2',$customer->add_part2)
                    ->where('add_part3',$customer->add_part3)
                    ->where('address_type',$customer->address_type)
                    ->where('user_type',7)
                    ->first();
                if(!empty($dealer)) {
                    $dealer_product = DB::table('products')
                        ->select('*', 'product_assign.id as p_a_id', 'products.id as id')
                        ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                        ->whereBetween('products.price',[$min_price, $max_price])
                        ->where('products.status', 1)
                        ->where('product_assign.dealer_id', $dealer->id)
                        ->orderBy('products.id', 'ASC')->paginate(100);
                    //dd($dealer_product);
                    if($dealer_product->count()>0){
                        $dealer_status['status'] = 1;
                    }
                    else{
                        $dealer_status['status'] = 0;
                    }
                }
                else{
                    $dealer_product = DB::table('products')
                        ->whereBetween('products.price',[$min_price, $max_price])
                        ->where('status', 1)
                        ->orderBy('id', 'ASC')->paginate(100);
                    $dealer_status['status'] = 0;
                }
            }
            else {
                $dealer_product = DB::table('products')
                    ->whereBetween('products.price',[$min_price, $max_price])
                    ->where('status', 1)
                    ->orderBy('id', 'ASC')->paginate(100);
                $dealer_status['status'] = 0;
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
        return view('frontend.shop',
            [
                'products' => $dealer_product ,
                'status' =>$dealer_status,
                'ser_categories' => $service_cat,
                'pro_categories' => $product_cat,
            ]);
    }
    public function cart(){
        try{
            if(Cookie::get('user_id') != null ) {
                $id =Cookie::get('user_id');
                $rowsCount = DB::table('carts')
                    ->where('user_id', $id)
                    ->distinct()->get()->count();
            }
            else{
                $cart_item = Session::get('cart_item');
                if(count($cart_item)>0){
                    $rowsCount = count($cart_item);
                }
                else{
                    $rowsCount =0;
                }
            }
            return view('frontend.cart', ['count' => $rowsCount]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function couponCheck(Request $request){
        if($request->coupon_code){
            $output = array();
            $total_arr = array();
            $item = array();
            $i =0;
            $c_count = 0;
            $coupon = DB::table('coupon')
                ->where('name',$request->coupon_code)
                ->whereDate('start_date', '<=', Date('y-m-d'))
                ->whereDate('end_date', '>=', Date('y-m-d'))
                ->first();
            if($coupon){
                $discount = $coupon->discount;
                if(Cookie::get('user_id') != null ) {
                    $id =Cookie::get('user_id');
                    $rowsCount = DB::table('carts')
                        ->where('user_id', $id)
                        ->distinct()->get()->count();
                    if($rowsCount > 0){
                        $user = DB::table('users')
                            ->where('id',Cookie::get('user_id'))
                            ->first();
                        $address_type = $user->address_type;
                        $add_part1 = DB::table('divisions')
                            ->where('id',$user->add_part1)
                            ->first();
                        if($address_type==1){
                            $add_part2 = DB::table('districts')
                                ->where('div_id',$user->add_part1)
                                ->where('id',$user->add_part2)
                                ->first();
                            $add_part3 = DB::table('upazillas')
                                ->where('div_id',$user->add_part1)
                                ->where('dis_id',$user->add_part2)
                                ->where('id',$user->add_part3)
                                ->first();
                            $add_part4 = DB::table('unions')
                                ->where('div_id',$user->add_part1)
                                ->where('dis_id',$user->add_part2)
                                ->where('upz_id',$user->add_part3)
                                ->where('id',$user->add_part4)
                                ->first();
                            $add_part5 = DB::table('wards')
                                ->where('div_id',$user->add_part1)
                                ->where('dis_id',$user->add_part2)
                                ->where('upz_id',$user->add_part3)
                                ->where('uni_id',$user->add_part4)
                                ->where('id',$user->add_part5)
                                ->first();
                        }
                        if($address_type==2){
                            $add_part2 = DB::table('cities')
                                ->where('div_id',$user->add_part1)
                                ->where('id',$user->add_part2)
                                ->first();
                            $add_part3 = DB::table('city_corporations')
                                ->where('div_id',$user->add_part1)
                                ->where('city_id',$user->add_part2)
                                ->where('id',$user->add_part3)
                                ->first();
                            $add_part4 = DB::table('thanas')
                                ->where('div_id',$user->add_part1)
                                ->where('city_id',$user->add_part2)
                                ->where('city_co_id',$user->add_part3)
                                ->where('id',$user->add_part4)
                                ->first();
                            $add_part5 = DB::table('c_wards')
                                ->where('div_id',$user->add_part1)
                                ->where('city_id',$user->add_part2)
                                ->where('city_co_id',$user->add_part3)
                                ->where('id',$user->add_part4)
                                ->where('id',$user->add_part4)
                                ->first();
                        }
                        $address = [$add_part1->name, $add_part2->name,$add_part3->name,$add_part4->name, $add_part5->name];
                        if(Session::has('cart_item')){
                            foreach(Session::get('cart_item') as $row){
                                $rowsCount = DB::table('carts')
                                    ->where('user_id', Cookie::get('user_id'))
                                    ->where('product_id', $row['productid'])
                                    ->distinct()->get()->count();
                                if($rowsCount < 1){
                                    $result = DB::table('carts')->insert([
                                        'user_id' => Cookie::get('user_id'),
                                        'product_id' => $row['productid'],
                                        'quantity' => $row['quantity']
                                    ]);
                                    $result1 = DB::table('donate_carts')->insert([
                                        'user_id' => Cookie::get('user_id'),
                                        'product_id' => $row['productid'],
                                        'quantity' => $row['quantity']
                                    ]);
                                }
                                else{
                                    $result =DB::table('carts')
                                        ->where('user_id',  Cookie::get('user_id'))
                                        ->where('product_id', $row['productid'])
                                        ->update([
                                            'quantity' => $row['quantity'],
                                        ]);
                                    $result1 =DB::table('donate_carts')
                                        ->where('user_id',  Cookie::get('user_id'))
                                        ->where('product_id', $row['productid'])
                                        ->update([
                                            'quantity' => $row['quantity'],
                                        ]);
                                }
                            }
                            session()->forget('cart_item');
                        }
                        try{
                            $total = 0;
                            $customer = DB::table('users')
                                ->where('id',Cookie::get('user_id'))
                                ->first();
                            $dealer = DB::table('users')
                                ->where('add_part1',$customer->add_part1)
                                ->where('add_part2',$customer->add_part2)
                                ->where('add_part3',$customer->add_part3)
                                ->where('address_type',$customer->address_type)
                                ->where('user_type',7)
                                ->first();
                            $stmt = DB::table('carts')
                                ->select('*','carts.id AS cartid')
                                ->leftJoin('products', 'products.id', '=', 'carts.product_id')
                                ->join('product_assign','product_assign.product_id', '=','products.id')
                                ->where('carts.user_id',Cookie::get('user_id'))
                                ->where('product_assign.dealer_id',$dealer->id)
                                ->orderBy('products.id','Asc')
                                ->get();
                            $c_count = $stmt->count();
                            if($stmt->count() > 0) {
                                foreach ($stmt as $row) {
                                    $quantity =$row->quantity / $row->minqty;
                                    $subtotal = $row->edit_price * $quantity;
                                    $total += $subtotal;
                                    $item[] = $row->name;
                                    $item[] = $subtotal;
                                    $item[] = $quantity;
                                    $output[$i] = $item;
                                    $i++;
                                    $item = array();
                                }
                                $rows = DB::table('delivery_charges')
                                    ->where('lower','<=', $total)
                                    ->where('higher','>=', $total)
                                    ->first();
                                $delivery_charge = $rows->charge;
                                $total_arr['delivery'] = number_format($delivery_charge, 2);
                                $total_arr['s_total'] = number_format($total, 2);
                                $total_arr['g_discount'] = number_format($discount, 2);
                                $total_arr['g_total'] = number_format($total + $delivery_charge - $discount, 2);
                                Session::put('discount',$total_arr['g_discount']);
                                Session::save();
                                return view('frontend.checkout',['output'=>$output,'total' => $total_arr,'user'=>$user,'address'=>$address,'count'=>$c_count]);
                            }
                            else{
                                return redirect()->to('checkout')->with('errorMessage','Your Cart is empty.');
                            }

                        }
                        catch(\Illuminate\Database\QueryException $ex){
                            return back()->with('errorMessage', $ex->getMessage());
                        }
                    }
                    else{
                        return redirect()->to('checkout')->with('errorMessage','Your Cart is empty.');
                    }
                }
                else{
                    $cart_item = Session::get('cart_item');
                    if(count($cart_item) > 0){
                        $address = array();
                        $user = array();
                        $total = 0;
                        $c_count = count($cart_item);
                        foreach (Session::get('cart_item') as $row) {
                            $product = DB::table('products')
                                ->where('id', $row['productid'])
                                ->first();
                            $quantity = $row['quantity'] / $product->minqty;
                            $price = $product->price;
                            $subtotal = $price * $quantity;
                            $total += $subtotal;
                            $bprice = $this->en2bn($price);
                            $item[] = $product->name;
                            $item[] = $subtotal;
                            $item[] = $quantity;
                            $output[$i] = $item;
                            $i++;
                            $item = array();
                        }
                        $rows = DB::table('delivery_charges')
                            ->where('lower','<=', $total)
                            ->where('higher','>=', $total)
                            ->first();
                        $delivery_charge = $rows->charge;
                        $total_arr['delivery'] = number_format($delivery_charge, 2);
                        $total_arr['s_total'] = number_format($total, 2);
                        $total_arr['g_discount'] = number_format($discount, 2);
                        $total_arr['g_total'] = number_format($total + $delivery_charge - $discount, 2);
                        Session::put('discount',$total_arr['g_discount']);
                        Session::save();
                        return view('frontend.checkout',['output'=>$output,'total' => $total_arr,'user'=>$user,'address'=>$address,'count'=>$c_count]);
                    }
                    else{
                        return redirect()->to('checkout')->with('errorMessage','Your Cart is empty.');
                    }
                }
            }
            else{
                return redirect()->to('checkout')->with('errorMessage','Coupon is expired or not found.');
            }
        }
        else{
            return redirect()->to('checkout')->with('errorMessage','Coupon code not found.');
        }
    }
    public function checkout(){
        if(Cookie::get('user_id')){
            $user = DB::table('users')
                ->where('id',Cookie::get('user_id'))
                ->first();
            $address_type = $user->address_type;
            $add_part1 = DB::table('divisions')
                ->where('id',$user->add_part1)
                ->first();
            if($address_type==1){
                $add_part2 = DB::table('districts')
                    ->where('div_id',$user->add_part1)
                    ->where('id',$user->add_part2)
                    ->first();
                $add_part3 = DB::table('upazillas')
                    ->where('div_id',$user->add_part1)
                    ->where('dis_id',$user->add_part2)
                    ->where('id',$user->add_part3)
                    ->first();
                $add_part4 = DB::table('unions')
                    ->where('div_id',$user->add_part1)
                    ->where('dis_id',$user->add_part2)
                    ->where('upz_id',$user->add_part3)
                    ->where('id',$user->add_part4)
                    ->first();
                $add_part5 = DB::table('wards')
                    ->where('div_id',$user->add_part1)
                    ->where('dis_id',$user->add_part2)
                    ->where('upz_id',$user->add_part3)
                    ->where('uni_id',$user->add_part4)
                    ->where('id',$user->add_part5)
                    ->first();
            }
            if($address_type==2){
                $add_part2 = DB::table('cities')
                    ->where('div_id',$user->add_part1)
                    ->where('id',$user->add_part2)
                    ->first();
                $add_part3 = DB::table('city_corporations')
                    ->where('div_id',$user->add_part1)
                    ->where('city_id',$user->add_part2)
                    ->where('id',$user->add_part3)
                    ->first();
                $add_part4 = DB::table('thanas')
                    ->where('div_id',$user->add_part1)
                    ->where('city_id',$user->add_part2)
                    ->where('city_co_id',$user->add_part3)
                    ->where('id',$user->add_part4)
                    ->first();
                $add_part5 = DB::table('c_wards')
                    ->where('div_id',$user->add_part1)
                    ->where('city_id',$user->add_part2)
                    ->where('city_co_id',$user->add_part3)
                    ->where('id',$user->add_part4)
                    ->where('id',$user->add_part4)
                    ->first();
            }
            $address = [$add_part1->name, $add_part2->name,$add_part3->name,$add_part4->name, $add_part5->name];
        }
        else{
            $address = array();
            $user = array();
        }
        $output = array();
        $total_arr = array();
        $item = array();
        $i =0;
        $c_count = 0;
        if(Cookie::get('user_id') != null ){
            if(Session::has('cart_item')){
                foreach(Session::get('cart_item') as $row){
                    $rowsCount = DB::table('carts')
                        ->where('user_id', Cookie::get('user_id'))
                        ->where('product_id', $row['productid'])
                        ->distinct()->get()->count();
                    if($rowsCount < 1){
                        $result = DB::table('carts')->insert([
                            'user_id' => Cookie::get('user_id'),
                            'product_id' => $row['productid'],
                            'quantity' => $row['quantity']
                        ]);
                        $result1 = DB::table('donate_carts')->insert([
                            'user_id' => Cookie::get('user_id'),
                            'product_id' => $row['productid'],
                            'quantity' => $row['quantity']
                        ]);
                    }
                    else{
                        $result =DB::table('carts')
                            ->where('user_id',  Cookie::get('user_id'))
                            ->where('product_id', $row['productid'])
                            ->update([
                                'quantity' => $row['quantity'],
                            ]);
                        $result1 =DB::table('donate_carts')
                            ->where('user_id',  Cookie::get('user_id'))
                            ->where('product_id', $row['productid'])
                            ->update([
                                'quantity' => $row['quantity'],
                            ]);
                    }
                }
                session()->forget('cart_item');
            }
            try{
                $total = 0;
                $customer = DB::table('users')
                    ->where('id',Cookie::get('user_id'))
                    ->first();
                $dealer = DB::table('users')
                    ->where('add_part1',$customer->add_part1)
                    ->where('add_part2',$customer->add_part2)
                    ->where('add_part3',$customer->add_part3)
                    ->where('address_type',$customer->address_type)
                    ->where('user_type',7)
                    ->first();
                $stmt = DB::table('carts')
                    ->select('*','carts.id AS cartid')
                    ->leftJoin('products', 'products.id', '=', 'carts.product_id')
                    ->join('product_assign','product_assign.product_id', '=','products.id')
                    ->where('carts.user_id',Cookie::get('user_id'))
                    ->where('product_assign.dealer_id',$dealer->id)
                    ->orderBy('products.id','Asc')
                    ->get();
                $c_count = $stmt->count();
                if($stmt->count() > 0) {
                    foreach ($stmt as $row) {
                        $quantity =$row->quantity / $row->minqty;
                        $subtotal = $row->edit_price * $quantity;
                        $total += $subtotal;
                        $item[] = $row->name;
                        $item[] = $subtotal;
                        $item[] = $quantity;
                        $output[$i] = $item;
                        $i++;
                        $item = array();
                    }
                    $rows = DB::table('delivery_charges')
                        ->where('lower','<=', $total)
                        ->where('higher','>=', $total)
                        ->first();
                    $delivery_charge = $rows->charge;
                    $total_arr['delivery'] = number_format($delivery_charge, 2,'.','');
                    $total_arr['s_total'] = number_format($total, 2,'.','');
                    $total_arr['g_total'] = number_format(($total + $delivery_charge), 2,'.','');
                }
                else{
                    $total_arr['delivery'] = number_format(0, 2,'.','');
                    $total_arr['s_total'] = number_format(0, 2,'.','');
                    $total_arr['g_total'] = number_format(0, 2,'.','');
                }

            }
            catch(\Illuminate\Database\QueryException $ex){
                return back()->with('errorMessage', $ex->getMessage());
            }
        }
        else {
            if(Session::get('cart_item')){
                $count= count(Session::get('cart_item'));
                $c_count = $count;
                if ($count > 0) {
                    $total = 0;
                    foreach (Session::get('cart_item') as $row) {
                        $product = DB::table('products')
                            ->where('id', $row['productid'])
                            ->first();
                        $quantity = $row['quantity'] / $product->minqty;
                        $price = $product->price;
                        $subtotal = $price * $quantity;
                        $total += $subtotal;
                        $bprice = $this->en2bn($price);
                        $item[] = $product->name;
                        $item[] = $subtotal;
                        $item[] = $quantity;
                        $output[$i] = $item;
                        $i++;
                        $item = array();
                    }
                    $rows = DB::table('delivery_charges')
                        ->where('lower','<=', $total)
                        ->where('higher','>=', $total)
                        ->first();
                    $delivery_charge = $rows->charge;
                    $total_arr['delivery'] = number_format($delivery_charge, 2,'.','');
                    $total_arr['s_total'] = number_format($total, 2,'.','');
                    $total_arr['g_total'] = number_format($total + $delivery_charge, 2,'.','');
                }
                else{

                    $total_arr['delivery'] = number_format(0, 2,'.','');
                    $total_arr['s_total'] = number_format(0, 2,'.','');
                    $total_arr['g_total'] = number_format(0, 2,'.','');
                }
            }
            else{
                $total_arr['delivery'] = number_format(0, 2,'.','');
                $total_arr['s_total'] = number_format(0, 2,'.','');
                $total_arr['g_total'] = number_format(0, 2,'.','');
            }
        }
        Session::forget('w_check');
        Session::forget('n_check');
        Session::save();
        return view('frontend.checkout',['output'=>$output,'total' => $total_arr,'user'=>$user,'address'=>$address,'count'=>$c_count]);
    }
    public function getDonatePrice(Request $request){

        if($request->id == 'w_donate'){
            if(Session::get('w_check')){
                return response()->json(array('donate_total'=>0));
            }
            else{
                Session::put('w_check',1);
                Session::forget('n_check');
                Session::save();
            }
        }
        if($request->id == 'n_donate'){
            if(Session::get('n_check')){
                return response()->json(array('donate_total'=>0));
            }
            else{
                Session::put('n_check',1);
                Session::forget('w_check');
                Session::save();
            }
        }
        if(Cookie::get('user_id') != null ){
            try{
                $total = 0;
                $customer = DB::table('users')
                    ->where('id',Cookie::get('user_id'))
                    ->first();
                $dealer = DB::table('users')
                    ->where('add_part1',$customer->add_part1)
                    ->where('add_part2',$customer->add_part2)
                    ->where('add_part3',$customer->add_part3)
                    ->where('address_type',$customer->address_type)
                    ->where('user_type',7)
                    ->first();
                $stmt = DB::table('donate_carts')
                    ->select('*','donate_carts.id AS cartid','products.id as p_id')
                    ->leftJoin('products', 'products.id', '=', 'donate_carts.product_id')
                    ->join('product_assign','product_assign.product_id', '=','products.id')
                    ->where('donate_carts.user_id',Cookie::get('user_id'))
                    ->where('product_assign.dealer_id',$dealer->id)
                    ->orderBy('products.id','Asc')
                    ->get();
                if($stmt->count() > 0) {
                    foreach ($stmt as $row) {
                        $quantity = $row->quantity / $row->minqty;
                        $subtotal = $row->edit_price * $quantity;
                        $total += $subtotal;
                    }
                    $total_arr['g_total'] =number_format($total, 2, '.', '');
                }
                else{
                    $total_arr['g_total'] =number_format(0, 2, '.', '');
                }
            }
            catch(\Illuminate\Database\QueryException $ex){
                return back()->with('errorMessage', $ex->getMessage());
            }
        }
        return response()->json(array('donate_total'=>$total_arr));
    }
    public function getProductByCatId($id,  Request $request){
        try{
            $slide= DB::table('slide')
                ->orderBy('id', 'DESC')
                ->take(10)->get();
            $product_cat = DB::table('categories')
                ->where('type', 1)
                ->where('status', 1)
                ->orderBy('id', 'ASC')->get();
            $service_cat = DB::table('categories')
                ->where('type', 2)
                ->where('status', 1)
                ->orderBy('id', 'DESC')->get();
            $sub_cat = DB::table('subcategories')
                ->where('cat_id', $id)
                ->where('status', 1)
                ->orderBy('id', 'Desc')->get();
            if($sub_cat->count()>0){
                $shops= DB::table('seller_shop_category')
                    ->where('cat_id', $id)
                    ->first();
                if($shops)
                    $check = 1;
                else
                    $check = 0;
                return view('frontend.subcategorypage',
                    [
                        'ser_categories' => $service_cat,
                        'pro_categories' => $product_cat,
                        'sub_categories' => $sub_cat,
                        'slides' => $slide,
                        'shops' => $shops,
                        'check' => $check,
                    ]);
            }
            else{
                $buySale_cat = DB::table('categories')
                    ->where('id', $id)
                    ->where('type', 3)
                    ->where('status', 1)
                    ->first();
                if($buySale_cat){
                    try {
                        $order_details = DB::table('custom_order_booking')->where('category',$id)->orderBy('id','desc')->get();
                        $cat = DB::table('categories')->where('id',$id)->first();
                        $i=0;
                        $sum = 0;
                        $orderArr = array();
                        foreach($order_details as $order){
                            if($order->address_type == 1){
                                $add_part1 = DB::table('divisions')
                                    ->where('id',$order->add_part1)
                                    ->first();
                                $add_part2 = DB::table('districts')
                                    ->where('div_id',$order->add_part1)
                                    ->where('id',$order->add_part2)
                                    ->first();
                                $add_part3 = DB::table('upazillas')
                                    ->where('div_id',$order->add_part1)
                                    ->where('dis_id',$order->add_part2)
                                    ->where('id',$order->add_part3)
                                    ->first();
                                $add_part4 = DB::table('unions')
                                    ->where('div_id',$order->add_part1)
                                    ->where('dis_id',$order->add_part2)
                                    ->where('upz_id',$order->add_part3)
                                    ->where('id',$order->add_part4)
                                    ->first();
                                $add_part5 = DB::table('wards')
                                    ->where('div_id',$order->add_part1)
                                    ->where('dis_id',$order->add_part2)
                                    ->where('upz_id',$order->add_part3)
                                    ->where('uni_id',$order->add_part4)
                                    ->where('id',$order->add_part5)
                                    ->first();
                            }
                            if($order->address_type == 2){
                                $add_part1 = DB::table('divisions')
                                    ->where('id',$order->add_part1)
                                    ->first();
                                $add_part2 = DB::table('cities')
                                    ->where('div_id',$order->add_part1)
                                    ->where('id',$order->add_part2)
                                    ->first();
                                $add_part3 = DB::table('city_corporations')
                                    ->where('div_id',$order->add_part1)
                                    ->where('city_id',$order->add_part2)
                                    ->where('id',$order->add_part3)
                                    ->first();
                                $add_part4 = DB::table('thanas')
                                    ->where('div_id',$order->add_part1)
                                    ->where('city_id',$order->add_part2)
                                    ->where('city_co_id',$order->add_part3)
                                    ->where('id',$order->add_part4)
                                    ->first();
                                $add_part5 = DB::table('c_wards')
                                    ->where('div_id',$order->add_part1)
                                    ->where('city_id',$order->add_part2)
                                    ->where('city_co_id',$order->add_part3)
                                    ->where('thana_id',$order->add_part4)
                                    ->where('id',$order->add_part5)
                                    ->first();
                            }
                            $orderArr[$i]['id'] = $order->id;
                            $orderArr[$i]['name'] = $order->name;
                            $orderArr[$i]['phone'] = $order->phone;
                            $orderArr[$i]['address'] = $add_part1->name.' ,'.$add_part2->name.' ,'.$add_part3->name.' ,'.$add_part4->name.' ,'.$add_part5->name;
                            $orderArr[$i]['date'] = $order->date;
                            $orderArr[$i]['amount'] = $order->amount;
                            $orderArr[$i]['price'] = $order->price;
                            $orderArr[$i]['image'] = $order->image;
                            $orderArr[$i]['status'] = $order->status;
                            $orderArr[$i]['details'] = $order->details;
                            $i++;
                        }
                        $currentPage = LengthAwarePaginator::resolveCurrentPage();
                        $itemCollection = collect($orderArr);
                        $perPage = 20;
                        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
                        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
                        $paginatedItems->setPath($request->url());
                        return view('frontend.buysale', ['orders' => $paginatedItems,'cat' => $cat->name]);
                    }
                    catch(\Illuminate\Database\QueryException $ex){
                        return back()->with('errorMessage', $ex->getMessage());
                    }
                }
            }
            if(Cookie::get('user_id') != null) {
                $customer = DB::table('users')
                    ->where('id',Cookie::get('user_id'))
                    ->first();
                $dealer = DB::table('users')
                    ->where('add_part1',$customer->add_part1)
                    ->where('add_part2',$customer->add_part2)
                    ->where('add_part3',$customer->add_part3)
                    ->where('address_type',$customer->address_type)
                    ->where('user_type',7)
                    ->first();
                if(!empty($dealer)) {
                    $dealer_product = DB::table('products')
                        ->select('*', 'product_assign.id as p_a_id', 'products.id as id')
                        ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                        ->where('products.cat_id', $id)
                        ->where('products.status', 1)
                        ->where('product_assign.dealer_id', $dealer->id)
                        ->orderBy('products.id', 'ASC')->paginate(100);
                    //dd($dealer_product);
                    if($dealer_product->count()>0){
                        $dealer_status['status'] = 1;
                        //dd($dealer_product);
                        return view('frontend.shop',
                            [
                                'products' => $dealer_product ,
                                'status' =>$dealer_status,
                                'ser_categories' => $service_cat,
                                'pro_categories' => $product_cat,
                            ]);
                    }
                }
                else{
                    $dealer_product = DB::table('products')
                        ->where('cat_id', $id)
                        ->where('status', 1)
                        ->orderBy('id', 'ASC')->paginate(100);
                    $dealer_status['status'] = 0;
                    return view('frontend.shop',
                        [
                            'products' => $dealer_product ,
                            'status' =>$dealer_status,
                            'ser_categories' => $service_cat,
                            'pro_categories' => $product_cat,
                        ]);
                }
            }
            else {
                $dealer_product = DB::table('products')
                    ->where('cat_id', $id)
                    ->where('status', 1)
                    ->orderBy('id', 'ASC')->paginate(100);
                $dealer_status['status'] = 0;
                return view('frontend.shop',
                    [
                        'products' => $dealer_product ,
                        'status' =>$dealer_status,
                        'ser_categories' => $service_cat,
                        'pro_categories' => $product_cat,
                    ]);
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getProductBySubCatId($id, Request  $request){
        try{

            $product_cat = DB::table('categories')
                ->where('type', 1)
                ->where('status', 1)
                ->orderBy('id', 'ASC')->get();
            $service_cat = DB::table('categories')
                ->where('type', 2)
                ->where('status', 1)
                ->orderBy('id', 'DESC')->get();
            $sub_cat = DB::table('subcategories')
                ->where('id', $id)
                ->where('status', 1)
                ->orderBy('id', 'Desc')->first();

            if($sub_cat->type == 3){
                try {
                    $order_details = DB::table('custom_order_booking')->where('sub_category',$id)->orderBy('id','desc')->get();
                    $cat = DB::table('subcategories')->where('id',$id)->first();
                    $i=0;
                    $sum = 0;
                    $orderArr = array();
                    foreach($order_details as $order){
                        if($order->address_type == 1){
                            $add_part1 = DB::table('divisions')
                                ->where('id',$order->add_part1)
                                ->first();
                            $add_part2 = DB::table('districts')
                                ->where('div_id',$order->add_part1)
                                ->where('id',$order->add_part2)
                                ->first();
                            $add_part3 = DB::table('upazillas')
                                ->where('div_id',$order->add_part1)
                                ->where('dis_id',$order->add_part2)
                                ->where('id',$order->add_part3)
                                ->first();
                            $add_part4 = DB::table('unions')
                                ->where('div_id',$order->add_part1)
                                ->where('dis_id',$order->add_part2)
                                ->where('upz_id',$order->add_part3)
                                ->where('id',$order->add_part4)
                                ->first();
                            $add_part5 = DB::table('wards')
                                ->where('div_id',$order->add_part1)
                                ->where('dis_id',$order->add_part2)
                                ->where('upz_id',$order->add_part3)
                                ->where('uni_id',$order->add_part4)
                                ->where('id',$order->add_part5)
                                ->first();
                        }
                        if($order->address_type == 2){
                            $add_part1 = DB::table('divisions')
                                ->where('id',$order->add_part1)
                                ->first();
                            $add_part2 = DB::table('cities')
                                ->where('div_id',$order->add_part1)
                                ->where('id',$order->add_part2)
                                ->first();
                            $add_part3 = DB::table('city_corporations')
                                ->where('div_id',$order->add_part1)
                                ->where('city_id',$order->add_part2)
                                ->where('id',$order->add_part3)
                                ->first();
                            $add_part4 = DB::table('thanas')
                                ->where('div_id',$order->add_part1)
                                ->where('city_id',$order->add_part2)
                                ->where('city_co_id',$order->add_part3)
                                ->where('id',$order->add_part4)
                                ->first();
                            $add_part5 = DB::table('c_wards')
                                ->where('div_id',$order->add_part1)
                                ->where('city_id',$order->add_part2)
                                ->where('city_co_id',$order->add_part3)
                                ->where('thana_id',$order->add_part4)
                                ->where('id',$order->add_part5)
                                ->first();
                        }
                        $orderArr[$i]['id'] = $order->id;
                        $orderArr[$i]['name'] = $order->name;
                        $orderArr[$i]['phone'] = $order->phone;
                        $orderArr[$i]['address'] = $add_part1->name.' ,'.$add_part2->name.' ,'.$add_part3->name.' ,'.$add_part4->name.' ,'.$add_part5->name;
                        $orderArr[$i]['date'] = $order->date;
                        $orderArr[$i]['amount'] = $order->amount;
                        $orderArr[$i]['price'] = $order->price;
                        $orderArr[$i]['image'] = $order->image;
                        $orderArr[$i]['status'] = $order->status;
                        $orderArr[$i]['details'] = $order->details;
                        $i++;
                    }
                    $currentPage = LengthAwarePaginator::resolveCurrentPage();
                    $itemCollection = collect($orderArr);
                    $perPage = 20;
                    $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
                    $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
                    $paginatedItems->setPath($request->url());
                    return view('frontend.buysale', ['orders' => $paginatedItems,'cat' => $cat->name]);
                }
                catch(\Illuminate\Database\QueryException $ex){
                    return back()->with('errorMessage', $ex->getMessage());
                }

            }
            if(Cookie::get('user_id') != null) {
                $customer = DB::table('users')
                    ->where('id',Cookie::get('user_id'))
                    ->first();
                $dealer = DB::table('users')
                    ->where('add_part1',$customer->add_part1)
                    ->where('add_part2',$customer->add_part2)
                    ->where('add_part3',$customer->add_part3)
                    ->where('address_type',$customer->address_type)
                    ->where('user_type',7)
                    ->first();
                if(!empty($dealer)) {
                    $dealer_product = DB::table('products')
                        ->select('*', 'product_assign.id as p_a_id', 'products.id as id')
                        ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                        ->where('products.cat_id', $sub_cat->cat_id)
                        ->where('products.sub_cat_id', $id)
                        ->where('products.status', 1)
                        ->where('product_assign.dealer_id', $dealer->id)
                        ->orderBy('products.id', 'ASC')->paginate(100);
                    //dd($dealer_product);
                    if($dealer_product->count()>0){
                        $dealer_status['status'] = 1;
                        //dd($dealer_product);
                        return view('frontend.shop',
                            [
                                'products' => $dealer_product ,
                                'status' =>$dealer_status,
                                'ser_categories' => $service_cat,
                                'pro_categories' => $product_cat,
                            ]);
                    }
                }
                else{
                    $dealer_product = DB::table('products')
                        ->where('products.cat_id', $sub_cat->cat_id)
                        ->where('products.sub_cat_id', $id)
                        ->where('status', 1)
                        ->orderBy('id', 'ASC')->paginate(100);
                    $dealer_status['status'] = 0;
                    return view('frontend.shop',
                        [
                            'products' => $dealer_product ,
                            'status' =>$dealer_status,
                            'ser_categories' => $service_cat,
                            'pro_categories' => $product_cat,
                        ]);
                }
            }
            else {
                $dealer_product = DB::table('products')
                    ->where('products.cat_id', $sub_cat->cat_id)
                    ->where('products.sub_cat_id', $id)
                    ->where('status', 1)
                    ->orderBy('id', 'ASC')->paginate(100);
                $dealer_status['status'] = 0;
                return view('frontend.shop',
                    [
                        'products' => $dealer_product ,
                        'status' =>$dealer_status,
                        'ser_categories' => $service_cat,
                        'pro_categories' => $product_cat,
                    ]);
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getProductMiqty(Request $request){
        try{
            $rows = DB::table('products')
                ->where('id', $request->id)
                ->first();
            return response()->json(array('products'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function cart_add(Request $request){
        try{
            $id=$request->id;
            $quantity= $request->quantity;
            if(Cookie::get('user_id') != null){
                $rowsCount = DB::table('carts')
                    ->where('user_id', Cookie::get('user_id'))
                    ->where('product_id', $id)
                    ->distinct()->get()->count();
                if($rowsCount < 1){
                    try{
                        $result = DB::table('carts')->insert([
                            'user_id' => Cookie::get('user_id'),
                            'product_id' => $id,
                            'quantity' =>$quantity
                        ]);
                        $result1 = DB::table('donate_carts')->insert([
                            'user_id' => Cookie::get('user_id'),
                            'product_id' => $id,
                            'quantity' =>$quantity
                        ]);
                        $output['message'] = 'Item added to cart';

                    }
                    catch(\Illuminate\Database\QueryException $ex){
                        return back()->with('errorMessage', $ex->getMessage());
                    }
                }
                else{
                    $output['error'] = true;
                    $output['message'] = 'Product already in cart';
                }
            }
            else {
                if (!Session::has('cart_item')) {
                    Session::put('cart_item', array());
                }
                $exist = array();
                foreach (Session::get('cart_item') as $row) {
                    array_push($exist, $row['productid']);
                }

                if (in_array($id, $exist)) {
                    $output['error'] = true;
                    $output['message'] = 'Product already in cart';
                } else {
                    $data['productid'] = $id;
                    $data['quantity'] = $quantity;
                    $item = Session::get('cart_item');
                    if (array_push($item, $data)) {
                        Session::put('cart_item', $item);
                        $output['message'] = 'Item added to cart';
                    } else {
                        $output['error'] = true;
                        $output['message'] = 'Cannot add item to cart';
                    }
                }
            }
            return response()->json(array('output'=>$output));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public static function en2bn($number) {
        $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $bn_number = str_replace($search_array, $replace_array, $number);
        return $bn_number;
    }
    public function cart_fetch(Request $request){
        try{
            $output = array('list'=>'','count'=>0);
            $m_output =array();
            if(Cookie::get('user_id') != null){
                try{
                    $url = url('/') . '/';
                    $customer = DB::table('users')
                        ->where('id',Cookie::get('user_id'))
                        ->first();
                    $dealer = DB::table('users')
                        ->where('add_part1',$customer->add_part1)
                        ->where('add_part2',$customer->add_part2)
                        ->where('add_part3',$customer->add_part3)
                        ->where('address_type',$customer->address_type)
                        ->where('user_type',7)
                        ->first();
                    if(!empty($dealer)) {
                        $stmt = DB::table('carts')
                            ->select('*', 'products.name AS prodname','products.id as id')
                            ->leftJoin('products', 'products.id', '=', 'carts.product_id')
                            ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                            ->where('carts.user_id', Cookie::get('user_id'))
                            ->where('product_assign.dealer_id', $dealer->id)
                            ->orderBy('products.id', 'Asc')
                            ->get();
                        $total=0;
                        foreach ($stmt as $row) {
                            $output['count']++;
                            $image = (!empty($row->photo)) ? $row->photo : 'public/asset/no_image.jpg';

                            $quantity = $row->quantity / $row->minqty;
                            $bprice = $row->edit_price;
                            $bquantity = $quantity;
                            $bsum = $row->edit_price * $quantity;
                            $total += $bsum;
                            $url = url('/') . '/';
                            $output['list'] .= '
                            <div class="product product-cart">
                                    <div class="product-detail">
                                        <a href="'.url('product-by-id/'.$row->product_id) .'" class="product-name">'.$row->name.'<br></a>
                                        <div class="price-box">
                                            <span class="product-quantity">'.$bquantity.'</span>
                                            <span class="product-price">'.$bprice.' টাকা'.'</span>
                                        </div>
                                    </div>
                                    <figure class="product-media">
                                        <a href="'.url('product-by-id/'.$row->product_id) .'">
                                            <img src="'. $url . $image .'" alt="product" height="84"
                                                 width="94" />
                                        </a>
                                    </figure>
                                    <button class="btn btn-link btn-close cart_delete" data-id="'.$row->product_id.'">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                        ';
                        }
                        $output['list'] .= '
                            <div class="cart-total">
                                <label>Grand Total:</label>
                                <span class="price">'.$total.' টাকা'.'</span>
                            </div>

                            <div class="cart-action">
                                <a href="'.url('cart').'" class="btn btn-dark btn-outline btn-rounded">View Cart</a>
                                <a href="'.url('checkout').'" class="btn btn-primary  btn-rounded">Checkout</a>
                            </div>
                         ';
                        $m_output = '
                            <div class="cart-total">
                                <label>Grand Total:</label>
                                <span class="price">'.$total.' টাকা'.'</span>
                            </div>

                            <div class="cart-action">
                                <a href="'.url('cart').'" class="btn btn-dark btn-outline btn-rounded">View Cart</a>
                                <a href="'.url('checkout').'" class="btn btn-primary  btn-rounded">Checkout</a>
                            </div>
                         ';
                    }
                    else{
                        $output['message']='No Dealer and Delivery Man are found in your area.';
                    }
                }
                catch(\Illuminate\Database\QueryException $ex){
                    return back()->with('errorMessage', $ex->getMessage());
                }
            }
            else {
                if (!Session::has('cart_item')) {
                    $cart_item = array();
                    Session::put('cart_item', $cart_item);
                    $cart_item = Session::get('cart_item');
                }
                if (Session::has('cart_item') == null) {
                    $output['count'] = 0;
                }
                else {
                    $cart_item = Session::get('cart_item');
                    foreach ($cart_item as $key => $row) {
                        if ($row['productid'] == $request->id) {
                            dd($cart_item);
                            $cart_item['quantity'] = $request->quantity;
                            $output['message'] = 'Cart Item Updated';
                            break;
                        }
                        else{
                            $output['message'] = 'Cart Item Not Updated';
                        }
                    }
                    $total=0;
                    $cart_item = Session::get('cart_item');
                    foreach ($cart_item as $row) {
                        $output['count']++;
                        $product = DB::table('products')
                            ->where('id', $row['productid'])
                            ->first();
                        $image = (!empty($product->photo)) ? $product->photo : 'public/asset/no_image.jpg';

                        $quantity = $row['quantity']/$product->minqty;
                        $bprice = $product->price;
                        $bquantity = $quantity;
                        if (strpos($product->price, '৳') !== false) {
                            $priceArr = explode("৳",$product->price);
                            $price = (int)$priceArr[1];
                        }
                        else{
                            $price=$product->price;
                        }

                        $bsum = $price * $quantity;
                        $url = url('/') . '/';
                        $total += $bsum;
                        $output['list'] .= '
                            <div class="product product-cart">
                                    <div class="product-detail">
                                        <a href="'.url('product-by-id/'.$product->id) .'" class="product-name">'.$product->name.'<br></a>
                                        <div class="price-box">
                                            <span class="product-quantity">'.$bquantity.'</span>
                                            <span class="product-price">'.$bprice.' টাকা'.'</span>
                                        </div>
                                    </div>
                                    <figure class="product-media">
                                        <a href="'.url('product-by-id/'.$product->id) .'">
                                            <img src="'. $url . $image .'" alt="product" height="84"
                                                 width="94" />
                                        </a>
                                    </figure>
                                    <button class="btn btn-link btn-close cart_delete" data-id="'.$product->id.'">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                        ';
                    }
                    $output['list'] .= '
                            <div class="cart-total">
                                <label>Grand Total:</label>
                                <span class="price">'.$total.' টাকা'.'</span>
                            </div>

                            <div class="cart-action">
                                <a href="'.url('cart').'" class="btn btn-dark btn-outline btn-rounded">View Cart</a>
                                <a href="'.url('checkout').'" class="btn btn-primary  btn-rounded">Checkout</a>
                            </div>
                    ';
                    $m_output = '
                            <div class="cart-total">
                                <label>Grand Total:</label>
                                <span class="price">'.$total.' টাকা'.'</span>
                            </div>

                            <div class="cart-action">
                                <a href="'.url('cart').'" class="btn btn-dark btn-outline btn-rounded">View Cart</a>
                                <a href="'.url('checkout').'" class="btn btn-primary  btn-rounded">Checkout</a>
                            </div>
                         ';
                }
            }
            return response()->json(array('output'=>$output,'m_output' => $m_output));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function cart_view(Request $request){
        try{
            if(Cookie::get('user_id') != null ) {
                $id =Cookie::get('user_id');
            }else{
                $id = '';
            }
            $rowsCount = DB::table('carts')
                ->where('user_id', $id)
                ->distinct()->get()->count();

            return view('frontend.cartView', ['count' => $rowsCount]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function productQuantityChange(Request $request){
        if(Cookie::get('user_id')){
            $result =DB::table('carts')
                ->where('user_id',  Cookie::get('user_id'))
                ->where('product_id', $request->id)
                ->update([
                    'quantity' => $request->quantity,
                ]);
            $output="";
            if($result){
                $output="ok";
            }
            else{
                $output="Not ok";
            }
        }
        else{
            $cart_item = Session::get('cart_item');
            foreach ($cart_item as $key => $row) {
                if ($row['productid'] == $request->id) {
                    $cart_item[$key]['productid'] =$request->id;
                    $cart_item[$key]['quantity'] =$request->quantity;
                    $output['message'] = 'Cart Item Updated';
                    break;
                }
                else{
                    $output['message'] = 'Cart Item Not Updated';
                }
            }
            Session::put('cart_item', $cart_item);
            Session::save();
        }
        if($request->donateValue == 1){
            Session::put('donate_value', 1);
        }
        return response()->json(array('output'=>$output));
    }
    public function productQuantityChangeDonate (Request $request){
        $result =DB::table('donate_carts')
            ->where('user_id',  Cookie::get('user_id'))
            ->where('product_id', $request->id)
            ->update([
                'quantity' => $request->quantity,
            ]);
        $output_donate = "";
        $url =url('/').'/';
        if(Cookie::get('user_id') != null ){
            try{
                $total = 0;
                $customer = DB::table('users')
                    ->where('id',Cookie::get('user_id'))
                    ->first();
                $dealer = DB::table('users')
                    ->where('add_part1',$customer->add_part1)
                    ->where('add_part2',$customer->add_part2)
                    ->where('add_part3',$customer->add_part3)
                    ->where('address_type',$customer->address_type)
                    ->where('user_type',7)
                    ->first();
                $stmt = DB::table('donate_carts')
                    ->select('*','donate_carts.id AS cartid','products.id as p_id')
                    ->leftJoin('products', 'products.id', '=', 'donate_carts.product_id')
                    ->join('product_assign','product_assign.product_id', '=','products.id')
                    ->where('donate_carts.user_id',Cookie::get('user_id'))
                    ->where('product_assign.dealer_id',$dealer->id)
                    ->orderBy('products.id','Asc')
                    ->get();
                if($stmt->count() > 0) {
                    foreach ($stmt as $row) {
                        $image = (!empty($row->photo)) ? $url . $row->photo : $url . 'public/asset/no_image.jpg';
                        $quantity = $row->quantity / $row->minqty;
                        $subtotal = $row->edit_price * $quantity;
                        $total += $subtotal;
                        $output_donate .= '
                                <tr>
                                    <td class="product-thumbnail">
                                        <div class="p-relative">
                                            <a href="' . url('product-by-id/' . $row->product_id) . '">
                                                <figure>
                                                    <img src="' . $image . '" alt="product"
                                                         width="300" height="338">
                                                </figure>
                                            </a>
                                            <button type="submit" data-id="' . $row->product_id . '" class="btn btn-close cart_delete_donate"><i
                                                    class="fas fa-times"></i></button>
                                        </div>
                                    </td>
                                    <td class="product-name">
                                        <a href="' . url('product-by-id/' . $row->product_id) . '">
                                            ' . $row->name . '
                                        </a>
                                    </td>
                                    <td class="product-price"><span class="amount">' . number_format($row->edit_price, 2) . ' টাকা' . '</span></td>
                                    <td class="product-quantity">
                                        <div class="input-group">
                                            <input name="quantity" class="form-control" data-id="' . $row->product_id . 'd' . '" id="' . $row->product_id . 'd' . '" type="number" min="1" max="1000" value="' . $row->quantity . '" readonly>
                                            <button id="add" class="quantity-plus-donate w-icon-plus" data-id="' . $row->product_id . '"></button>
                                            <button id="minus" class="quantity-minus-donate w-icon-minus" data-id="' . $row->product_id . '"></button>
                                        </div>
                                    </td>
                                    <td class="product-subtotal">
                                        <span class="amount">' . number_format($subtotal, 2) . ' টাকা' . '</span>
                                    </td>
                                </tr>
                                 ';
                    }
                    $total_arr['g_total'] =number_format($total + Session::get('total_bill'), 2, '.', '');
                }
                else{
                    $output_donate .= "
                                <tr>
                                    <td colspan='7' align='center'>Donate cart empty</td>
                                <tr>
                            ";
                }
            }
            catch(\Illuminate\Database\QueryException $ex){
                return back()->with('errorMessage', $ex->getMessage());
            }
        }
        return response()->json(array('output_donate'=>$output_donate,'donate_total'=>$total_arr));
    }
    public function cart_details(Request $request){
        try{
            if(Session::get('donate_value') != 1){
                Session::forget('total_donate_bill');
                Session::save();
            }
            if($request->id == 'want_donate'){
                $output_donate="";
                $url =url('/').'/';
                if(Cookie::get('user_id') != null ){
                    try{
                        $total = 0;
                        $customer = DB::table('users')
                            ->where('id',Cookie::get('user_id'))
                            ->first();
                        $dealer = DB::table('users')
                            ->where('add_part1',$customer->add_part1)
                            ->where('add_part2',$customer->add_part2)
                            ->where('add_part3',$customer->add_part3)
                            ->where('address_type',$customer->address_type)
                            ->where('user_type',7)
                            ->first();
                        $stmt = DB::table('donate_carts')
                            ->select('*','donate_carts.id AS cartid','products.id as p_id')
                            ->leftJoin('products', 'products.id', '=', 'donate_carts.product_id')
                            ->join('product_assign','product_assign.product_id', '=','products.id')
                            ->where('donate_carts.user_id',Cookie::get('user_id'))
                            ->where('product_assign.dealer_id',$dealer->id)
                            ->orderBy('products.id','Asc')
                            ->get();
                        if($stmt->count() > 0) {
                            foreach ($stmt as $row) {
                                $image = (!empty($row->photo)) ? $url . $row->photo : $url . 'public/asset/no_image.jpg';
                                $quantity = $row->quantity / $row->minqty;
                                $subtotal = $row->edit_price * $quantity;
                                $total += $subtotal;
                                $output_donate .= '
                                <tr>
                                    <td class="product-thumbnail">
                                        <div class="p-relative">
                                            <a href="' . url('product-by-id/' . $row->product_id) . '">
                                                <figure>
                                                    <img src="' . $image . '" alt="product"
                                                         width="300" height="338">
                                                </figure>
                                            </a>
                                            <button type="submit" data-id="' . $row->product_id . '" class="btn btn-close cart_delete_donate"><i
                                                    class="fas fa-times"></i></button>
                                        </div>
                                    </td>
                                    <td class="product-name">
                                        <a href="' . url('product-by-id/' . $row->product_id) . '">
                                            ' . $row->name . '
                                        </a>
                                    </td>
                                    <td class="product-price"><span class="amount">' . number_format($row->edit_price, 2) . ' টাকা' . '</span></td>
                                    <td class="product-quantity">
                                        <div class="input-group">
                                            <input name="quantity" class="form-control" data-id="' . $row->product_id . 'd' . '" id="' . $row->product_id . 'd' . '" type="number" min="1" max="1000" value="' . $row->quantity . '" readonly>
                                            <button id="add" class="quantity-plus-donate w-icon-plus" data-id="' . $row->product_id . '"></button>
                                            <button id="minus" class="quantity-minus-donate w-icon-minus" data-id="' . $row->product_id . '"></button>
                                        </div>
                                    </td>
                                    <td class="product-subtotal">
                                        <span class="amount">' . number_format($subtotal, 2) . ' টাকা' . '</span>
                                    </td>
                                </tr>
                                 ';
                            }
                            $total_arr['g_total'] =number_format($total, 2, '.', '');
                        }
                        else{
                            $output_donate .= "
                                <tr>
                                    <td colspan='7' align='center'>Donate cart empty</td>
                                <tr>
                            ";
                        }
                    }
                    catch(\Illuminate\Database\QueryException $ex){
                        return back()->with('errorMessage', $ex->getMessage());
                    }
                }
                Session::put('total_donate_bill', $total_arr['g_total']);
                return response()->json(array('output_donate'=>$output_donate,'donate_total'=>$total_arr));
            }
            $output = "";
            $url =url('/').'/';
            $total_arr = array();
            if(Cookie::get('user_id') != null ){
                if(Session::has('cart_item')){
                    foreach(Session::get('cart_item') as $row){
                        $rowsCount = DB::table('carts')
                            ->where('user_id', Cookie::get('user_id'))
                            ->where('product_id', $row['productid'])
                            ->distinct()->get()->count();
                        if($rowsCount < 1){
                            $result = DB::table('carts')->insert([
                                'user_id' => Cookie::get('user_id'),
                                'product_id' => $row['productid'],
                                'quantity' => $row['quantity']
                            ]);
                            $result1 = DB::table('donate_carts')->insert([
                                'user_id' => Cookie::get('user_id'),
                                'product_id' => $row['productid'],
                                'quantity' => $row['quantity']
                            ]);
                        }
                        else{
                            $result =DB::table('carts')
                                ->where('user_id',  Cookie::get('user_id'))
                                ->where('product_id', $row['productid'])
                                ->update([
                                    'quantity' => $row['quantity'],
                                ]);
                            $result1 =DB::table('donate_carts')
                                ->where('user_id',  Cookie::get('user_id'))
                                ->where('product_id', $row['productid'])
                                ->update([
                                    'quantity' => $row['quantity'],
                                ]);
                        }
                    }
                    session()->forget('cart_item');
                }
                try{
                    $total = 0;
                    $customer = DB::table('users')
                        ->where('id',Cookie::get('user_id'))
                        ->first();
                    $dealer = DB::table('users')
                        ->where('add_part1',$customer->add_part1)
                        ->where('add_part2',$customer->add_part2)
                        ->where('add_part3',$customer->add_part3)
                        ->where('address_type',$customer->address_type)
                        ->where('user_type',7)
                        ->first();
                    $stmt = DB::table('carts')
                        ->select('*','carts.id AS cartid')
                        ->leftJoin('products', 'products.id', '=', 'carts.product_id')
                        ->join('product_assign','product_assign.product_id', '=','products.id')
                        ->where('carts.user_id',Cookie::get('user_id'))
                        ->where('product_assign.dealer_id',$dealer->id)
                        ->orderBy('products.id','Asc')
                        ->get();
                    if($stmt->count() > 0) {
                        foreach ($stmt as $row) {
                            $image = (!empty($row->photo)) ? $url . $row->photo : $url . 'public/asset/no_image.jpg';
                            $quantity = $row->quantity / $row->minqty;
                            $subtotal = $row->edit_price * $quantity;
                            $total += $subtotal;
                            $output .= '
                                <tr>
                                    <td class="product-thumbnail">
                                        <div class="p-relative">
                                            <a href="'.url('product-by-id/'.$row->product_id).'">
                                                <figure>
                                                    <img src="'.$image.'" alt="product"
                                                         width="300" height="338">
                                                </figure>
                                            </a>
                                            <button type="submit" data-id="' . $row->product_id . '" class="btn btn-close cart_delete"><i
                                                    class="fas fa-times"></i></button>
                                        </div>
                                    </td>
                                    <td class="product-name">
                                        <a href="'.url('product-by-id/'.$row->product_id).'">
                                            '.$row->name.'
                                        </a>
                                    </td>
                                    <td class="product-price"><span class="amount">'.number_format($row->edit_price, 2).' টাকা'.'</span></td>
                                    <td class="product-quantity">
                                        <div class="input-group">
                                            <input name="quantity" class="form-control" data-id="'.$row->product_id.'q'.'" id="'.$row->product_id.'q'.'" type="number" min="1" max="1000" value="'.$row->quantity.'" readonly>
                                            <button id="add" class="quantity-plus w-icon-plus" data-id="'.$row->product_id.'"></button>
                                            <button id="minus" class="quantity-minus w-icon-minus" data-id="'.$row->product_id.'"></button>
                                        </div>
                                    </td>
                                    <td class="product-subtotal">
                                        <span class="amount">'.number_format($subtotal, 2).' টাকা'.'</span>
                                    </td>
                                </tr>
                        ';
                        }
                        $total_arr['g_total'] =number_format($total, 2, '.', '');
                    }
                    else{
                        $output .= '
                        <tr>
                            <td class="product-subtotal" colspan="7" align="center">Shopping cart empty</td>
                        <tr>
                    ';
                        $total_arr['g_total'] =number_format(0, 2, '.', '');
                    }

                }
                catch(\Illuminate\Database\QueryException $ex){
                    return back()->with('errorMessage', $ex->getMessage());
                }
            }
            else {
                if(Session::get('cart_item')){
                    $count= count(Session::get('cart_item'));
                    if ($count > 0) {
                        $total = 0;
                        foreach (Session::get('cart_item') as $row) {
                            $product = DB::table('products')
                                ->where('id', $row['productid'])
                                ->first();
                            $image = (!empty($product->photo)) ? $url . $product->photo : $url . 'public/asset/no_image.jpg';
                            $quantity = $row['quantity'] / $product->minqty;
                            $price = $product->price;
                            $subtotal = $price * $quantity;
                            $total += $subtotal;
                            $bprice = $this->en2bn($price);
                            $output .= '
                                <tr>
                                    <td class="product-thumbnail">
                                        <div class="p-relative">
                                            <a href="' . url('product-by-id/' . $product->id) . '">
                                                <figure>
                                                    <img src="' . $image . '" alt="product"
                                                         width="300" height="338">
                                                </figure>
                                            </a>
                                            <button type="submit" data-id="' . $product->id . '" class="btn btn-close cart_delete"><i
                                                    class="fas fa-times"></i></button>
                                        </div>
                                    </td>
                                    <td class="product-name">
                                        <a href="' . url('product-by-id/' . $product->id) . '">
                                            ' . $product->name . '
                                        </a>
                                    </td>
                                    <td class="product-price"><span class="amount">' . number_format($product->price, 2) . ' টাকা' . '</span></td>
                                    <td class="product-quantity">
                                        <div class="input-group">
                                            <input name="quantity" class="form-control" data-id="'.$product->id.'q'.'" id="'.$product->id.'q'.'" type="number" min="1" max="100000" value="' . $row['quantity']. '" readonly>
                                            <button class="quantity-plus w-icon-plus" data-id="'.$product->id.'"></button>
                                            <button class="quantity-minus w-icon-minus" data-id="'.$product->id.'"></button>
                                        </div>
                                    </td>
                                    <td class="product-subtotal">
                                        <span class="amount">' . number_format($subtotal, 2) . ' টাকা' . '</span>
                                    </td>
                                </tr>
                        ';
                        }
                        $total_arr['g_total'] =number_format($total, 2, '.', '');
                    }
                    else{
                        $output .= '
                            <tr>
                                <td class="product-subtotal" colspan="7" align="center">Shopping cart empty</td>
                            <tr>
                        ';

                        $total_arr['g_total'] =number_format(0, 2, '.', '');
                    }
                }
                else{
                    $output .= '
                        <tr>
                            <td class="product-subtotal" colspan="7" align="center">Shopping cart empty</td>
                        <tr>
                    ';
                    $total_arr['g_total'] =number_format(0, 2, '.', '');
                }
            }
            if(Session::get('total_donate_bill')){
                $total_arr['g_total'] = number_format( (Session::get('total_donate_bill') + $total_arr['g_total']),2,'.','');
            }
            Session::forget('donate_value');
            Session::put('total_bill', $total_arr['g_total']);
            Session::save();
            return response()->json(array('output'=>$output, 'total'=>$total_arr));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function cart_delete(Request $request){
        try{
            $output = array('error'=>false);
            $id = $request->id;
            if(Cookie::get('user_id') != null ){
                try{
                    $results = DB::table('carts')->where('user_id', Cookie::get('user_id'))->where('product_id', $id)->delete();
                    if($results){
                        $output['message'] = 'Cart Item Deleted';
                    }
                    else{
                        $output['message'] = 'Cart Item Not Deleted';
                    }
                }
                catch(\Illuminate\Database\QueryException $ex){
                    return back()->with('errorMessage', $ex->getMessage());
                }
            }
            else {
                $cart_item = Session::get('cart_item');
                foreach ($cart_item as $key => $row) {
                    if ($row['productid'] == $id) {
                        unset($cart_item[$key]);
                        $output['message'] = 'Cart Item Deleted';
                    }
                    else{
                        $output['message'] = 'Cart Item Not Deleted';
                    }
                }
                Session::put('cart_item', $cart_item);
            }
            return response()->json(array('output' => $output));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function clear_cart(Request $request){
        try{
            $output = array('error'=>false);
            $id = $request->value;
            if(Cookie::get('user_id') != null ){
                try{
                    $results = DB::table('carts')->where('user_id', Cookie::get('user_id'))->delete();
                    if($results){
                        $output['message'] = 'Cart Item Cleared';
                    }
                    else{
                        $output['message'] = 'Cart Item Not Cleared';
                    }
                }
                catch(\Illuminate\Database\QueryException $ex){
                    return back()->with('errorMessage', $ex->getMessage());
                }
            }
            else {
                $cart_item = Session::get('cart_item');
                Session::forget('cart_item');
                Session::flush();
                Session::save();
                $output['message'] = 'Cart Item Cleared';
            }
            return response()->json(array('output' => $output));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function cart_delete_donate(Request $request){
        $output_donate = '';
        $id = $request->id;
        $url = url('/') . '/';
        if(Cookie::get('user_id') != null ){
            try{
                $results = DB::table('donate_carts')->where('user_id', Cookie::get('user_id'))->where('product_id', $id)->delete();
                if($results){
                    $total = 0;
                    $customer = DB::table('users')
                        ->where('id',Cookie::get('user_id'))
                        ->first();
                    $dealer = DB::table('users')
                        ->where('add_part1',$customer->add_part1)
                        ->where('add_part2',$customer->add_part2)
                        ->where('add_part3',$customer->add_part3)
                        ->where('address_type',$customer->address_type)
                        ->where('user_type',7)
                        ->first();
                    $stmt = DB::table('donate_carts')
                        ->select('*','donate_carts.id AS cartid','products.id as p_id')
                        ->leftJoin('products', 'products.id', '=', 'donate_carts.product_id')
                        ->join('product_assign','product_assign.product_id', '=','products.id')
                        ->where('donate_carts.user_id',Cookie::get('user_id'))
                        ->where('product_assign.dealer_id',$dealer->id)
                        ->orderBy('products.id','Asc')
                        ->get();
                    if($stmt->count() > 0) {
                        foreach ($stmt as $row) {
                            $image = (!empty($row->photo)) ? $url . $row->photo : $url . 'public/asset/no_image.jpg';
                            $quantity = $row->quantity / $row->minqty;
                            $subtotal = $row->edit_price * $quantity;
                            $total += $subtotal;
                            $output_donate .= '
                    <tr>
                        <td class="product-thumbnail">
                            <div class="p-relative">
                                <a href="' . url('product-by-id/' . $row->product_id) . '">
                                    <figure>
                                        <img src="' . $image . '" alt="product"
                                             width="300" height="338">
                                    </figure>
                                </a>
                                <button type="submit" data-id="' . $row->product_id . '" class="btn btn-close cart_delete_donate"><i
                                        class="fas fa-times"></i></button>
                            </div>
                        </td>
                        <td class="product-name">
                            <a href="' . url('product-by-id/' . $row->product_id) . '">
                                ' . $row->name . '
                            </a>
                        </td>
                        <td class="product-price"><span class="amount">' . number_format($row->edit_price, 2) . ' টাকা' . '</span></td>
                        <td class="product-quantity">
                            <div class="input-group">
                                <input name="quantity" class="form-control" data-id="' . $row->product_id . 'd' . '" id="' . $row->product_id . 'd' . '" type="number" min="1" max="1000" value="' . $row->quantity . '" readonly>
                                <button id="add" class="quantity-plus-donate w-icon-plus" data-id="' . $row->product_id . '"></button>
                                <button id="minus" class="quantity-minus-donate w-icon-minus" data-id="' . $row->product_id . '"></button>
                            </div>
                        </td>
                        <td class="product-subtotal">
                            <span class="amount">' . number_format($subtotal, 2) . ' টাকা' . '</span>
                        </td>
                    </tr>
                     ';
                        }
                        $total_arr['g_total'] =number_format($total + Session::get('total_bill'), 2, '.', '');
                    }
                    else{
                        $output_donate .= "
                    <tr>
                        <td colspan='7' align='center'>Donate cart empty</td>
                    <tr>
                ";
                    }
                }
                else{

                }
            }
            catch(\Illuminate\Database\QueryException $ex){
                return back()->with('errorMessage', $ex->getMessage());
            }
        }
        return response()->json(array('output_donate'=>$output_donate,'donate_total'=>$total_arr));
    }
    public function sales(Request $request){
        try{

            if(Session::get('discount'))
                $discount = Session::get('discount');
            else
                $discount = 0;

            $order_details = Session::get('order_details');

            $dif_add = @$order_details['dif_add'];
            $name = @$order_details['name'];
            $phone = @$order_details['phone'];
            $email = @$order_details['email'];
            $gender = @$order_details['gender'];
            $addressGroup = @$order_details['addressGroup'];
            $add_part1 = @$order_details['div_id'];
            if($addressGroup == 1){
                $add_part2 = @$order_details['disid'];
                $add_part3 = @$order_details['upzid'];
                $add_part4 = @$order_details['uniid'];
                $add_part5 = @$order_details['wardid'];
            }
            if($addressGroup == 2){
                $add_part2 = @$order_details['c_disid'];
                $add_part3 = @$order_details['c_upzid'];
                $add_part4 = @$order_details['c_uniid'];
                $add_part5 = @$order_details['c_wardid'];
            }

            $address = @$order_details['address'];
            $order_notes = @$order_details['order-notes'];
            $w_donate = @$order_details['w_donate'];
            $total = 0;
            $donate_total = 0;
            $status = $request->status;
            if(($request->status == 'cash') || ($request->status == 'bank')|| ($request->status == 'temp_user')){
                $status = $request->status;
                $date = date('Y-m-d');
                $tx_id = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(16/strlen($x)) )),1,16);
            }
            else{
                $status = $request->status;
                $type = 'daily_sales';
                $msg = $request->msg;
                $tx_id = $request->tx_id;
                $bank_tx_id = $request->bank_tx_id;
                $amount = $request->amount;
                $bank_status = $request->bank_status;
                $sp_code = $request->sp_code;
                $sp_code_des = $request->sp_code_des;
                $sp_payment_option = $request->sp_payment_option;
                $date = date('Y-m-d');
                $result = DB::table('payment_info')->insert([
                    'user_id' => Cookie::get('user_id'),
                    'status' => $status,
                    'type' => $type,
                    'msg' => $msg,
                    'tx_id' => $tx_id,
                    'bank_tx_id' => $bank_tx_id,
                    'amount' => $amount,
                    'bank_status' => $bank_status,
                    'sp_code' => $sp_code,
                    'sp_code_des' => $sp_code_des,
                    'sp_payment_option' => $sp_payment_option,
                ]);
            }
            if($status == 'Failed'){
                return redirect('checkout')->with('errorMessage', 'আবার চেষ্টা করুন।');;
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }
            else{
                if(Cookie::get('user_id')){
                    $user_info = DB::table('users')
                        ->select('*')
                        ->where('id', Cookie::get('user_id'))
                        ->first();
                    if($dif_add){

                    }
                    else{
                        $name = $user_info->name;
                        $email = $user_info->email;
                        $phone = $user_info->phone;
                        $gender = $user_info->gender;
                        $addressGroup = $user_info->address_type;
                        $add_part1 = $user_info->add_part1;
                        $add_part2 = $user_info->add_part2;
                        $add_part3 = $user_info->add_part3;
                        $add_part4 = $user_info->add_part4;
                        $add_part5 = $user_info->add_part5;
                        $address = $user_info->address;
                    }
                    $delear = DB::table('users')
                        ->where('user_type',  7)
                        ->where('add_part1',  $user_info->add_part1)
                        ->where('add_part2',  $user_info->add_part2)
                        ->where('add_part3',  $user_info->add_part3)
                        ->where('address_type',  $user_info->address_type)
                        ->where('status',  1)
                        ->first();
                    $result = DB::table('v_assign')->insert([
                        'user_id' => Cookie::get('user_id'),
                        'dealer_id' => $delear->id,
                        'pay_id' => $tx_id,
                        'sales_date' => $date
                    ]);
                    $salesid = DB::getPdo()->lastInsertId();
                    $stmt = DB::table('carts')
                        ->select('*','carts.id AS cartid')
                        ->leftJoin('products', 'products.id', '=', 'carts.product_id')
                        ->join('product_assign','product_assign.product_id', '=','products.id')
                        ->where('carts.user_id',Cookie::get('user_id'))
                        ->where('product_assign.dealer_id',$delear->id)
                        ->orderBy('products.id','Asc')
                        ->get();

                    foreach($stmt as $row){
                        $result = DB::table('details')->insert([
                            'sales_id' => $salesid,
                            'product_id' => $row->product_id,
                            'quantity' => $row->quantity,
                            'price' => $row->edit_price
                        ]);
                        $total = $total + (int)$row->edit_price;
                    }
                    if($w_donate  == 'w_donate'){
                        $d_cart = DB::table('donate_carts')
                            ->select('*')
                            ->where('user_id', Cookie::get('user_id'))
                            ->get();
                        if($d_cart->count()>0){
                            $d_stmt = DB::table('donate_carts')
                                ->select('*','donate_carts.id AS cartid')
                                ->leftJoin('products', 'products.id', '=', 'donate_carts.product_id')
                                ->join('product_assign','product_assign.product_id', '=','products.id')
                                ->where('donate_carts.user_id',Cookie::get('user_id'))
                                ->where('product_assign.dealer_id',$delear->id)
                                ->orderBy('products.id','Asc')
                                ->get();
                            foreach($d_stmt as $d_row){
                                $result = DB::table('donation_details')->insert([
                                    'sales_id' => $salesid,
                                    'product_id' => $d_row->product_id,
                                    'quantity' => $d_row->quantity,
                                ]);
                                $donate_total = $donate_total + $d_row->quantity;
                            }
                            DB::table('donate_carts')->where('user_id',  Cookie::get('user_id'))->delete();
                            session()->forget('donate');
                        }
                    }
                    $product_cart = DB::table('carts')
                        ->select('*')
                        ->where('user_id', Cookie::get('user_id'))
                        ->first();
                    DB::table('carts')->where('user_id',  Cookie::get('user_id'))->delete();
                    DB::table('donate_carts')->where('user_id',  Cookie::get('user_id'))->delete();
                    $working_status = 1;
                    if($user_info->address_type == 1) {
                        $ward_info = DB::table('wards')
                            ->select('*')
                            ->where('div_id', $user_info->add_part1)
                            ->where('dis_id', $user_info->add_part2)
                            ->where('upz_id', $user_info->add_part3)
                            ->where('uni_id', $user_info->add_part4)
                            ->where('id', $user_info->add_part5)
                            ->first();
                        $ward_plus = $ward_info->position + 1;
                        $ward_minus = $ward_info->position - 1;
                        $ward_plus_id_info = DB::table('wards')
                            ->select('*')
                            ->where('div_id', $user_info->add_part1)
                            ->where('dis_id', $user_info->add_part2)
                            ->where('upz_id', $user_info->add_part3)
                            ->where('uni_id', $user_info->add_part4)
                            ->where('position', $ward_plus)
                            ->first();
                        $ward_plus_id = $ward_plus_id_info->id;
                        if($ward_info->position == 1) $ward_minus_id = $ward_info->position;
                        else{
                            $ward_minus_id_info = DB::table('wards')
                                ->select('*')
                                ->where('div_id', $user_info->add_part1)
                                ->where('dis_id', $user_info->add_part2)
                                ->where('upz_id', $user_info->add_part3)
                                ->where('uni_id', $user_info->add_part4)
                                ->where('position', $ward_minus)
                                ->first();
                            $ward_minus_id = $ward_minus_id_info->id;
                        }
                    }
                    if($user_info->address_type == 2) {
                        $c_ward_info = DB::table('c_wards')
                            ->select('*')
                            ->where('div_id', $user_info->add_part1)
                            ->where('city_id', $user_info->add_part2)
                            ->where('city_co_id', $user_info->add_part3)
                            ->where('thana_id', $user_info->add_part4)
                            ->where('id', $user_info->add_part5)
                            ->first();
                        $ward_plus = $c_ward_info->position + 1;
                        $ward_minus = $c_ward_info->position - 1;
                        $c_ward_plus_id_info = DB::table('c_wards')
                            ->select('*')
                            ->where('div_id', $user_info->add_part1)
                            ->where('city_id', $user_info->add_part2)
                            ->where('city_co_id', $user_info->add_part3)
                            ->where('thana_id', $user_info->add_part4)
                            ->where('position', $ward_plus)
                            ->first();
                        $ward_plus_id = $c_ward_plus_id_info->id;
                        if($c_ward_info->position == 1) $ward_minus_id = $c_ward_info->position;
                        else{
                            $c_ward_minus_id_info = DB::table('wards')
                                ->select('*')
                                ->where('div_id', $user_info->add_part1)
                                ->where('dis_id', $user_info->add_part2)
                                ->where('upz_id', $user_info->add_part3)
                                ->where('uni_id', $user_info->add_part4)
                                ->where('position', $ward_minus)
                                ->first();
                            $ward_minus_id = $c_ward_minus_id_info->id;
                        }
                    }
                    $user_type = 5;
                    $delivery_man = DB::table('users')
                        ->where('user_type',  $user_type)
                        ->where('add_part1',  $user_info->add_part1)
                        ->where('add_part2',  $user_info->add_part2)
                        ->where('add_part3',  $user_info->add_part3)
                        ->where('add_part4',  $user_info->add_part4)
                        ->where('add_part5',  $user_info->add_part5)
                        ->where('working_status',  $working_status)
                        ->where('address_type',  $user_info->address_type)
                        ->where('status',  1)
                        ->get();
                    if($delivery_man->count()>0){

                    }
                    else{
                        $delivery_man = DB::table('users')
                            ->where('user_type',  $user_type)
                            ->where('add_part1',  $user_info->add_part1)
                            ->where('add_part2',  $user_info->add_part2)
                            ->where('add_part3',  $user_info->add_part3)
                            ->where('add_part4',  $user_info->add_part4)
                            ->where('add_part5',  $ward_plus_id)
                            ->where('working_status',  $working_status)
                            ->where('address_type',  $user_info->address_type)
                            ->where('status',  1)
                            ->get();
                        if($delivery_man->count()>0){

                        }
                        else{
                            $delivery_man = DB::table('users')
                                ->where('user_type',  $user_type)
                                ->where('add_part1',  $user_info->add_part1)
                                ->where('add_part2',  $user_info->add_part2)
                                ->where('add_part3',  $user_info->add_part3)
                                ->where('add_part4',  $user_info->add_part4)
                                ->where('add_part5',  $ward_minus_id)
                                ->where('working_status',  $working_status)
                                ->where('address_type',  $user_info->address_type)
                                ->where('status',  1)
                                ->get();
                            if($delivery_man->count()>0){

                            }
                        }
                    }
                    if($delivery_man->count()>0){
                        $data = array(
                            'userName'=> $user_info->name,
                            'dev_name'=> $delivery_man[0]->name,
                            'dev_phone'=> $delivery_man[0]->phone,
                            'data' => $stmt,
                            'tx_id' => $tx_id,
                        );
                        $userName = $user_info->name;
                        $userPhone = $user_info->phone;
                        $dealerName = $delear->name;
                        $userEmail = $user_info->email;
                        if($dif_add){
                            $userEmail = $email;
                        }
                        $dealerEmail = $delear->email;
                        $deliveryEmail = $delivery_man[0]->email;
                        $salesEmail = 'sales@bazar-sadai.com';
                        $emails = [$userEmail, $dealerEmail,$deliveryEmail];
                        Mail::send('frontend.salesEmailFormat',$data, function($message) use($emails,$salesEmail,$userName,$userPhone) {
                            $message->to($emails)->subject('Daily bazar order by '.$userName.' ('.$userPhone. ' )');
                            $message->from(''.$salesEmail.'','Bazar-sadai.com');
                        });
                        $result =DB::table('users')
                            ->where('id', $delivery_man[0]->id)
                            ->update([
                                'working_status' => 2,
                            ]);
                        $result =DB::table('v_assign')
                            ->where('id', $salesid)
                            ->update([
                                'v_id' => $delivery_man[0]->id,
                                'v_type' => $delivery_man[0]->user_type,
                                'v_status' => 2,
                            ]);
                        $rows = DB::table('delivery_charges')
                            ->where('lower','<=', $total)
                            ->where('higher','>=', $total)
                            ->first();
                        $delivery_charge = $rows->charge;
                        $data = [
                            [   'user_id' => Cookie::get('user_id'),
                                'tx_id' => $tx_id,
                                'name' => $name,
                                'email' => $email,
                                'phone' => $phone,
                                'gender' => $gender,
                                'address_type' => $addressGroup,
                                'add_part1' => $add_part1,
                                'add_part2' => $add_part2,
                                'add_part3' => $add_part3,
                                'add_part4' => $add_part4,
                                'add_part5' => $add_part5,
                                'address' => $address,
                                'order_notes' => $order_notes,
                                'user_type' => 3,
                                'total' => ((int)$total + (int)$donate_total + (int)$delivery_charge - (int)$discount) ,
                                'discount' => (int)$discount,
                                'delivery_charge' => (int)$delivery_charge,
                            ],
                        ];
                        DB::table('order_details')->insert($data);
                        Session::forget('discount');
                        Session::save();
                        return redirect()->to('myProductOrder')->with('successMessage', 'সফল্ভাবে অর্ডার সম্পন্ন্য হয়েছে। '.$delivery_man[0]->name.' আপনার অর্ডার এর দায়িত্বে আছে। প্রয়োজনে '.$delivery_man[0]->phone.' কল করুন।'  );
                    }
                    else{
                        $data = array(
                            'userName'=> $user_info->name,
                            'dev_name'=> @$delivery_man[0]->name,
                            'dev_phone'=> @$delivery_man[0]->phone,
                            'data' => $stmt,
                            'tx_id' => $tx_id,
                        );
                        $userName = $user_info->name;
                        $userPhone = $user_info->phone;
                        $userEmail = $user_info->email;
                        if($dif_add){
                            $userEmail = $email;
                        }
                        $salesEmail = 'sales@bazar-sadai.com';
                        $emails = [$userEmail];
                        Mail::send('frontend.salesEmailFormat',$data, function($message) use($emails,$salesEmail,$userName,$userPhone) {
                            $message->to($emails)->subject('Daily bazar order by '.$userName.' ('.$userPhone. ' )');
                            $message->from(''.$salesEmail.'','Bazar-sadai.com');
                        });
                        $result =DB::table('v_assign')
                            ->where('id', $salesid)
                            ->update([
                                'v_id' => 0,
                                'v_type' => 0,
                                'v_status' => 0,
                            ]);
                        $rows = DB::table('delivery_charges')
                            ->where('lower','<=', $total)
                            ->where('higher','>=', $total)
                            ->first();
                        $delivery_charge = $rows->charge;
                        $data = [
                            [   'user_id' => Cookie::get('user_id'),
                                'tx_id' => $tx_id,
                                'name' => $name,
                                'email' => $email,
                                'phone' => $phone,
                                'gender' => $gender,
                                'address_type' => $addressGroup,
                                'add_part1' => $add_part1,
                                'add_part2' => $add_part2,
                                'add_part3' => $add_part3,
                                'add_part4' => $add_part4,
                                'add_part5' => $add_part5,
                                'address' => $address,
                                'order_notes' => $order_notes,
                                'user_type' => 3,
                                'total' => ((int)$total + (int)$donate_total + (int)$delivery_charge - (int)$discount) ,
                                'discount' => (int)$discount,
                                'delivery_charge' => (int)$delivery_charge,
                            ],
                        ];
                        DB::table('order_details')->insert($data);
                        Session::forget('discount');
                        Session::save();
                        if($result){
                            return redirect()->to('myProductOrder')->with('successMessage', 'আপনার অর্ডার প্রোসেসিং আছে।');
                        }
                        else{
                            return redirect()->to('myProductOrder')->with('errorMessage', 'আবার চেষ্টা করুন');
                        }
                    }
                }
                else {
                    $result = DB::table('v_assign')->insert([
                        'user_id' => 0,
                        'dealer_id' => 0,
                        'pay_id' => $tx_id,
                        'sales_date' => $date
                    ]);
                    $salesid = DB::getPdo()->lastInsertId();

                    $total = 0;
                    foreach (Session::get('cart_item') as $row) {
                        $product = DB::table('products')
                            ->where('id', $row['productid'])
                            ->first();
                        $quantity = $row['quantity'] / $product->minqty;
                        $price = $product->price;
                        $subtotal = $price * $quantity;
                        $total += $subtotal;
                        $result = DB::table('details')->insert([
                            'sales_id' => $salesid,
                            'product_id' => $product->id,
                            'quantity' => $quantity,
                            'price' => $product->price
                        ]);
                    }
                    $rows = DB::table('delivery_charges')
                        ->where('lower','<=', $total)
                        ->where('higher','>=', $total)
                        ->first();
                    $delivery_charge = $rows->charge;
                    $total = $total + $delivery_charge;
                    $data = [
                        [   'user_id' => 0,
                            'tx_id' => $tx_id,
                            'name' => $name,
                            'email' => $email,
                            'phone' => $phone,
                            'gender' => $gender,
                            'address_type' => $addressGroup,
                            'add_part1' => $add_part1,
                            'add_part2' => $add_part2,
                            'add_part3' => $add_part3,
                            'add_part4' => $add_part4,
                            'add_part5' => $add_part5,
                            'address' => $address,
                            'order_notes' => $order_notes,
                            'user_type' => 3,
                            'total' => $total,
                            'discount' => 0,
                            'delivery_charge' => $delivery_charge,
                        ],
                    ];
                    $result = DB::table('order_details')->insert($data);
                    if($result){
                        Session::forget('cart_item');
                        Session::save();
                        return view('frontend.orderComplete');
                    }
                    else{
                        return redirect()->to('homepage')->with('errorMessage', 'আবার চেষ্টা করুন');
                    }
                }
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function buySale($id){
        try{
            $products = DB::table('seller_product')
                ->where('status', 'Active')
                ->where('amount','>', 0)
                ->orderBy('id','desc')
                ->paginate(50);
               return view('frontend.buysale', ['products' => $products]);
            }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }public function videoView(Request $request){
        try{
            $products = DB::table('seller_product')
                ->where('id', $request->id)
                ->where('status', 'Active')
                ->first();
               return view('frontend.videoView', ['products' => $products]);
            }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function buySaleAnimal($id){
        try{
            $products = DB::table('seller_product')
                ->where('status', 'Active')
                ->where('type', 'Animal')
                ->where('approval','=' ,1)
                ->where('amount','>', 0)
                ->orderBy('id','desc')
                ->paginate(50);
               return view('frontend.buysale', ['products' => $products]);
            }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getAllSaleCategory(Request $request){
        try{
            $rows = DB::table('categories')
                ->where('id', 6)
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }

    public function insertSaleProduct(Request $request){
        try{
            if($request) {
                    if(Cookie::get('user_id')) {
                        $PhotoPath="";
                        if ($request->hasFile('photo')) {
                            $targetFolder = 'public/asset/images/';
                            $file = $request->file('photo');
                            $pname = time() . '.' . $file->getClientOriginalName();
                            $image['filePath'] = $pname;
                            $file->move($targetFolder, $pname);
                            $PhotoPath = $targetFolder . $pname;
                        }
                        $address = $request->address1.','.$request->address2.','.$request->address3;
                        $result = DB::table('sale_products')->insert([
                            'seller_id' => Cookie::get('user_id'),
                            'name' => $request->name,
                            'price' => $request->price,
                            'jat' => $request->jat,
                            'color' => $request->color,
                            'weight' => $request->weight,
                            'address' => $address,
                            'photo' => $PhotoPath,
                            'description' => $request->description,
                        ]);
                        if ($result) {
                            return back()->with('successMessage', 'সফলভাবে  সম্পন্ন  হয়েছে।');
                        } else {
                            return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                        }
                    }
                    else{
                        return back()->with('errorMessage', 'ফর্ম পুরন করুন।');
                    }
                }
            else{
                return back()->with('errorMessage', 'ফর্ম পুরন করুন।');
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getSaleProductsDetails(Request $request){
        try{
            $rows = DB::table('seller_product')
                ->where('id', $request->id)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function animalSaleView($id){
        try{

            $rows = DB::table('sale_products')
                ->where('id', $id)
                ->first();
            return view('frontend.animalSaleView', ['products' => $rows, 'id' =>$id]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function productSaleView($id){
        try{

            $rows = DB::table('seller_product')
                ->where('id', $id)
                ->first();
            return view('frontend.productSaleView', ['products' => $rows, 'id' =>$id]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function animalSales($id){
        try{

            $rows = DB::table('sale_products')
                ->where('id', $id)
                ->first();
            $set='123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $code=substr(str_shuffle($set), 0, 12);
            $result = DB::table('animal_sales')->insert([
                'seller_id' => $rows->seller_id,
                'buyer_id' =>  Cookie::get('user_id'),
                'product_id' => $rows->id,
                'date' =>date("Y-m-d"),
                'pay_id' => $code,
            ]);

            if ($result) {
                $upresult =DB::table('sale_products')
                    ->where('id', $rows->id)
                    ->update([
                        'sale_status' => 0,
                    ]);
                if ($upresult) {
                    return redirect()->to('profile')->with('successMessage', 'সফলভাবে  সম্পন্ন  হয়েছে। দ্রুত আপনার সাথে যোগাযোগ করা হবে।');
                }
                else{
                    return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                }

            } else {
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function productSales(Request $request){
        try{
            $sessRequest = json_encode(Session::get('variousMarket'));
            $sessRequest = json_decode($sessRequest);
            $ref = $sessRequest->ref;
            $id = $sessRequest->id;
            $rows = DB::table('seller_product')
                ->where('id', $id)
                ->first();
            $price  = $rows->price;
            $type = 'various kinds of product sales';
            $msg = $request->msg;
            $tx_id = $request->tx_id;
            $status = $request->status;
            $bank_tx_id = $request->bank_tx_id;
            $amount = $request->amount;
            $bank_status = $request->bank_status;
            $sp_code = $request->sp_code;
            $sp_code_des = $request->sp_code_des;
            $sp_payment_option = $request->sp_payment_option;
            $date = date('Y-m-d');
            if($status == 'Failed'){
                return redirect('homepage')->with('errorMessage', 'আবার চেষ্টা করুন।');
            }
            else{
                $result = DB::table('payment_info')->insert([
                    'user_id' => Cookie::get('user_id'),
                    'status' => $status,
                    'type' => $type,
                    'msg' => $msg,
                    'tx_id' => $tx_id,
                    'bank_tx_id' => $bank_tx_id,
                    'amount' => $amount,
                    'bank_status' => $bank_status,
                    'sp_code' => $sp_code,
                    'sp_code_des' => $sp_code_des,
                    'sp_payment_option' => $sp_payment_option,
                ]);
                if($result){
                    $result = DB::table('product_sales')->insert([
                        'seller_id' => $rows->seller_id,
                        'buyer_id' =>  Cookie::get('user_id'),
                        'product_id' => $rows->id,
                        'date' =>date("Y-m-d"),
                        'pay_id' => $tx_id,
                        'ref' => $ref,
                    ]);
                    if ($result) {
                        $upresult =DB::table('seller_product')
                            ->where('id', $rows->id)
                            ->update([
                                'amount' => $rows->amount-1,
                            ]);
                        if ($upresult) {
                            return redirect()->to('myVariousProductOrderUser')->with('successMessage', 'সফলভাবে  সম্পন্ন  হয়েছে। দ্রুত আপনার সাথে যোগাযোগ করা হবে।');
                        }
                        else{
                            return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                        }

                    }
                }
                else {
                    return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                }
            }

        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function searchProduct(Request $request){
        try{
            if($request->search)
                $search = $request->search;
            if($request->mbSearch)
                $search = $request->mbSearch;
            $service_cat = DB::table('categories')
                ->where('type', 2)
                ->where('status', 1)
                ->orderBy('id', 'DESC')->get();
            $product_cat = DB::table('categories')
                ->where('type', 1)
                ->where('status', 1)
                ->orderBy('id', 'ASC')->get();
            if(Cookie::get('user_id') != null) {
                $customer = DB::table('users')
                    ->where('id',Cookie::get('user_id'))
                    ->first();
                $dealer = DB::table('users')
                    ->where('add_part1',$customer->add_part1)
                    ->where('add_part2',$customer->add_part2)
                    ->where('add_part3',$customer->add_part3)
                    ->where('address_type',$customer->address_type)
                    ->where('user_type',7)
                    ->first();
                if(!empty($dealer)) {
                    $dealer_product = DB::table('products')
                        ->select('*', 'product_assign.id as p_a_id', 'products.id as id')
                        ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                        ->where('products.name', 'LIKE','%'.$search.'%')
                        ->orWhere('products.genre', 'LIKE','%'.$search.'%')
                        ->where('products.status', 1)
                        ->where('product_assign.dealer_id', $dealer->id)
                        ->orderBy('products.id', 'ASC')->paginate(100);
                    if($dealer_product->count()>0){
                        $dealer_status['status'] = 1;
                        return view('frontend.shop', ['products' => $dealer_product,'status' =>$dealer_status,'pro_categories' => $product_cat, 'ser_categories' => $service_cat]);
                    }
                    else{
                        return redirect()->to('shop')->with('errorMessage', 'পণ্যটি পাওয়া যায়নি।');
                    }

                }
                else{
                    $dealer_product = DB::table('products')
                        ->where('name', 'LIKE','%'.$search.'%')
                        ->orWhere('genre', 'LIKE','%'.$search.'%')
                        ->where('status', 1)
                        ->orderBy('id', 'ASC')->paginate(100);
                    if($dealer_product->count()>0){
                        $dealer_status['status'] = 0;
                        return view('frontend.shop', ['products' => $dealer_product,'status' =>$dealer_status,'pro_categories' => $product_cat, 'ser_categories' => $service_cat]);
                    }
                    else{
                        return redirect()->to('shop')->with('errorMessage', 'পণ্যটি পাওয়া যায়নি।');
                    }
                }

            }
            else {
                $dealer_product = DB::table('products')
                    ->where('name', 'LIKE','%'.$search.'%')
                    ->orWhere('genre', 'LIKE','%'.$search.'%')
                    ->where('status', 1)
                    ->orderBy('id', 'ASC')->paginate(100);
                if($dealer_product->count()>0){
                    $dealer_status['status'] = 0;
                    return view('frontend.shop', ['products' => $dealer_product,'status' =>$dealer_status,'pro_categories' => $product_cat, 'ser_categories' => $service_cat]);
                }
                else{
                    return redirect()->to('shop')->with('errorMessage', 'পণ্যটি পাওয়া যায়নি।');
                }
            }

        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function searchMedicine(Request $request){
        try{
            $service_cat = DB::table('categories')
                ->where('type', 2)
                ->where('status', 1)
                ->orderBy('id', 'DESC')->get();
            $product_cat = DB::table('categories')
                ->where('type', 1)
                ->where('status', 1)
                ->orderBy('id', 'ASC')->get();
            $trade_name = $request->trade_name;
            $generic_name = $request->generic_name;
            $company_name = $request->company_name ;
            if($company_name=="" && $trade_name=="" && $generic_name==""){
                return back()->with('errorMessage', 'কোন ডাটা পাওয়া যাইনি।');
            }
            else{
                if(Cookie::get('user_id') != null) {
                    $customer = DB::table('users')
                        ->where('id',Cookie::get('user_id'))
                        ->first();
                    $dealer = DB::table('users')
                        ->where('add_part1',$customer->add_part1)
                        ->where('add_part2',$customer->add_part2)
                        ->where('add_part3',$customer->add_part3)
                        ->where('address_type',$customer->address_type)
                        ->where('user_type',7)
                        ->first();
                    if(!empty($dealer)) {
                        if($trade_name){
                            $dealer_product = DB::table('products')
                                ->select('*', 'product_assign.id as p_a_id', 'products.id as id')
                                ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                                ->where('products.name', 'LIKE','%'.$trade_name.'%')
                                ->where('products.status', 1)
                                ->where('products.cat_id', 3)
                                ->where('product_assign.dealer_id', $dealer->id)
                                ->orderBy('products.id', 'ASC')->paginate(100);
                        }
                        if($generic_name){
                            $dealer_product = DB::table('products')
                                ->select('*', 'product_assign.id as p_a_id', 'products.id as id')
                                ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                                ->where('products.genre', 'LIKE','%'.$generic_name.'%')
                                ->where('products.status', 1)
                                ->where('products.cat_id', 3)
                                ->where('product_assign.dealer_id', $dealer->id)
                                ->orderBy('products.id', 'ASC')->paginate(100);
                        }
                        if($company_name){
                            $dealer_product = DB::table('products')
                                ->select('*', 'product_assign.id as p_a_id', 'products.id as id')
                                ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                                ->where('products.company', 'LIKE','%'.$company_name.'%')
                                ->where('products.status', 1)
                                ->where('products.cat_id', 3)
                                ->where('product_assign.dealer_id', $dealer->id)
                                ->orderBy('products.id', 'ASC')->paginate(100);
                        }
                        if($dealer_product->count()>0){
                            $dealer_status['status'] = 1;
                        }
                        else{
                            return back()->with('errorMessage', 'পণ্যটি পাওয়া যায়নি।');
                        }
                    }
                    else{
                        if($trade_name) {
                            $dealer_product = DB::table('products')
                                ->where('name', 'LIKE', '%' . $trade_name . '%')
                                ->where('status', 1)
                                ->where('cat_id', 3)
                                ->orderBy('id', 'ASC')->paginate(100);
                            if($dealer_product->count()>0){
                                $dealer_status['status'] = 0;
                            }
                            else{
                                return back()->with('errorMessage', 'পণ্যটি পাওয়া যায়নি।');
                            }
                        }
                        if($generic_name) {
                            $dealer_product = DB::table('products')
                                ->where('genre', 'LIKE', '%' . $generic_name . '%')
                                ->where('status', 1)
                                ->where('cat_id', 3)
                                ->orderBy('id', 'ASC')->paginate(100);
                            if($dealer_product->count()>0){
                                $dealer_status['status'] = 0;
                            }
                            else{
                                return back()->with('errorMessage', 'পণ্যটি পাওয়া যায়নি।');
                            }
                        }
                        if($company_name) {
                            $dealer_product = DB::table('products')
                                ->where('company', 'LIKE', '%' . $company_name . '%')
                                ->where('status', 1)
                                ->where('cat_id', 3)
                                ->orderBy('id', 'ASC')->paginate(100);
                            if($dealer_product->count()>0){
                                $dealer_status['status'] = 0;
                            }
                            else{
                                return back()->with('errorMessage', 'পণ্যটি পাওয়া যায়নি।');
                            }
                        }
                    }

                }
                else {
                    if ($trade_name) {
                        $dealer_product = DB::table('products')
                            ->where('name', 'LIKE', '%' . $trade_name . '%')
                            ->where('status', 1)
                            ->where('cat_id', 3)
                            ->orderBy('id', 'ASC')->paginate(100);
                        if($dealer_product->count()>0){
                            $dealer_status['status'] = 0;
                        }
                        else{
                            return back()->with('errorMessage', 'পণ্যটি পাওয়া যায়নি।');
                        }
                    }
                    if ($generic_name) {
                        $dealer_product = DB::table('products')
                            ->where('genre', 'LIKE', '%' . $generic_name . '%')
                            ->where('status', 1)
                            ->where('cat_id', 3)
                            ->orderBy('id', 'ASC')->paginate(100);
                        if($dealer_product->count()>0){
                            $dealer_status['status'] = 0;
                        }
                        else{
                            return back()->with('errorMessage', 'পণ্যটি পাওয়া যায়নি।');
                        }
                    }
                    if ($company_name) {
                        $dealer_product = DB::table('products')
                            ->where('company', 'LIKE', '%' . $company_name . '%')
                            ->where('status', 1)
                            ->where('cat_id', 3)
                            ->orderBy('id', 'ASC')->paginate(100);
                        if($dealer_product->count()>0){
                            $dealer_status['status'] = 0;
                        }
                        else{
                            return back()->with('errorMessage', 'পণ্যটি পাওয়া যায়নি।');
                        }
                    }
                }
            }
            return view('frontend.shop', ['products' => $dealer_product,'status' =>$dealer_status,'pro_categories' => $product_cat, 'ser_categories' => $service_cat]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function searchMedicineByLetter($letter){
        try{
            $service_cat = DB::table('categories')
                ->where('type', 2)
                ->where('status', 1)
                ->orderBy('id', 'DESC')->get();
            $product_cat = DB::table('categories')
                ->where('type', 1)
                ->where('status', 1)
                ->orderBy('id', 'ASC')->get();
            if($letter==""){
                return back()->with('errorMessage', 'কোন ডাটা পাওয়া যাইনি।');
            }
            else{
                if(Cookie::get('user_id') != null) {
                    $customer = DB::table('users')
                        ->where('id',Cookie::get('user_id'))
                        ->first();
                    $dealer = DB::table('users')
                        ->where('add_part1',$customer->add_part1)
                        ->where('add_part2',$customer->add_part2)
                        ->where('add_part3',$customer->add_part3)
                        ->where('address_type',$customer->address_type)
                        ->where('user_type',7)
                        ->first();
                    if(!empty($dealer)) {
                        if($letter){
                            $dealer_product = DB::table('products')
                                ->select('*', 'product_assign.id as p_a_id', 'products.id as id')
                                ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                                ->where('products.name', 'LIKE',$letter.'%')
                                ->where('products.status', 1)
                                ->where('products.cat_id', 3)
                                ->where('product_assign.dealer_id', $dealer->id)
                                ->orderBy('products.id', 'ASC')->paginate(100);
                        }
                        if($dealer_product->count()>0){
                            $dealer_status['status'] = 1;
                            //dd($dealer_product);
                        }
                    }
                    else{
                        if($letter) {
                            $dealer_product = DB::table('products')
                                ->where('name', 'LIKE',  $letter . '%')
                                ->where('status', 1)
                                ->where('cat_id', 3)
                                ->orderBy('id', 'ASC')->paginate(100);
                            $dealer_status['status'] = 0;
                        }
                    }

                }
                else {
                    if ($letter) {
                        $dealer_product = DB::table('products')
                            ->where('name', 'LIKE', $letter . '%')
                            ->where('status', 1)
                            ->where('cat_id', 3)
                            ->orderBy('id', 'ASC')->paginate(100);
                        $dealer_status['status'] = 0;
                    }
                }
            }
            return view('frontend.shop', ['products' => $dealer_product,'status' =>$dealer_status,'pro_categories' => $product_cat, 'ser_categories' => $service_cat]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }

    public function deliveryAddress(Request $request){

        $upresult =DB::table('sale_products')
            ->where('id', $request->proId)
            ->update([
                'delivery_address' => $request->delAdd,
            ]);
        if($upresult){
            return back()->with('successMessage', 'সফলভাবে  সম্পন্ন  হয়েছে।');
        }
        else{
            return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
        }
    }
    public function serviceCategory(Request $request){

        $services_cat_trans = DB::table('categories')
            ->where('id', 8)
            ->where('type', 2)
            ->where('status', 1)
            ->orderBy('id', 'ASC')->get();
        $services_cat_courier = DB::table('categories')
            ->where('id', 11)
            ->where('type', 2)
            ->where('status', 1)
            ->orderBy('id', 'ASC')->get();
        $services_cat_medical = DB::table('categories')
            ->where('id', 10)
            ->where('type', 2)
            ->where('status', 1)
            ->orderBy('id', 'ASC')->get();
        $home_assistants = DB::table('categories')
            ->where('id', 9)
            ->where('type', 2)
            ->where('status', 1)
            ->orderBy('id', 'ASC')->get();
        $tours = DB::table('categories')
            ->where('id', 12)
            ->where('type', 2)
            ->where('status', 1)
            ->orderBy('id', 'ASC')->get();
        return view('frontend.servicesCategory',
                [
                    'services_cat_trans' => $services_cat_trans,
                    'services_cat_medical'=>$services_cat_medical,
                    'home_assistants'=>$home_assistants,
                    'services_cat_couriers'=>$services_cat_courier,
                    'tours'=>$tours
                ]);
    }
    public function serviceSubCategoryMedical($id){
        $med_services_sub_cat = DB::table('subcategories')
            ->where('cat_id', $id)
            ->where('type', 2)
            ->where('status', 1)
            ->orderBy('id', 'ASC')->get();
        return view('frontend.serviceSubCategoryMedical', ['med_services_sub_cat' => $med_services_sub_cat]);
    }

    public function changeWorkingStatus(Request  $request){
        if($request->id == 0){
            $result =DB::table('users')
                ->where('id', Cookie::get('user_id'))
                ->update([
                    'working_status' => $request->id,
                ]);
        }
        if($request->id == 1){
            $result =DB::table('users')
                ->where('id', Cookie::get('user_id'))
                ->update([
                    'working_status' => $request->id,
                ]);
        }
        if($request->id == 2){
            $result =DB::table('users')
                ->where('id', Cookie::get('user_id'))
                ->update([
                    'working_status' => $request->id,
                ]);
            if($result){
                $result1 =DB::table('v_assign')
                    ->where('v_id', Cookie::get('user_id'))
                    ->orderBy('id','desc')
                    ->first();
                $result2 =DB::table('v_assign')
                    ->where('id', $result1->id)
                    ->update([
                        'v_status' => $request->id,
                    ]);
                if($result2){
                    return response()->json(array('data'=>'ok'));
                }
                else{
                    return response()->json(array('data'=>'not ok'));
                }
            }
        }
        if($request->id == 3){
            $result =DB::table('users')
                ->where('id', Cookie::get('user_id'))
                ->update([
                    'working_status' => $request->id,
                ]);
            if($result){
                $result1 =DB::table('v_assign')
                    ->where('v_id', Cookie::get('user_id'))
                    ->orderBy('id','desc')
                    ->first();
                $result2 =DB::table('v_assign')
                    ->where('id', $result1->id)
                    ->update([
                        'v_status' => $request->id,
                    ]);
                if($result2){
                    return response()->json(array('data'=>'ok'));
                }
                else{
                    return response()->json(array('data'=>'not ok'));
                }
            }
        }
        if($request->id == 4){
            $result =DB::table('users')
                ->where('id', Cookie::get('user_id'))
                ->update([
                    'working_status' => 1,
                ]);
            if($result){
                $result1 =DB::table('v_assign')
                    ->where('v_id', Cookie::get('user_id'))
                    ->orderBy('id','desc')
                    ->first();
                $result2 =DB::table('v_assign')
                    ->where('id', $result1->id)
                    ->update([
                        'v_status' => $request->id,
                    ]);
                if($result2){
                    return response()->json(array('data'=>'ok'));
                }
                else{
                    return response()->json(array('data'=>'not ok'));
                }
            }
        }
        else{
            return response()->json(array('data'=>'not ok'));
        }
    }

    public function forHumanity(){
        $rows = DB::table('donation_details')
            ->select('products.cat_id','products.unit','products.name', DB::raw('SUM(donation_details.quantity) AS quantity'))
            ->join('products','products.id','=','donation_details.product_id')
            ->groupBy('products.name','products.unit','products.cat_id')
            ->get();
        return view('frontend.forHumanity',['products' => $rows]);
    }
    public function bondhonBazar(){
        try{
            if(Cookie::get('user_id') != null) {
                $customer = DB::table('users')
                    ->where('id',Cookie::get('user_id'))
                    ->first();
                $dealer = DB::table('users')
                    ->where('add_part1',$customer->add_part1)
                    ->where('add_part2',$customer->add_part2)
                    ->where('add_part3',$customer->add_part3)
                    ->where('address_type',$customer->address_type)
                    ->where('user_type',7)
                    ->first();
                if(!empty($dealer)) {
                    $dealer_product = DB::table('products')
                        ->select('*', 'product_assign.id as p_a_id', 'products.id as id')
                        ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                        ->where(function($query) {
                            $query->where('products.cat_id', 1)
                                ->orWhere('products.cat_id', 2);
                        })
                        ->where('products.status', 1)
                        ->where('product_assign.dealer_id', $dealer->id)
                        ->orderBy('products.id', 'ASC')->paginate(100);
                    //dd($dealer_product);
                    if($dealer_product->count()>0){
                        $dealer_status['status'] = 1;
                        //dd($dealer_product);
                        return view('frontend.productPage', ['products' => $dealer_product,'status' =>$dealer_status]);
                    }
                }
                else{
                    $dealer_product = DB::table('products')
                        ->where(function($query) {
                            $query->where('products.cat_id', 1)
                                ->orWhere('products.cat_id', 2);
                        })
                        ->where('status', 1)
                        ->orderBy('id', 'ASC')->paginate(100);
                    $dealer_status['status'] = 0;
                    return view('frontend.productPage', ['products' => $dealer_product ,'status' =>$dealer_status]);
                }

            }
            else {
                $dealer_product = DB::table('products')
                    ->where(function($query) {
                        $query->where('products.cat_id', 1)
                            ->orWhere('products.cat_id', 2);
                    })
                    ->where('status', 1)
                    ->orderBy('id', 'ASC')->paginate(100);
                $dealer_status['status'] = 0;
                return view('frontend.productPage', ['products' => $dealer_product,'status' =>$dealer_status]);
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getProductSearchByName(Request $request){
        try{
            if($request->val){
                $products = DB::table('products')
                    ->where('name', 'like', '%' . $request->val . '%')
                    ->where('status', 1)
                    ->get();
                if($products->count() > 0){
                    $output = '<ul class="menu" style="display:block; margin-top: -30px;>';
                    foreach ($products as $row) {
                        $output .= '
                   <li><a href="#">' . $row->name . '</a></li>
                   ';
                    }
                    $output .= '</ul>';
                }
                else{
                    $output = '';
                }
            }
            else{
                $output = '';
            }
            return response()->json(array('data'=>$output));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getProductSearchDesktopByName(Request $request){
        try{
            $output = array();
            if($request->val){
                $products = DB::table('products')
                    ->where('name', 'like', '%' . $request->val . '%')
                    ->where('status', 1)
                    ->get();
                if($products->count() > 0){
                    foreach ($products as $row) {
                        $output[] = $row->name;
                    }
                }
                else{
                    $output[] = "No item found!";
                }
            }
            else{
                $output[] = "No item found!";
            }
            return response()->json(array('data'=>$output));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function searchAnimal(Request $request){
        try{
            $products = DB::table('seller_product')
                ->where('status', 'Active')
                ->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('address', 'like', '%'.$request->search.'%')
                ->where('type', 'Animal')
                ->where('amount','>', 0)
                ->orderBy('id','desc')
                ->paginate(50);
            if(count($products)<1){
                Session::flash('errorMessage', 'কোন তথ্য পাওয়া যায়নি।');
                return view('frontend.buysale', ['products' => $products,'val'=>$request->search]);
            }
            else{
                return view('frontend.buysale', ['products' => $products,'val'=>$request->search]);
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function marchantShop(Request $request){
        try{
            $slide= DB::table('slide')
                ->orderBy('id', 'DESC')
                ->take(10)->get();
            $shop= DB::table('seller_shop')
                ->orderBy('id', 'DESC')->paginate(100);
            if($request->cat_id){
                $shop= DB::table('seller_shop')
                    ->where('cat_id',$request->cat_id)
                    ->orderBy('id', 'DESC')->paginate(100);
            }
            return view('frontend.marchantShop', ['slides' => $slide,'shops' => $shop]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function sellerShopById($id){
        try{
            $service_cat = DB::table('categories')
                ->where('type', 2)
                ->where('status', 1)
                ->orderBy('id', 'DESC')->get();
            $product_cat = DB::table('categories')
                ->where('type','1')
                ->where('status','1')
                ->orWhere('type','3')
                ->where('status','1')
                ->orderBy('id', 'ASC')->get();
            $shop= DB::table('seller_shop')
                ->where('id', $id)
                ->orderBy('id', 'DESC')->first();
            $products= DB::table('products')
                ->where('upload_by', $shop->seller_id)
                ->where('status', 1)
                ->orderBy('id', 'DESC')->paginate(100);
            $dealer_status_1['status'] = 0;
            return view('frontend.shop', ['ser_categories' => $service_cat,'pro_categories' => $product_cat,'status' => $dealer_status_1,'products' => $products]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function locationBaseSearchPage(){
        try{
            $slide= DB::table('slide')
                ->orderBy('id', 'DESC')
                ->take(10)->get();
            return view('frontend.locationBaseSearchPage' ,['slides' => $slide]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function shop1(Request $request){
        try{
            $service_cat = DB::table('categories')
                ->where('type', 2)
                ->where('status', 1)
                ->orderBy('id', 'DESC')->get();
            $product_cat = DB::table('categories')
                ->where('type', 1)
                ->where('status', 1)
                ->orderBy('id', 'ASC')->get();
            if(Cookie::get('user_id') != null) {
                $customer = DB::table('users')
                    ->where('id',Cookie::get('user_id'))
                    ->first();
                $dealer = DB::table('users')
                    ->where('add_part1',$customer->add_part1)
                    ->where('add_part2',$customer->add_part2)
                    ->where('add_part3',$customer->add_part3)
                    ->where('address_type',$customer->address_type)
                    ->where('user_type',7)
                    ->first();
                if(!empty($dealer)) {
                    $dealer_product_1 = DB::table('products')
                        ->select('*', 'product_assign.id as p_a_id', 'products.id as id')
                        ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                        ->where('products.status', 1)
                        ->where('product_assign.dealer_id', $dealer->id)
                        ->orderBy('products.id', 'ASC')->paginate(60);
                    if($dealer_product_1->count()>0){
                        $dealer_status_1['status'] = 1;
                    }
                }
                else{
                    $dealer_product_1 = DB::table('products')
                        ->where('status', 1)
                        ->orderBy('id', 'ASC')->paginate(60);
                    $dealer_status_1['status'] = 0;
                }
            }
            else {
                $dealer_product_1 = DB::table('products')
                    ->where('status', 1)
                    ->orderBy('id', 'ASC')->paginate(60);
                $dealer_status_1['status'] = 0;
            }

            //dd($dealer_product_1);
            return view('frontend.shop',
                [
                    'pro_categories' => $product_cat,
                    'ser_categories' => $service_cat,
                    'products' => $dealer_product_1 ,
                    'status' =>$dealer_status_1,
                ]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function locationBaseProductSearch(Request $request){
        try{
            $service_cat = DB::table('categories')
                ->where('type', 2)
                ->where('status', 1)
                ->orderBy('id', 'DESC')->get();
            $product_cat = DB::table('categories')
                ->where('type', 1)
                ->where('status', 1)
                ->orderBy('id', 'ASC')->get();

            $dealer = DB::table('users')
                ->where('add_part1',$request->add_part1)
                ->where('add_part2',$request->add_part2)
                ->where('add_part3',$request->add_part3)
                ->where('address_type',$request->address_type)
                ->where('user_type',7)
                ->orWhere('user_type',4)
                ->first();
            if(!empty($dealer)) {
                $dealer_product_1 = DB::table('products')
                    ->select('*', 'product_assign.id as p_a_id', 'products.id as id')
                    ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                    ->where('products.status', 1)
                    ->where('product_assign.dealer_id', $dealer->id)
                    ->orderBy('products.id', 'ASC')->paginate(60);
                if($dealer_product_1->count()>0){
                    $dealer_status_1['status'] = 1;
                }
                else{
                    return back()->with('errorMessage', 'আপনার কাংখিত লোকেশনে পণ্য খুজে পাওয়া যাইনি।');
                }
            }
            else{
                $dealer_product_1 = DB::table('products')
                    ->where('status', 1)
                    ->orderBy('id', 'ASC')->paginate(60);
                $dealer_status_1['status'] = 0;
                return back()->with('errorMessage', 'আপনার কাংখিত লোকেশনে পণ্য খুজে পাওয়া যাইনি।');
            }

            return view('frontend.shop',
                [
                    'pro_categories' => $product_cat,
                    'ser_categories' => $service_cat,
                    'products' => $dealer_product_1 ,
                    'status' =>$dealer_status_1,
                ]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage','');
        }
    }
    public function customOrder(Request $request){
        try{
            $product_cat = DB::table('categories')
                ->where('status', 1)
                ->orderBy('id', 'ASC')->get();
            return view('frontend.customOrder', ['categories' =>$product_cat]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage','');
        }
    }
    public function  getSubcategoryByCat(Request $request){
        try{

            $rows = DB::table('subcategories')->where('cat_id', $request->id)->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function  insertCustomOrder(Request $request){
        try{
            $addressGroup = $request->addressGroup;
            $add_part1 = $request->div_id;
            if ($addressGroup == 1) {
                $add_part2 = $request->disid;
                $add_part3 = $request->upzid;
                $add_part4 = $request->uniid;
                $add_part5 = $request->wardid;
            }
            if ($addressGroup == 2) {
                $add_part2 = $request->c_disid;
                $add_part3 = $request->c_upzid;
                $add_part4 = $request->c_uniid;
                $add_part5 = $request->c_wardid;
            }
            if ($request->hasFile('image')) {
                $targetFolder = 'public/asset/images/';
                $file = $request->file('image');
                $pname = time() . '.' . $file->getClientOriginalName();
                $image['filePath'] = $pname;
                $file->move($targetFolder, $pname);
                $userPhotoPath = $targetFolder . $pname;
            }
            $result = DB::table('custom_order_booking')->insert([
                'category' => $request->category,
                'sub_category' => $request->sub_category,
                'name' => $request->name,
                'phone' => $request->phone,
                'address_type' =>$addressGroup,
                'add_part1' => $add_part1,
                'add_part2' => $add_part2,
                'add_part3' => $add_part3,
                'add_part4' => $add_part4,
                'add_part5' => $add_part5,
                'address' => $request->address,
                'details' => $request->details,
                'date' => $request->date,
                'amount' => $request->amount,
                'price' => $request->price,
                'image' =>$userPhotoPath,
            ]);
            if ($result) {
                return view('frontend.orderComplete');
            } else {
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function  insertCustomOrderRequest(Request $request){
        try{
            $result = DB::table('custom_order_seller')->insert([
                'buyer_request_id' => $request->id,
                'seller_name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'date' => $request->date,
                'price' => $request->price,
            ]);
            if ($result) {
                return view('frontend.orderComplete');
            } else {
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function customerDemandList (Request $request){
        try {
            $order_details = DB::table('custom_order_booking')->orderBy('id','desc')->get();
            //dd($order_details);
            $i=0;
            $sum = 0;
            $orderArr = array();
            foreach($order_details as $order){
                if($order->address_type == 1){
                    $add_part1 = DB::table('divisions')
                        ->where('id',$order->add_part1)
                        ->first();
                    $add_part2 = DB::table('districts')
                        ->where('div_id',$order->add_part1)
                        ->where('id',$order->add_part2)
                        ->first();
                    $add_part3 = DB::table('upazillas')
                        ->where('div_id',$order->add_part1)
                        ->where('dis_id',$order->add_part2)
                        ->where('id',$order->add_part3)
                        ->first();
                    $add_part4 = DB::table('unions')
                        ->where('div_id',$order->add_part1)
                        ->where('dis_id',$order->add_part2)
                        ->where('upz_id',$order->add_part3)
                        ->where('id',$order->add_part4)
                        ->first();
                    $add_part5 = DB::table('wards')
                        ->where('div_id',$order->add_part1)
                        ->where('dis_id',$order->add_part2)
                        ->where('upz_id',$order->add_part3)
                        ->where('uni_id',$order->add_part4)
                        ->where('id',$order->add_part5)
                        ->first();
                }
                if($order->address_type == 2){
                    $add_part1 = DB::table('divisions')
                        ->where('id',$order->add_part1)
                        ->first();
                    $add_part2 = DB::table('cities')
                        ->where('div_id',$order->add_part1)
                        ->where('id',$order->add_part2)
                        ->first();
                    $add_part3 = DB::table('city_corporations')
                        ->where('div_id',$order->add_part1)
                        ->where('city_id',$order->add_part2)
                        ->where('id',$order->add_part3)
                        ->first();
                    $add_part4 = DB::table('thanas')
                        ->where('div_id',$order->add_part1)
                        ->where('city_id',$order->add_part2)
                        ->where('city_co_id',$order->add_part3)
                        ->where('id',$order->add_part4)
                        ->first();
                    $add_part5 = DB::table('c_wards')
                        ->where('div_id',$order->add_part1)
                        ->where('city_id',$order->add_part2)
                        ->where('city_co_id',$order->add_part3)
                        ->where('thana_id',$order->add_part4)
                        ->where('id',$order->add_part5)
                        ->first();
                }
                $orderArr[$i]['id'] = $order->id;
                $orderArr[$i]['name'] = $order->name;
                $orderArr[$i]['phone'] = $order->phone;
                $orderArr[$i]['address'] = $add_part1->name.' ,'.$add_part2->name.' ,'.$add_part3->name.' ,'.$add_part4->name.' ,'.$add_part5->name;
                $orderArr[$i]['date'] = $order->date;
                $orderArr[$i]['amount'] = $order->amount;
                $orderArr[$i]['price'] = $order->price;
                $orderArr[$i]['image'] = $order->image;
                $orderArr[$i]['status'] = $order->status;
                $orderArr[$i]['details'] = $order->details;
                $i++;
            }
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $itemCollection = collect($orderArr);
            $perPage = 20;
            $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
            $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
            $paginatedItems->setPath($request->url());
            return view('frontend.customerDemandList', ['orders' => $paginatedItems]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function allRestaurantShop (Request $request){
        $shop = DB::table('seller_shop')->where('cat_id','23')->orderBy('id','desc')->paginate(50);
        if($shop->count()>0){
            $slide= DB::table('slide')
                ->orderBy('id', 'DESC')
                ->take(10)->get();
            return view('frontend.marchantShop', ['slides' => $slide,'shops' => $shop]);
        }
        else{
            return back()->with('errorMessage', 'কোন শপ পাওয়া যায়নি।');
        }

    }
}
