<?php

namespace App\Helper;

use Exception;
Use GuzzleHttp\Client;
use App\Helper\Helper;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;

class Mongo
{
    private static $cookies;
    private static $client;

    public static function init()
    {
        self::$client = new Client([
            'base_uri' => env('API_MONGO'),
        ]);
    }
    public static function response($res)
    {
        return json_decode($res->getBody());
    }
    public static function send()
    {
        self::init();
    }
    public static function redeemCode($user_id, $code)
    {
        self::init();

        $res = self::$client->post('/validate_code',[
            'form_params' => [
                'pais'  =>  Helper::getCountry(),
                'user_id'   =>  $user_id,
                'codigo'    =>  $code,
            ]
        ]);

        return self::response($res);
    }
}
