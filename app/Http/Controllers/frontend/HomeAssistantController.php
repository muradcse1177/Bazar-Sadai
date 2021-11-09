<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use smasif\ShurjopayLaravelPackage\ShurjopayService;

class HomeAssistantController extends Controller
{
    public function serviceSubCategoryHomeAssistant($id){
        $home_assistant_sub_cat = DB::table('subcategories')
            ->where('cat_id', $id)
            ->where('type', 2)
            ->where('status', 1)
            ->orderBy('id', 'ASC')->get();
        return view('frontend.serviceSubCategoryHomeAssistant', ['home_assistant_sub_cats' => $home_assistant_sub_cat]);
    }
    public function cookingPageFront(){
        return view('frontend.cookingPage');
    }
    public function getAllCookingType(){
        $rows = DB::table('cooking')
            ->distinct()
            ->get('cooking_type');
        return response()->json(array('data'=>$rows));
    }
    public function getMealTypeFront(Request $request){
        $rows = DB::table('cooking')
            ->where('cooking_type', $request->id)
            ->get();
        return response()->json(array('data'=>$rows));
    }
    public function getMealPersonFront(Request $request){
        $rows = DB::table('cooking')
            ->where('cooking_type', $request->cooking_type)
            ->where('meal', $request->meal)
            ->get();
        return response()->json(array('data'=>$rows));
    }
    public function getMealTimeFront(Request $request){
        $rows = DB::table('cooking')
            ->where('cooking_type', $request->cooking_type)
            ->where('meal', $request->meal)
            ->where('person', $request->person)
            ->get();
        return response()->json(array('data'=>$rows));
    }
    public function getMealPriceFront(Request $request){
        $rows = DB::table('cooking')
            ->where('cooking_type', $request->cooking_type)
            ->where('meal', $request->meal)
            ->where('person', $request->person)
            ->where('time', $request->time)
            ->first();
        return response()->json(array('data'=>$rows));
    }
    public function cookingBookingFront(Request $request){
        try{
            if($request) {
                $rows = DB::table('cooking')
                    ->where('cooking_type', $request->cooking_type)
                    ->where('meal', $request->meal)
                    ->where('person', $request->person)
                    ->where('time', $request->time)
                    ->first();
                if($request->days) {
                    $price = $request->days * $rows->price;
                    $days = $request->days;
                }
                else {
                    $price = $rows->price;
                    $days =30;
                }
                //common
                $user_info = DB::table('users')
                    ->select('*')
                    ->where('id', Cookie::get('user_id'))
                    ->first();
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
                $user_type = 16;
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
                    ->first();
                if(!empty($delivery_man)){
                    $ok='ok';
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
                        ->first();
                    if(!empty($delivery_man)){
                        $ok='ok';
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
                            ->first();
                        if(!empty($delivery_man)){
                            $ok='ok';

                        }
                    }
                }
                if(!empty($delivery_man)){
                    Session::put('d_name', $delivery_man->name);
                    Session::put('d_phone', $delivery_man->phone);
                    $shurjopay_service = new ShurjopayService();
                    $tx_id = $shurjopay_service->generateTxId();
                    $result =DB::table('users')
                        ->where('id', $delivery_man->id)
                        ->update([
                            'working_status' => 2,
                        ]);
                    $result = DB::table('cooking_booking')->insert([
                        'tx_id' => $tx_id,
                        'user_id' => Cookie::get('user_id'),
                        'cooker_id' => $delivery_man->id,
                        'days' => $days,
                        'cooking_type' => $request->cooking_type,
                        'meal' => $request->meal,
                        'person' => $request->person,
                        'time' => $request->time,
                        'price' => $price,
                        'date' => date("Y-m-d"),
                    ]);
                    $success_route = url('insertCookingPaymentInfo');
                    $shurjopay_service->sendPayment($price, $success_route);
                }
                else{
                    return redirect()->to('cookingPageFront')->with('errorMessage', 'আপনার এলাকাই কোন কুকার খুজে পাওয়া যায়নি।');
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
    public function insertCookingPaymentInfo(Request $request){
        $name = Session::get('d_name');
        $phone =Session::get('d_phone');
        $status = $request->status;
        $type = 'Cooking';
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
        session()->forget('d_name');
        session()->forget('d_phone');
        return redirect()->to('myCookingOrder')->with('successMessage', 'সফল্ভাবে অর্ডার সম্পন্ন্য হয়েছে। '.$name.' আপনার অর্ডার এর দায়িত্বে আছে। প্রয়োজনে '.$phone.' কল করুন।'  );
    }
    public function clothWashingPage(){
        $rows = DB::table('cloth_washing')
            ->get();
        return view('frontend.clothWashingPage', ['cloths' => $rows]);
    }
    public function getAllClothTypeFront(){
        $rows = DB::table('cloth_washing')
            ->get();
        return response()->json(array('data'=>$rows));
    }
    public function getClothWashingPriceFront(Request $request){
        $rows = DB::table('cloth_washing')
            ->where('id', $request->id)
            ->first();
        return response()->json(array('data'=>$rows));
    }
    public function clothWashingBookingFront(Request $request){
        try{
            if($request) {
                if(!empty($request->cloth_id)){
                    $quantity = array_filter($request->quantity, function($value) { return !is_null($value) && $value !== ''; });
                    $cloth_id = array_filter($request->cloth_id, function($value) { return !is_null($value) && $value !== ''; });
                    $i =0;
                    $j=0;
                    foreach ($quantity as $q){
                        $quantity_arr[$i] =$q;
                        $i++;
                    }
                    foreach ($cloth_id as $p){
                        $cloth_id_arr[$j] =$p;
                        $j++;
                    }
                    $price = 0;
                    for ($k=0; $k<count($cloth_id_arr); $k++){
                        $rows = DB::table('cloth_washing')
                            ->where('id', $cloth_id_arr[$k])
                            ->first();
                        $q_price = $rows->price* $quantity_arr[$k];
                        $price = ($price + $q_price) ;
                    }
                    //common
                    $user_info = DB::table('users')
                        ->select('*')
                        ->where('id', Cookie::get('user_id'))
                        ->first();
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
                    $user_type = 21;
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
                        ->first();
                    if(!empty($delivery_man)){

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
                            ->first();
                        if(!empty($delivery_man)){

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
                                ->first();
                            if(!empty($delivery_man)){

                            }
                        }
                    }
                    if(!empty($delivery_man)){
                        Session::put('d_name', $delivery_man->name);
                        Session::put('d_phone', $delivery_man->phone);
                        $shurjopay_service = new ShurjopayService();
                        $tx_id = $shurjopay_service->generateTxId();
                        $result =DB::table('users')
                            ->where('id', $delivery_man->id)
                            ->update([
                                'working_status' => 2,
                            ]);
                        $result = DB::table('cloth_washing_order')->insert([
                            'user_id' => Cookie::get('user_id'),
                            'tx_id' => $tx_id,
                            'cleaner_id' => $delivery_man->id,
                            'date' => date("Y-m-d"),
                            'cloth_id' => json_encode($cloth_id),
                            'quantity' => json_encode($quantity),
                            'price' => $price,
                        ]);
                        $success_route = url('insertClothWashingPaymentInfo');
                        $shurjopay_service->sendPayment($price, $success_route);
                    }
                    else{
                        return redirect()->to('clothWashingPage')->with('errorMessage', 'আপনার এলাকাই কোন কাপড় পরিস্কারক খুজে পাওয়া যায়নি।');
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
    public function insertClothWashingPaymentInfo(Request $request){
        $name = Session::get('d_name');
        $phone =Session::get('d_phone');
        $status = $request->status;
        $type = 'Cloth Washing';
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
        session()->forget('d_name');
        session()->forget('d_phone');
        return redirect()->to('myClothWashingOrder')->with('successMessage', 'সফল্ভাবে অর্ডার সম্পন্ন্য হয়েছে। '.$name.' আপনার অর্ডার এর দায়িত্বে আছে। প্রয়োজনে '.$phone.' কল করুন।'  );
    }
    public function getClothPriceByIdFront(Request $request){
        $rows = DB::table('cloth_washing')
            ->where('id', $request->id)
            ->first();
        return response()->json(array('data'=>$rows));
    }
    public function cleaningPage(){
        return view('frontend.cleaningPage');
    }
    public function getAllCleaningTypeFront(Request $request){
        $rows = DB::table('room_cleaning')
            ->distinct()
            ->get('type');
        return response()->json(array('data'=>$rows));
    }
    public function getCleaningSizeFront(Request $request){
        $rows = DB::table('room_cleaning')
            ->where('type', $request->type)
            ->get();
        return response()->json(array('data'=>$rows));
    }
    public function getCleaningPriceFront(Request $request){
        $rows = DB::table('room_cleaning')
            ->where('type', $request->type)
            ->where('size', $request->size)
            ->first();
        return response()->json(array('data'=>$rows));
    }
    public function cleaningBookingFront(Request $request){
        try{
            if($request) {
                $rows = DB::table('room_cleaning')
                    ->where('type', $request->type)
                    ->where('size', $request->size)
                    ->first();
                //common
                $user_info = DB::table('users')
                    ->select('*')
                    ->where('id', Cookie::get('user_id'))
                    ->first();
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
                if($request->type =='ট্যাংক')
                    $user_type = 24;
                else
                    $user_type = 23;
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
                    ->first();
                if(!empty($delivery_man)){

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
                        ->first();
                    if(!empty($delivery_man)){

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
                            ->first();
                        if(!empty($delivery_man)){

                        }
                    }
                }
                if(!empty($delivery_man)){
                    Session::put('d_name', $delivery_man->name);
                    Session::put('d_phone', $delivery_man->phone);
                    $shurjopay_service = new ShurjopayService();
                    $tx_id = $shurjopay_service->generateTxId();
                    $result =DB::table('users')
                        ->where('id', $delivery_man->id)
                        ->update([
                            'working_status' => 2,
                        ]);
                    $result = DB::table('cleaning_order')->insert([
                        'user_id' => Cookie::get('user_id'),
                        'tx_id' =>  $tx_id,
                        'cleaner_id' => $delivery_man->id,
                        'type' => $request->type,
                        'size' => $request->size,
                        'price' => $rows->price,
                        'date' => date("Y-m-d"),
                    ]);
                    $success_route = url('insertRoomCleaningPaymentInfo');
                    $shurjopay_service->sendPayment($rows->price, $success_route);

                }
                else{
                    return redirect()->to('cleaningPage')->with('errorMessage', 'আপনার এলাকাই কোন  পরিস্কারক খুজে পাওয়া যায়নি।');
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
    public function insertRoomCleaningPaymentInfo(Request $request){
        $name = Session::get('d_name');
        $phone =Session::get('d_phone');
        $status = $request->status;
        $type = 'Room/Washroom/Tank Cleaning';
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
        session()->forget('d_name');
        session()->forget('d_phone');
        return redirect()->to('myRoomCleaningOrder')->with('successMessage', 'সফল্ভাবে অর্ডার সম্পন্ন্য হয়েছে। '.$name.' আপনার অর্ডার এর দায়িত্বে আছে। প্রয়োজনে '.$phone.' কল করুন।'  );
    }
    public function getAllHelpingHandTypeFront(Request $request){
        $rows = DB::table('child_caring')
            ->distinct()
            ->get('type');
        return response()->json(array('data'=>$rows));
    }
    public function helpingHandPage(){
        return view('frontend.helpingHandPage');
    }
    public function getHelpingTimeFront(Request $request){
        $rows = DB::table('child_caring')
            ->where('type', $request->type)
            ->get();
        return response()->json(array('data'=>$rows));
    }
    public function getHelpingPriceFront(Request $request){
        $rows = DB::table('child_caring')
            ->where('type', $request->type)
            ->where('time', $request->time)
            ->first();
        return response()->json(array('data'=>$rows));
    }
    public function helpingHandBookingFront(Request $request){
        try{
            if($request) {
                $rows = DB::table('child_caring')
                    ->where('type', $request->type)
                    ->where('time', $request->time)
                    ->first();
                if($request->days) {
                    $price = $request->days * $rows->price;
                    $days = $request->days;
                }
                else {
                    $price = $rows->price;
                    $days =30;
                }
                //common
                $user_info = DB::table('users')
                    ->select('*')
                    ->where('id', Cookie::get('user_id'))
                    ->first();
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
                $user_type = 25;
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
                    ->first();
                if(!empty($delivery_man)){

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
                        ->first();
                    if(!empty($delivery_man)){

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
                            ->first();
                        if(!empty($delivery_man)){
                        }
                    }
                }
                if(!empty($delivery_man)){
                    Session::put('d_name', $delivery_man->name);
                    Session::put('d_phone', $delivery_man->phone);
                    $shurjopay_service = new ShurjopayService();
                    $tx_id = $shurjopay_service->generateTxId();
                    $result =DB::table('users')
                        ->where('id', $delivery_man->id)
                        ->update([
                            'working_status' => 2,
                        ]);
                    $result = DB::table('helping_hand_order')->insert([
                        'user_id' => Cookie::get('user_id'),
                        'helper' => $delivery_man->id,
                        'tx_id' => $tx_id,
                        'days' => $days,
                        'type' => $request->type,
                        'time' => $request->time,
                        'price' => $price,
                        'date' => date("Y-m-d"),
                    ]);
                    $success_route = url('insertHelpingHandPaymentInfo');
                    $shurjopay_service->sendPayment($price, $success_route);
                }
                else{
                    return redirect()->to('helpingHandPage')->with('errorMessage', 'আপনার এলাকাই কোন হেল্পার খুজে পাওয়া যায়নি।');
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
    public function insertHelpingHandPaymentInfo(Request $request){
        $name = Session::get('d_name');
        $phone =Session::get('d_phone');
        $status = $request->status;
        $type = 'Helping Hand';
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
        session()->forget('d_name');
        session()->forget('d_phone');
        return redirect()->to('myHelpingHandOrder')->with('successMessage', 'সফল্ভাবে অর্ডার সম্পন্ন্য হয়েছে। '.$name.' আপনার অর্ডার এর দায়িত্বে আছে। প্রয়োজনে '.$phone.' কল করুন।'  );
    }
    public function guardPage(){
        return view('frontend.guardPage');
    }
    public function getAllGuardTypeFront(Request $request){
        $rows = DB::table('guard_setting')
            ->distinct()
            ->get('type');
        return response()->json(array('data'=>$rows));
    }
    public function getGuardTimeFront(Request $request){
        $rows = DB::table('guard_setting')
            ->where('type', $request->type)
            ->get();
        return response()->json(array('data'=>$rows));
    }
    public function getGuardPriceFront(Request $request){
        $rows = DB::table('guard_setting')
            ->where('type', $request->type)
            ->where('time', $request->time)
            ->first();
        return response()->json(array('data'=>$rows));
    }
    public function guardBookingFront(Request $request){
        try{
            if($request) {
                $rows = DB::table('guard_setting')
                    ->where('type', $request->type)
                    ->where('time', $request->time)
                    ->first();
                if($request->days) {
                    $price = $request->days * $rows->price;
                    $days = $request->days;
                }
                else {
                    $price = $rows->price;
                    $days =30;
                }
                //common
                $user_info = DB::table('users')
                    ->select('*')
                    ->where('id', Cookie::get('user_id'))
                    ->first();
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
                $user_type = 26;
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
                    ->first();
                if(!empty($delivery_man)){

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
                        ->first();
                    if(!empty($delivery_man)){

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
                            ->first();
                        if(!empty($delivery_man)){

                        }
                    }
                }
                if(!empty($delivery_man)){
                    Session::put('d_name', $delivery_man->name);
                    Session::put('d_phone', $delivery_man->phone);
                    $shurjopay_service = new ShurjopayService();
                    $tx_id = $shurjopay_service->generateTxId();
                    $result =DB::table('users')
                        ->where('id', $delivery_man->id)
                        ->update([
                            'working_status' => 2,
                        ]);
                    $result = DB::table('guard_order')->insert([
                        'user_id' => Cookie::get('user_id'),
                        'gurd_id' => $delivery_man->id,
                        'days' => $days,
                        'tx_id' => $tx_id,
                        'type' => $request->type,
                        'time' => $request->time,
                        'price' => $price,
                        'date' => date("Y-m-d"),
                    ]);
                    $success_route = url('insertGuardPaymentInfo');
                    $shurjopay_service->sendPayment($price, $success_route);
                }
                else{
                    return redirect()->to('guardPage')->with('errorMessage', 'আপনার এলাকাই কোন গার্ড খুজে পাওয়া যায়নি।');
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
    public function insertGuardPaymentInfo(Request $request){
        $name = Session::get('d_name');
        $phone =Session::get('d_phone');
        $status = $request->status;
        $type = 'Guard';
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
        session()->forget('d_name');
        session()->forget('d_phone');
        return redirect()->to('myGuardOrder')->with('successMessage', 'সফল্ভাবে অর্ডার সম্পন্ন্য হয়েছে। '.$name.' আপনার অর্ডার এর দায়িত্বে আছে। প্রয়োজনে '.$phone.' কল করুন।'  );
    }
    public function productServicingPage(){
        return view('frontend.productServicingPage');
    }
    public function getAllProductServiceTypeFront(Request $request){
        $rows = DB::table('various_servicing')
            ->get();
        return response()->json(array('data'=>$rows));
    }
    public function getProductServiceNameTimeFront(Request $request){
        $rows = DB::table('various_servicing')
            ->where('type', $request->type)
            ->get();
        return response()->json(array('data'=>$rows));
    }
    public function getProductServicePriceFront(Request $request){
        $rows = DB::table('various_servicing')
            ->where('type', $request->type)
            ->where('name', $request->name)
            ->first();
        return response()->json(array('data'=>$rows));
    }
    public function productServicingBookingFront(Request $request){
        try{
            if($request) {
                $rows = DB::table('various_servicing')
                    ->where('type', $request->type)
                    ->where('name', $request->name)
                    ->first();
                //common
                $user_info = DB::table('users')
                    ->select('*')
                    ->where('id', Cookie::get('user_id'))
                    ->first();
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
                if($request->type == 'স্টোভ')
                    $user_type = 27;
                if($request->type == 'ইলেক্ট্রনিক্স')
                    $user_type = 28;
                if($request->type == 'স্যানিটারি')
                    $user_type = 29;
                if($request->type == 'এসি')
                    $user_type = 30;
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
                    ->first();
                if(!empty($delivery_man)){

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
                        ->first();
                    if(!empty($delivery_man)){

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
                            ->first();
                        if(!empty($delivery_man)){

                        }
                    }
                }
                if(!empty($delivery_man)){
                    Session::put('d_name', $delivery_man->name);
                    Session::put('d_phone', $delivery_man->phone);
                    $shurjopay_service = new ShurjopayService();
                    $tx_id = $shurjopay_service->generateTxId();
                    $result =DB::table('users')
                        ->where('id', $delivery_man->id)
                        ->update([
                            'working_status' => 2,
                        ]);
                    $result = DB::table('various_servicing_order')->insert([
                        'user_id' => Cookie::get('user_id'),
                        'worker' => $delivery_man->id,
                        'tx_id' => $tx_id,
                        'type' => $request->type,
                        'name' => $request->name,
                        'price' => $rows->price,
                        'date' => date("Y-m-d"),
                    ]);
                    $success_route = url('insertProductServicingPaymentInfo');
                    $shurjopay_service->sendPayment($rows->price, $success_route);
                }
                else{
                    return redirect()->to('productServicingPage')->with('errorMessage', 'আপনার এলাকাই কোন কাজের লোক খুজে পাওয়া যায়নি।');
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
    public function insertProductServicingPaymentInfo(Request $request){
        $name = Session::get('d_name');
        $phone =Session::get('d_phone');
        $status = $request->status;
        $type = 'Various Servicing';
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
        session()->forget('d_name');
        session()->forget('d_phone');
        return redirect()->to('myProductServicingOrder')->with('successMessage', 'সফল্ভাবে অর্ডার সম্পন্ন্য হয়েছে। '.$name.' আপনার অর্ডার এর দায়িত্বে আছে। প্রয়োজনে '.$phone.' কল করুন।'  );
    }
    public function parlorServicingPage(){
        return view('frontend.parlorServicingPage');
    }
    public function getAllParlorTypeFront(Request $request){
        $rows = DB::table('parlor_service')
            ->where('address_type', $request->main)
            ->where('add_part1', $request->a1)
            ->where('add_part2', $request->a2)
            ->where('add_part3', $request->a3)
            ->where('add_part4', $request->a4)
            ->where('add_part5', $request->a5)
            ->distinct()
            ->get('p_type');
        return response()->json(array('data'=>$rows));
    }
    public function getParlorServiceNameFront(Request $request){
        $rows = DB::table('parlor_service')
            ->where('p_type', $request->type)
            ->get();
        return response()->json(array('data'=>$rows));
    }
    public function getGenderServiceNameFront(Request $request){
        $rows = DB::table('parlor_service')
            ->where('address_type', $request->main)
            ->where('add_part1', $request->a1)
            ->where('add_part2', $request->a2)
            ->where('add_part3', $request->a3)
            ->where('add_part4', $request->a4)
            ->where('add_part5', $request->a5)
            ->where('p_type', $request->type)
            ->distinct()
            ->get('gender_type');
        return response()->json(array('data'=>$rows));
    }
    public function getParlorServicePriceFront(Request $request){
        $rows = DB::table('parlor_service')
            ->where('address_type', $request->main)
            ->where('add_part1', $request->a1)
            ->where('add_part2', $request->a2)
            ->where('add_part3', $request->a3)
            ->where('add_part4', $request->a4)
            ->where('add_part5', $request->a5)
            ->where('p_type', $request->type)
            ->where('service', $request->service)
            ->where('gender_type', $request->gender)
            ->first();
        return response()->json(array('data'=>$rows));
    }
    public function parlorServiceBookingFront(Request $request){
        try{
            if($request) {
                $re_Arr = array();
                $add_part1 = $request->div_id;
                $addressGroup = $request->addressGroup;
                $g_type = $request->gender;
                $type = $request->type;
                $name = $request->service;
                $date = $request->pickup_date;
                $time = $request->time;
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
                $rows = DB::table('parlor_service')
                    ->select('*')
                    ->where('address_type', $addressGroup)
                    ->where('add_part1', $add_part1)
                    ->where('add_part2', $add_part2)
                    ->where('add_part3', $add_part3)
                    ->where('add_part4', $add_part4)
                    ->where('add_part5', $add_part5)
                    ->where('gender_type', $g_type)
                    ->where('p_type', $type)
                    ->where('service', $name)
                    ->first();
                $re_Arr[0] = $add_part1;
                $re_Arr[1] = $add_part2;
                $re_Arr[2] = $add_part3;
                $re_Arr[3] = $add_part4;
                $re_Arr[4] = $add_part5;
                $re_Arr[5] = $addressGroup;
                $re_Arr[6] = $g_type;
                $re_Arr[7] = $type;
                $re_Arr[8] = $date;
                $re_Arr[9] = $time;
                $re_Arr[10] = $name;
                $re_Arr[11] = $rows->price;
                $working_status = 1;
                if($addressGroup == 1) {
                    $ward_info = DB::table('wards')
                        ->select('*')
                        ->where('div_id', $add_part1)
                        ->where('dis_id', $add_part2)
                        ->where('upz_id', $add_part3)
                        ->where('uni_id', $add_part4)
                        ->where('id', $add_part5)
                        ->first();
                    $ward_plus = $ward_info->position + 1;
                    $ward_minus = $ward_info->position - 1;
                    $ward_plus_id_info = DB::table('wards')
                        ->select('*')
                        ->where('div_id', $add_part1)
                        ->where('dis_id', $add_part2)
                        ->where('upz_id', $add_part3)
                        ->where('uni_id', $add_part4)
                        ->where('position', $ward_plus)
                        ->first();
                    $ward_plus_id = $ward_plus_id_info->id;
                    if($ward_info->position == 1) $ward_minus_id = $ward_info->position;
                    else{
                        $ward_minus_id_info = DB::table('wards')
                            ->select('*')
                            ->where('div_id', $add_part1)
                            ->where('dis_id', $add_part2)
                            ->where('upz_id', $add_part3)
                            ->where('uni_id', $add_part4)
                            ->where('position', $ward_minus)
                            ->first();
                        $ward_minus_id = $ward_minus_id_info->id;
                    }
                }
                if($addressGroup == 2) {
                    $c_ward_info = DB::table('c_wards')
                        ->select('*')
                        ->where('div_id', $add_part1)
                        ->where('city_id', $add_part2)
                        ->where('city_co_id', $add_part3)
                        ->where('thana_id', $add_part4)
                        ->where('id', $add_part5)
                        ->first();
                    $ward_plus = $c_ward_info->position + 1;
                    $ward_minus = $c_ward_info->position - 1;
                    $c_ward_plus_id_info = DB::table('c_wards')
                        ->select('*')
                        ->where('div_id', $add_part1)
                        ->where('city_id', $add_part2)
                        ->where('city_co_id', $add_part3)
                        ->where('thana_id', $add_part4)
                        ->where('position', $ward_plus)
                        ->first();
                    $ward_plus_id = $c_ward_plus_id_info->id;
                    if($c_ward_info->position == 1) $ward_minus_id = $c_ward_info->position;
                    else{
                        $c_ward_minus_id_info = DB::table('wards')
                            ->select('*')
                            ->where('div_id', $add_part1)
                            ->where('dis_id', $add_part2)
                            ->where('upz_id', $add_part3)
                            ->where('uni_id', $add_part4)
                            ->where('position', $ward_minus)
                            ->first();
                        $ward_minus_id = $c_ward_minus_id_info->id;
                    }
                }
                if($g_type == 'লেডিস')
                    $user_type = 31;
                if($g_type == 'জেন্টস')
                    $user_type = 35;
                $delivery_man = DB::table('users')
                    ->where('user_type',  $user_type)
                    ->where('add_part1',  $add_part1)
                    ->where('add_part2',  $add_part2)
                    ->where('add_part3',  $add_part3)
                    ->where('add_part4',  $add_part4)
                    ->where('add_part5',  $add_part5)
                    ->where('working_status',  $working_status)
                    ->where('address_type',  $addressGroup)
                    ->where('status',  1)
                    ->first();
                if(!empty($delivery_man)){

                }
                else{
                    $delivery_man = DB::table('users')
                        ->where('user_type',  $user_type)
                        ->where('add_part1',  $add_part1)
                        ->where('add_part2',  $add_part2)
                        ->where('add_part3',  $add_part3)
                        ->where('add_part4',  $add_part4)
                        ->where('add_part5',  $ward_plus_id)
                        ->where('working_status',  $working_status)
                        ->where('address_type',  $addressGroup)
                        ->where('status',  1)
                        ->first();
                    if(!empty($delivery_man)){

                    }
                    else{
                        $delivery_man = DB::table('users')
                            ->where('user_type',  $user_type)
                            ->where('add_part1',  $add_part1)
                            ->where('add_part2',  $add_part2)
                            ->where('add_part3',  $add_part3)
                            ->where('add_part4',  $add_part4)
                            ->where('add_part5',  $ward_minus_id)
                            ->where('working_status',  $working_status)
                            ->where('address_type',  $addressGroup)
                            ->where('status',  1)
                            ->first();
                        if(!empty($delivery_man)){

                        }
                    }
                }
                if(!empty($delivery_man)){
                    Session::put('d_name', $delivery_man->name);
                    Session::put('d_phone', $delivery_man->phone);
                    Session::put('d_id', $delivery_man->id);
                    Session::put('d_array', $re_Arr);
                    $shurjopay_service = new ShurjopayService();
                    $tx_id = $shurjopay_service->generateTxId();
                    $success_route = url('insertParlorPaymentInfo');
                    $shurjopay_service->sendPayment($rows->price, $success_route);
                }
                else{
                    return redirect()->to('parlorServicingPage')->with('errorMessage', 'আপনার এলাকাই কোন পার্লার খুজে পাওয়া যায়নি।');
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
    public function insertParlorPaymentInfo(Request $request){
        $name = Session::get('d_name');
        $phone =Session::get('d_phone');
        $delivery_man =Session::get('d_id');
        $re_Arr = Session::get('d_array');
        $status = $request->status;
        $type = 'Parlour';
        $msg = $request->msg;
        $tx_id = $request->tx_id;
        $bank_tx_id = $request->bank_tx_id;
        $amount = $request->amount;
        $bank_status = $request->bank_status;
        $sp_code = $request->sp_code;
        $sp_code_des = $request->sp_code_des;
        $sp_payment_option = $request->sp_payment_option;
        $date = date('Y-m-d');
        if($status == 'Failed'){
            return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
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
            $result = DB::table('parlor_order')->insert([
                'user_id' => Cookie::get('user_id'),
                'tx_id' => $tx_id,
                'parlor_id' => $delivery_man,
                'add_part1' => $re_Arr[0],
                'add_part2' => $re_Arr[1],
                'add_part3' => $re_Arr[2],
                'add_part4' => $re_Arr[3],
                'add_part5' => $re_Arr[4],
                'address_type' => $re_Arr[5],
                'g_type' => $re_Arr[6],
                'type' => $re_Arr[7],
                'date' => $re_Arr[8],
                'time' => $re_Arr[9],
                'name' => $re_Arr[10],
                'price' => $re_Arr[11],
                'order_date' => date("Y-m-d"),
            ]);
            session()->forget('d_name');
            session()->forget('d_phone');
            session()->forget('d_id');
            session()->forget('d_array');
            Session::save();
            return redirect()->to('myParlorOrder')->with('successMessage', 'সফল্ভাবে অর্ডার সম্পন্ন্য হয়েছে। '.$name.' আপনার অর্ডার এর দায়িত্বে আছে। প্রয়োজনে '.$phone.' কল করুন।'  );

        }
    }
    public function laundryServicePage(){
        $rows = DB::table('laundry')
            ->get();
        return view('frontend.laundryServicePage', ['cloths' => $rows]);
    }
    public function getLaundryPriceByIdFront(Request $request){
        $rows = DB::table('laundry')
            ->where('id', $request->id)
            ->first();
        return response()->json(array('data'=>$rows));
    }
    public function laundryBookingFront(Request $request){
        try{
            if($request) {
                if(!empty($request->cloth_id)){
                    $quantity = array_filter($request->quantity, function($value) { return !is_null($value) && $value !== ''; });
                    $cloth_id = array_filter($request->cloth_id, function($value) { return !is_null($value) && $value !== ''; });
                    if($request->cloth_idwa == null && $request->cloth_idis == null)
                        return back()->with('errorMessage', 'ফর্ম পুরন করুন।');
                    $cloth_idwa = array_filter($request->cloth_idwa, function($value) { return !is_null($value) && $value !== ''; });
                    $cloth_idis = array_filter($request->cloth_idis, function($value) { return !is_null($value) && $value !== ''; });
                    $pickup_date = $request->pickup_date;
                    $delivery_date = $request->delivery_date;
                    $i =0;
                    $j=0;
                    foreach ($quantity as $q){
                        $quantity_arr[$i] =$q;
                        $i++;
                    }
                    foreach ($cloth_id as $p){
                        $cloth_id_arr[$j] =$p;
                        $j++;
                    }
                    $j=0;
                    foreach ($cloth_idwa as $w){
                        $cloth_idwa_arr[$j] =$w;
                        $j++;
                    }
                    $j=0;
                    foreach ($cloth_idis as $s){
                        $cloth_idis_arr[$j] =$s;
                        $j++;
                    }
                    $price = 0;
                    for ($k=0; $k<count($cloth_id_arr); $k++){
                        $rows = DB::table('laundry')
                            ->where('id', $cloth_id_arr[$k])
                            ->first();
                        $is_price = 0;
                        $wa_price = 0;
                        if(in_array($cloth_id_arr[$k],$cloth_idwa_arr))
                            $wa_price = $rows->pricewa;
                        if(in_array($cloth_id_arr[$k],$cloth_idis_arr))
                            $is_price = $rows->priceis;

                        $q_price = ($is_price + $wa_price)*$quantity_arr[$k];
                        $price = ($price + $q_price) ;
                    }
                    //common
                    $user_info = DB::table('users')
                        ->select('*')
                        ->where('id', Cookie::get('user_id'))
                        ->first();
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
                    $user_type = 22;
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
                        ->first();
                    if(!empty($delivery_man)){

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
                            ->first();
                        if(!empty($delivery_man)){

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
                                ->first();
                            if(!empty($delivery_man)){

                            }
                        }
                    }
                    if(!empty($delivery_man)){
                        Session::put('d_id', $delivery_man->id);
                        Session::put('d_name', $delivery_man->name);
                        Session::put('d_phone', $delivery_man->phone);
                        Session::put('d_price', $price);
                        Session::put('cloth_id', $cloth_id);
                        Session::put('cloth_idwa', $cloth_idwa);
                        Session::put('cloth_idis', $cloth_idis);
                        Session::put('quantity', $quantity);
                        Session::put('pickup_date', $pickup_date);
                        Session::put('delivery_date', $delivery_date);
                        $shurjopay_service = new ShurjopayService();
                        $tx_id = $shurjopay_service->generateTxId();
                        $success_route = url('insertLaundryPaymentInfo');
                        $shurjopay_service->sendPayment($price, $success_route);
                    }
                    else{
                        return redirect()->to('laundryServicePage')->with('errorMessage', 'আপনার এলাকাই কোন কাপড় পরিস্কারক খুজে পাওয়া যায়নি।');
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
    public function insertLaundryPaymentInfo(Request $request){
        $name = Session::get('d_name');
        $phone = Session::get('d_phone');
        $d_id = Session::get('d_id');
        $d_price = Session::get('d_price');
        $cloth_id = Session::get('cloth_id');
        $cloth_idwa = Session::get('cloth_idwa');
        $cloth_idis = Session::get('cloth_idis');
        $quantity = Session::get('quantity');
        $pickup_date = Session::get('pickup_date');
        $delivery_date = Session::get('delivery_date');

        $status = $request->status;
        $type = 'Laundry';
        $msg = $request->msg;
        $tx_id = $request->tx_id;
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
        else {
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
            $result = DB::table('laundry_order')->insert([
                'user_id' => Cookie::get('user_id'),
                'cleaner_id' => $d_id,
                'tx_id' => $tx_id,
                'date' => date("Y-m-d"),
                'cloth_id' => json_encode($cloth_id),
                'quantity' => json_encode($quantity),
                'price' => $d_price,
                'wa_id' => json_encode($cloth_idwa),
                'is_id' => json_encode($cloth_idis),
                'pickup_date' => $pickup_date,
                'delivery_date' => $delivery_date,
            ]);
            session()->forget('d_name');
            session()->forget('d_phone');
            session()->forget('d-id');
            session()->forget('d_price');
            session()->forget('cloth_id');
            session()->forget('cloth_idwa');
            session()->forget('cloth_idis');
            session()->forget('quantity');
            session()->forget('pickup_date');
            session()->forget('delivery_date');
            Session::save();
            return redirect()->to('myLaundryOrder')->with('successMessage', 'সফল্ভাবে অর্ডার সম্পন্ন্য হয়েছে। ' . $name . ' আপনার অর্ডার এর দায়িত্বে আছে। প্রয়োজনে ' . $phone . ' কল করুন।');
        }
    }
    public function serviceAreaParlor(){
        if(Cookie::get('user_id'))
            return view('frontend.serviceAreaParlor');
        else
            return redirect('login');
    }
    public function insertServiceAreaParlor(Request $request){
        $addressGroup = $request->addressGroup;
        if ($addressGroup == 1) {
            $add_part1 = $request->div_id;
            $add_part2 = $request->disid;
            $add_part3 = $request->upzid;
            $add_part4 = $request->uniid;
            $add_part5 = $request->wardid;
        }
        if ($addressGroup == 2) {
            $add_part1 = $request->div_id;
            $add_part2 = $request->c_disid;
            $add_part3 = $request->c_upzid;
            $add_part4 = $request->c_uniid;
            $add_part5 = $request->c_wardid;
        }
        if ($addressGroup == 3) {
            $add_part1 = $request->naming1;
            $add_part2 = $request->naming2;
            $add_part3 = $request->naming3;
            $add_part4 = $request->naming4;
            $add_part5 = "";
        }
        $rows = DB::table('service_area')
            ->where('user_id', Cookie::get('user_id'))
            ->distinct()->get()->count();
        if ($rows > 0) {
            $result = DB::table('service_area')
                ->where('user_id', Cookie::get('user_id'))
                ->update([
                    'address_type' => $addressGroup,
                    'add_part1' => $add_part1,
                    'add_part2' => $add_part2,
                    'add_part3' => $add_part3,
                    'add_part4' => $add_part4,
                    'add_part5' => $add_part5,
                ]);
            if ($result) {
                return redirect('parlorServicingPage')->with('successMessage', 'সফলভাবে  সম্পন্ন  হয়েছে।');
            } else {
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }
        }
        else{
            $result = DB::table('service_area')->insert([
                'user_id' => Cookie::get('user_id'),
                'address_type' => $addressGroup,
                'add_part1' => $add_part1,
                'add_part2' => $add_part2,
                'add_part3' => $add_part3,
                'add_part4' => $add_part4,
                'add_part5' => $add_part5,
            ]);
            if ($result) {
                return redirect('parlorServicingPage')->with('successMessage', 'সফলভাবে  সম্পন্ন  হয়েছে।');
            } else {
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }
        }
    }
}
