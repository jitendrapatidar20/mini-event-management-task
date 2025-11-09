<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use App\Lib\Mailer;
class Controller extends BaseController
{
   
    function random($length = 30){
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length).time();
    }    

}
