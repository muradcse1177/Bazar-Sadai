<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function verifyUsers(Request $request){
        try{
            if($request->login == "login"){
                $phone = $request->phone;
                $password = $request->password;
                $rows = DB::table('users')
                    ->where('phone', $phone)
                    ->get()->count();
                if ($rows > 0) {
                    $rows = DB::table('users')
                        ->where('phone', $phone)
                        ->first();
                    if (Hash::check($password, $rows->password)) {
                        $role = $rows->user_type;
                        Session::put('user_info', $rows);
                        Cookie::queue('user', $rows->id, time()+31556926 ,'/');
                        Cookie::queue('user_id', $rows->id, time()+31556926 ,'/');
                        Cookie::queue('user_name', $rows->name, time()+31556926 ,'/');
                        Cookie::queue('user_type', $rows->user_type, time()+31556926 ,'/');
                        Cookie::queue('user_photo', $rows->photo, time()+31556926 ,'/');

                        if($role==1 || $role==2 || $role==8){
                            Cookie::queue('admin', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('dashboard');
                        }
                        elseif($role==3){
                            Cookie::queue('buyer', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('homepage');
                        }
                        elseif($role==4){
                            Cookie::queue('seller', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('sellerForm');
                        }
                        elseif($role==5){
                            Cookie::queue('delivery', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('deliveryProfile');
                        }
                        elseif($role==7){
                            Cookie::queue('dealer', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('dealerProfile');
                        }
                        elseif ($role==12){
                            Cookie::queue('dataOperator', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('product');
                        }
                        elseif ($role==11){
                            Cookie::queue('accounting', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('accounting');
                        }
                        elseif ($role==13){
                            Cookie::queue('doctor', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('doctorServiceArea');
                        }
                        elseif($role==15){
                            Cookie::queue('pharmacy', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('myMedicineSale');
                        }
                        elseif($role==16){
                            Cookie::queue('cooker', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('cookerProfile');
                        }
                        elseif($role==17 ||$role==18 ||$role==19 ||$role==20||$role==32){
                            Cookie::queue('rider', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('riderServiceArea');
                        }
                        elseif($role==21){
                            Cookie::queue('clothCleaner', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('clothCleanerProfile');
                        }
                        elseif($role==22){
                            Cookie::queue('laundry', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('laundryProfile');
                        }
                        elseif($role==23){
                            Cookie::queue('roomCleaner', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('roomCleanerProfile');
                        }
                        elseif($role==24){
                            Cookie::queue('tankCleaner', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('tankCleanerProfile');
                        }
                        elseif($role==25){
                            Cookie::queue('helpingHand', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('helpingHandProfile');
                        }
                        elseif($role==26){
                            Cookie::queue('guard', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('guardProfile');
                        }
                        elseif($role==27){
                            Cookie::queue('stove', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('stoveProfile');
                        }
                        elseif($role==28){
                            Cookie::queue('electronics', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('electronicsProfile');
                        }
                        elseif($role==29){
                            Cookie::queue('sanitary', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('sanitaryProfile');
                        }
                        elseif($role==30){
                            Cookie::queue('ac', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('acProfile');
                        }
                        elseif($role==31){
                            Cookie::queue('parlor', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('parlorProfile');
                        }
                        elseif($role==33){
                            Cookie::queue('courier', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('courierProfile');
                        }
                        elseif($role==34){
                            Cookie::queue('tnt', $rows->id, time()+31556926 ,'/');
                            return redirect()->to('tntProfile');
                        }
                        else{
                            return redirect()->to('login');
                        }
                    }
                    else{
                        return back()->with('errorMessage', '??????????????????????????? ????????? ????????????????????????');
                    }
                } else {
                    return back()->with('errorMessage', '?????????????????? ??????????????? ?????????????????? ?????????');
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
    public function verifyUserFromCheckout(Request $request){
        try{
            if($request->login == "login"){
                $phone = $request->phone;
                $password = $request->password;
                $rows = DB::table('users')
                    ->where('phone', $phone)
                    ->get()->count();
                if ($rows > 0) {
                    $rows = DB::table('users')
                        ->where('phone', $phone)
                        ->first();
                    $role = $rows->user_type;
                    if($role == 3){
                        Cookie::queue('buyer', $rows->id, time()+31556926 ,'/');
                        if (Hash::check($password, $rows->password)) {
                            Session::put('user_info', $rows);
                            Cookie::queue('user', $rows->id, time()+31556926 ,'/');
                            Cookie::queue('user_id', $rows->id, time()+31556926 ,'/');
                            Cookie::queue('user_name', $rows->name, time()+31556926 ,'/');
                            Cookie::queue('user_type', $rows->user_type, time()+31556926 ,'/');
                            Cookie::queue('user_photo', $rows->photo, time()+31556926 ,'/');
                            return redirect()->to('checkout');
                        }
                        else{
                            return back()->with('errorMessage', '??????????????????????????? ????????? ????????????????????????');
                        }
                    }
                    else{
                        return back()->with('errorMessage', '?????????????????? ?????????????????? ???????????? ??????/?????? ?????? ???????????????');
                    }
                } else {
                    return back()->with('errorMessage', '?????????????????? ??????????????? ?????????????????? ?????????');
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
    public function logout(){
        Cookie::queue(Cookie::forget('user','/'));
        Cookie::queue(Cookie::forget('user_id','/'));
        Cookie::queue(Cookie::forget('user_name','/'));
        Cookie::queue(Cookie::forget('user_type','/'));
        Cookie::queue(Cookie::forget('user_photo','/'));
        Cookie::queue(Cookie::forget('admin','/'));
        Cookie::queue(Cookie::forget('buyer','/'));
        Cookie::queue(Cookie::forget('delivery','/'));
        Cookie::queue(Cookie::forget('dataOperator','/'));
        Cookie::queue(Cookie::forget('accounting','/'));
        Cookie::queue(Cookie::forget('pharmacy','/'));
        Cookie::queue(Cookie::forget('seller','/'));
        Cookie::queue(Cookie::forget('dealer','/'));
        Cookie::queue(Cookie::forget('rider','/'));
        Cookie::queue(Cookie::forget('doctor','/'));
        Cookie::queue(Cookie::forget('cooker','/'));
        Cookie::queue(Cookie::forget('clothCleaner','/'));
        Cookie::queue(Cookie::forget('laundry','/'));
        Cookie::queue(Cookie::forget('roomCleaner','/'));
        Cookie::queue(Cookie::forget('tankCleaner','/'));
        Cookie::queue(Cookie::forget('helpingHand','/'));
        Cookie::queue(Cookie::forget('guard','/'));
        Cookie::queue(Cookie::forget('stove','/'));
        Cookie::queue(Cookie::forget('electronics','/'));
        Cookie::queue(Cookie::forget('sanitary','/'));
        Cookie::queue(Cookie::forget('ac','/'));
        Cookie::queue(Cookie::forget('parlor','/'));
        Cookie::queue(Cookie::forget('courier','/'));
        Cookie::queue(Cookie::forget('tnt','/'));
        session()->forget('user_info');
        session()->flush();
        session()->save();
        return redirect()->to('homepage');
    }
    public function getAllUserTypeSignUp(Request $request){
        try{
            $rows = DB::table('user_type')
                ->where('type', 2)
                ->get();

            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertNewUser(Request $request){
        try{
            if($request) {
                //dd($request);
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
                    $address = $request->address;
                    $user_type = $request->user_type;
                    $nid = "";
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
                        $add_part5 = $request->naming5;
                    }
                    if ($user_type == 5 || $user_type == 6 || $user_type == 7) {
                        $nid = $request->nid;
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
                        'nid' => $nid,
                        'working_status' => 1,
                        'device_token' => $request->device
                    ]);
                    if ($result) {
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
                                'days' => json_encode($request->days),
                            ]);
                        }
                        if($user_type == 15) {
                            $pharmacy_id = DB::getPdo()->lastInsertId();
                            $result = DB::table('pharmacy')->insert([
                                'user_id' => $pharmacy_id,
                                'pharmacy_name' => $request->p_name,
                                'pharmacy_address' => $request->p_address,
                            ]);
                        }
                        if($user_type == 16){
                            $Cooker_id = DB::getPdo()->lastInsertId();
                            $result = DB::table('cookers')->insert([
                                'cooker_id' => $Cooker_id,
                                'mealtype' => $request->mealtype,
                                'meal' => $request->meal,
                                'mealtime' => $request->mealtime,
                            ]);
                        }
                        $rows = DB::table('users')
                            ->where('phone', $phone)
                            ->first();
                        $user = $rows->id;
                        $role = $rows->user_type;
                        Cookie::queue('user', $user, time()+31556926 ,'/');
                        Cookie::queue('role', $role, time()+31556926 ,'/');
                        return redirect()->to('login');
                        //return redirect()->to('login')->with('errorMessage', '?????????????????????  ?????????????????????  ?????????????????? ?????? ?????? ??????????????? ');
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
    public function profile(){
        try{
            if(Cookie::get('user_id')) {
                $id = Cookie::get('user_id');
                $user_info = DB::table('users')
                    ->select('user_type.name as desig', 'users.*')
                    ->join('user_type', 'user_type.id', '=', 'users.user_type')
                    ->where('users.id', $id)
                    ->where('users.status', 1)
                    ->first();
                $users['info'] = $user_info;
                if(Cookie::get('user_type') == 3) {
                    $buyer_sold_lst = DB::table('sale_products')
                        ->select('*','sale_products.id as salePID', 'sale_products.name as salName', 'sale_products.photo as salPPhoto')
                        ->join('animal_sales', 'sale_products.id', '=', 'animal_sales.product_id')
                        ->join('users', 'users.id', '=', 'animal_sales.seller_id')
                        ->where('animal_sales.buyer_id', $id)
                        ->where('sale_products.sale_status', 0)
                        ->get();
                }
                return view('frontend.profile', ['users' => $users]);
            }
            else{
                return redirect()->to('/');
            }
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function transaction(Request $request){
        try{
            $id= $request->id;

            $output = array('list'=>'');
            $order_details = DB::table('order_details')
                ->where('tx_id',$id)
                ->first();
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
            $stmt= DB::table('v_assign')
                ->where('v_assign.pay_id', $id)
                ->first();
            if($stmt->user_id == 0){
                $stmt2= DB::table('details')
                    ->join('products', 'products.id', '=', 'details.product_id')
                    ->join('v_assign', 'v_assign.id', '=', 'details.sales_id')
                    ->where('details.sales_id', $stmt->id)
                    ->orderBy('products.id','Asc')
                    ->get();
            }
            else{
                $stmt2= DB::table('details')
                    ->join('products', 'products.id', '=', 'details.product_id')
                    ->join('v_assign', 'v_assign.id', '=', 'details.sales_id')
                    ->join('product_assign','product_assign.product_id', '=','products.id')
                    ->where('product_assign.dealer_id',$dealer->id)
                    ->where('details.sales_id', $stmt->id)
                    ->orderBy('products.id','Asc')
                    ->get();
            }
            //dd($stmt2);
            $data = json_decode($stmt2, true);
            $total = 0;
            foreach($data as $row){

                $output['transaction'] = $row['pay_id'];
                $output['date'] = date('M d, Y', strtotime($row['sales_date']));
                if($row['quantity']>50) {
                    $quantity = $row['quantity']/1000;
                }
                else{
                    $quantity = $row['quantity'];
                }
                if($stmt->user_id == 0){
                    $price =  $row['price'];
                    $subtotal = $row['price']*$quantity;
                }
                else{
                    $price  = $row['edit_price'];
                    $subtotal = $row['edit_price']*$quantity;
                }
                $total += $subtotal;
                $output['list'] .= "
                    <tr class='prepend_items'>
                        <td>".$row['name']."</td>
                        <td> ".$this->en2bn(number_format($price, 2))."</td>
                        <td>".$this->en2bn($row['quantity'])."</td>
                        <td> ".$this->en2bn(number_format($subtotal, 2))."</td>
                    </tr>
                ";
            }

            $output['delivery_charge'] = '<b> '.$this->en2bn(number_format($order_details->delivery_charge, 2)).'<b>';
            $output['discount'] = '<b> '.$this->en2bn(number_format($order_details->discount, 2)).'<b>';
            $output['total'] = '<b> '.$this->en2bn(number_format($order_details->total, 2)).'<b>';
            return response()->json(array('data'=>$output));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public static function en2bn($number) {
        $replace_array= array("???", "???", "???", "???", "???", "???", "???", "???", "???", "???");
        $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $bn_number = str_replace($search_array, $replace_array, $number);
        return $bn_number;
    }
    public function forgotPasswordLink(){
        return view('frontend.forgotPassForm');
    }
    public function verificationCodeForm(){
        return view('frontend.verificationCodeForm');
    }
    public function nePasswordForm(){
        return view('frontend.nePasswordForm');
    }
    public function verifyEmail(Request $request){
        $rows = DB::table('users')->where('email', $request->email)->first();
        if(!empty($rows)){
            $email = $rows->email;
            $userName = $rows->name;
            $dataNum = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(8/strlen($x)) )),1,8);
            $data = array(
                'userName'=> $userName,
                'data'=> $dataNum,
            );
            Mail::send('frontend.forgotPassEmailFormat',$data, function($message) use($email,$userName) {
                $message->to($email, $userName)->subject('Password recovery email.');
                $message->from('support@bazar-sadai.com','Bazar-sadai.com');
            });
            if (Mail::failures()) {
                return back()->with('errorMessage', '???????????? ?????????????????? ???????????????');
            }
            else{
                $result =DB::table('users')
                    ->where('id', $rows->id)
                    ->update([
                        'reset_code' => $dataNum,
                    ]);
                if($result){
                    return view('frontend.verificationCodeForm', ['id' =>  $rows->id]);
                }
                else{
                    return back()->with('errorMessage', '???????????? ?????????????????? ???????????????');
                }
            }
        }
        else{
            return back()->with('errorMessage', '?????????????????? ???????????? ??????????????? ?????????????????? ??????!');
        }
    }
    public function verifyForgetCode(Request $request){
        if($request->code){
            $rows = DB::table('users')->where('id', $request->id)->first();
            if($request->code == $rows->reset_code){
                return view('frontend.nePasswordForm', ['id' =>  $rows->id]);
            }
            else{
                return back()->with('errorMessage', '???????????? ????????? ?????????????????? ????????????!');
            }
        }
        else{
            return back()->with('errorMessage', '???????????? ???????????? ???????????????');
        }

    }
    public function passwordUpdate(Request $request){
        if($request->password){
            $password = Hash::make($request->password);
            $result =DB::table('users')
                ->where('id', $request->id)
                ->update([
                    'password' => $password,
                ]);
            if($result){
                $result =DB::table('users')
                    ->where('id', $request->id)
                    ->update([
                        'reset_code' => '',
                    ]);
                if($result){
                    return view('frontend.login');
                }
                else{
                    return back()->with('errorMessage', '???????????? ?????????????????? ???????????????');
                }
            }
            else{
                return back()->with('errorMessage', '???????????? ?????????????????? ???????????????');
            }
        }
        else{
            return back()->with('errorMessage', '???????????? ???????????? ???????????????');
        }

    }
    public  function roleAssign(){
        $result = DB::table('user_type')
            ->where('type', 1)->get();
        $attributes = DB::table('attribute')->get();
        $r_as = DB::table('role_assign')->get();
        return view('backend.roleAssignPage',['users' =>  $result,'attributes'=> $attributes,'r_as'=> $r_as]);
    }
    public function insertUserRole(Request $request){
        try{
            if($request) {
                $result =DB::table('role_assign')
                    ->where('user_type', $request->user)->get();
                if($result->count()>0){
                    return back()->with('errorMessage', '?????? ???????????? ??????????????? ???????????? ?????????????????? ???????????? ???????????? ?????????????????? ???????????????');
                }
                else{
                    $result = DB::table('role_assign')->insert([
                        'user_type' => $request->user,
                        'role' => json_encode($request->role),
                    ]);
                    if($result){
                        return back()->with('successMessage', '?????????????????????  ?????????????????????  ??????????????????');
                    }
                    else{
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
    public function roleAssignEditPage(Request $request){
        try{
            $result = DB::table('user_type')
                ->where('type', 1)->get();
            $attributes = DB::table('attribute')->get();
            $r_as = DB::table('role_assign')->get();
            return view('backend.roleAssignEditPage', ['users' => $result, 'attributes' => $attributes, 'r_as' => $r_as]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function updateUserRole(Request $request){
        try{
            if($request->id) {
                $result = DB::table('role_assign') ->where('id',$request->id)
                    ->update([
                        'user_type' => $request->user,
                        'role' => json_encode($request->role),
                    ]);
                if($result){
                    return redirect('roleAssign')->with('successMessage', '?????????????????????  ?????????????????????  ??????????????????');
                }
                else{
                    return back()->with('errorMessage', '???????????? ?????????????????? ???????????????');
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
    public function sendSMSAll($tx_id){
        $user = DB::table('users') ->where('id',Cookie::get('user_id'))->first();
        $url = "http://66.45.237.70/api.php";
        $number = $user->phone;
        $name = $user->name;
        $text="Dear, Your order is placed on Bazar-Sadai.Com.Your TX-ID:".@$tx_id.".You will get it as soon as possible.Thanks.";
        $data= array(
            'username'=>"01929877307",
            'password'=>"murad1107053",
            'number'=>"$number",
            'message'=>"$text"
        );

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        $p = explode("|",$smsresult);
        $sendstatus = $p[0];
        if($sendstatus){
            $result = DB::table('smslog')->insert([
                'number' => $number,
                'msg' => $text,
            ]);
        }
        $data = array(
            'userName'=> $user->name,
            'tx_id' => $tx_id,
        );
        $salesEmail = 'sales@bazar-sadai.com';
        $emails = [$user->email];
        Mail::send('frontend.serviceEmailFormat',$data, function($message) use($emails,$salesEmail,$name,$number) {
            $message->to($emails)->subject('Service order by '.$name.' ('.$number. ' )');
            $message->from(''.$salesEmail.'','Bazar-Sadai.Com');
        });
    }
    public function sendSMSServiceHolder($tx_id,$id){
        $user = DB::table('users') ->where('id',$id)->first();
        $number = $user->phone;
        $name = $user->email;
        $url = "http://66.45.237.70/api.php";
        if($tx_id)
            $text="Dear, Customer is placed order on Bazar-Sadai.Com.TX-ID:".@$tx_id.".Please check app/website.Thanks.";
        else
            $text="Dear, Customer is placed order on Bazar-Sadai.Com.Please check app/website.Thanks.";
        $data= array(
            'username'=>"01929877307",
            'password'=>"murad1107053",
            'number'=>"$number",
            'message'=>"$text"
        );
        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        $p = explode("|",$smsresult);
        $sendstatus = $p[0];
        if($sendstatus){
            $result = DB::table('smslog')->insert([
                'number' => $number,
                'msg' => $text,
            ]);
        }
        $data = array(
            'userName'=> $name,
            'tx_id' => @$tx_id,
        );
        $salesEmail = 'sales@bazar-sadai.com';
        $emails = [$user->email];
        Mail::send('frontend.serviceEmailFormat',$data, function($message) use($emails,$salesEmail) {
            $message->to($emails)->subject('Service Order From Bazar-Sadai.com');
            $message->from(''.$salesEmail.'','Bazar-Sadai.Com');
        });
    }
}
