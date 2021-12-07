<?php

namespace App\Helpers;

use App\Models\OtpVerification;

class Otp
{
    public static function sendOtp($phone)
    {
        $model = OtpVerification::where('phone', $phone)->where('date', self::date());
        $count = $model->count();
        $model = $model->orderBy('id', 'desc')->first();

        // check validity time otp
        if ($model) {
            if ((int) $model->time > time()) {
                return [
                    'otp' => true,
                    'message' => 'OTP sudah pernah dikirim, mohon proses OTP sebelumnya atau tunggu waktu OTP sebelumnya habis.'
                ];
            }
        }

        if ($model && (int) $model->time > time())
            $count -= 1;

        // check maximum send otp
        if ($count >= 5) {
            return [
                'otp' => false,
                'message' => 'Sudah mencapai batas pengiriman OTP, mohon proses esok hari. (5x sehari)'
            ];
        }

        self::deleteOtp($phone);
        $otp = self::createOtp($phone);
        $message = 'TIRAMART - Kode verifikasi OTP anda adalah ' . $otp . '. Jangan informasikan kode ini ke orang lain.';
        $sendOtp = TiraApi::sendWhatsapp($phone, $message);

        if ($sendOtp) {
            return [
                'otp' => true,
                'message' => 'OTP berhasil dikirim.'
            ];
        } else {
            return [
                'otp' => false,
                'message' => 'OTP gagal dikirim.'
            ];
        }
    }

    public static function checkOtp($phone, $otp)
    {
        $model = OtpVerification::where('phone', $phone)->where('otp', $otp)->where('is_process', 'N')->orderBy('id', 'desc')->first();

        if (!$model) {
            return [
                'otp' => false,
                'message' => 'Kode OTP salah.'
            ];
        }

        $model->is_process = 'Y';

        if ($model->save()) {
            return [
                'otp' => true,
                'message' => 'Kode OTP benar.'
            ];
        }

        return [
            'otp' => false,
            'message' => 'Verifikasi OTP gagal.'
        ];
    }

    private static function createOtp($phone, int $digits = 4, int $validity = 60)
    {
        $model = new OtpVerification();
        $model->otp = self::generateOtp($digits);
        $model->phone = $phone;
        $model->date = self::date();
        $model->time = time() + ($validity);
        $model->save();

        return $model->otp;
    }

    private static function deleteOtp($phone)
    {
        OtpVerification::where('phone', $phone)->where('date', '!=', self::date())->delete();
    }

    private static function generateOtp($digits = 4)
    {
        $i = 0;
        $otp = '';

        while ($i < $digits) {
            $otp .= mt_rand(0, 9);
            $i++;
        }

        return $otp;
    }

    private static function date()
    {
        return date('Y-m-d');
    }
}
