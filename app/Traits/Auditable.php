<?php

namespace App\Traits;

use App\Utilities\AuditLogger;

trait Auditable
{
    public static function bootAuditable()
    {
        static::created(function ($item) {
            AuditLogger::capture("CREATED", $item, static::class);
        });

        static::updated(function ($item) {
            AuditLogger::capture("UPDATED", $item, static::class);
        });

        static::deleted(function ($item) {
            AuditLogger::capture("DELETED", $item, static::class);
        });

        // Uncomment to enable SQL query logging
        // \DB::listen(function ($sql) {
        //     if (\App\Utilities\AuditConfig::getOption("sqlLog", "LOG")) {
        //         AuditLogger::captureSql($sql);
        //     }
        // });
    }

    public function audit()
    {
        return $this->hasMany(\App\Models\Audit::class, "auditable_id");
    }
}
