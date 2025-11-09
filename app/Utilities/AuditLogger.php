<?php

namespace App\Utilities;

use App\Models\Audit;
use App\Models\AuditSql;
use Barryvdh\Debugbar\Facade as Debugbar;
use Illuminate\Support\Facades\Auth;

class AuditLogger
{
    public static function capture($event, $item, $model, $authUser = null)
    {
        Debugbar::info($event, $item, $model);

        if (!AuditConfig::getOption("events", $event)) {
            return false;
        }

        try {
            // Get authenticated user from parameter or fallback to auth context
            $authUser = $authUser ?: self::getAuthenticatedUser();

            Audit::create([
                'user_type'      => $authUser ? $authUser->role_id : null,
                'user_id'        => $authUser ? $authUser->id : null,
                'event'          => $event,
                'auditable_id'   => $item->getKey(),
                'auditable_type' => $model,
                'old_values'     => json_encode($item->getOriginal()),
                'new_values'     => json_encode($item->getAttributes()),
                'ip_address'     => AuditUtility::ipAddress(),
                'user_agent'     => AuditUtility::userAgent(),
                'url'            => AuditUtility::url(),
            ]);
        } catch (\Exception $e) {
            Debugbar::error($e);
        }
    }

    public static function captureSql($sql, $authUser = null)
    {
        $queryType = self::getQueryType($sql->sql);

        if (!AuditConfig::getOption("sqlLog", $queryType)) {
            return false;
        }

        try {
            $authUser = $authUser ?: self::getAuthenticatedUser();

            AuditSql::create([
                'event'       => $queryType,
                'user_type'   => $authUser ? get_class($authUser) : null,
                'user_id'     => $authUser ? $authUser->id : null,
                'log'         => json_encode($sql),
                'ip_address'  => AuditUtility::ipAddress(),
                'user_agent'  => AuditUtility::userAgent(),
                'url'         => AuditUtility::url(),
            ]);
        } catch (\Exception $e) {
            Debugbar::error($e);
        }
    }

    public static function getQueryType($query)
    {
        $str = strtoupper(trim($query));
        $queryTypes = [
            'SELECT'  => 'RETRIEVE',
            'INSERT'  => 'CREATED',
            'UPDATE'  => 'UPDATED',
            'DELETE'  => 'DELETED',
            'REPLACE' => 'REPLACE',
            'SET'     => 'SET',
            'DROP'    => 'DROP',
        ];

        foreach ($queryTypes as $keyword => $type) {
            if (strpos($str, $keyword) !== false) {
                return $type;
            }
        }

        return 'UNKNOWN';
    }

    protected static function getAuthenticatedUser()
    {
        return Auth::user(); // fallback if AuditConfig::getAuthUser() fails
    }
}
