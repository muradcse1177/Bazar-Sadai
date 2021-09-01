<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SellerController extends Controller
{
    public function sellerForm(){
        $rows = DB::table('seller_product')
            ->where('status', 'Active')
            ->where('amount','>', '0')
            ->where('seller_id', Cookie::get('user_id'))
            ->orderBy('id', 'desc')
            ->paginate(20);
        return view('backend.sellerForm',['products' => $rows]);
    }
    public function insertSellerProduct(Request $request){
        try{
            if($request) {
                if(Cookie::get('user_id')) {
                    if($request->id) {
                        $PhotoPath ='';
                        if(empty($request->deleteCheck)){
                            $row =DB::table('seller_product')
                                ->where('id', $request->id)
                                ->first();
                            if ($request->hasFile('photo')) {
                                $files = $request->file('photo');

                                foreach ($files as $file) {
                                    $targetFolder = 'public/asset/images/';
                                    $pname = time() . '.' . $file->getClientOriginalName();
                                    $image['filePath'] = $pname;
                                    $file->move($targetFolder, $pname);
                                    $PhotoPath .= $targetFolder . $pname.',';
                                }
                            }
                            $PhotoPath .= json_decode($row->photo);
                        }
                        else{
                            if ($request->hasFile('photo')) {
                                $files = $request->file('photo');

                                foreach ($files as $file) {
                                    $targetFolder = 'public/asset/images/';
                                    $pname = time() . '.' . $file->getClientOriginalName();
                                    $image['filePath'] = $pname;
                                    $file->move($targetFolder, $pname);
                                    $PhotoPath .= $targetFolder . $pname.',';
                                }
                            }
                        }
                        $video = '';
                        if ($request->hasFile('video')) {
                            $targetFolder = 'public/asset/images/';
                            $file = $request->file('video');
                            $pname = time() . '.' . $file->getClientOriginalName();
                            $image['filePath'] = $pname;
                            $file->move($targetFolder, $pname);
                            $video = $targetFolder . $pname;
                        }
                        $address = $request->address1.','.$request->address2.','.$request->address3;
                        $result =DB::table('seller_product')
                            ->where('id', $request->id)
                            ->update([
                                'type' => $request->type,
                                'name' => $request->name,
                                'amount' => $request->amount,
                                'price' => $request->price,
                                'address' => $address,
                                'photo' => json_encode($PhotoPath),
                                'video' => $video,
                                'w_phone' => $request->w_phone,
                                'description' => $request->description,
                                'status' => $request->status,
                            ]);
                        if ($result) {
                            return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                        } else {
                            return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                        }
                    }
                    else{
                        $PhotoPath ='';
                        if ($request->hasFile('photo')) {
                            $files = $request->file('photo');

                            foreach ($files as $file) {
                                $targetFolder = 'public/asset/images/';
                                $pname = time() . '.' . $file->getClientOriginalName();
                                $image['filePath'] = $pname;
                                $file->move($targetFolder, $pname);
                                $PhotoPath .= $targetFolder . $pname.',';
                            }
                        };
                        $video = '';
                        if ($request->hasFile('video')) {
                            $size = $request->file('video')->getSize();
                            $mb = number_format($size / 1048576, 11);
                            if($mb>11){
                                return back()->with('errorMessage', '10MB এর কম ফাইল আপলোড করুন।');
                            }
                            else{
                                $targetFolder = 'public/asset/images/';
                                $file = $request->file('video');
                                $pname = time() . '.' . $file->getClientOriginalName();
                                $image['filePath'] = $pname;
                                $file->move($targetFolder, $pname);
                                $video = $targetFolder . $pname;
                            }
                        }
                        $address = $request->address1.','.$request->address2.','.$request->address3;
                        $result = DB::table('seller_product')->insert([
                            'seller_id' => Cookie::get('user_id'),
                            'type' => $request->type,
                            'name' => $request->name,
                            'amount' => $request->amount,
                            'price' => $request->price,
                            'address' => $address,
                            'photo' => json_encode($PhotoPath),
                            'video' => $video,
                            'w_phone' => $request->w_phone,
                            'description' => $request->description,
                            'status' => $request->status,
                        ]);
                        if ($result) {
                            return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                        } else {
                            return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                        }
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
    public function getSellerProductsById(Request $request){
        try{
            $rows = DB::table('seller_product')
                ->where('id', $request->id)
                ->where('seller_id', Cookie::get('user_id'))
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getSellerProductsByIdAdmin(Request $request){
        try{
            $rows = DB::table('seller_product')
                ->where('id', $request->id)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteSellerProduct(Request $request){
        try{
            if($request->id) {
                $result =DB::table('seller_product')
                    ->where('id', $request->id)
                    ->where('seller_id', Cookie::get('user_id'))
                    ->update([
                        'status' =>  0,
                    ]);
                if ($result) {
                    return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                } else {
                    return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                }
            }
            else{
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }

        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function changeSellerProductSituation(Request $request){
        try{
            if($request->id) {
                $id = explode('&',$request->id);
                $result =DB::table('seller_product')
                    ->where('id', $id[1])
                    ->update([
                        'Situation' =>  $id[0],
                    ]);
                if ($result) {
                    Session::flash('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    return response()->json(array('data'=>$result));
                } else {
                    Session::flash('errorMessage', 'আবার চেষ্টা করুন।');
                    return response()->json(array('data'=>$result));
                }
            }
            else{
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }

        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function deleteSellerUploadProduct(Request $request){
        try{
            if($request->id) {
                $result =DB::table('seller_product')
                    ->where('id', $request->id)
                    ->delete();
                if ($result) {
                    return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                } else {
                    return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                }
            }
            else{
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }

        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function mySaleProduct(){
        try{
            $products = DB::table('product_sales')
                ->join('seller_product as a','product_sales.product_id','=','a.id')
                ->where('product_sales.seller_id', Cookie::get('user_id'))
                ->paginate(20);
            //dd($products);
            return view('backend.mySaleProduct',['products' => $products]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function myShop(){
        try{
            $products = DB::table('seller_shop')->paginate(20);
            return view('backend.myShop',['products' => $products]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function insertSellerShop(Request $request){
        try{
            if($request) {
                if(Cookie::get('user_id')) {
                    if($request->id) {
                        $result =DB::table('seller_shop')
                            ->where('id', $request->id)
                            ->update([
                                'name' => $request->name,
                                'address' => $request->address,
                            ]);
                        if ($result) {
                            return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                        } else {
                            return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                        }
                    }
                    else{
                        $count =DB::table('seller_shop')
                            ->where('seller_id', Cookie::get('user_id'))->get()->count();
                        if($count>0){
                            return back()->with('errorMessage', 'আপনার দোকান রয়েছে। আপনি নতুন দোনাল খুলতে পারবেন না।');
                        }
                        else{
                            $result = DB::table('seller_shop')->insert([
                                'seller_id' => Cookie::get('user_id'),
                                'name' => $request->name,
                                'address' => $request->address,
                            ]);
                            if ($result) {
                                return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                            } else {
                                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                            }
                        }
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
    public function getSellerShopsById(Request $request){
        try{
            $rows = DB::table('seller_shop')
                ->where('id', $request->id)
                ->where('seller_id', Cookie::get('user_id'))
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function importProduct(){
        try{
            $products = DB::table('product_sales')
                ->join('seller_product as a','product_sales.product_id','=','a.id')
                ->where('product_sales.seller_id', Cookie::get('user_id'))
                ->paginate(20);
            //dd($products);
            return view('backend.importProduct',['products' => $products]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getAllProductCategory(Request $request){
        try{
            $rows = DB::table('categories')
                ->where('type', 1)
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function selectProductByCategory(Request $request){
        try{
            $rows = DB::table('products')
                ->where('cat_id', $request->id)
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function importSellerProduct(Request $request){
        try{
            if($request->med_id){
                $medicine_id = array_filter($request->med_id, function($value) { return !is_null($value) && $value !== ''; });
            }
            else{
                return back()->with('errorMessage', 'আপনি কোন মেডিসিন সিলেক্ট করেন নি।');
            }
            $quantity = array_filter($request->quantity, function($value) { return !is_null($value) && $value !== ''; });
            if(empty($quantity)){
                return back()->with('errorMessage', 'আপনি কোন পরিমান দেন নি।');
            }
            $i =0;
            foreach ($quantity as $q){
                $quantity_arr[$i] =$q;
                $i++;
            }
            foreach ($medicine_id as $med){
                $product= DB::table('products')->where('id', $med)->first();
                dd($product);
            }
            $result = DB::table('medicine_order')->insert([
                'user_id' => Cookie::get('user_id'),
                'med_id' => json_encode($medicine_id),
                'quantity' => json_encode($quantity),
                'price' =>  json_encode($price_arr),
                'date' => date("Y-m-d"),
                'company' => $request->company,
                'email' => $request->email,
            ]);
            if ($result) {
                return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
            } else {
                return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
            }

        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
}