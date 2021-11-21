<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function($view)
        {
            $noto_count = 0;
            //product Sale
            $product_order_count = DB::table('order_details')->where('view', 0)->distinct()->get()->count();
            if($product_order_count>0){
                $product_order_url = "salesReport?salesView=1";
                $product_order_count = $product_order_count;
                $noto_count = $noto_count + $product_order_count;
            }
            else{
                $product_order_url = null;
                $product_order_count = 0;
            }
            //custom order booking
            $custom_order_count = DB::table('custom_order_booking')->where('view', 0)->distinct()->get()->count();
            if($custom_order_count>0){
                $custom_order_url = "customOrderReport?salesView=1";
                $custom_order_count = $custom_order_count;
                $noto_count = $noto_count + $custom_order_count;
            }
            else{
                $custom_order_url = null;
                $custom_order_count = 0;
            }
            //Ticket Sale
            $ticket_order_count = DB::table('ticket_booking')->where('view', 0)->distinct()->get()->count();
            if($ticket_order_count>0){
                $ticket_order_url = "ticketSalesReport?salesView=1";
                $ticket_order_count = $ticket_order_count;
                $noto_count = $noto_count + $ticket_order_count;
            }
            else{
                $ticket_order_url = null;
                $ticket_order_count = 0;
            }
            //Dr Appointment
            $dr_order_count = DB::table('dr_apportionment')->where('view', 0)->distinct()->get()->count();
            if($dr_order_count>0){
                $dr_order_url = "doctorAppointmentReport?salesView=1";
                $dr_order_count = $dr_order_count;
                $noto_count = $noto_count + $dr_order_count;
            }
            else{
                $dr_order_url = null;
                $dr_order_count = 0;
            }
            //Therapy Appointment
            $therapy_order_count = DB::table('therapy_appointment')->where('view', 0)->distinct()->get()->count();
            if($therapy_order_count>0){
                $therapy_order_url = "therapyAppointmentReport?salesView=1";
                $therapy_order_count = $therapy_order_count;
                $noto_count = $noto_count + $therapy_order_count;
            }
            else{
                $therapy_order_url = null;
                $therapy_order_count = 0;
            }
            //Diagnostic Appointment
            $diagnostic_order_count = DB::table('diagonostic_appointment')->where('view', 0)->distinct()->get()->count();
            if($diagnostic_order_count>0){
                $diagnostic_order_url = "diagnosticAppointmentReport?salesView=1";
                $diagnostic_order_count = $diagnostic_order_count;
                $noto_count = $noto_count + $diagnostic_order_count;
            }
            else{
                $diagnostic_order_url = null;
                $diagnostic_order_count = 0;
            }
            //Medicine Order Report
            $medicine_order_count = DB::table('diagonostic_appointment')->where('view', 0)->distinct()->get()->count();
            if($medicine_order_count>0){
                $medicine_order_url = "medicine_order?salesView=1";
                $medicine_order_count = $medicine_order_count;
                $noto_count = $noto_count + $medicine_order_count;
            }
            else{
                $medicine_order_url = null;
                $medicine_order_count = 0;
            }
            //Transport Order
            $ride_order_count = DB::table('ride_booking')->where('view', 0)->distinct()->get()->count();
            if($medicine_order_count>0){
                $ride_order_url = "transportReportAdmin?salesView=1";
                $ride_order_count = $ride_order_count;
                $noto_count = $noto_count + $ride_order_count;
            }
            else{
                $ride_order_url = null;
                $ride_order_count = 0;
            }
            //Courier Order
            $courier_order_count = DB::table('courier_booking')->where('view', 0)->distinct()->get()->count();
            if($courier_order_count>0){
                $courier_order_url = "courierReport?salesView=1";
                $courier_order_count = $courier_order_count;
                $noto_count = $noto_count + $courier_order_count;
            }
            else{
                $courier_order_url = null;
                $courier_order_count = 0;
            }
            //Cooking Order
            $cooking_order_count = DB::table('cooking_booking')->where('view', 0)->distinct()->get()->count();
            if($cooking_order_count>0){
                $cooking_order_url = "cookingReport?salesView=1";
                $cooking_order_count = $cooking_order_count;
                $noto_count = $noto_count + $cooking_order_count;
            }
            else{
                $cooking_order_url = null;
                $cooking_order_count = 0;
            }
            //Cloth Cleaning Order
            $cleaning_order_count = DB::table('cleaning_order')->where('view', 0)->distinct()->get()->count();
            if($cleaning_order_count>0){
                $cleaning_order_url = "clothWashingReport?salesView=1";
                $cleaning_order_count = $cleaning_order_count;
                $noto_count = $noto_count + $cleaning_order_count;
            }
            else{
                $cleaning_order_url = null;
                $cleaning_order_count = 0;
            }
            //Laundry Order
            $laundry_order_count = DB::table('laundry_order')->where('view', 0)->distinct()->get()->count();
            if($laundry_order_count>0){
                $laundry_order_url = "laundryReport?salesView=1";
                $laundry_order_count = $laundry_order_count;
                $noto_count = $noto_count + $laundry_order_count;
            }
            else{
                $laundry_order_url = null;
                $laundry_order_count = 0;
            }
            //Room/washroom/Tank Order
            $room_order_count = DB::table('cleaning_order')->where('view', 0)->distinct()->get()->count();
            if($room_order_count>0){
                $room_order_url = "roomCleaningReport?salesView=1";
                $room_order_count = $room_order_count;
                $noto_count = $noto_count + $room_order_count;
            }
            else{
                $room_order_url = null;
                $room_order_count = 0;
            }
            //Helping Hand Order
            $helpingHand_order_count = DB::table('helping_hand_order')->where('view', 0)->distinct()->get()->count();
            if($helpingHand_order_count>0){
                $helpingHand_order_url = "helpingHandReport?salesView=1";
                $helpingHand_order_count = $helpingHand_order_count;
                $noto_count = $noto_count + $helpingHand_order_count;
            }
            else{
                $helpingHand_order_url = null;
                $helpingHand_order_count = 0;
            }
            //Gard Order
            $gard_order_count = DB::table('guard_order')->where('view', 0)->distinct()->get()->count();
            if($gard_order_count>0){
                $gard_order_url = "guardReport?salesView=1";
                $gard_order_count = $gard_order_count;
                $noto_count = $noto_count + $gard_order_count;
            }
            else{
                $gard_order_url = null;
                $gard_order_count = 0;
            }
            //various_servicing_order
            $various_servicing_order_count = DB::table('various_servicing_order')->where('view', 0)->distinct()->get()->count();
            if($various_servicing_order_count>0){
                $various_servicing_order_url = "variousServicingReport?salesView=1";
                $various_servicing_order_count = $various_servicing_order_count;
                $noto_count = $noto_count + $various_servicing_order_count;
            }
            else{
                $various_servicing_order_url = null;
                $various_servicing_order_count = 0;
            }
            //parlor Order
            $parlor_order_count = DB::table('parlor_order')->where('view', 0)->distinct()->get()->count();
            if($parlor_order_count>0){
                $parlor_order_url = "parlorReport?salesView=1";
                $parlor_order_count = $parlor_order_count;
                $noto_count = $noto_count + $parlor_order_count;
            }
            else{
                $parlor_order_url = null;
                $parlor_order_count = 0;
            }
            //T&T Order
            $tour_order_count = DB::table('bookingtnt')->where('view', 0)->distinct()->get()->count();
            if($tour_order_count>0){
                $tour_order_url = "toursNTravelsReport?salesView=1";
                $tour_order_count = $tour_order_count;
                $noto_count = $noto_count + $tour_order_count;
            }
            else{
                $tour_order_url = null;
                $tour_order_count = 0;
            }
            $view->with([
                'noti_count' => $noto_count,
                'product_order_count' => $product_order_count, 'product_order_url' => $product_order_url,
                'custom_order_count' => $custom_order_count, 'custom_order_url' => $custom_order_url,
                'ticket_order_count' => $ticket_order_count, 'ticket_order_url' => $ticket_order_url,
                'dr_order_count' => $dr_order_count, 'dr_order_url' => $dr_order_url,
                'therapy_order_count' => $therapy_order_count, 'therapy_order_url' => $therapy_order_url,
                'diagnostic_order_count' => $diagnostic_order_count, 'diagnostic_order_url' => $diagnostic_order_url,
                'medicine_order_count' => $medicine_order_count, 'medicine_order_url' => $medicine_order_url,
                'ride_order_count' => $ride_order_count, 'ride_order_url' => $ride_order_url,
                'courier_order_count' => $courier_order_count, 'courier_order_url' => $courier_order_url,
                'cooking_order_count' => $cooking_order_count, 'cooking_order_url' => $cooking_order_url,
                'cleaning_order_count' => $cleaning_order_count, 'cleaning_order_url' => $cleaning_order_url,
                'laundry_order_count' => $laundry_order_count, 'laundry_order_url' => $laundry_order_url,
                'room_order_count' => $room_order_count, 'room_order_url' => $room_order_url,
                'helpingHand_order_count' => $helpingHand_order_count, 'helpingHand_order_url' => $helpingHand_order_url,
                'gard_order_count' => $gard_order_count, 'gard_order_url' => $gard_order_url,
                'various_servicing_order_count' => $various_servicing_order_count, 'various_servicing_order_url' => $various_servicing_order_url,
                'parlor_order_count' => $parlor_order_count, 'parlor_order_url' => $parlor_order_url,
                'tour_order_count' => $tour_order_count, 'tour_order_url' => $tour_order_url,
            ]);
        });
    }
}
