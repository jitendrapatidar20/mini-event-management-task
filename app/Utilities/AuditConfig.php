<?php
namespace App\Utilities;
use App\Models\User;

class AuditConfig
{
    public static $options = [
        "model" => User::class,
        "events" => [
            "CREATED"  => true,
            "UPDATED"  => true,
            "DELETED"  => true,
            "RETRIEVE" => false,
        ],
        "sqlLog" => [
            "LOG"      => true,
            "CREATED"  => true,
            "UPDATED"  => true,
            "DELETED"  => true,
            "RETRIEVE" => false,
        ]
    ];

    public static $UserModel = User::class;
    public static $authUser = null;
    public static $authUserFetched = false;

    public static function set(array $options)
    {
        self::$UserModel = $options["model"] ?? self::$options['model'];
    }

    public static function setOption($name, $value)
    {
        self::$options[$name] = $value;
    }

    public static function getOption($name, $key)
    {
        return self::$options[$name][$key] ?? false;
    }

    public static function getAuthUser()
    {
        if (!self::$authUserFetched) {
            $model = self::$UserModel;
            self::$authUser = method_exists($model, 'getAuthUser') ? $model::getAuthUser() : null;
            self::$authUserFetched = true;
        }

        return self::$authUser;
    }
}
