<?php

namespace App\Http\Controllers\backend;
use Illuminate\Pagination\LengthAwarePaginator;
use smasif\ShurjopayLaravelPackage\ShurjopayService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeAssistantController extends Controller
{
    public function cookingPage(){
        $shurjopay_service = new ShurjopayService();
        $tx_id = $shurjopay_service->generateTxId();
        $a = $shurjopay_service->sendPayment(200);
        dd($a);
        $rows = DB::table('cooking')
            ->where('status', 1)
            ->orderBy('id', 'DESC')->Paginate(10);
        return view('backend.cookingPage', ['cookings' => $rows]);
    }

    public function getCookingList(Request $request){
        try{
            $rows = DB::table('cooking')
                ->where('id', $request->id)
                ->where('status', 1)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function insertCooking(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('cooking')
                        ->where('id', $request->id)
                        ->update([
                            'cooking_type' => $request->type,
                            'meal' => $request->meal,
                            'time' => $request->time,
                            'price' => $request->price,
                            'person' => $request->person,
                            'gender' => $request->gender,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফলভাবে  সম্পন্ন  হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('cooking')->select('id')->where([
                        ['cooking_type', '=', $request->type],
                        ['meal', '=', $request->meal],
                        ['time', '=', $request->time],
                        ['price', '=', $request->price],
                        ['person', '=', $request->person],
                        ['gender', '=', $request->gender],
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন আইটেম লিখুন।');
                    } else {
                        $result = DB::table('cooking')->insert([
                            'cooking_type' => $request->type,
                            'meal' => $request->meal,
                            'time' => $request->time,
                            'price' => $request->price,
                            'person' => $request->person,
                            'gender' => $request->gender,
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
    public function deleteCooking(Request $request){
        try{

            if($request->id) {
                $result =DB::table('cooking')
                    ->where('id', $request->id)
                    ->update([
                        'status' =>  0,
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
    public function parlorService(Request $request){

        $rows = DB::table('parlor_service')
            ->where('status', 1)
            ->orderBy('id', 'DESC')->get();
        $i = 0;
        $p = array();
        foreach ($rows as $row){
            if($row->address_type == 1){
                $add_part1 = DB::table('divisions')
                    ->where('id',$row->add_part1)
                    ->first();
                $add_part2 = DB::table('districts')
                    ->where('div_id',$row->add_part1)
                    ->where('id',$row->add_part2)
                    ->first();
                $add_part3 = DB::table('upazillas')
                    ->where('div_id',$row->add_part1)
                    ->where('dis_id',$row->add_part2)
                    ->where('id',$row->add_part3)
                    ->first();
                $add_part4 = DB::table('unions')
                    ->where('div_id',$row->add_part1)
                    ->where('dis_id',$row->add_part2)
                    ->where('upz_id',$row->add_part3)
                    ->where('id',$row->add_part4)
                    ->first();
                $add_part5 = DB::table('wards')
                    ->where('div_id',$row->add_part1)
                    ->where('dis_id',$row->add_part2)
                    ->where('upz_id',$row->add_part3)
                    ->where('uni_id',$row->add_part4)
                    ->where('id',$row->add_part5)
                    ->first();
            }
            if($row->address_type==2){
                $add_part1 = DB::table('divisions')
                    ->where('id',$row->add_part1)
                    ->first();
                $add_part2 = DB::table('cities')
                    ->where('div_id',$row->add_part1)
                    ->where('id',$row->add_part2)
                    ->first();
                $add_part3 = DB::table('city_corporations')
                    ->where('div_id',$row->add_part1)
                    ->where('city_id',$row->add_part2)
                    ->where('id',$row->add_part3)
                    ->first();
                $add_part4 = DB::table('thanas')
                    ->where('div_id',$row->add_part1)
                    ->where('city_id',$row->add_part2)
                    ->where('city_co_id',$row->add_part3)
                    ->where('id',$row->add_part4)
                    ->first();
                $add_part5 = DB::table('c_wards')
                    ->where('div_id',$row->add_part1)
                    ->where('city_id',$row->add_part2)
                    ->where('city_co_id',$row->add_part3)
                    ->where('thana_id',$row->add_part4)
                    ->where('id',$row->add_part5)
                    ->first();
            }
            $p[$i]['id'] = $row->id;
            $p[$i]['p_type'] = $row->p_type;
            $p[$i]['gender_type'] = $row->gender_type;
            $p[$i]['service'] = $row->service;
            $p[$i]['price'] = $row->price;
            $p[$i]['a1'] = $add_part1->name;
            $p[$i]['a2'] = $add_part2->name;
            $p[$i]['a3'] = $add_part3->name;
            $p[$i]['a4'] = $add_part4->name;
            $p[$i]['a5'] = $add_part5->name;
            $i++;
         }
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($p);
        $perPage = 20;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
        $paginatedItems->setPath($request->url());
        return view('backend.parlorService', ['p_services' => $paginatedItems]);
    }
    public function getAllParlorType(Request $request){
        try{
            $rows = DB::table('parlor')
                ->get();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }

    public function insertParlourService(Request $request){
        try{
            if($request) {
                $add_part1 = $request->div_id;
                $addressGroup = $request->addressGroup;
                $gender_type = $request->g_type;
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
                if($request->id) {
                    $result =DB::table('parlor_service')
                        ->where('id', $request->id)
                        ->update([
                            'p_type' => $request->p_type,
                            'service' => $request->service,
                            'price' => $request->price,
                            'address_type' => $addressGroup,
                            'add_part1' => $add_part1,
                            'add_part2' => $add_part2,
                            'add_part3' => $add_part3,
                            'add_part4' => $add_part4,
                            'add_part5' => $add_part5,
                            'gender_type' => $gender_type,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফলভাবে  সম্পন্ন  হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $result = DB::table('parlor_service')->insert([
                        'p_type' => $request->p_type,
                        'service' => $request->service,
                        'price' => $request->price,
                        'address_type' => $addressGroup,
                        'add_part1' => $add_part1,
                        'add_part2' => $add_part2,
                        'add_part3' => $add_part3,
                        'add_part4' => $add_part4,
                        'add_part5' => $add_part5,
                        'gender_type' => $gender_type,
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

    public function getParlorServiceById(Request $request){
        try{
            $rows = DB::table('parlor_service')
                ->where('id', $request->id)
                ->where('status', 1)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteParlorService(Request $request){
        try{

            if($request->id) {
                $result =DB::table('parlor_service')
                    ->where('id', $request->id)
                    ->update([
                        'status' =>  0,
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

    public function clothWashing(){
        $rows = DB::table('cloth_washing')
            ->orderBy('id', 'DESC')->Paginate(20);
        return view('backend.clothWashing', ['cloths' => $rows]);
    }
    public function insertCloth(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('cloth_washing')
                        ->where('id', $request->id)
                        ->update([
                            'name' => $request->name,
                            'price' => $request->price,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফলভাবে  সম্পন্ন  হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('cloth_washing')->select('id')->where([
                        ['name', '=', $request->name],
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন আইটেম লিখুন।');
                    } else {
                        $result = DB::table('cloth_washing')->insert([
                            'name' => $request->name,
                            'price' => $request->price,
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
    public function getClothById(Request $request){
        try{
            $rows = DB::table('cloth_washing')
                ->where('id', $request->id)
                ->where('status', 1)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteCloth(Request $request){
        try{

            if($request->id) {
                $result =DB::table('cloth_washing')
                    ->where('id', $request->id)
                    ->update([
                        'status' =>  0,
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
    public function roomCleaning(){
        $rows = DB::table('room_cleaning')
            ->orderBy('id', 'DESC')->Paginate(20);
        return view('backend.roomCleaning', ['rooms' => $rows]);
    }
    public function insertRoomCleaning(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('room_cleaning')
                        ->where('id', $request->id)
                        ->update([
                            'type' => $request->type,
                            'size' => $request->size,
                            'price' => $request->price,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফলভাবে  সম্পন্ন  হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('room_cleaning')->select('id')->where([
                        ['type', '=', $request->type],
                        ['size', '=', $request->size],
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন আইটেম লিখুন।');
                    } else {
                        $result = DB::table('room_cleaning')->insert([
                            'type' => $request->type,
                            'size' => $request->size,
                            'price' => $request->price,
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
    public function getRoomCleaningById(Request $request){
        try{
            $rows = DB::table('room_cleaning')
                ->where('id', $request->id)
                ->where('status', 1)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteRoomCleaning(Request $request){
        try{

            if($request->id) {
                $result =DB::table('room_cleaning')
                    ->where('id', $request->id)
                    ->update([
                        'status' =>  0,
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
    public function childCaring(){
        $rows = DB::table('child_caring')
            ->orderBy('id', 'DESC')->Paginate(20);
        return view('backend.childCaring', ['childs' => $rows]);
    }
    public function insertChildCaring(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('child_caring')
                        ->where('id', $request->id)
                        ->update([
                            'type' => $request->type,
                            'time' => $request->time,
                            'price' => $request->price,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফলভাবে  সম্পন্ন  হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('child_caring')->select('id')->where([
                        ['type', '=', $request->type],
                        ['time', '=', $request->size],
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন আইটেম লিখুন।');
                    } else {
                        $result = DB::table('child_caring')->insert([
                            'type' => $request->type,
                            'time' => $request->time,
                            'price' => $request->price,
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
    public function getChildCaringById(Request $request){
        try{
            $rows = DB::table('child_caring')
                ->where('id', $request->id)
                ->where('status', 1)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteChildCaring(Request $request){
        try{

            if($request->id) {
                $result =DB::table('room_cleaning')
                    ->where('id', $request->id)
                    ->update([
                        'status' =>  0,
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
    public function guardSetting(){
        $rows = DB::table('guard_setting')
            ->orderBy('id', 'DESC')->Paginate(20);
        return view('backend.guardSetting', ['guards' => $rows]);
    }
    public function insertGuardSetting(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('guard_setting')
                        ->where('id', $request->id)
                        ->update([
                            'type' => $request->type,
                            'time' => $request->time,
                            'price' => $request->price,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফলভাবে  সম্পন্ন  হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('guard_setting')->select('id')->where([
                        ['type', '=', $request->type],
                        ['time', '=', $request->size],
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন আইটেম লিখুন।');
                    } else {
                        $result = DB::table('guard_setting')->insert([
                            'type' => $request->type,
                            'time' => $request->time,
                            'price' => $request->price,
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
    public function getGuardSettingById(Request $request){
        try{
            $rows = DB::table('guard_setting')
                ->where('id', $request->id)
                ->where('status', 1)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteGuardSetting(Request $request){
        try{

            if($request->id) {
                $result =DB::table('guard_setting')
                    ->where('id', $request->id)
                    ->update([
                        'status' =>  0,
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
    public function variousServicing(){
        $rows = DB::table('various_servicing')
            ->orderBy('id', 'DESC')->Paginate(20);
        return view('backend.variousServicing', ['services' => $rows]);
    }
    public function insertVariousServicing(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('various_servicing')
                        ->where('id', $request->id)
                        ->update([
                            'type' => $request->type,
                            'name' => $request->name,
                            'price' => $request->price,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফলভাবে  সম্পন্ন  হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('various_servicing')->select('id')->where([
                        ['type', '=', $request->type],
                        ['name', '=', $request->name],
                    ])->where('status', 1)->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন আইটেম লিখুন।');
                    } else {
                        $result = DB::table('various_servicing')->insert([
                            'type' => $request->type,
                            'name' => $request->name,
                            'price' => $request->price,
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
    public function getVariousServiceById(Request $request){
        try{
            $rows = DB::table('various_servicing')
                ->where('id', $request->id)
                ->where('status', 1)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteVariousService(Request $request){
        try{

            if($request->id) {
                $result =DB::table('various_servicing')
                    ->where('id', $request->id)
                    ->update([
                        'status' =>  0,
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
    public function laundryService(){
        $rows = DB::table('laundry')
            ->orderBy('id', 'DESC')->Paginate(20);
        return view('backend.laundryService', ['cloths' => $rows]);
    }
    public function insertLaundry(Request $request){
        try{
            if($request) {
                if($request->id) {
                    $result =DB::table('laundry')
                        ->where('id', $request->id)
                        ->update([
                            'name' => $request->name,
                            'price' => $request->price,
                            'priceis' => $request->priceis,
                            'pricewa' => $request->pricewa,
                        ]);
                    if ($result) {
                        return back()->with('successMessage', 'সফলভাবে  সম্পন্ন  হয়েছে।');
                    } else {
                        return back()->with('errorMessage', 'আবার চেষ্টা করুন।');
                    }
                }
                else{
                    $rows = DB::table('laundry')->select('id')->where([
                        ['name', '=', $request->name],
                    ])->distinct()->get()->count();
                    if ($rows > 0) {
                        return back()->with('errorMessage', ' নতুন আইটেম লিখুন।');
                    } else {
                        $result = DB::table('laundry')->insert([
                            'name' => $request->name,
                            'price' => $request->price,
                            'priceis' => $request->priceis,
                            'pricewa' => $request->pricewa,
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
    public function getLaundryById(Request $request){
        try{
            $rows = DB::table('laundry')
                ->where('id', $request->id)
                ->first();
            return response()->json(array('data'=>$rows));
        }
        catch(\Illuminate\Database\QueryException $ex){
            return response()->json(array('data'=>$ex->getMessage()));
        }
    }
    public function deleteLaundry(Request $request){
        try{
            if($request->id) {
                $result =DB::table('laundry')
                    ->where('id', $request->id)
                    ->delete();
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
