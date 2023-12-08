<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class CustomerController extends Controller
{
    public function create(Request $request)
    {
        try {
            $validator = $this->validateCustomer();
            if ($validator->fails()) {
                return response()->json(['message' => $validator->messages(), 'data' => null], 400);
            }

            $res = Customer::create($request->all());

            return response()->json(['message' => 'Customer Saved', 'data' => $res], 200);
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

            $count = DB::table('customers')->count();

            $data = DB::table('customers')->offset($request['start'])->limit($request['limit'])->get();

            return response()->json(['customers' => $data, 'total' => $count], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function searchByName(Request $request)
    {
        try {
            $data =  Customer::where('name', 'like', '%' . $request['name'] . '%')->whereNotIn('id', $request['list'])->get();

            return response()->json(['customers' => $data], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function getById($id)
    {
        try {

            $data = Customer::where('id', $id)->first();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Customer::find($id)->update($request->all());
            $res = Customer::find($id);
            return response()->json(['customer' => $res, 'message' => 'Customer ' . $res['name'] . ' update successful'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $res = Customer::find($id)->delete();
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

    public function validateCustomer()
    {

        return Validator::make(request()->all(), [
            'name' => 'required|string|min:3|max:255',
            'document_number' => 'required|string|min:3|max:25',
        ]);
    }
}
