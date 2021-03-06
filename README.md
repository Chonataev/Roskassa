# Оплата через кашелек Roskassa
Чтобы устоновить пакет используйте комманду composer require rkassa/payment
composer update - обнавляет компоненты из composer.json
dump-autoload - находит все классы которые необходимо включить

php artisan vendor-publish копирует файлы в нужнные места

Для начало посмотрите файл .env создайте переменные 
------------
DOMAIN=pay.roskassa.net
SECRET_KEY = 'ваш секретный ключ'
SHOP_ID = 'ваш публичный ключ'
local = 'ru' || 'en'
------------
Простой пример контроллера
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Rkassa\Payment\Rkassa;
class KasaController extends Controller
{
    public $data;
    public $shop_id;
    private $secret;

    public $name;
    public $email;
    public $count;
    public $price;
    public $payment_system;

    public function __construct(){
        $this->name = 'product';
        $this->email = 'test@test.test';
        $this->price = 200;
        $this->count = 4;
        $this->amount = $this->price*$this->count;
        $this->payment_system = 5;
        $this->data = [
            "shop_id"  => env("SHOP_ID"),
            "order_id" => "Заказ #777",
            "currency" => "RUB",
            'amount' => $this->amount
        ];
        $this->secret = env('SECRET_KEY');
    }
    public function sendMoney(){
        $this->data['sign'] = $this->getSing();
        $this->data['name'] = $this->name;
        $this->data['price'] = $this->price;
        $this->data['count'] = $this->count;
        $this->data['email'] = $this->email;
        $this->data['payment_system'] = $this->payment_system;
        return Rkassa::sendData($this->data);
    }

    public function getSing(){
        return Rkassa::getSing($this->data,$this->secret);
    }

    public function checkPayment(){
        if(isset($_POST)){
            return Rkassa::getSing($_POST,$this->secret);
        }
    }
    public function getView(){
       $this->data['sign'] = $this->getSing();
       $this->data['name'] = $this->name;
       $this->data['price'] = $this->price;
       $this->data['count'] = $this->count;
       $this->data['email'] = $this->email;
       $this->data['payment_system'] = $this->payment_system;
        return Rkassa::toPlug($this->data);
    }
}

