<?php
namespace App\Resolvers;

 
use Session;
use App\Models\Admin;
class UserResolver implements \OwenIt\Auditing\Contracts\UserResolver
{
    /**
     * {@inheritdoc}
     */
    public static function resolve()
    {
          
        if(Session::has('AdminLoggedIn'))
        {
       

            return Admin::find(Session::get("AdminLoggedIn")["admin_id"]);
            
            
        }
        else
        {
        	return null;
        }
    }
}