<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class DealerController extends Controller
{
    public function dealerProfile(){
        try{
            $rows = DB::table('products')
                ->select('*','product_assign.id as p_id')
                ->join('product_assign','product_assign.product_id','=','products.id')
                ->where('product_assign.dealer_id', Cookie::get('user_id'))
                ->where('products.status', 1)
                ->orderBy('products.id', 'ASC')
                ->Paginate(100);
            return view('backend.dealerProductManagement', ['products' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function changeProductPrice(Request $request){
        try{
            if(Cookie::get('user_id') !=null) {
                $user_id = Cookie::get('user_id');
                $result =DB::table('product_assign')
                    ->where('id',  $request->id)
                    ->update([
                        'edit_price' => $request->price
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
    public function getProductListDealer(Request $request){
        try{
            $user_id = Cookie::get('user_id');
            $rows = DB::table('product_assign')
                ->where('id',  $request->id)
                ->where('dealer_id',  $user_id)
                ->first();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function productSearchFromDealer(Request $request){
        try{
            if($request->proSearch == null){
                $rows = DB::table('products')
                    ->select('*','products.id as p_id')
                    ->join('product_assign','product_assign.product_id','=','products.id')
                    ->where('product_assign.dealer_id', Cookie::get('user_id'))
                    ->where('products.status', 1)
                    ->orderBy('products.id', 'ASC')
                    ->Paginate(100);
                return view('backend.dealerProductManagement', ['products' => $rows]);
            }
            else {
                $rows = DB::table('products')
                    ->select('*','products.id as p_id')
                    ->join('product_assign','product_assign.product_id','=','products.id')
                    ->where('product_assign.dealer_id', Cookie::get('user_id'))
                    ->where('name', 'LIKE','%'.$request->proSearch.'%')
                    ->where('products.status', 1)
                    ->orderBy('products.id', 'ASC')
                    ->Paginate(100);
                return view('backend.dealerProductManagement', ['products' => $rows , "key"=>$request->proSearch]);
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    function en2bn($number) {
        $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $bn_number = str_replace($search_array, $replace_array, $number);
        return $bn_number;
    }
    public function mySaleProductDealer (Request $request){
        try {
            $order_details = DB::table('order_details')->orderBy('id','desc')->get();
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
                if($order->user_id == 0){
                    $date = explode(' ',$order->created_at);
                    $orderArr[$i]['sales_date'] = $date[0];
                    $orderArr[$i]['name'] = $order->name;
                    $orderArr[$i]['phone'] = $order->phone;
                    $orderArr[$i]['address'] = $add_part1->name.' ,'.$add_part2->name.' ,'.$add_part3->name.' ,'.$add_part4->name.' ,'.$add_part5->name.' ,'.$order->address;
                    $orderArr[$i]['pay_id'] = $order->tx_id;
                    $orderArr[$i]['amount'] =  $order->total;
                    $orderArr[$i]['v_id'] = '';
                    $orderArr[$i]['v_name'] = 'Not Assigned';
                    $orderArr[$i]['v_phone'] = '';
                    $orderArr[$i]['user_id'] = 0;
                    $orderArr[$i]['status'] = @$order->status;
                    $orderArr[$i]['sales_id'] = $order->tx_id;
                }
                else {
                    $row = DB::table('v_assign')
                        ->where('pay_id', $order->tx_id)
                        ->where('dealer_id', Cookie::get('user_id'))
                        ->orderBy('sales_date', 'Desc')
                        ->first();
                    if ($row) {
                        $row1 = DB::table('users')
                            ->where('id', $row->v_id)
                            ->get();
                        $volunteer = DB::table('users')
                            ->where('id', $row->v_id)
                            ->first();
                        if ($row1->count() > 0) {
                            $name = $volunteer->name;
                            $v_phone = $volunteer->phone;
                            $v_id = $volunteer->id;
                        } else {
                            $name = "Not Assigned";
                            $v_id = " ";
                            $v_phone = " ";
                        }
                        $date = explode(' ',$order->created_at);
                        $orderArr[$i]['sales_date'] = $date[0];
                        $orderArr[$i]['name'] = $order->name;
                        $orderArr[$i]['phone'] = $order->phone;
                        $orderArr[$i]['address'] = $add_part1->name.' ,'.$add_part2->name.' ,'.$add_part3->name.' ,'.$add_part4->name.' ,'.$add_part5->name.' ,'.$order->address;
                        $orderArr[$i]['pay_id'] = $order->tx_id;
                        $orderArr[$i]['amount'] = $order->total;
                        $orderArr[$i]['v_id'] = $v_id;
                        $orderArr[$i]['v_name'] = $name;
                        $orderArr[$i]['v_phone'] = $v_phone;
                        $orderArr[$i]['user_id'] = $row->user_id;
                        $orderArr[$i]['status'] = $order->status;
                        $orderArr[$i]['sales_id'] = $order->tx_id;
                    }
                }
                $sum  += $orderArr[$i]['amount'];
                $i++;
            }
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $itemCollection = collect($orderArr);
            $perPage = 20;
            $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
            $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
            $paginatedItems->setPath($request->url());
            return view('backend.mySaleProductDealer', ['orders' => $paginatedItems,'sum' => $sum]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getDealerProductSalesOrderListByDate (Request $request){
        try{
            $order_details = DB::table('order_details') ->whereBetween('created_at',array($request->from_date,$request->to_date))->orderBy('id','desc')->get();
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
                if($order->user_id == 0){
                    $date = explode(' ',$order->created_at);
                    $orderArr[$i]['sales_date'] = $date[0];
                    $orderArr[$i]['name'] = $order->name;
                    $orderArr[$i]['phone'] = $order->phone;
                    $orderArr[$i]['address'] = $add_part1->name.' ,'.$add_part2->name.' ,'.$add_part3->name.' ,'.$add_part4->name.' ,'.$add_part5->name.' ,'.$order->address;
                    $orderArr[$i]['pay_id'] = $order->tx_id;
                    $orderArr[$i]['amount'] =  $order->total;
                    $orderArr[$i]['v_id'] = '';
                    $orderArr[$i]['v_name'] = 'Not Assigned';
                    $orderArr[$i]['v_phone'] = '';
                    $orderArr[$i]['user_id'] = 0;
                    $orderArr[$i]['status'] =$order->status;
                    $orderArr[$i]['sales_id'] = $order->tx_id;
                }
                else {
                    $row = DB::table('v_assign')
                        ->where('pay_id', $order->tx_id)
                        ->where('dealer_id', Cookie::get('user_id'))
                        ->orderBy('sales_date', 'Desc')
                        ->first();
                    if ($row) {
                        $row1 = DB::table('users')
                            ->where('id', $row->v_id)
                            ->get();
                        $volunteer = DB::table('users')
                            ->where('id', $row->v_id)
                            ->first();
                        if ($row1->count() > 0) {
                            $name = $volunteer->name;
                            $v_phone = $volunteer->phone;
                            $v_id = $volunteer->id;
                        } else {
                            $name = "Not Assigned";
                            $v_id = " ";
                            $v_phone = " ";
                        }
                        $date = explode(' ',$order->created_at);
                        $orderArr[$i]['sales_date'] = $date[0];
                        $orderArr[$i]['name'] = $order->name;
                        $orderArr[$i]['phone'] = $order->phone;
                        $orderArr[$i]['address'] = $add_part1->name.' ,'.$add_part2->name.' ,'.$add_part3->name.' ,'.$add_part4->name.' ,'.$add_part5->name.' ,'.$order->address;
                        $orderArr[$i]['pay_id'] = $order->tx_id;
                        $orderArr[$i]['amount'] = $order->total;
                        $orderArr[$i]['v_id'] = $v_id;
                        $orderArr[$i]['v_name'] = $name;
                        $orderArr[$i]['v_phone'] = $v_phone;
                        $orderArr[$i]['user_id'] = $row->user_id;
                        $orderArr[$i]['status'] = $order->status;
                        $orderArr[$i]['sales_id'] = $order->tx_id;
                    }
                }
                $sum  += $orderArr[$i]['amount'];
                $i++;
            }
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $itemCollection = collect($orderArr);
            $perPage = 20;
            $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
            $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
            $paginatedItems->setPath($request->url());
            return view('backend.sales', ['orders' => $paginatedItems,'sum' => $this->en2bn($sum).'/-','from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function dealerProductAdmin (Request $request){
        try{

            $rows = DB::table('products')->where('status', 1)
                ->orderBy('id', 'DESC')->Paginate(20);
            return view('backend.dealerProductAdmin', ['products' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getAllDealerAdmin(Request $request){
        try{
            $rows = DB::table('users')
                ->where('status', 1)
                ->where('user_type', 7)
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function searchDealerProductsAdmin(Request $request){
        try{
            $rows = DB::table('products')
                ->select('*','product_assign.id as p_id')
                ->join('product_assign','product_assign.product_id','=','products.id')
                ->where('product_assign.dealer_id', $request->dealer)
                ->where('products.status', 1)
                ->orderBy('products.id', 'ASC')
                ->Paginate(100);
            return view('backend.dealerProductAdmin', ['products' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
}
