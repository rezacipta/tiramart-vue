<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class AccountController extends ApiController
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:50|unique:customers,id,' . $request->user()->id
        ]);

        try {
            $customer = Customer::findOrFail($request->user()->id);
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->save();

            return $this->respondWithSuccess();
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
        //
    }
}
