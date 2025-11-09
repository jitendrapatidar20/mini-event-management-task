<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\User;
class LoginHistory extends Model
{
    use \App\Traits\Auditable;
    protected $fillable = [
        'user_id', 'ip_address', 'user_agent', 'latitude','longitude'
    ];
     
}


