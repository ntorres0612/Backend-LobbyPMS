<?php

namespace App\Http\Controllers;

use App\Models\BookingCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class BookingCustomerController extends Controller
{
    static function addCustomerToBooking($data)
    {
        $response = BookingCustomer::create($data);
        return $response;
    }
    public function create(Request $request)
    {
        try {

            $validator = $this->validateBookingCustomer();
            if ($validator->fails()) {
                return response()->json(['message' => $validator->messages(), 'data' => null], 400);
            }
            $data = self::addCustomerToBooking($request->all());

            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function delete($booking_id, $customer_id)
    {

        try {
            $res = BookingCustomer::where(
                [
                    'booking_id' => $booking_id,
                    'customer_id' => $customer_id
                ]
            )->delete();
            return response()->json(["deleted" => $res], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }



    public function validateBookingCustomer()
    {

        return Validator::make(request()->all(), [
            'booking_id' => 'required|integer',
            'customer_id' => 'required|integer',
        ]);
    }
}
