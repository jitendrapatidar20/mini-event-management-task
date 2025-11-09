<?php
namespace App\Utilities;
use Illuminate\Support\Facades\Request;

class AuditUtility
{
    public static function userAgent()
    {
        return Request::header('User-Agent');
    }

    public static function ipAddress()
    {
        return request()->ip();
    }

    public static function url()
    {
        return request()->url();
    }
}
