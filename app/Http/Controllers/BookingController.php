<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{

    public function create(Request $request)
    {
        try {
            $validator = $this->validateBooking();
            if ($validator->fails()) {
                return response()->json(['message' => $validator->messages(), 'data' => null], 400);
            }

            $startDate = strtotime($request['checkIn']);
            $endDate = strtotime($request['checkOut']);
            $datediff = $endDate - $startDate;

            $nights = round($datediff / (60 * 60 * 24));

            $data = array(
                "amount" => $request['amount'],
                "hotel_id" => $request['hotel_id'],
                "checkIn" => $request['checkIn'] . " 14:00:00",
                "checkOut" => $request['checkOut'] . " 12:00:00",
                "nights" => $nights,
            );
            $res = Booking::create($data);
            $customers = $request['customers'];
            foreach ($customers as $value) {
                BookingCustomerController::addCustomerToBooking(array("customer_id" => $value, "booking_id" => $res['id']));
            }

            return response()->json(['message' => 'Booking Saved', 'data' => $res], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function findAll(Request $request)
    {
        try {

            $validator = $this->validatePagination();
            if ($validator->fails()) {
                return response()->json(['message' => $validator->messages(), 'data' => null], 400);
            }


            $data = DB::table('bookings')
                ->join('hotels', 'hotel_id', '=', 'hotels.id')
                ->offset($request['start'])
                ->limit($request['limit'])
                ->get();
            $count = DB::table('bookings')->count();


            return response()->json(['bookings' => $data, 'total' => $count], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function getById($id)
    {
        try {

            $data = Booking::where('id', $id)->with('hotel')->with('customers')->first();

            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $startDate = strtotime($request['checkIn']);
            $endDate = strtotime($request['checkOut']);
            $datediff = $endDate - $startDate;

            $nights = round($datediff / (60 * 60 * 24));

            $data = array(
                "amount" => $request['amount'],
                "hotel_id" => $request['hotel_id'],
                "checkIn" => $request['checkIn'] . " 14:00:00",
                "checkOut" => $request['checkOut'] . " 12:00:00",
                "nights" => $nights,
            );


            Booking::find($id)->update($data);
            $res = Booking::find($id);

            DB::table('booking_customer')->where('booking_id', '=', $id)->delete();
            $customers = $request['customers'];
            foreach ($customers as $value) {
                BookingCustomerController::addCustomerToBooking(array("customer_id" => $value, "booking_id" => $id));
            }

            return response()->json(['message' => 'Booking Updated', 'data' => $res], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $res = Booking::find($id)->delete();
            return response()->json(["deleted" => $res], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function validateBooking()
    {

        return Validator::make(request()->all(), [
            'checkIn' => 'date_format:"Y-m-d"',
            'checkOut' => 'date_format:"Y-m-d"',
            'amount' => 'required|integer',
            'hotel_id' => 'required|integer'
        ]);
    }
    public function validatePagination()
    {

        return Validator::make(request()->all(), [
            'start' => 'required|integer',
            'limit' => 'required|integer',
        ]);
    }
}
