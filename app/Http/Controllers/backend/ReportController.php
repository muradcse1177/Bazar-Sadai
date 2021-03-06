<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ReportController extends Controller
{
    function en2bn($number) {
        $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $bn_number = str_replace($search_array, $replace_array, $number);
        return $bn_number;
    }
    public function salesReport (Request $request){
        try {
            if($request->salesView ==1){
                $result =DB::table('order_details')
                    ->update(['view' =>  $request->salesView]);
            }
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
            return view('backend.sales', ['orders' => $paginatedItems,'sum' => $sum]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function changeOrderStatus(Request $request){
        try{
            if($request->id) {
                $id = explode('&',$request->id);
                $result =DB::table('order_details')
                    ->where('tx_id', $id[1])
                    ->update([
                        'status' =>  $id[0],
                    ]);
                if ($result) {
                    Session::flash('successMessage', 'সফলভাবে  সম্পন্ন  হয়েছে।');
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
    public function changeCustomOrderStatus(Request $request){
        try{
            if($request->id) {
                $id = explode('&',$request->id);
                if($id[0] == 'Delivered'){
                    $result =DB::table('custom_order_booking')
                        ->where('id', $id[1])
                        ->update([
                            'status' =>  $id[0],
                        ]);
                }
                else{
                    $result =DB::table('custom_order_booking')
                        ->where('id', $id[1])
                        ->update([
                            'status' =>  $id[0],
                        ]);
                }

                if ($result) {
                    Session::flash('successMessage', 'সফলভাবে  সম্পন্ন  হয়েছে।');
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
    public function getProductSalesOrderListByDate (Request $request){
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
    public function productur(Request  $request){
        try{
            $rows = DB::table('products')
                ->select('*','products.id as p_id','products.name as p_name','users.name as u_name')
                ->join('users','users.id','=','products.upload_by')
                ->where('users.user_type',4)
                ->paginate(50);
            return view('backend.productur',['products' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function ticketSalesReport (Request $request){
        try{
            if($request->salesView ==1){
                $result =DB::table('ticket_booking')
                    ->update(['view' =>  $request->salesView]);
            }
            $ticket_Sale = DB::table('ticket_booking')
                ->join('users', 'ticket_booking.user_id', '=', 'users.id')
                ->orderBy('ticket_booking.id','desc')
                ->paginate(20);
            return view('backend.ticketSalesReport', ['ticket_Sales' => $ticket_Sale]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getTicketSalesOrderListByDate (Request $request){
        try{
            $ticket_Sale = DB::table('ticket_booking')
                ->join('users', 'ticket_booking.user_id', '=', 'users.id')
                ->whereBetween('date',array($request->from_date,$request->to_date))
                ->orderBy('ticket_booking.id','desc')
                ->paginate(20);
            return view('backend.ticketSalesReport', ['ticket_Sales' => $ticket_Sale,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function accountName (){
        try{
            $row = DB::table('account_name')
                ->paginate(20);
            return view('backend.accountName', ['accountings' => $row]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function accountHead (){
        try{
            $row = DB::table('account_head')
                ->select('*','account_head.id as h_id')
                ->join('account_name','account_name.id','=','account_head.name_id')
                ->paginate(20);
            $name = DB::table('account_name')
                ->get();
            return view('backend.accountHead', ['accountings' => $row,'names' => $name]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function insertAccountName(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('account_name')
                        ->where('id', $request->id)
                        ->update([
                            'name' => $request->name,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফলভাবে  সম্পন্ন  হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else {
                    $rows = DB::table('account_name')
                        ->select('id')
                        ->where([
                            ['name', '=', $request->name],
                        ])
                        ->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন ডাটা দিন');
                    } else {
                        $result = DB::table('account_name')->insert([
                            'name' => $request->name,
                        ]);
                        if ($result) {
                            return back()->with('successMessage', 'সফলভাবে  সম্পন্ন  হয়েছে।');
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
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function insertAccountHead(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('account_head')
                        ->where('id', $request->id)
                        ->update([
                            'name_id' => $request->name_id,
                            'head' => $request->head,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফলভাবে  সম্পন্ন  হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else {
                    $rows = DB::table('account_head')
                        ->select('id')
                        ->where([
                            ['head', '=', $request->head],
                        ])
                        ->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন ডাটা দিন');
                    } else {
                        $result = DB::table('account_head')->insert([
                            'name_id' => $request->name_id,
                            'head' => $request->head,
                        ]);
                        if ($result) {
                            return back()->with('successMessage', 'সফলভাবে  সম্পন্ন  হয়েছে।');
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
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getAccountingNameListById(Request $request){
        try{
            $rows = DB::table('account_name')
                ->where('id', $request->id)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getAccountingHeadListById(Request $request){
        try{
            $rows = DB::table('account_head')
                ->where('id', $request->id)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function accounting (){
        try{
            $name = DB::table('account_name')
                ->get();
            $row = DB::table('accounting')
                ->select('*','accounting.id as acc_id')
                ->join('account_name','account_name.id','=','accounting.ac_name_id')
                ->join('account_head','account_head.id','=','accounting.acc_head_id')
                ->orderBy('date','desc')
                ->paginate(30);
            return view('backend.accounting', ['accountings' => $row,'names' => $name]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getAccountHeadListAll(Request $request){
        try{
            $rows = DB::table('account_head')
                ->where('name_id', $request->id)
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertAccounting(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('accounting')
                        ->where('id', $request->id)
                        ->update([
                            'ac_name_id' => $request->name_id,
                            'acc_head_id' => $request->head_id,
                            'type' => $request->type,
                            'purpose' => $request->purpose,
                            'amount' => $request->amount,
                            'amount1' => $request->amount1,
                            'amount2' => $request->amount2,
                            'date' => $request->date,
                            'person' => $request->person,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফলভাবে  সম্পন্ন  হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else {
                    $result = DB::table('accounting')->insert([
                        'ac_name_id' => $request->name_id,
                        'acc_head_id' => $request->head_id,
                        'type' => $request->type,
                        'purpose' => $request->purpose,
                        'amount' => $request->amount,
                        'amount1' => $request->amount1,
                        'amount2' => $request->amount2,
                        'date' => $request->date,
                        'person' => $request->person,
                    ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফলভাবে  সম্পন্ন  হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
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
    public function getAccountingReportByDate (Request $request){
        $name = DB::table('account_name')
            ->get();
        $row = DB::table('accounting')
            ->select('*','accounting.id as acc_id')
            ->join('account_name','account_name.id','=','accounting.ac_name_id')
            ->join('account_head','account_head.id','=','accounting.acc_head_id')
            ->whereBetween('date',array($request->from_date,$request->to_date))
            ->orderBy('date', 'Desc')->paginate(20);
        return view('backend.accounting', ['accountings' => $row,'names' => $name,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
    }
    public function getAccountingListById(Request $request){
        try{
            $rows = DB::table('accounting')
                ->where('id', $request->id)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function doctorAppointmentReport(Request $request){
        if($request->salesView ==1){
            $result =DB::table('dr_apportionment')
                ->update(['view' =>  $request->salesView]);
        }
        $rows = DB::table('dr_apportionment')
            ->select('*','dr_apportionment.id as a_id','a.phone as dr_phone','b.phone as p_phone','a.name as dr_name')
            ->join('users as a','a.id','=','dr_apportionment.dr_id')
            ->join('users as b','b.id','=','dr_apportionment.user_id')
            ->paginate('20');
        return view('backend.doctorAppointmentReport',['drReports' => $rows]);
    }
    public function getDrAppOrderListByDate(Request $request){
        $rows = DB::table('dr_apportionment')
            ->select('*','dr_apportionment.id as a_id','a.phone as dr_phone','b.phone as p_phone','a.name as dr_name')
            ->join('users as a','a.id','=','dr_apportionment.dr_id')
            ->join('users as b','b.id','=','dr_apportionment.user_id')
            ->whereBetween('date',array($request->from_date,$request->to_date))
            ->paginate('20');
        //dd($rows);
        return view('backend.doctorAppointmentReport',['drReports' => $rows,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
    }
    public function therapyAppointmentReport(Request $request){
        if($request->salesView ==1){
            $result =DB::table('therapy_appointment')
                ->update(['view' =>  $request->salesView]);
        }
        $rows = DB::table('therapy_appointment')
            ->select('*')
            ->join('users','users.id','=','therapy_appointment.user_id')
            ->join('therapyfees as a','a.id','=','therapy_appointment.therapy_fees_id')
            ->join('therapy_center','therapy_center.id','=','a.therapy_center_id')
            ->join('therapy_services','therapy_services.id','=','a.therapy_name_id')
            ->paginate('20');
        //dd($rows);
        return view('backend.therapyAppointmentReport',['therapyReports' => $rows]);
    }
    public function getTherapyAppOrderListByDate(Request $request){
        $rows = DB::table('therapy_appointment')
            ->select('*')
            ->join('users','users.id','=','therapy_appointment.user_id')
            ->join('therapyfees as a','a.id','=','therapy_appointment.therapy_fees_id')
            ->join('therapy_center','therapy_center.id','=','a.therapy_center_id')
            ->join('therapy_services','therapy_services.id','=','a.therapy_name_id')
            ->whereBetween('date',array($request->from_date,$request->to_date))
            ->paginate('20');
        //dd($rows);
        return view('backend.therapyAppointmentReport',['therapyReports' => $rows,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
    }
    public function diagnosticAppointmentReport(Request $request){
        if($request->salesView ==1){
            $result =DB::table('diagonostic_appointment')
                ->update(['view' =>  $request->salesView]);
        }
        $rows = DB::table('diagonostic_appointment')
            ->select('*')
            ->join('users','users.id','=','diagonostic_appointment.user_id')
            ->join('diagnostic_fees as a','a.id','=','diagonostic_appointment.diagnostic_fees_id')
            ->join('diagnostic_center','diagnostic_center.id','=','a.diagnostic_center_id')
            ->join('diagnostic_test','diagnostic_test.id','=','a.diagnostic_test_id')
            ->paginate('20');
        //dd($rows);
        return view('backend.diagnosticAppointmentReport',['diagnosticReports' => $rows]);
    }
    public function getDiagAppOrderListByDate(Request $request){
        $rows = DB::table('diagonostic_appointment')
            ->select('*')
            ->join('users','users.id','=','diagonostic_appointment.user_id')
            ->join('diagnostic_fees as a','a.id','=','diagonostic_appointment.diagnostic_fees_id')
            ->join('diagnostic_center','diagnostic_center.id','=','a.diagnostic_center_id')
            ->join('diagnostic_test','diagnostic_test.id','=','a.diagnostic_test_id')
            ->whereBetween('date',array($request->from_date,$request->to_date))
            ->paginate('20');
        //dd($rows);
        return view('backend.diagnosticAppointmentReport',['diagnosticReports' => $rows,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
    }

    public function donationReportBackend(Request $request){
        if($request->salesView ==1){
            $result =DB::table('donation_details')
                ->update(['view' =>  $request->salesView]);
        }
        $rows = DB::table('donation_details')
            ->select('*','products.name as p_name')
            ->join('products','products.id','=','donation_details.product_id')
            ->join('v_assign','donation_details.sales_id','=','v_assign.id')
            ->join('users','users.id','=','v_assign.user_id')
            ->paginate(20);
        //dd($rows);
        return view('backend.donationReportBackend',['products' => $rows]);
    }
    public function donationListByDate(Request $request){
        $rows = DB::table('donation_details')
            ->select('*','products.name as p_name')
            ->join('products','products.id','=','donation_details.product_id')
            ->join('v_assign','donation_details.sales_id','=','v_assign.id')
            ->join('users','users.id','=','v_assign.user_id')
            ->whereBetween('v_assign.sales_date',array($request->from_date,$request->to_date))
            ->paginate(20);
        //dd($rows);
        return view('backend.donationReportBackend',['products' => $rows],['diagnosticReports' => $rows,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
    }
    public function transportReportAdmin(Request $request){
        if($request->salesView ==1){
            $result =DB::table('ride_booking')
                ->update(['view' =>  $request->salesView]);
        }
        $rows = DB::table('ride_booking')
            ->get();
        $booking =array();
        $i = 0;
        foreach ($rows as $riding){
            $user_id = $riding->user_id;
            $address_type = $riding->address_type;
            $address_typep = $riding->address_type;
            $service_area = DB::table('service_area')
                ->where('user_id',$user_id)
                ->first();
            $user = DB::table('users')
                ->where('id', $user_id)
                ->first();
            if($address_type==1){
                $add_part1 = DB::table('divisions')
                    ->where('id',$service_area->add_part1)
                    ->first();
                $add_part2 = DB::table('districts')
                    ->where('div_id',$service_area->add_part1)
                    ->where('id',$service_area->add_part2)
                    ->first();
                $add_part3 = DB::table('upazillas')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('id',$riding->add_part3)
                    ->first();
                $add_part4 = DB::table('unions')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('upz_id',$riding->add_part3)
                    ->where('id',$riding->add_part4)
                    ->first();
            }
            if($address_type==2){
                $add_part1 = DB::table('divisions')
                    ->where('id',$service_area->add_part1)
                    ->first();
                $add_part2 = DB::table('cities')
                    ->where('div_id',$service_area->add_part1)
                    ->where('id',$service_area->add_part2)
                    ->first();
                $add_part3 = DB::table('city_corporations')
                    ->where('div_id',$service_area->add_part1)
                    ->where('city_id',$service_area->add_part2)
                    ->where('id',$riding->add_part3)
                    ->first();
                $add_part4 = DB::table('thanas')
                    ->where('div_id',$service_area->add_part1)
                    ->where('city_id',$service_area->add_part2)
                    ->where('city_co_id',$riding->add_part3)
                    ->where('id',$riding->add_part4)
                    ->first();
            }
            if($address_typep==1){
                $add_partp1 = DB::table('divisions')
                    ->where('id',$riding->add_partp1)
                    ->first();
                $add_partp2 = DB::table('districts')
                    ->where('div_id',$riding->add_partp1)
                    ->where('id',$riding->add_partp2)
                    ->first();
                $add_partp3 = DB::table('upazillas')
                    ->where('div_id',$riding->add_partp1)
                    ->where('dis_id',$riding->add_partp2)
                    ->where('id',$riding->add_partp3)
                    ->first();
                $add_partp4 = DB::table('unions')
                    ->where('div_id',$riding->add_partp1)
                    ->where('dis_id',$riding->add_partp2)
                    ->where('upz_id',$riding->add_partp3)
                    ->where('id',$riding->add_partp4)
                    ->first();
            }
            if($address_typep==2){
                $add_partp1 = DB::table('divisions')
                    ->where('id',$riding->add_partp1)
                    ->first();
                $add_partp2 = DB::table('cities')
                    ->where('div_id',$riding->add_partp1)
                    ->where('id',$riding->add_partp2)
                    ->first();
                $add_partp3 = DB::table('city_corporations')
                    ->where('div_id',$riding->add_partp1)
                    ->where('city_id',$riding->add_partp2)
                    ->where('id',$riding->add_partp3)
                    ->first();
                $add_partp4 = DB::table('thanas')
                    ->where('div_id',$riding->add_partp1)
                    ->where('city_id',$riding->add_partp2)
                    ->where('city_co_id',$riding->add_partp3)
                    ->where('id',$riding->add_partp4)
                    ->first();
            }
            if($riding->transport =='Motorcycle'){
                if($address_type==1){
                    $add_partp1 = DB::table('divisions')
                        ->where('id',$service_area->add_part1)
                        ->first();
                    $add_partp2 = DB::table('districts')
                        ->where('div_id',$service_area->add_part1)
                        ->where('id',$service_area->add_part2)
                        ->first();
                    $add_partp3 = DB::table('upazillas')
                        ->where('div_id',$service_area->add_part1)
                        ->where('dis_id',$service_area->add_part2)
                        ->where('id',$riding->add_partp3)
                        ->first();
                    $add_partp4 = DB::table('unions')
                        ->where('div_id',$service_area->add_part1)
                        ->where('dis_id',$service_area->add_part2)
                        ->where('upz_id',$riding->add_partp3)
                        ->where('id',$riding->add_partp4)
                        ->first();
                }
                if($address_type==2){
                    $add_partp1 = DB::table('divisions')
                        ->where('id',$service_area->add_part1)
                        ->first();
                    $add_partp2 = DB::table('cities')
                        ->where('div_id',$service_area->add_part1)
                        ->where('id',$service_area->add_part2)
                        ->first();
                    $add_partp3 = DB::table('city_corporations')
                        ->where('div_id',$service_area->add_part1)
                        ->where('city_id',$service_area->add_part2)
                        ->where('id',$riding->add_partp3)
                        ->first();
                    $add_partp4 = DB::table('thanas')
                        ->where('div_id',$service_area->add_part1)
                        ->where('city_id',$service_area->add_part2)
                        ->where('city_co_id',$riding->add_part3)
                        ->where('id',$riding->add_partp4)
                        ->first();
                }
            }
            $booking[$i]['date'] = $riding->date;
            $booking[$i]['transport'] = $riding->transport;
            $booking[$i]['user'] = $user->name;
            $booking[$i]['add_part1'] = $add_part1->name;
            $booking[$i]['add_part2'] = $add_part2->name;
            $booking[$i]['add_part3'] = $add_part3->name;
            $booking[$i]['add_part4'] = $add_part4->name;
            $booking[$i]['add_partp1'] = @$add_partp1->name;
            $booking[$i]['add_partp2'] = @$add_partp2->name;
            $booking[$i]['add_partp3'] = @$add_partp3->name;
            $booking[$i]['add_partp4'] = @$add_partp4->name;
            $booking[$i]['c_distance'] = $riding->customer_distance;
            $booking[$i]['c_cost'] = $riding->cutomer_cost;
            $booking[$i]['r_distance'] = $riding->rider_distance;
            $booking[$i]['r_cost'] = $riding->rider_cost;
            $i++;
        }
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($booking);
        $perPage = 20;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        $paginatedItems->setPath($request->url());
        return view('backend.transportReportAdmin',['bookings' => $paginatedItems]);
    }
    public function transportListByDate(Request $request){
        $rows = DB::table('ride_booking')
            ->where('transport',$request->transport)
            ->whereBetween('date',array($request->from_date,$request->to_date))
            ->get();
        $booking =array();
        $i = 0;
        foreach ($rows as $riding){
            $user_id = $riding->user_id;
            $address_type = $riding->address_type;
            $address_typep = $riding->address_type;
            $service_area = DB::table('service_area')
                ->where('user_id',$user_id)
                ->first();
            $user = DB::table('users')
                ->where('id', $user_id)
                ->first();
            if($address_type==1){
                $add_part1 = DB::table('divisions')
                    ->where('id',$service_area->add_part1)
                    ->first();
                $add_part2 = DB::table('districts')
                    ->where('div_id',$service_area->add_part1)
                    ->where('id',$service_area->add_part2)
                    ->first();
                $add_part3 = DB::table('upazillas')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('id',$riding->add_part3)
                    ->first();
                $add_part4 = DB::table('unions')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('upz_id',$riding->add_part3)
                    ->where('id',$riding->add_part4)
                    ->first();
            }
            if($address_type==2){
                $add_part1 = DB::table('divisions')
                    ->where('id',$service_area->add_part1)
                    ->first();
                $add_part2 = DB::table('cities')
                    ->where('div_id',$service_area->add_part1)
                    ->where('id',$service_area->add_part2)
                    ->first();
                $add_part3 = DB::table('city_corporations')
                    ->where('div_id',$service_area->add_part1)
                    ->where('city_id',$service_area->add_part2)
                    ->where('id',$riding->add_part3)
                    ->first();
                $add_part4 = DB::table('thanas')
                    ->where('div_id',$service_area->add_part1)
                    ->where('city_id',$service_area->add_part2)
                    ->where('city_co_id',$riding->add_part3)
                    ->where('id',$riding->add_part4)
                    ->first();
            }
            if($address_typep==1){
                $add_partp1 = DB::table('divisions')
                    ->where('id',$riding->add_partp1)
                    ->first();
                $add_partp2 = DB::table('districts')
                    ->where('div_id',$riding->add_partp1)
                    ->where('id',$riding->add_partp2)
                    ->first();
                $add_partp3 = DB::table('upazillas')
                    ->where('div_id',$riding->add_partp1)
                    ->where('dis_id',$riding->add_partp2)
                    ->where('id',$riding->add_partp3)
                    ->first();
                $add_partp4 = DB::table('unions')
                    ->where('div_id',$riding->add_partp1)
                    ->where('dis_id',$riding->add_partp2)
                    ->where('upz_id',$riding->add_partp3)
                    ->where('id',$riding->add_partp4)
                    ->first();
            }
            if($address_typep==2){
                $add_partp1 = DB::table('divisions')
                    ->where('id',$riding->add_partp1)
                    ->first();
                $add_partp2 = DB::table('cities')
                    ->where('div_id',$riding->add_partp1)
                    ->where('id',$riding->add_partp2)
                    ->first();
                $add_partp3 = DB::table('city_corporations')
                    ->where('div_id',$riding->add_partp1)
                    ->where('city_id',$riding->add_partp2)
                    ->where('id',$riding->add_partp3)
                    ->first();
                $add_partp4 = DB::table('thanas')
                    ->where('div_id',$riding->add_partp1)
                    ->where('city_id',$riding->add_partp2)
                    ->where('city_co_id',$riding->add_partp3)
                    ->where('id',$riding->add_partp4)
                    ->first();
            }
            if($riding->transport =='Motorcycle'){
                if($address_type==1){
                    $add_partp1 = DB::table('divisions')
                        ->where('id',$service_area->add_part1)
                        ->first();
                    $add_partp2 = DB::table('districts')
                        ->where('div_id',$service_area->add_part1)
                        ->where('id',$service_area->add_part2)
                        ->first();
                    $add_partp3 = DB::table('upazillas')
                        ->where('div_id',$service_area->add_part1)
                        ->where('dis_id',$service_area->add_part2)
                        ->where('id',$riding->add_partp3)
                        ->first();
                    $add_partp4 = DB::table('unions')
                        ->where('div_id',$service_area->add_part1)
                        ->where('dis_id',$service_area->add_part2)
                        ->where('upz_id',$riding->add_partp3)
                        ->where('id',$riding->add_partp4)
                        ->first();
                }
                if($address_type==2){
                    $add_partp1 = DB::table('divisions')
                        ->where('id',$service_area->add_part1)
                        ->first();
                    $add_partp2 = DB::table('cities')
                        ->where('div_id',$service_area->add_part1)
                        ->where('id',$service_area->add_part2)
                        ->first();
                    $add_partp3 = DB::table('city_corporations')
                        ->where('div_id',$service_area->add_part1)
                        ->where('city_id',$service_area->add_part2)
                        ->where('id',$riding->add_partp3)
                        ->first();
                    $add_partp4 = DB::table('thanas')
                        ->where('div_id',$service_area->add_part1)
                        ->where('city_id',$service_area->add_part2)
                        ->where('city_co_id',$riding->add_part3)
                        ->where('id',$riding->add_partp4)
                        ->first();
                }
            }
            $booking[$i]['date'] = $riding->date;
            $booking[$i]['transport'] = $riding->transport;
            $booking[$i]['user'] = $user->name;
            $booking[$i]['add_part1'] = $add_part1->name;
            $booking[$i]['add_part2'] = $add_part2->name;
            $booking[$i]['add_part3'] = $add_part3->name;
            $booking[$i]['add_part4'] = $add_part4->name;
            $booking[$i]['add_partp1'] = @$add_partp1->name;
            $booking[$i]['add_partp2'] = @$add_partp2->name;
            $booking[$i]['add_partp3'] = @$add_partp3->name;
            $booking[$i]['add_partp4'] = @$add_partp4->name;
            $booking[$i]['c_distance'] = $riding->customer_distance;
            $booking[$i]['c_cost'] = $riding->cutomer_cost;
            $booking[$i]['r_distance'] = $riding->rider_distance;
            $booking[$i]['r_cost'] = $riding->rider_cost;
            $i++;
        }
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($booking);
        $perPage = 20;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        $paginatedItems->setPath($request->url());
        return view('backend.transportReportAdmin',['bookings' => $paginatedItems,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
    }
    public function courierReport(Request $request){
        if($request->salesView ==1){
            $result =DB::table('courier_booking')
                ->update(['view' =>  $request->salesView]);
        }
        $rows = DB::table('courier_booking')
            ->select('*','naming1s.name as n_name','courier_type.name as c_name','courier_status.status as c_status','courier_status.id as c_id','courier_status.c_id as cc_id')
            ->join('courier_type','courier_type.id','=','courier_booking.type')
            ->join('courier_status','courier_status.c_id','=','courier_booking.id')
            ->join('naming1s','naming1s.id','=','courier_booking.f_country')
            ->get();
        $booking =array();
        $i = 0;
        foreach ($rows as $couriers) {
            $service_area = DB::table('service_area')
                ->where('user_id',$couriers->user_id)
                ->first();
            $user = DB::table('users')
                ->where('id',$couriers->user_id)
                ->first();
            $address_type_service_area = $service_area->address_type;
            if($address_type_service_area==1){
                $add_part1 = DB::table('divisions')
                    ->where('id',$service_area->add_part1)
                    ->first();
                $add_part2 = DB::table('districts')
                    ->where('div_id',$service_area->add_part1)
                    ->where('id',$service_area->add_part2)
                    ->first();
                $add_part3 = DB::table('upazillas')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('id',$service_area->add_part3)
                    ->first();
                $add_part4 = DB::table('unions')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('upz_id',$service_area->add_part3)
                    ->where('id',$service_area->add_part4)
                    ->first();
            }
            if($address_type_service_area==2){
                $add_part1 = DB::table('divisions')
                    ->where('id',$service_area->add_part1)
                    ->first();
                $add_part2 = DB::table('cities')
                    ->where('div_id',$service_area->add_part1)
                    ->where('id',$service_area->add_part2)
                    ->first();
                $add_part3 = DB::table('city_corporations')
                    ->where('div_id',$service_area->add_part1)
                    ->where('city_id',$service_area->add_part2)
                    ->where('id',$service_area->add_part3)
                    ->first();
                $add_part4 = DB::table('thanas')
                    ->where('div_id',$service_area->add_part1)
                    ->where('city_id',$service_area->add_part2)
                    ->where('city_co_id',$service_area->add_part3)
                    ->where('id',$service_area->add_part4)
                    ->first();
            }
            if($address_type_service_area==3){
                $add_part1 = DB::table('naming1s')
                    ->where('id',$service_area->add_part1)
                    ->first();
                $add_part2 = DB::table('naming2s')
                    ->where('div_id',$service_area->add_part1)
                    ->where('id',$service_area->add_part2)
                    ->first();
                $add_part3 = DB::table('naming3s')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('id',$service_area->add_part3)
                    ->first();
                $add_part4 = DB::table('naming4')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('upz_id',$service_area->add_part3)
                    ->where('id',$service_area->add_part4)
                    ->first();
            }
            if($couriers->address_type==1){
                $add_part1C = DB::table('divisions')
                    ->where('id',$couriers->add_part1)
                    ->first();
                $add_part2C = DB::table('districts')
                    ->where('div_id',$couriers->add_part1)
                    ->where('id',$couriers->add_part2)
                    ->first();
                $add_part3C = DB::table('upazillas')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('id',$couriers->add_part3)
                    ->first();
                $add_part4C = DB::table('unions')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('id',$couriers->add_part4)
                    ->first();
                $add_part5C = DB::table('wards')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('uni_id',$couriers->add_part4)
                    ->where('id',$couriers->add_part5)
                    ->first();
            }
            if($couriers->address_type==2){
                $add_part1C = DB::table('divisions')
                    ->where('id',$couriers->add_part1)
                    ->first();
                $add_part2C = DB::table('cities')
                    ->where('div_id',$couriers->add_part1)
                    ->where('id',$couriers->add_part2)
                    ->first();
                $add_part3C = DB::table('city_corporations')
                    ->where('div_id',$couriers->add_part1)
                    ->where('city_id',$couriers->add_part2)
                    ->where('id',$couriers->add_part3)
                    ->first();
                $add_part4C = DB::table('thanas')
                    ->where('div_id',$couriers->add_part1)
                    ->where('city_id',$couriers->add_part2)
                    ->where('city_co_id',$couriers->add_part3)
                    ->where('id',$couriers->add_part4)
                    ->first();
                $add_part5C = DB::table('c_wards')
                    ->where('div_id',$couriers->add_part1)
                    ->where('city_id',$couriers->add_part2)
                    ->where('city_co_id',$couriers->add_part3)
                    ->where('thana_id',$couriers->add_part4)
                    ->where('id',$couriers->add_part5)
                    ->first();
            }
            if($couriers->address_type==3){
                $add_part1C = DB::table('naming1s')
                    ->where('id',$couriers->add_part1)
                    ->first();
                $add_part2C = DB::table('naming2s')
                    ->where('div_id',$couriers->add_part1)
                    ->where('id',$couriers->add_part2)
                    ->first();
                $add_part3C = DB::table('naming3s')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('id',$couriers->add_part3)
                    ->first();
                $add_part4C = DB::table('naming4')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('id',$couriers->add_part4)
                    ->first();
                $add_part5C = DB::table('naming5s')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('uni_id',$couriers->add_part4)
                    ->where('id',$couriers->add_part5)
                    ->first();
            }
            $booking[$i]['date'] = $couriers->date;
            $booking[$i]['user'] = $user->name;
            $booking[$i]['user_phone'] = $user->phone;
            $booking[$i]['add_part1'] = $add_part1->name;
            $booking[$i]['add_part2'] = $add_part2->name;
            $booking[$i]['add_part3'] = $add_part3->name;
            $booking[$i]['add_part4'] = $add_part4->name;
            $booking[$i]['add_part1C'] = $add_part1C->name;
            $booking[$i]['add_part2C'] = $add_part2C->name;
            $booking[$i]['add_part3C'] = $add_part3C->name;
            $booking[$i]['add_part4C'] = $add_part4C->name;
            $booking[$i]['add_part5C'] = $add_part5C->name;
            $booking[$i]['address'] = $couriers->address;
            $booking[$i]['n_name'] = $couriers->n_name;
            $booking[$i]['cost'] = $couriers->cost;
            $booking[$i]['weight'] = $couriers->weight;
            $booking[$i]['tx_id'] = $couriers->tx_id;
            $booking[$i]['status'] = $couriers->c_status;
            $booking[$i]['id'] = $couriers->c_id;
            $booking[$i]['cc_id'] = $couriers->cc_id;
            $i++;

        }
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($booking);
        $perPage = 20;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        $paginatedItems->setPath($request->url());
        return view('backend.courierReport',['bookings' => $paginatedItems]);
    }
    public function courierListByDate(Request $request){
        $rows = DB::table('courier_booking')
            ->select('*','naming1s.name as n_name','courier_type.name as c_name','courier_status.status as c_status','courier_status.id as c_id','courier_status.c_id as cc_id')
            ->join('courier_type','courier_type.id','=','courier_booking.type')
            ->join('courier_status','courier_status.c_id','=','courier_booking.id')
            ->join('naming1s','naming1s.id','=','courier_booking.f_country')
            ->whereBetween('date',array($request->from_date,$request->to_date))
            ->get();
        $booking =array();
        $i = 0;
        foreach ($rows as $couriers) {
            $service_area = DB::table('service_area')
                ->where('user_id',$couriers->user_id)
                ->first();
            $user = DB::table('users')
                ->where('id',$couriers->user_id)
                ->first();
            $address_type_service_area = $service_area->address_type;
            if($address_type_service_area==1){
                $add_part1 = DB::table('divisions')
                    ->where('id',$service_area->add_part1)
                    ->first();
                $add_part2 = DB::table('districts')
                    ->where('div_id',$service_area->add_part1)
                    ->where('id',$service_area->add_part2)
                    ->first();
                $add_part3 = DB::table('upazillas')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('id',$service_area->add_part3)
                    ->first();
                $add_part4 = DB::table('unions')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('upz_id',$service_area->add_part3)
                    ->where('id',$service_area->add_part4)
                    ->first();
            }
            if($address_type_service_area==2){
                $add_part1 = DB::table('divisions')
                    ->where('id',$service_area->add_part1)
                    ->first();
                $add_part2 = DB::table('cities')
                    ->where('div_id',$service_area->add_part1)
                    ->where('id',$service_area->add_part2)
                    ->first();
                $add_part3 = DB::table('city_corporations')
                    ->where('div_id',$service_area->add_part1)
                    ->where('city_id',$service_area->add_part2)
                    ->where('id',$service_area->add_part3)
                    ->first();
                $add_part4 = DB::table('thanas')
                    ->where('div_id',$service_area->add_part1)
                    ->where('city_id',$service_area->add_part2)
                    ->where('city_co_id',$service_area->add_part3)
                    ->where('id',$service_area->add_part4)
                    ->first();
            }
            if($address_type_service_area==3){
                $add_part1 = DB::table('naming1s')
                    ->where('id',$service_area->add_part1)
                    ->first();
                $add_part2 = DB::table('naming2s')
                    ->where('div_id',$service_area->add_part1)
                    ->where('id',$service_area->add_part2)
                    ->first();
                $add_part3 = DB::table('naming3s')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('id',$service_area->add_part3)
                    ->first();
                $add_part4 = DB::table('naming4')
                    ->where('div_id',$service_area->add_part1)
                    ->where('dis_id',$service_area->add_part2)
                    ->where('upz_id',$service_area->add_part3)
                    ->where('id',$service_area->add_part4)
                    ->first();
            }
            if($couriers->address_type==1){
                $add_part1C = DB::table('divisions')
                    ->where('id',$couriers->add_part1)
                    ->first();
                $add_part2C = DB::table('districts')
                    ->where('div_id',$couriers->add_part1)
                    ->where('id',$couriers->add_part2)
                    ->first();
                $add_part3C = DB::table('upazillas')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('id',$couriers->add_part3)
                    ->first();
                $add_part4C = DB::table('unions')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('id',$couriers->add_part4)
                    ->first();
                $add_part5C = DB::table('wards')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('uni_id',$couriers->add_part4)
                    ->where('id',$couriers->add_part5)
                    ->first();
            }
            if($couriers->address_type==2){
                $add_part1C = DB::table('divisions')
                    ->where('id',$couriers->add_part1)
                    ->first();
                $add_part2C = DB::table('cities')
                    ->where('div_id',$couriers->add_part1)
                    ->where('id',$couriers->add_part2)
                    ->first();
                $add_part3C = DB::table('city_corporations')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('id',$couriers->add_part3)
                    ->first();
                $add_part4C = DB::table('thanas')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('id',$couriers->add_part4)
                    ->first();
                $add_part5C = DB::table('c_wards')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('uni_id',$couriers->add_part4)
                    ->where('id',$couriers->add_part5)
                    ->first();
            }
            if($couriers->address_type==3){
                $add_part1C = DB::table('naming1s')
                    ->where('id',$couriers->add_part1)
                    ->first();
                $add_part2C = DB::table('naming2s')
                    ->where('div_id',$couriers->add_part1)
                    ->where('id',$couriers->add_part2)
                    ->first();
                $add_part3C = DB::table('naming3s')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('id',$couriers->add_part3)
                    ->first();
                $add_part4C = DB::table('naming4')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('id',$couriers->add_part4)
                    ->first();
                $add_part5C = DB::table('naming5s')
                    ->where('div_id',$couriers->add_part1)
                    ->where('dis_id',$couriers->add_part2)
                    ->where('upz_id',$couriers->add_part3)
                    ->where('uni_id',$couriers->add_part4)
                    ->where('id',$couriers->add_part5)
                    ->first();
            }
            $booking[$i]['date'] = $couriers->date;
            $booking[$i]['user'] = $user->name;
            $booking[$i]['user_phone'] = $user->phone;
            $booking[$i]['add_part1'] = $add_part1->name;
            $booking[$i]['add_part2'] = $add_part2->name;
            $booking[$i]['add_part3'] = $add_part3->name;
            $booking[$i]['add_part4'] = $add_part4->name;
            $booking[$i]['add_part1C'] = $add_part1C->name;
            $booking[$i]['add_part2C'] = $add_part2C->name;
            $booking[$i]['add_part3C'] = $add_part3C->name;
            $booking[$i]['add_part4C'] = $add_part4C->name;
            $booking[$i]['add_part5C'] = $add_part5C->name;
            $booking[$i]['address'] = $couriers->address;
            $booking[$i]['n_name'] = $couriers->n_name;
            $booking[$i]['cost'] = $couriers->cost;
            $booking[$i]['weight'] = $couriers->weight;
            $booking[$i]['tx_id'] = $couriers->tx_id;
            $booking[$i]['status'] = $couriers->c_status;
            $booking[$i]['id'] = $couriers->c_id;
            $booking[$i]['cc_id'] = $couriers->cc_id;
            $i++;

        }
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($booking);
        $perPage = 20;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        $paginatedItems->setPath($request->url());
        return view('backend.courierReport',['bookings' => $paginatedItems,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
    }
    public function customOrderReport(Request $request){
        if($request->salesView ==1){
            $result =DB::table('custom_order_booking')
                ->update(['view' =>  $request->salesView]);
        }
        $results = DB::table('custom_order_booking')
            ->select('*','custom_order_seller.phone as s_phone','custom_order_seller.date as s_date','custom_order_seller.price as s_price')
            ->leftJoin('custom_order_seller','custom_order_seller.buyer_request_id','=','custom_order_booking.id')
            ->orderBy('custom_order_booking.id','desc')
            ->get();
        $i=0;
        foreach ($results as $result){
            $address_type  = $result->address_type;
            if($address_type == 1){
                $add_part1 = DB::table('divisions')
                    ->where('id',$result->add_part1)
                    ->first();
                $add_part2 = DB::table('districts')
                    ->where('div_id',$result->add_part1)
                    ->where('id',$result->add_part2)
                    ->first();
                $add_part3 = DB::table('upazillas')
                    ->where('div_id',$result->add_part1)
                    ->where('dis_id',$result->add_part2)
                    ->where('id',$result->add_part3)
                    ->first();
                $add_part4 = DB::table('unions')
                    ->where('div_id',$result->add_part1)
                    ->where('dis_id',$result->add_part2)
                    ->where('upz_id',$result->add_part3)
                    ->where('id',$result->add_part4)
                    ->first();
                $add_part5 = DB::table('wards')
                    ->where('div_id',$result->add_part1)
                    ->where('dis_id',$result->add_part2)
                    ->where('upz_id',$result->add_part3)
                    ->where('uni_id',$result->add_part4)
                    ->where('id',$result->add_part5)
                    ->first();
            }
            if($address_type ==2){
                $add_part1 = DB::table('divisions')
                    ->where('id',$result->add_part1)
                    ->first();
                $add_part2 = DB::table('cities')
                    ->where('div_id',$result->add_part1)
                    ->where('id',$result->add_part2)
                    ->first();
                $add_part3 = DB::table('city_corporations')
                    ->where('div_id',$result->add_part1)
                    ->where('city_id',$result->add_part2)
                    ->where('id',$result->add_part3)
                    ->first();
                $add_part4 = DB::table('thanas')
                    ->where('div_id',$result->add_part1)
                    ->where('city_id',$result->add_part2)
                    ->where('city_co_id',$result->add_part3)
                    ->where('id',$result->add_part4)
                    ->first();
                $add_part5 = DB::table('c_wards')
                    ->where('div_id',$result->add_part1)
                    ->where('city_id',$result->add_part2)
                    ->where('city_co_id',$result->add_part3)
                    ->where('thana_id',$result->add_part4)
                    ->where('id',$result->add_part5)
                    ->first();
            }
            $cat = DB::table('categories')
                ->where('id',$result->category)
                ->first();
            if($result->sub_category){
                $sub_cat = DB::table('subcategories')
                    ->where('cat_id',$result->category)
                    ->where('id',$result->sub_category)
                    ->first();
            }

            $booking[$i]['id'] = $result->id;
            $booking[$i]['category'] = $cat->name;
            $booking[$i]['sub_category'] = @$sub_cat->name;
            $booking[$i]['name'] = $result->name;
            $booking[$i]['phone'] = $result->phone;
            $booking[$i]['add_part1'] = $add_part1->name;
            $booking[$i]['add_part2'] = $add_part2->name;
            $booking[$i]['add_part3'] = $add_part3->name;
            $booking[$i]['add_part4'] = $add_part4->name;
            $booking[$i]['add_part5'] = $add_part5->name;
            $booking[$i]['address'] = $result->address;
            $booking[$i]['details'] = $result->details;
            $booking[$i]['date'] = $result->date;
            $booking[$i]['amount'] = $result->amount;
            $booking[$i]['price'] = $result->price;
            $booking[$i]['image'] = $result->image;
            $booking[$i]['status'] = $result->status;
            $booking[$i]['seller_name'] = $result->seller_name;
            $booking[$i]['s_phone'] = $result->s_phone;
            $booking[$i]['s_date'] = $result->s_date;
            $booking[$i]['s_price'] = $result->s_price;
            $i++;
        }
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($booking);
        $perPage = 30;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        $paginatedItems->setPath($request->url());
        return view('backend.customOrderReport',['bookings' => $paginatedItems]);
    }
    public function customOrderReportListByDate(Request $request){
        $results = DB::table('custom_order_booking')
            ->whereBetween('date',array($request->from_date,$request->to_date))
            ->orderBy('id','desc')
            ->get();
        $i=0;
        $booking = array();
        foreach ($results as $result){
            $address_type  = $result->address_type;
            if($address_type == 1){
                $add_part1 = DB::table('divisions')
                    ->where('id',$result->add_part1)
                    ->first();
                $add_part2 = DB::table('districts')
                    ->where('div_id',$result->add_part1)
                    ->where('id',$result->add_part2)
                    ->first();
                $add_part3 = DB::table('upazillas')
                    ->where('div_id',$result->add_part1)
                    ->where('dis_id',$result->add_part2)
                    ->where('id',$result->add_part3)
                    ->first();
                $add_part4 = DB::table('unions')
                    ->where('div_id',$result->add_part1)
                    ->where('dis_id',$result->add_part2)
                    ->where('upz_id',$result->add_part3)
                    ->where('id',$result->add_part4)
                    ->first();
                $add_part5 = DB::table('wards')
                    ->where('div_id',$result->add_part1)
                    ->where('dis_id',$result->add_part2)
                    ->where('upz_id',$result->add_part3)
                    ->where('uni_id',$result->add_part4)
                    ->where('id',$result->add_part5)
                    ->first();
            }
            if($address_type ==2){
                $add_part1 = DB::table('divisions')
                    ->where('id',$result->add_part1)
                    ->first();
                $add_part2 = DB::table('cities')
                    ->where('div_id',$result->add_part1)
                    ->where('id',$result->add_part2)
                    ->first();
                $add_part3 = DB::table('city_corporations')
                    ->where('div_id',$result->add_part1)
                    ->where('city_id',$result->add_part2)
                    ->where('id',$result->add_part3)
                    ->first();
                $add_part4 = DB::table('thanas')
                    ->where('div_id',$result->add_part1)
                    ->where('city_id',$result->add_part2)
                    ->where('city_co_id',$result->add_part3)
                    ->where('id',$result->add_part4)
                    ->first();
                $add_part5 = DB::table('c_wards')
                    ->where('div_id',$result->add_part1)
                    ->where('city_id',$result->add_part2)
                    ->where('city_co_id',$result->add_part3)
                    ->where('thana_id',$result->add_part4)
                    ->where('id',$result->add_part5)
                    ->first();
            }
            $cat = DB::table('categories')
                ->where('id',$result->category)
                ->first();
            if($result->sub_category){
                $sub_cat = DB::table('subcategories')
                    ->where('cat_id',$result->category)
                    ->where('id',$result->sub_category)
                    ->first();
            }
            $users = DB::table('users')
                ->where('id',$result->seller_id)
                ->first();

            if($users)
                $user = $users->name;
            else
                $user = "";
            $booking[$i]['id'] = $result->id;
            $booking[$i]['category'] = $cat->name;
            $booking[$i]['sub_category'] = $sub_cat->name;
            $booking[$i]['name'] = $result->name;
            $booking[$i]['phone'] = $result->phone;
            $booking[$i]['add_part1'] = $add_part1->name;
            $booking[$i]['add_part2'] = $add_part2->name;
            $booking[$i]['add_part3'] = $add_part3->name;
            $booking[$i]['add_part4'] = $add_part4->name;
            $booking[$i]['add_part5'] = $add_part5->name;
            $booking[$i]['address'] = $result->address;
            $booking[$i]['details'] = $result->details;
            $booking[$i]['date'] = $result->date;
            $booking[$i]['amount'] = $result->amount;
            $booking[$i]['price'] = $result->price;
            $booking[$i]['image'] = $result->image;
            $booking[$i]['status'] = $result->status;
            $booking[$i]['seller_id'] = $user;
            $booking[$i]['delivery_date'] = $result->delivered_date;
            $i++;
        }
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($booking);
        $perPage = 30;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        $paginatedItems->setPath($request->url());
        return view('backend.customOrderReport',['bookings' => $paginatedItems,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
    }
    public function cookingReport (Request $request){
        try{
            if($request->salesView ==1){
                $result =DB::table('cooking_booking')
                    ->update(['view' =>  $request->salesView]);
            }
            $cooking = DB::table('cooking_booking')
                ->select('*','a.name as u_name','a.phone as  u_phone')
                ->join('users as a', 'a.id', '=', 'cooking_booking.user_id')
                ->join('users as b', 'b.id', '=', 'cooking_booking.cooker_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->paginate(20);
            return view('backend.cookingReport',['cookings' =>$cooking]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function cookingReportListByDate (Request  $request){
        try{

            $cooking = DB::table('cooking_booking')
                ->select('*','a.name as u_name','a.phone as  u_phone')
                ->join('users as a', 'a.id', '=', 'cooking_booking.user_id')
                ->join('users as b', 'b.id', '=', 'cooking_booking.cooker_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->whereBetween('date',array($request->from_date,$request->to_date))
                ->paginate(20);
            return view('backend.cookingReport',['cookings' =>$cooking,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function clothWashingReport (Request  $request){
        try{
            if($request->salesView ==1){
                $result =DB::table('cloth_washing_order')
                    ->update(['view' =>  $request->salesView]);
            }
            $washing = DB::table('cloth_washing_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','cloth_washing_order.id as c_id')
                ->join('users as a', 'a.id', '=', 'cloth_washing_order.user_id')
                ->join('users as b', 'b.id', '=', 'cloth_washing_order.cleaner_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->orderBy('cloth_washing_order.id','desc')
                ->paginate(20);
            return view('backend.clothWashingReport',['washings' =>$washing]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function clothWashingReportListByDate (Request  $request){
        try{

            $washing = DB::table('cloth_washing_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','cloth_washing_order.id as c_id')
                ->join('users as a', 'a.id', '=', 'cloth_washing_order.user_id')
                ->join('users as b', 'b.id', '=', 'cloth_washing_order.cleaner_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->orderBy('cloth_washing_order.id','desc')
                ->whereBetween('date',array($request->from_date,$request->to_date))
                ->paginate(20);
            return view('backend.clothWashingReport',['washings' =>$washing,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getClothWashingById(Request $request){
        $output = array('list'=>'');
        $orders = DB::table('cloth_washing_order')
            ->where('id',  $request->id)
            ->first();
        $cloth_id = json_decode($orders->cloth_id);
        $quantity = json_decode($orders->quantity);
        $i =0;
        foreach ($quantity as $q){
            $quantity_arr[$i] =$q;
            $i++;
        }
        for($i=0; $i<count($cloth_id); $i++){
            $cloth = DB::table('cloth_washing')
                ->select('*')
                ->where('id',  $cloth_id[$i])
                ->first();
            $output['list'] .= "
                    <tr class='prepend_items'>
                        <td>".$cloth->name."</td>
                        <td>".$quantity_arr[$i]."</td>
                    </tr>
                ";
        }
        return response()->json(array('data'=>$output));
    }
    public function roomCleaningReport (Request  $request){
        try{
            if($request->salesView ==1){
                $result =DB::table('cleaning_order')
                ->update(['view' =>  $request->salesView]);
            }
            $washing = DB::table('cleaning_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','cleaning_order.id as c_id')
                ->join('users as a', 'a.id', '=', 'cleaning_order.user_id')
                ->join('users as b', 'b.id', '=', 'cleaning_order.cleaner_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->orderBy('cleaning_order.id','desc')
                ->paginate(20);
            return view('backend.roomCleaningReport',['washings' =>$washing]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function cleaningReportListByDate (Request  $request){
        try{
            $washing = DB::table('cleaning_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','cleaning_order.id as c_id')
                ->join('users as a', 'a.id', '=', 'cleaning_order.user_id')
                ->join('users as b', 'b.id', '=', 'cleaning_order.cleaner_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->whereBetween('date',array($request->from_date,$request->to_date))
                ->orderBy('cleaning_order.id','desc')
                ->paginate(20);
            return view('backend.roomCleaningReport',['washings' =>$washing,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function helpingHandReport (Request  $request){
        try{
            if($request->salesView ==1){
                $result =DB::table('helping_hand_order')
                    ->update(['view' =>  $request->salesView]);
            }
            $washing = DB::table('helping_hand_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','helping_hand_order.id as c_id')
                ->join('users as a', 'a.id', '=', 'helping_hand_order.user_id')
                ->join('users as b', 'b.id', '=', 'helping_hand_order.helper')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->orderBy('helping_hand_order.id','desc')
                ->paginate(20);
            return view('backend.helpingHandReport',['washings' =>$washing]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function helpingHandReportListByDate (Request  $request){
        try{
            $washing = DB::table('helping_hand_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','helping_hand_order.id as c_id')
                ->join('users as a', 'a.id', '=', 'helping_hand_order.user_id')
                ->join('users as b', 'b.id', '=', 'helping_hand_order.helper')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->whereBetween('date',array($request->from_date,$request->to_date))
                ->orderBy('helping_hand_order.id','desc')
                ->paginate(20);
            return view('backend.helpingHandReport',['washings' =>$washing,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function guardReport (Request  $request){
        try{
            if($request->salesView ==1){
                $result =DB::table('guard_order')
                ->update(['view' =>  $request->salesView]);
            }
            $washing = DB::table('guard_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','guard_order.id as c_id')
                ->join('users as a', 'a.id', '=', 'guard_order.user_id')
                ->join('users as b', 'b.id', '=', 'guard_order.gurd_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->orderBy('guard_order.id','desc')
                ->paginate(20);
            return view('backend.guardReport',['washings' =>$washing]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function guardReportListByDate (Request  $request){
        try{
            $washing = DB::table('guard_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','guard_order.id as c_id')
                ->join('users as a', 'a.id', '=', 'guard_order.user_id')
                ->join('users as b', 'b.id', '=', 'guard_order.gurd_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->whereBetween('date',array($request->from_date,$request->to_date))
                ->orderBy('guard_order.id','desc')
                ->paginate(20);
            return view('backend.guardReport',['washings' =>$washing,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function variousServicingReport (Request  $request){
        try{
            if($request->salesView ==1){
                $result =DB::table('various_servicing_order')
                    ->update(['view' =>  $request->salesView]);
            }
            $washing = DB::table('various_servicing_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','various_servicing_order.name as v_name')
                ->join('users as a', 'a.id', '=', 'various_servicing_order.user_id')
                ->join('users as b', 'b.id', '=', 'various_servicing_order.worker')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->orderBy('various_servicing_order.id','desc')
                ->paginate(20);
            return view('backend.variousServicingReport',['washings' =>$washing]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function laundryReport (Request  $request){
        try{
            if($request->salesView ==1){
                $result =DB::table('laundry_order')
                    ->update(['view' =>  $request->salesView]);
            }
            $washing = DB::table('laundry_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','a.address as  u_address','laundry_order.id as c_id','laundry_order.status as situation')
                ->join('users as a', 'a.id', '=', 'laundry_order.user_id')
                ->join('users as b', 'b.id', '=', 'laundry_order.cleaner_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->orderBy('laundry_order.id','desc')
                ->paginate(20);
            return view('backend.laundryReport',['washings' =>$washing]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function laundryReportListByDate (Request  $request){
        try{
            $washing = DB::table('laundry_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','a.address as  u_address','laundry_order.id as c_id')
                ->join('users as a', 'a.id', '=', 'laundry_order.user_id')
                ->join('users as b', 'b.id', '=', 'laundry_order.cleaner_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->orderBy('laundry_order.id','desc')
                ->whereBetween('date',array($request->from_date,$request->to_date))
                ->paginate(20);
            return view('backend.laundryReport',['washings' =>$washing,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getLaundryWashingById(Request $request){
        $output = array('list'=>'');
        $orders = DB::table('laundry_order')
            ->where('id',  $request->id)
            ->first();
        $cloth_id = json_decode($orders->cloth_id);
        $quantity = json_decode($orders->quantity);
        $wash = json_decode($orders->wa_id);
        $iron = json_decode($orders->is_id);
        $i =0;
        foreach ($quantity as $q){
            $quantity_arr[$i] =$q;
            $i++;
        }
        for($i=0; $i<count($cloth_id); $i++){
            $cloth = DB::table('laundry')
                ->select('*')
                ->where('id',  $cloth_id[$i])
                ->first();
            $wa_price = 'No';
            $is_price = 'No';
            if(in_array($cloth_id[$i],$wash))
                $wa_price = "Yes";
            if(in_array($cloth_id[$i],$iron))
                $is_price = "Yes";
            $output['list'] .= "
                    <tr class='prepend_items'>
                        <td>".$cloth->name."</td>
                        <td>".$wa_price."</td>
                        <td>".$is_price."</td>
                        <td>".$quantity_arr[$i]."</td>
                    </tr>
                ";
        }
        return response()->json(array('data'=>$output));
    }
    public function parlorReport  (Request  $request){
        try{
            if($request->salesView ==1){
                $result =DB::table('parlor_order')
                    ->update(['view' =>  $request->salesView]);
            }
            $washing = DB::table('parlor_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','parlor_order.name as v_name')
                ->join('users as a', 'a.id', '=', 'parlor_order.user_id')
                ->join('users as b', 'b.id', '=', 'parlor_order.parlor_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->orderBy('parlor_order.id','desc')
                ->paginate(20);
            return view('backend.parlorReport',['washings' =>$washing]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function parlorReportListByDate  (Request  $request){
        try{
            $washing = DB::table('parlor_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','parlor_order.name as v_name')
                ->join('users as a', 'a.id', '=', 'parlor_order.user_id')
                ->join('users as b', 'b.id', '=', 'parlor_order.parlor_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->whereBetween('date',array($request->from_date,$request->to_date))
                ->orderBy('parlor_order.id','desc')
                ->paginate(20);
            return view('backend.parlorReport',['washings' =>$washing,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function toursNTravelsReport(Request $request){
        try{
            if($request->salesView ==1){
                $result =DB::table('bookingtnt')
                    ->update(['view' =>  $request->salesView]);
            }
            $results = DB::table('bookingtnt')
                ->select('*','bookingtnt.price as f_price')
                ->join('toor_booking2','toor_booking2.id','=','bookingtnt.pack_id')
                ->join('toor_booking1','toor_booking1.id','=','toor_booking2.name_id')
                ->orderBy('bookingtnt.id','desc')
                ->paginate(20);
            return view('backend.toursNTravelsReport',['orders' => $results]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function toursNTravelsReportListByDate(Request  $request){
        try{
            $results = DB::table('bookingtnt')
                ->select('*','bookingtnt.price as f_price')
                ->join('toor_booking2','toor_booking2.id','=','bookingtnt.pack_id')
                ->join('toor_booking1','toor_booking1.id','=','toor_booking2.name_id')
                ->orderBy('bookingtnt.id','desc')
                ->whereBetween('bookingtnt.date',array($request->from_date,$request->to_date))
                ->paginate(20);
            return view('backend.toursNTravelsReport',['orders' => $results,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function approvalChange(Request  $request){
        try{
            if($request->id) {
                $status =DB::table('products')->where('id', $request->id)->first();
                if($status->approval == 1)
                    $approval = 0;
                else
                    $approval = 1;
                $result =DB::table('products')
                    ->where('id', $request->id)
                    ->update([
                        'approval' =>  $approval,
                    ]);
                if ($result) {
                    return response()->json(array('data'=>'ok'));
                } else {
                    return response()->json(array('data'=>'ok'));
                }
            }
            else{
                return response()->json(array('data'=>'ok'));
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function ConfirmSellerOrder(Request  $request){
        try{
            if($request->id) {
                $result =DB::table('custom_order_booking')
                    ->where('id', $request->id)
                    ->update([
                        'seller_id' =>  Cookie::get('user_id'),
                    ]);
                if ($result) {
                    return back()->with('successMessage', 'সফলভাবে  সম্পন্ন  হয়েছে।');
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

}
