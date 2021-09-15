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
        $rows = DB::table('products')
            ->where('upload_by', Cookie::get('user_id'))
            ->orderBy('id', 'desc')
            ->paginate(20);
        return view('backend.sellerForm',['products' => $rows]);
    }
    public function insertSellerProduct(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $photo = '';
                    $slider = '';
                    $row =DB::table('products')
                        ->where('id', $request->id)
                        ->first();
                    if ($request->hasFile('product_photo')) {
                        $targetFolder = 'public/asset/images/';
                        $file = $request->file('product_photo');
                        $pname = time(). '.' . $file->getClientOriginalName();
                        $image['filePath'] = $pname;
                        $file->move($targetFolder, $pname);
                        $photo = $targetFolder . $pname;
                    }
                    else{
                        $photo =  $row->photo;
                    }
                    if ($request->hasFile('slider')) {
                        $files = $request->file('slider');
                        foreach ($files as $file) {
                            $targetFolder = 'public/asset/images/';
                            $pname = time(). '.' . $file->getClientOriginalName();
                            $image['filePath'] = $pname;
                            $file->move($targetFolder, $pname);
                            $slider .= $targetFolder . $pname.',';
                        }
                        $slider = json_encode($slider);
                    }
                    else{
                        $slider =  $row->slider;
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
                    else{
                        $video =  $row->video;
                    }
                    $result =DB::table('products')
                        ->where('id', $request->id)
                        ->update([
                            'name' =>  $request->name,
                            'cat_id' => $request->catId,
                            'sub_cat_id' => $request->subcat_name,
                            'company' => $request->company,
                            'genre' => $request->genre,
                            'type' => $request->type,
                            'description' => $request->description,
                            'specification' => $request->specification,
                            'price' => $request->price,
                            'unit' => $request->unit,
                            'minqty' => $request->minqty,
                            'photo' => $photo,
                            'slider' => $slider,
                            'video' => $video,
                            'w_phone' => $request->w_phone,
                            'status' => $request->status,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $slider = '';
                    if ($request->hasFile('product_photo')) {
                        $targetFolder = 'public/asset/images/';
                        $file = $request->file('product_photo');
                        $pname = time() . '.' . $file->getClientOriginalName();
                        $image['filePath'] = $pname;
                        $file->move($targetFolder, $pname);
                        $photo = $targetFolder . $pname;
                    }
                    else{
                        $photo ="";
                    }
                    if ($request->hasFile('slider')) {
                        $files = $request->file('slider');

                        foreach ($files as $file) {
                            $targetFolder = 'public/asset/images/';
                            $pname = time() . '.' . $file->getClientOriginalName();
                            $image['filePath'] = $pname;
                            $file->move($targetFolder, $pname);
                            $slider .= $targetFolder . $pname.',';
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
                    $result = DB::table('products')->insert([
                        'upload_by' =>  Cookie::get('user_id'),
                        'name' =>  $request->name,
                        'cat_id' => $request->catId,
                        'sub_cat_id' => $request->subcat_name,
                        'company' => $request->company,
                        'genre' => $request->genre,
                        'type' => $request->type,
                        'description' => $request->description,
                        'specification' => $request->specification,
                        'price' => $request->price,
                        'unit' => $request->unit,
                        'minqty' => $request->minqty,
                        'photo' => $photo,
                        'video' => $video,
                        'slider' => json_encode($slider),
                        'w_phone' => $request->w_phone,
                        'status' => $request->status,
                    ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফল্ভাবে সম্পন্ন্য হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
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
    public function mySaleProduct(){
        try{
            $products = DB::table('details')
                ->join('v_assign','details.sales_id','=','v_assign.id')
                ->join('products','products.id','=','details.product_id')
                ->where('products.upload_by',Cookie::get('user_id'))
                ->paginate(20);
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
                        if ($request->hasFile('logo')) {
                            $targetFolder = 'public/asset/images/';
                            $file = $request->file('logo');
                            $pIname = time() . '.' . $file->getClientOriginalName();
                            $image['filePath'] = $pIname;
                            $file->move($targetFolder, $pIname);
                            $logo = $targetFolder . $pIname;
                        }
                        $result =DB::table('seller_shop')
                            ->where('id', $request->id)
                            ->update([
                                'name' => $request->name,
                                'address' => $request->address,
                                'logo' => $logo,
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
                            if ($request->hasFile('logo')) {
                                $targetFolder = 'public/asset/images/';
                                $file = $request->file('logo');
                                $pIname = time() . '.' . $file->getClientOriginalName();
                                $image['filePath'] = $pIname;
                                $file->move($targetFolder, $pIname);
                                $logo = $targetFolder . $pIname;
                            }

                            $result = DB::table('seller_shop')->insert([
                                'seller_id' => Cookie::get('user_id'),
                                'name' => $request->name,
                                'address' => $request->address,
                                'logo' => $logo,
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
            $data = array();
            $i = 0;
            foreach ($medicine_id as $med) {
                $rows = DB::table('products')
                    ->where('id', $med)
                    ->first();
                $data[$i]['upload_by'] = Cookie::get('user_id');
                $data[$i]['name'] =$rows->name;
                $data[$i]['cat_id'] =$rows->cat_id;
                $data[$i]['sub_cat_id'] =$rows->sub_cat_id;
                $data[$i]['company'] =$rows->company;
                $data[$i]['genre'] =$rows->genre;
                $data[$i]['type'] =$rows->type;
                $data[$i]['description'] =$rows->description;
                $data[$i]['price'] =$rows->price;
                $data[$i]['unit'] =$rows->unit;
                $data[$i]['minqty'] =$rows->minqty;
                $data[$i]['photo'] =$rows->photo;
                $data[$i]['video'] =$rows->video;
                $data[$i]['slider'] =$rows->slider;
                $data[$i]['w_phone'] =$rows->w_phone;
                $data[$i]['status'] =$rows->status;
                $data[$i]['approval'] =$rows->approval;
                $i++;
            }
            $result = DB::table('products')->insert($data);
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
