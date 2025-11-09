<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Lib\RenderJson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Role;
use App\Models\PageTitle;


class AdminController extends BaseController
{
    
    public function dashboard(Request $request)
    {
        try
        {
            if(Auth::check()){
                return view('admin.dashboard');
            }
            return redirect("login")->withSuccess('Opps! You do not have access');

        }catch (\Exception $e) {
            $msg = $e->getMessage();
            Session::flash('danger',$msg);
            return redirect()->back()->withInput();
        }
  
       
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout() {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }
}
