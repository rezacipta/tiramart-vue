<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class TiraApi
{
    private static function client($params = [])
    {
        $client = new Client([
            'verify' => false,
            'base_uri' => env('TIRA_API_URL', 'http://localhost/tira-sf/public/'),
            'headers' => [
                'Authorization' => env('TIRA_API_KEY', '123')
            ] + $params
        ]);

        return $client;
    }

    // send whatsapp from unofficial account
    public static function sendWhatsapp($phone, $message)
    {
        $response = self::client()->request('POST', 'api/send-whatsapp', [
            'form_params' => [
                'phone' => $phone,
                'message' => $message
            ]
        ]);

        $response = json_decode($response->getBody());

        return $response->status;
    }

    // send whatsapp from official account
    public static function sendWhatsappOfficial($phone, $message, $type)
    {
        $response = self::client()->request('POST', 'api/send-whatsapp-official', [
            'form_params' => [
                'phone' => $phone,
                'message' => $message,
                'type' => $type
            ]
        ]);

        $response = json_decode($response->getBody());

        return $response->status;
    }
}
