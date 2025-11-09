<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UserDevices extends Model
{
     use \App\Traits\Auditable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','device', 'platform'
    ];
    public $timestamps = false;
        
}
