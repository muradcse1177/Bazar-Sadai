<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class ClothCleanerController extends Controller
{
    public function clothCleanerProfile  (){
        try{
            $id = Cookie::get('user_id');
            $user_info = DB::table('users')
                ->select('user_type.name as desig', 'users.*')
                ->join('user_type', 'user_type.id', '=', 'users.user_type')
                ->where('users.id', $id)
                ->where('users.status', 1)
                ->first();
            $users['info'] = $user_info;
            $washing = DB::table('cloth_washing_order')
                ->select('*','a.name as u_name','a.phone as  u_phone','cloth_washing_order.id as c_id')
                ->join('users as a', 'a.id', '=', 'cloth_washing_order.user_id')
                ->join('users as b', 'b.id', '=', 'cloth_washing_order.cleaner_id')
                ->where('a.status', 1)
                ->where('b.status', 1)
                ->where('b.id', $id)
                ->orderBy('cloth_washing_order.id','desc')
                ->paginate(20);
            return view('backend.clothCleanerProfile',['washings' =>$washing,'users'=> $users]);
        }
        catch(\Illuminate\Database\QueryException $ex){
            return back()->with('errorMessage', $ex->getMessage());
        }
    }
    public function getLaundryWashingByIdOwn(Request $request){
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
}
