<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    public function dashboard(){
        $users = DB::table('users')
            ->where('status', 1)
            ->distinct()->get()->count();
        $cashOut = DB::table('accounting')
            ->where('date', date('y-m-d'))
            ->where('type', 'Cash Out')
            ->sum('amount');
        $cashIn = DB::table('accounting')
            ->where('date', date('y-m-d'))
            ->where('type', 'Cash In')
            ->sum('amount');
        $p_order = DB::table('v_assign')
            ->where('sales_date', date('y-m-d'))
            ->distinct()->get()->count();
        $t_order = DB::table('ticket_booking')
            ->where('date', date('y-m-d'))
            ->distinct()->get()->count();
        $d_order = DB::table('dr_apportionment')
            ->where('date', date('y-m-d'))
            ->distinct()->get()->count();
        $th_order = DB::table('therapy_appointment')
            ->where('date', date('y-m-d'))
            ->distinct()->get()->count();
        $di_order = DB::table('diagonostic_appointment')
            ->where('date', date('y-m-d'))
            ->distinct()->get()->count();
        $m_order = DB::table('medicine_order')
            ->where('date', date('y-m-d'))
            ->distinct()->get()->count();
        return view('backend.dashboard',
            [
                'users' => $users,
                'cashOut' => $cashOut,
                'cashIn' => $cashIn,
                'p_order' => $p_order,
                't_order' => $t_order,
                'd_order' => $d_order,
                'th_order' => $th_order,
                'di_order' => $di_order,
                'm_order' => $m_order,
            ]
        );
    }
    public function insertUserType(Request $request){
        try{
            if($request) {
                $rows = DB::table('user_type')->select('name')->where([
                    ['name', '=', $request->name]
                ])->where('status', 1)->distinct()->get()->count();
                if ($rows > 0) {
                    return back()->with('errorMessage', ' ???????????? ??????????????? ????????? ??????????????????');
                } else {
                    $result = DB::table('user_type')->insert([
                        'name' => $request->name,
                        'type' => $request->type
                    ]);
                    if ($result) {
                        return back()->with('successMessage', '?????????????????????  ?????????????????????  ??????????????????');
                    } else {
                        return back()->with('errorMessage', '???????????? ?????????????????? ???????????????');
                    }
                }
            }
            else{
                return back()->with('errorMessage', '???????????? ???????????? ???????????????');
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function selectUser_type(){
        try{
            $rows = DB::table('user_type')->where('status', 1)
                ->orderBy('id', 'DESC')->Paginate(10);
            return view('backend.user_type', ['user_types' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function selectUser(){
        try{
            $rows = DB::table('users')
                ->select('*','user_type.name as designation','users.name as name','users.id as u_id')
                ->join('user_type','users.user_type','=','user_type.id')
                ->orderBy('users.id', 'DESC')
                ->Paginate(10);
            return view('backend.user', ['users' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function selectUserFromUserPanel(Request  $request){
        try{
            if($request->userType =="All"){
                $rows = DB::table('users')
                    ->select('*','user_type.name as designation','users.name as name','users.id as u_id')
                    ->join('user_type','users.user_type','=','user_type.id')
                    ->orderBy('users.id', 'DESC')
                    ->Paginate(10);
            }
            else{
                $rows = DB::table('users')
                    ->select('*','user_type.name as designation','users.name as name','users.id as u_id')
                    ->join('user_type','users.user_type','=','user_type.id')
                    ->where('user_type', $request->userType)
                    ->orderBy('users.id', 'DESC')
                    ->Paginate(10);
            }

            return view('backend.user', ['users' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }

    public function getUserListByID(Request $request){
        try{
            $rows = DB::table('users')
                ->where('id', $request->id)
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertUser(Request $request){
        try{
            //dd($request);
                if($request) {
                    if ($request->id){
                        $username = $request->name;
                        $email = $request->email;
                        $phone = $request->phone;
                        $password = Hash::make($request->password);
                        $gender = $request->gender;
                        $addressGroup = $request->addressGroup;
                        $add_part1 = $request->div_id;
                        $address = $request->address;
                        $user_type = $request->user_type;
                        $userPhotoPath = "";
                        $userPhotoIdPath = "";
                        $nid = "";
                        if ($request->hasFile('user_photo')) {
                            $targetFolder = 'public/asset/images/';
                            $file = $request->file('user_photo');
                            $pname = time() . '.' . $file->getClientOriginalName();
                            $image['filePath'] = $pname;
                            $file->move($targetFolder, $pname);
                            $userPhotoPath = $targetFolder . $pname;
                        }
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
                        if ($user_type == 5 || $user_type == 6 || $user_type == 7) {
                            $nid = $request->nid;
                            if ($request->hasFile('photoId')) {
                                $targetFolder = 'public/asset/images/';
                                $file = $request->file('photoId');
                                $pIname = time() . '.' . $file->getClientOriginalName();
                                $image['filePath'] = $pIname;
                                $file->move($targetFolder, $pIname);
                                $userPhotoIdPath = $targetFolder . $pIname;
                            }

                        }
                        $result =DB::table('users')
                            ->where('id', $request->id)
                            ->update([
                                'name' => $username,
                                'email' => $email,
                                'password' => $password,
                                'phone' => $phone,
                                'gender' => $gender,
                                'address_type' => $addressGroup,
                                'add_part1' => $add_part1,
                                'add_part2' => $add_part2,
                                'add_part3' => $add_part3,
                                'add_part4' => $add_part4,
                                'add_part5' => $add_part5,
                                'address' => $address,
                                'status' => 1,
                                'photo' => $userPhotoPath,
                                'nid' => $nid,
                                'photoid' => $userPhotoIdPath,
                                'working_status' => 1,
                            ]);
                        if ($result) {
                            if($user_type == 13){
                                $result = DB::table('doctors')
                                    ->where('doctor_id', $request->id)
                                    ->update([
                                    'dept_name_id' => $request->doc_department,
                                    'hos_name_id' => $request->doc_hospital,
                                    'designation' => $request->designation,
                                    'current_institute' => $request->currentInstitute,
                                    'education' => $request->education,
                                    'specialized' => $request->specialized,
                                    'experience' => $request->experience,
                                    'fees' => $request->fees,
                                    'address' => $request->pa_address,
                                    'days' => json_encode($request->days),
                                    'device_token' => $request->device
                                ]);
                            }
                            return back()->with('successMessage', '?????????????????????  ?????????????????????  ??????????????????');
                        } else {
                            return back()->with('errorMessage', '???????????? ?????????????????? ???????????????');
                        }
                    }
                    else{
                        $rows = DB::table('users')
                            ->where('phone', $request->phone)
                            ->orwhere('email', $request->email)
                            ->distinct()->get()->count();
                        if ($rows > 0) {
                            return back()->with('errorMessage', ' ???????????? ??????????????? ??????????????????');
                        } else {
                            $username = $request->name;
                            $email = $request->email;
                            $phone = $request->phone;
                            $password = Hash::make($request->password);
                            $gender = $request->gender;
                            $addressGroup = $request->addressGroup;
                            $add_part1 = $request->div_id;
                            $address = $request->address;
                            $user_type = $request->user_type;
                            $userPhotoPath = "";
                            $userPhotoIdPath = "";
                            $nid = "";
                            if ($request->hasFile('user_photo')) {
                                $targetFolder = 'public/asset/images/';
                                $file = $request->file('user_photo');
                                $pname = time() . '.' . $file->getClientOriginalName();
                                $image['filePath'] = $pname;
                                $file->move($targetFolder, $pname);
                                $userPhotoPath = $targetFolder . $pname;
                            }
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
                            if ($user_type == 5 || $user_type == 6 || $user_type == 7) {
                                $nid = $request->nid;
                                if ($request->hasFile('photoId')) {
                                    $targetFolder = 'public/asset/images/';
                                    $file = $request->file('photoId');
                                    $pIname = time() . '.' . $file->getClientOriginalName();
                                    $image['filePath'] = $pIname;
                                    $file->move($targetFolder, $pIname);
                                    $userPhotoIdPath = $targetFolder . $pIname;
                                }

                            }
                            $result = DB::table('users')->insert([
                                'name' => $username,
                                'email' => $email,
                                'password' => $password,
                                'phone' => $phone,
                                'gender' => $gender,
                                'address_type' => $addressGroup,
                                'add_part1' => $add_part1,
                                'add_part2' => $add_part2,
                                'add_part3' => $add_part3,
                                'add_part4' => $add_part4,
                                'add_part5' => $add_part5,
                                'address' => $address,
                                'user_type' => $user_type,
                                'status' => 1,
                                'photo' => $userPhotoPath,
                                'nid' => $nid,
                                'photoid' => $userPhotoIdPath,
                                'working_status' => 1,
                            ]);
                            if ($result) {
                                if($user_type == 7){
                                    $dealer_id = DB::getPdo()->lastInsertId();
                                    DB::insert("INSERT INTO product_assign (product_id, dealer_id, edit_price)
                                    SELECT id,$dealer_id,price
                                        FROM products");
                                }
                                if($user_type == 13){
                                    $doctor_id = DB::getPdo()->lastInsertId();
                                    $result = DB::table('doctors')->insert([
                                        'doctor_id' => $doctor_id,
                                        'dept_name_id' => $request->doc_department,
                                        'hos_name_id' => $request->doc_hospital,
                                        'designation' => $request->designation,
                                        'current_institute' => $request->currentInstitute,
                                        'education' => $request->education,
                                        'specialized' => $request->specialized,
                                        'experience' => $request->experience,
                                        'fees' => $request->fees,
                                        'address' => $request->pa_address,
                                        'in_time' => $request->intime,
                                        'in_timezone' => $request->intimezone,
                                        'out_time' => $request->outtime,
                                        'out_timezone' => $request->outtimezone,
                                        'days' => json_encode($request->days),
                                    ]);
                                }
                                return back()->with('successMessage', '?????????????????????  ?????????????????????  ??????????????????');
                            } else {
                                return back()->with('errorMessage', '???????????? ?????????????????? ???????????????');
                            }
                        }
                    }
                }
            else{
                return back()->with('errorMessage', '???????????? ???????????? ???????????????');
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getWardListAll(Request $request){
        try{
            $rows = DB::table('wards')
                ->where('uni_id', $request->id)
                ->where('status', 1)
                ->get();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getC_wardListAll(Request $request){
        try{
            $rows = DB::table('c_wards')
                ->where('thana_id', $request->id)
                ->where('status', 1)
                ->get();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getAllUserType(Request $request){
        try{
            $rows = DB::table('user_type')
                ->where('status', 1)
                ->get();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteUser(Request $request){
        try{

            if($request->id) {
                $result =DB::table('users')
                    ->where('id', $request->id)
                    ->update([
                        'status' =>  0,
                    ]);
                if ($result) {
                    return back()->with('successMessage', '?????????????????????  ?????????????????????  ??????????????????');
                } else {
                    return back()->with('errorMessage', '???????????? ?????????????????? ???????????????');
                }
            }
            else{
                return back()->with('errorMessage', '???????????? ?????????????????? ???????????????');
            }

        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function about_us(Request $request){
        try{
            $rows = DB::table('about_us')
                ->get();
            return view('backend.about_us', ['abouts' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertAboutUs(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('about_us')
                        ->where('id', $request->id)
                        ->update([
                            'about' => $request->name
                        ]);
                    if ($result) {
                        return back()->with('successMessage', '?????????????????????  ?????????????????????  ??????????????????');
                    } else {
                        return back()->with('errorMessage', '???????????? ?????????????????? ???????????????');
                    }
                }
                else {
                    $rows = DB::table('about_us')->select('id')->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' ?????????????????? ???????????????????????? ???????????? ???????????????????????????????????????');
                    } else {
                        $result = DB::table('about_us')->insert([
                            'about' => $request->name,
                        ]);
                        if ($result) {
                            return back()->with('successMessage', '?????????????????????  ?????????????????????  ??????????????????');
                        } else {
                            return back()->with('errorMessage', '???????????? ?????????????????? ???????????????');
                        }
                    }
                }
            }
            else{
                return back()->with('errorMessage', '???????????? ???????????? ???????????????');
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function insertContactUs(Request $request){
        try{
            $result = DB::table('contact_us')->insert([
                'name' => $request->name,
                'phone' => $request->phone,
                'purpose' => $request->purpose,
            ]);
            if ($result) {
                return back()->with('successMessage', '??????????????? ???????????????????????? ????????????????????? ???????????? ????????????????????????');
            } else {
                return back()->with('errorMessage', '???????????? ?????????????????? ???????????????');
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getAboutUS(Request $request){
        try{
            $rows = DB::table('about_us')
                ->where('id', $request->id)
                ->first();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function contact_us(Request $request){
        try{
            $rows = DB::table('contact_us')
                ->orderBy('id','desc')
                ->paginate();
            return view('backend.contact_us', ['lists' => $rows]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getContactUs(Request $request){
        try{
            $rows = DB::table('contact_us')
                ->where('id', $request->id)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getHospitalListAll(Request $request){
        try{
            $rows = DB::table('hospitals')
                ->where('dept', $request->id)
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getAllMedDept(Request $request){
        try{
            $rows = DB::table('med_departments')
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getMealTypeAll(Request $request){
        try{
            $rows = DB::table('meal_time')
                ->where('m_time', $request->id)
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    function en2bn($number) {
        $replace_array= array("???", "???", "???", "???", "???", "???", "???", "???", "???", "???");
        $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $bn_number = str_replace($search_array, $replace_array, $number);
        return $bn_number;
    }
    public function myProductOrder(Request $request){
        try{
            $id = Cookie::get('user_id');
            $order_details = DB::table('order_details')->where('user_id', $id)->get();
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
                        $v_id = $volunteer->id;
                        $phone = $volunteer->phone;
                    } else {
                        $name = "Not Assigned";
                        $v_id = " ";
                        $phone = "Not Assigned";
                     }
                    if ($row->v_status == 0) $status = "Processing";
                    if ($row->v_status == 2) $status = "Assigned";
                    if ($row->v_status == 3) $status = "On the service";
                    if ($row->v_status == 4) $status = "Delivered";
                    $date = explode(' ',$order->created_at);
                    $orderArr[$i]['sales_date'] = $date[0];
                    $orderArr[$i]['name'] = $order->name;
                    $orderArr[$i]['address'] = $add_part1->name.' ,'.$add_part2->name.' ,'.$add_part3->name.' ,'.$add_part4->name.' ,'.$add_part5->name.' ,'.$order->address;
                    $orderArr[$i]['pay_id'] = $order->tx_id;
                    $orderArr[$i]['amount'] = $order->total + $order->discount + $order->delivery_charge;;
                    $orderArr[$i]['v_id'] = $v_id;
                    $orderArr[$i]['v_name'] = $name;
                    $orderArr[$i]['user_id'] = $row->user_id;
                    $orderArr[$i]['status'] = $status;
                    $orderArr[$i]['deliver_phone'] = $phone;
                    $orderArr[$i]['sales_id'] = $order->tx_id;
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
            return view('frontend.myProductOrder', ['orders' => $paginatedItems,'sum' => $sum]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function myAnimalOrder(){
        try{

            $aminal_Sale = DB::table('sale_products')
                ->select('*','sale_products.id as salePID', 'sale_products.name as salName',
                    'sale_products.photo as salPPhoto','u1.name as buyerName','u1.phone as buyerPhone','u2.phone as sellerPhone')
                ->join('animal_sales', 'sale_products.id', '=', 'animal_sales.product_id')
                ->join('users as u1', 'u1.id', '=', 'animal_sales.buyer_id')
                ->join('users as u2', 'u2.id', '=', 'animal_sales.seller_id')
                ->where('u1.id', Cookie::get('user_id'))
                ->where('sale_products.sale_status', 0)
                ->paginate(10);

            return view('frontend.myAnimalOrder', ['aminal_Sales' => $aminal_Sale]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function myTicketOrder(){
        try{
            $ticket_Sale = DB::table('ticket_booking')
                ->join('users', 'ticket_booking.user_id', '=', 'users.id')
                ->where('user_id', Cookie::get('user_id'))
                ->orderBy('ticket_booking.id','desc')
                ->paginate(10);
            return view('frontend.myTicketOrder', ['ticket_Sales' => $ticket_Sale]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function myDrAppointment(){
        $rows = DB::table('dr_apportionment')
            ->select('*','dr_apportionment.id as a_id','a.phone as dr_phone','b.phone as p_phone','a.name as dr_name')
            ->join('users as a','a.id','=','dr_apportionment.dr_id')
            ->join('users as b','b.id','=','dr_apportionment.user_id')
            ->where('b.id', Cookie::get('user_id'))
            ->orderBy('dr_apportionment.id','desc')
            ->paginate('20');
        return view('frontend.myDrAppointment',['drReports' => $rows]);
    }
    public function myTherapyAppointment(){
        $rows = DB::table('therapy_appointment')
            ->select('*')
            ->join('users','users.id','=','therapy_appointment.user_id')
            ->join('therapyfees as a','a.id','=','therapy_appointment.therapy_fees_id')
            ->join('therapy_center','therapy_center.id','=','a.therapy_center_id')
            ->join('therapy_services','therapy_services.id','=','a.therapy_name_id')
            ->where('users.id', Cookie::get('user_id'))
            ->orderBy('therapy_appointment.id','desc')
            ->paginate('20');
        return view('frontend.myTherapyAppointment',['therapyReports' => $rows]);
    }
    public function myDiagnosticAppointment(){
        $rows = DB::table('diagonostic_appointment')
            ->select('*')
            ->join('users','users.id','=','diagonostic_appointment.user_id')
            ->join('diagnostic_fees as a','a.id','=','diagonostic_appointment.diagnostic_fees_id')
            ->join('diagnostic_center','diagnostic_center.id','=','a.diagnostic_center_id')
            ->join('diagnostic_test','diagnostic_test.id','=','a.diagnostic_test_id')
            ->where('users.id', Cookie::get('user_id'))
            ->orderBy('diagonostic_appointment.id','desc')
            ->paginate('20');
        //dd($rows);
        return view('frontend.myDiagnosticAppointment',['diagnosticReports' => $rows]);
    }
    public function myTransportOrder(Request $request){
        $rows = DB::table('ride_booking')
            ->where('user_id', Cookie::get('user_id'))
            ->orderBy('id','desc')
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
        return view('frontend.myTransportOrder',['bookings' => $paginatedItems]);
    }
    public function myCookingOrder (){
        try{
            $cooking = DB::table('cooking_booking')
                ->select('*','a.name as u_name','a.phone as  u_phone')
                ->join('users as a', 'a.id', '=', 'cooking_booking.user_id')
                ->join('users as b', 'b.id', '=', 'cooking_booking.cooker_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->where('cooking_booking.user_id', Cookie::get('user_id'))
                ->paginate(20);
            return view('frontend.myCookingOrder',['cookings' =>$cooking]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function myClothWashingOrder (Request  $request){
        try{
            $washing = DB::table('cloth_washing_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','cloth_washing_order.id as c_id')
                ->join('users as a', 'a.id', '=', 'cloth_washing_order.user_id')
                ->join('users as b', 'b.id', '=', 'cloth_washing_order.cleaner_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->where('cloth_washing_order.user_id', Cookie::get('user_id'))
                ->orderBy('cloth_washing_order.id','desc')
                ->paginate(20);
            return view('frontend.myClothWashingOrder',['washings' =>$washing]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getClothWashingByIdUser(Request $request){
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
    public function myRoomCleaningOrder (Request  $request){
        try{
            $washing = DB::table('cleaning_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','cleaning_order.id as c_id')
                ->join('users as a', 'a.id', '=', 'cleaning_order.user_id')
                ->join('users as b', 'b.id', '=', 'cleaning_order.cleaner_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->where('cleaning_order.user_id', Cookie::get('user_id'))
                ->orderBy('cleaning_order.id','desc')
                ->paginate(20);
            return view('frontend.myRoomCleaningOrder',['washings' =>$washing]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function myHelpingHandOrder (Request  $request){
        try{
            $washing = DB::table('helping_hand_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','helping_hand_order.id as c_id')
                ->join('users as a', 'a.id', '=', 'helping_hand_order.user_id')
                ->join('users as b', 'b.id', '=', 'helping_hand_order.helper')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->where('helping_hand_order.user_id', Cookie::get('user_id'))
                ->orderBy('helping_hand_order.id','desc')
                ->paginate(20);
            return view('frontend.myHelpingHandOrder',['washings' =>$washing]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function myGuardOrder (Request  $request){
        try{
            $washing = DB::table('guard_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','guard_order.id as c_id')
                ->join('users as a', 'a.id', '=', 'guard_order.user_id')
                ->join('users as b', 'b.id', '=', 'guard_order.gurd_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->where('guard_order.user_id', Cookie::get('user_id'))
                ->orderBy('guard_order.id','desc')
                ->paginate(20);
            return view('frontend.myGuardOrder',['washings' =>$washing]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function myProductServicingOrder (Request  $request){
        try{

            $washing = DB::table('various_servicing_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','various_servicing_order.name as v_name')
                ->join('users as a', 'a.id', '=', 'various_servicing_order.user_id')
                ->join('users as b', 'b.id', '=', 'various_servicing_order.worker')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->where('various_servicing_order.user_id', Cookie::get('user_id'))
                ->orderBy('various_servicing_order.id','desc')
                ->paginate(20);
            return view('frontend.myProductServicingOrder',['washings' =>$washing]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function myLaundryOrder (Request  $request){
        try{
            $washing = DB::table('laundry_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','laundry_order.id as c_id')
                ->join('users as a', 'a.id', '=', 'laundry_order.user_id')
                ->join('users as b', 'b.id', '=', 'laundry_order.cleaner_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->where('laundry_order.user_id', Cookie::get('user_id'))
                ->orderBy('laundry_order.id','desc')
                ->paginate(20);
            return view('frontend.myLaundryOrder',['washings' =>$washing]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getLaundryWashingByIdUser(Request $request){
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
    public function myParlorOrder  (Request  $request){
        try{
            $washing = DB::table('parlor_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','parlor_order.name as v_name')
                ->join('users as a', 'a.id', '=', 'parlor_order.user_id')
                ->join('users as b', 'b.id', '=', 'parlor_order.parlor_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->where('parlor_order.user_id', Cookie::get('user_id'))
                ->orderBy('parlor_order.id','desc')
                ->paginate(20);
            return view('frontend.myParlorOrder',['washings' =>$washing]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function deliveryProfile(Request $request){
        try{

            $id = Cookie::get('user_id');
            $stmt= DB::table('v_assign')
                ->select('*','v_assign.id AS salesid','v_assign.v_id AS v_id')
                ->join('users', 'users.id', '=', 'v_assign.v_id')
                ->where('v_assign.v_id',$id)
                ->orderBy('v_assign.sales_date','desc')
                ->get();
            //dd($stmt);
            $orderArr =array();
            $i=0;
            $sum=0;
            foreach($stmt as $row) {
                $dealer = DB::table('users')
                    ->where('add_part1', $row->add_part1)
                    ->where('add_part2', $row->add_part2)
                    ->where('add_part3', $row->add_part3)
                    ->where('address_type', $row->address_type)
                    ->where('user_type', 7)
                    ->first();
                if (isset($dealer->id))
                    $dealer_id = $dealer->id;
                else
                    $dealer_id = "";
                $stmt2 = DB::table('details')
                    ->join('products', 'products.id', '=', 'details.product_id')
                    ->join('product_assign', 'product_assign.product_id', '=', 'products.id')
                    ->where('product_assign.dealer_id', $dealer_id)
                    ->where('details.sales_id', $row->salesid)
                    ->orderBy('products.id', 'Desc')
                    ->get();
                $total = 0;
                foreach ($stmt2 as $details) {
                    if ($details->quantity > 101) {
                        $quantity = $details->quantity / 1000;
                    } else {
                        $quantity = $details->quantity;
                    }
                    $subtotal = $details->edit_price * $quantity;
                    $total += $subtotal;
                }
                $rows = DB::table('delivery_charges')
                    ->where('lower','<=', $total)
                    ->where('higher','>=', $total)
                    ->first();
                $delivery_charge = $rows->charge;
                $row1 = DB::table('users')
                    ->where('id', $row->v_id)
                    ->get();
                $volunteer = DB::table('users')
                    ->where('id', $row->v_id)
                    ->first();
                $customer = DB::table('users')
                    ->where('id', $row->user_id)
                    ->first();
                if ($row1->count() > 0) {
                    $name = $volunteer->name;
                    $v_id = "profile.php?id=" . $volunteer->id;
                } else {
                    $name = "Not Assigned";
                    $v_id = " ";
                }
                if ($row->v_status == 0) $status = "Processing";
                if ($row->v_status == 2) $status = "Assigned";
                if ($row->v_status == 3) $status = "On the Working";
                if ($row->v_status == 4) $status = "Delivered";
                $orderArr[$i]['sales_date'] = $row->sales_date;
                $orderArr[$i]['name'] = $row->name;
                $orderArr[$i]['address'] = $row->address;
                $orderArr[$i]['pay_id'] = $row->pay_id;
                $orderArr[$i]['amount'] =   $this->en2bn(number_format($total+$delivery_charge , 2)).'/-';
                $orderArr[$i]['v_id'] =$v_id;
                $orderArr[$i]['v_name'] =$name;
                $orderArr[$i]['user_id'] =$row->user_id;
                $orderArr[$i]['status'] =$status;
                $orderArr[$i]['sales_id'] =$row->salesid;
                $orderArr[$i]['phone'] =$customer->phone;
                $sum = $sum+$total+$delivery_charge;
                $i++;
            }
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $itemCollection = collect($orderArr);
            $perPage = 10;
            $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
            $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
            $paginatedItems->setPath($request->url());

            $id = Cookie::get('user_id');
            $user_info = DB::table('users')
                ->select('user_type.name as desig', 'users.*')
                ->join('user_type', 'user_type.id', '=', 'users.user_type')
                ->where('users.id', $id)
                ->where('users.status', 1)
                ->first();
            $users['info'] = $user_info;
            return view('backend.deliveryProfile', ['orders' => $paginatedItems,'sum' => $this->en2bn($sum).'/-','users' => $users]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function myVariousProductOrderUser(){
        try{
            $products = DB::table('product_sales')
                ->select('*','product_sales.id as ps_id','a.address as ps_address')
                ->join('seller_product as a','product_sales.product_id','=','a.id')
                ->where('product_sales.buyer_id', Cookie::get('user_id'))
                ->orderBy('product_sales.id','desc')
                ->paginate(20);
            return view('frontend.myVariousProductOrder',['orders' => $products]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function changeWorkingStatusProvider(Request  $request){
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
                if($result){
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
                if($result){
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
                if($result){
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
    public function myCourierOrder(Request $request){
        $rows = DB::table('courier_booking')
            ->select('*','naming1s.name as n_name','courier_type.name as c_name','courier_status.status as c_status','courier_status.id as c_id','courier_status.c_id as cc_id')
            ->join('courier_type','courier_type.id','=','courier_booking.type')
            ->join('courier_status','courier_status.c_id','=','courier_booking.id')
            ->join('naming1s','naming1s.id','=','courier_booking.f_country')
            ->where('user_id',Cookie::get('user_id'))
            ->orderBy('courier_booking.id','desc')
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
        return view('frontend.myCourierOrder',['bookings' => $paginatedItems]);
    }
    public function myToursNTravelsOrder(){
        try{
            $results = DB::table('bookingtnt')
                ->select('*','bookingtnt.price as f_price')
                ->join('toor_booking2','toor_booking2.id','=','bookingtnt.pack_id')
                ->join('toor_booking1','toor_booking1.id','=','toor_booking2.name_id')
                ->where('bookingtnt.user_id', Cookie::get('user_id'))
                ->orderBy('bookingtnt.id','desc')
                ->paginate(20);
            return view('frontend.myToursNTravels',['orders' => $results]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function m_acc(){
        try{
            $row = DB::table('m_acc')
                ->orderBy('date','desc')
                ->paginate(50);
            return view('backend.m_acc', ['accountings' => $row]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getAllCompany(){
        try{
            $rows = DB::table('company_name')->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function getAllProject(){
        try{
            $rows = DB::table('project_name')->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertM_acc(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('m_acc')
                        ->where('id', $request->id)
                        ->update([
                            'company' => $request->company,
                            'project' => $request->project,
                            'type' => $request->type,
                            'purpose' => $request->purpose,
                            'reference' => $request->reference,
                            'amount' => $request->amount,
                            'date' => $request->date,
                            'person' => $request->person,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', '?????????????????????  ?????????????????????  ??????????????????');
                    } else {
                        return back()->with('errorMessage', '???????????? ?????????????????? ???????????????');
                    }
                }
                else {
                    $rows = DB::table('m_acc')
                        ->select('id')
                        ->where([
                            ['company', '=', $request->company],
                            ['project', '=', $request->project],
                            ['type', '=', $request->type],
                            ['purpose', '=', $request->purpose],
                            ['amount', '=', $request->amount],
                            ['date', '=', $request->date],
                            ['person', '=', $request->person],
                        ])
                        ->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' ???????????? ???????????? ?????????');
                    } else {
                        $result = DB::table('m_acc')->insert([
                            'company' => $request->company,
                            'project' => $request->project,
                            'type' => $request->type,
                            'purpose' => $request->purpose,
                            'reference' => $request->reference,
                            'amount' => $request->amount,
                            'date' => $request->date,
                            'person' => $request->person,
                        ]);
                        if ($result) {
                            return back()->with('successMessage', '?????????????????????  ?????????????????????  ??????????????????');
                        } else {
                            return back()->with('errorMessage', '???????????? ?????????????????? ???????????????');
                        }
                    }
                }
            }
            else{
                return back()->with('errorMessage', '???????????? ???????????? ???????????????');
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getM_accReportByDate (Request $request){
        $row = DB::table('m_acc')
            ->whereBetween('date',array($request->from_date,$request->to_date))
            ->orderBy('date', 'Desc')->paginate(50);
        return view('backend.m_acc', ['accountings' => $row,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
    }
    public function getM_accListById(Request $request){
        try{
            $rows = DB::table('m_acc')
                ->where('id', $request->id)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
}
