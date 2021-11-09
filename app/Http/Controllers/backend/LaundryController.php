<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LaundryController extends Controller
{
    public function laundryProfile  (Request  $request){
        try{
            $id = Cookie::get('user_id');
            $user_info = DB::table('users')
                ->select('user_type.name as desig', 'users.*')
                ->join('user_type', 'user_type.id', '=', 'users.user_type')
                ->where('users.id', $id)
                ->where('users.status', 1)
                ->first();
            $users['info'] = $user_info;
            $washing = DB::table('laundry_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','a.address as  u_address','laundry_order.id as c_id','laundry_order.status as situation')
                ->join('users as a', 'a.id', '=', 'laundry_order.user_id')
                ->join('users as b', 'b.id', '=', 'laundry_order.cleaner_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->where('b.id', $id)
                ->orderBy('laundry_order.id','desc')
                ->paginate(20);
            return view('backend.laundryProfile ',['washings' =>$washing,'users'=> $users]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getLaundryWashingByIdOwn(Request $request){
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
    public function changeLaundryProductSituation(Request $request){
        try{
            if($request->id) {
                $id = explode('&',$request->id);
                $result =DB::table('laundry_order')
                    ->where('id', $id[1])
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
}
