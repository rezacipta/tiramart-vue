<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Models\City;
use App\Models\Province;
use App\Models\Subdistrict;
use FontLib\Table\Type\name;
use Illuminate\Http\Request;

class AddressController extends ApiController
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipientName' => 'required|string|max:255',
            'recipientPhone' => 'required|string|min:10|max:13|regex:/(08)[0-9]{8}/',
            'province' => 'required',
            'city' => 'required',
            'subdistrict' => 'required',
            'postalcode' => 'required',
            'fullAddress' => 'required|string|max:255',
            'name' => 'required|string|max:255'
        ]);

        try {
            if (auth('sanctum') && $request->isMain)
                $update = Address::where('customer_id', auth('sanctum')->user()->id)->update(['is_main' => 0]);

            if (!empty($request->id))
                $model = Address::where('id', $request->id)->first();
            else
                $model = new Address();

            $model->name = $request->name;
            $model->recipient_name = $request->recipientName;
            $model->phone = $request->recipientPhone;
            $model->province_id = $request->province;
            $model->city_id = $request->city;
            $model->subdistrict_id = $request->subdistrict;
            $model->address = $request->fullAddress;
            $model->detail = $request->detail ? $request->detail : null;
            $model->is_main = $request->isMain ? 1 : 0;
            $model->customer_id = auth('sanctum') ? auth('sanctum')->user()->id : null;
            $model->save();

            return $this->respondWithSuccess(new AddressResource($model));
        } catch (\Throwable $th) {
            if (env('APP_DEBUG')) {
                return $this->respondNotFound($th);
            } else {
                return $this->respondError($this->errorMessage());
            }
        }
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        try {
            $delete = Address::where('id', $id)->delete();

            return $this->respondWithSuccess();
        } catch (\Throwable $th) {
            if (env('APP_DEBUG')) {
                return $this->respondNotFound($th);
            } else {
                return $this->respondError($this->errorMessage());
            }
        }
    }

    public function province()
    {
        $province = Province::select('id', 'name as text')->get();

        $response = [
            'name' => 'Provinsi',
            'data' => $province
        ];

        return $this->respondWithSuccess($response);
    }

    public function city($id)
    {
        $city = City::select('id', 'name as text')->where('province_id', $id)->get();

        $response = [
            'name' => 'Kota',
            'data' => $city
        ];

        return $this->respondWithSuccess($response);
    }

    public function subdistrict($id)
    {
        $subdistrict = Subdistrict::select('id', 'name as text')->where('city_id', $id)->get();
        $postalcode = Subdistrict::select('id', 'postal_code')->where('city_id', $id)->get();

        $response = [
            'name' => 'Kecamatan',
            'data' => $subdistrict,
            'postalcode' => $postalcode,
        ];

        return $this->respondWithSuccess($response);
    }
}
