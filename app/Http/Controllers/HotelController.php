<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class HotelController extends Controller
{
    public function create(Request $request)
    {
        try {
            $validator = $this->validateHotel();
            if ($validator->fails()) {
                return response()->json(['message' => $validator->messages(), 'data' => null], 400);
            }

            $res = Hotel::create($request->all());

            return response()->json(['message' => 'Hotel Saved', 'data' => $res], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function paginate(Request $request)
    {
        try {

            $validator = $this->validatePagination();
            if ($validator->fails()) {
                return response()->json(['message' => $validator->messages(), 'data' => null], 400);
            }

            $data = DB::table('hotels')->offset($request['start'])->limit($request['limit'])->get();
            $count = DB::table('hotels')->count();
            return response()->json(['hotels' => $data, 'total' => $count], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function list()
    {
        try {
            $data = DB::table('hotels')->get();
            return response()->json(['hotels' => $data], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function getById($id)
    {
        try {

            $data = Hotel::where('id', $id)->first();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            Hotel::find($id)->update($request->all());
            $res = Hotel::find($id);
            return response()->json(['hotel' => $res, 'message' => 'Hotel ' . $res['name'] . ' update successful'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $res = Hotel::find($id)->delete();
            return response()->json(["deleted" => $res], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function validatePagination()
    {

        return Validator::make(request()->all(), [
            'start' => 'required|integer',
            'limit' => 'required|integer',
        ]);
    }

    public function validateHotel()
    {

        return Validator::make(request()->all(), [
            'name' => 'required|string|min:3|max:255',
            'address' => 'required|string|min:5|max:25',
            'country' => 'required|string|min:3|max:255',
            'province' => 'required|string|min:3|max:255',
            'city' => 'required|string|min:3|max:255',
            'nit' => 'required|string|min:5|max:255',
            'phone' => 'required|string|min:5|max:255',
        ]);
    }
}
