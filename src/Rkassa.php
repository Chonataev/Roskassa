<?php

namespace Rkassa\Payment;

class Rkassa{

    public static function getSing(array $params, string $secret){
        
        ksort($params);
        $str = http_build_query($params);
        return md5($str.$secret);
    }

    public static function checkPayment(array $params,string $secret){
        $key = $params['sign'];
        unset($params["sign"]);
        ksort($params);
        $sign = md5(http_build_query($params).$secret);
        if($sing === $key){
            return true;
        }else{
            return false;
        }
    }
    public static function sendData($params){
        $link = "https://".env('DOMAIN')."/?".http_build_query($params);
        return redirect($link);
    }

    public static function toPlug($data){
        return view('rkassa::form_plagin',compact('data'));
    }

}
