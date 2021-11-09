<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile(Request $request){
        $rows = DB::table('users')
            ->where('id', Cookie::get('user_id'))
            ->first();
        $role = $rows->user_type;
        if($role == 13){
            $df = DB::table('doctors')
                ->where('doctor_id', Cookie::get('user_id'))
                ->first();
            $dt = DB::table('doctor_time')
                ->get();
            return view('backend.profile__Doctor',['profile' =>$rows,'df'=> $df, 'dt'=> $dt]);
        }
        else{
            return redirect('homepage');
        }

    }
    public function updateProfile(Request $request){
        try{
            if($request) {
               // dd($request->times);
                $user_type = $request->user_type;
                if($user_type == 13){
                    $rows = DB::table('users')->where('id', Cookie::get('user_id'))->first();
                    $username = $request->name;
                    $email = $request->email;
                    $phone = $request->phone;
                    $password = Hash::make($request->password);
                    $gender = $request->gender;
                    $addressGroup = $request->addressGroup;
                    $address = $request->address;
                    $nid = $request->nid;
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

                    if ($request->hasFile('user_photo')) {
                        $targetFolder = 'public/asset/images/';
                        $file = $request->file('user_photo');
                        $pname = time(). '.' . $file->getClientOriginalName();
                        $image['filePath'] = $pname;
                        $file->move($targetFolder, $pname);
                        $photo = $targetFolder . $pname;
                    }
                    else{
                        $photo =  $rows->photo;
                    }
                    $result = DB::table('users')->where('id', $rows->id)
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
                            'user_type' => $user_type,
                            'status' => 1,
                            'nid' => $nid,
                            'working_status' => 1,
                            'device_token' => $request->device,
                            'photo' => $photo
                        ]);
                    if ($result) {
                        $doctor_id = $rows->id;
                        $result = DB::table('doctors')->where('doctor_id', $rows->id)
                            ->update([
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
                                'bmdc' => $request->bmdc,
                            ]);
                        $time_arr = [];
                        $i =0;
                        foreach ($request->times as $t){
                            $time_arr[] = [
                                'dr_id' => $doctor_id,
                                'time' => $t,
                            ];
                        }
                        $result = DB::table('dr_time_assign')->insert($time_arr);
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
}
