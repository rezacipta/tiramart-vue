<?php

namespace App\Http\Controllers;

use App\Helpers\Otp;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Models\Replika\Customer as CustomerReplika;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController
{
    public function checkLogin(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:10|max:13|regex:/(08)[0-9]{8}/'
        ]);

        $customer = Customer::where('whatsapp_number', $request->phone)->first();

        if ($customer) {
            if ($customer->status) {
                return $this->respondWithSuccess();
            } else {
                return $this->respondError('Akun sudah tidak aktif.');
            }
        } else {
            $customerReplika = CustomerReplika::where('whatsapp_number', $request->phone)->where('status', 1)->whereIn('member_type', [2, 3, 4])->first();

            if ($customerReplika) {
                try {
                    $customer = Customer::insert($customerReplika->toArray());

                    return $this->respondWithSuccess();
                } catch (\Throwable $th) {
                    if (env('APP_DEBUG')) {
                        return $this->respondNotFound($th);
                    } else {
                        return $this->respondError($this->errorMessage());
                    }
                }
            } else {
                $otp = Otp::sendOtp($request->phone);
                // $otp = [
                //     'otp' => true,
                //     'message' => 'OTP berhasil dikirim.'
                // ];

                // $otp = [
                //     'otp' => false,
                //     'message' => 'OTP gagal dikirim.'
                // ];

                if (!$otp['otp'])
                    return $this->respondError($otp['message']);

                return $this->respondWithSuccess($otp);
            }
        }
    }

    public function checkOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:10|max:13|regex:/(08)[0-9]{8}/',
            'otp' => 'required|digits:4'
        ]);

        $otp = Otp::checkOtp($request->phone, $request->otp);

        if (!$otp['otp'])
            return $this->respondError($otp['message']);

        return response($otp);
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:10|max:13|regex:/(08)[0-9]{8}/'
        ]);

        $otp = Otp::sendOtp($request->phone);
        // $otp = [
        //     'otp' => true,
        //     'message' => 'OTP berhasil dikirim.'
        // ];

        // $otp = [
        //     'otp' => false,
        //     'message' => 'OTP gagal dikirim.'
        // ];

        if (!$otp['otp'])
            return $this->respondError($otp['message']);

        return $this->respondWithSuccess($otp);
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:10|max:13|regex:/(08)[0-9]{8}/',
            'password' => 'required'
        ]);

        $customer = Customer::where('whatsapp_number', $request->phone)->first();

        if ($request->state != null) {
            try {
                if ($request->state == 'register') {
                    $customer = new Customer([
                        'name' => '',
                        'email' => '',
                        'phone' => $request->phone,
                        'whatsapp_number' => $request->phone,
                        'member_type' => 1,
                        'status' => 1,
                        'wa_status' => 1,
                        'phone_status' => 1,
                        'password' => bcrypt($request->password)
                    ]);
                }

                if ($request->state == 'forgot-password') {
                    $customer->password = bcrypt($request->password);
                }

                $customer->save();
            } catch (\Throwable $th) {
                if (env('APP_DEBUG')) {
                    return $this->respondNotFound($th);
                } else {
                    return $this->respondError($this->errorMessage());
                }
            }
        }

        if (!$customer || !Hash::check($request->password, $customer->password)) {
            return $this->respondError('Password salah.');
        }

        $token = $customer->createToken('tiramart')->plainTextToken;

        $data = [
            'token' => $token,
            'user' => $customer
        ];

        return $this->respondWithSuccess($data);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->respondOk('Anda telah logout.');
    }

    public function user(Request $request)
    {
        $resource = new CustomerResource($request->user());

        return $this->respondWithSuccess($resource);
    }
}
