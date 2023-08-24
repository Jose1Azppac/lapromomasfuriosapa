<?php

namespace App\Helper;

use App\Models\UserCode;

class Helper
{
    protected static $country;
    protected static $identity_card_type = [
        'cr' => ['title' => 'Cédula de identidad', 'abbreviation' => 'CI', 'lenght' => 9],
        'sv' => ['title' => 'Documento único de identidad', 'abbreviation' => 'DUI', 'lenght' => 9],
        'gt' => ['title' => 'Documento personal de identificación', 'abbreviation' => 'DPI', 'lenght' => 13],
        'hn' => ['title' => 'Documento nacional de identidad', 'abbreviation' => 'DNI', 'lenght' => 13],
        'pa' => ['title' => 'Cédula de identidad personal', 'abbreviation' => 'CIP', 'lenght' => 8],
    ];
    protected static $participation_limit = [
        'cr' => ['snacks_salados' => 11, 'galletas' => 4],
        'sv' => ['snacks_salados' => 7, 'tortix' => 5, 'galletas' => 3 ],
        'gt' => ['snacks_salados' => 7, 'tortix' => 5, 'galletas' => 3 ],
        'hn' => ['snacks_salados' => 11, 'galletas' => 5 ],
        'pa' => ['snacks_salados' => 11, 'galletas' => 4 ],
    ];

    public static function setCountry($abbreviation_country){
        self::$country = $abbreviation_country;
    }
    public static function getCountry(){
        return self::$country;
    }
    public static function getIdentityCardType(){
        return self::$identity_card_type[self::$country];
    }
    public static function getParticipationLimit(){
        return self::$participation_limit[self::$country];
    }
    public static function availableProducts(){ //return list of products availables in the current country
        return self::getParticipationLimit();
    }
    public static function validateProduct(&$product){ //valida if the product is avaibale in the current country
        $product = strtolower($product);
        $exists = array_key_exists($product, self::availableProducts());
        return $exists;
    }
    public static function validateParticipationUser($user_id, $product){
        if(!self::validateProduct($product)) return false; //validation if product is correct with respect to country

        $user_codes = UserCode::where('user_id',$user_id)->where('producto', $product)->whereDate('created_at', date('Y-m-d'))->get();
        $participationLimit = self::getParticipationLimit();

        if($user_codes->count() >= $participationLimit[$product]) return false;

        return true;
    }
}
