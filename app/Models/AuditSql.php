<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AuditSql extends Model
{
    protected $fillable = [
        'user_type',
        'user_id',
        'event',
        'log',
        'ip_address',
        'user_agent',
        'url',
    ];
}
