<?php
namespace App\Http\Controllers\Admin\Auth;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use App\Lib\RenderJson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\LoginHistory;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use App\Lib\Mailer;


class AuthController extends BaseController
{
    public function index()
    {
        $data = $this->getPageMeta(1);
        return view('auth.login', $data);
    }

    public function registration()
    {
        $data = $this->getPageMeta(2);
        return view('auth.registration', $data);
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $roleSlug = Crypt::decrypt($request->input('role'));
        $blockStatus = $this->getAttemptsStatus($request->ip(), $request->header('User-Agent'), $request->email);

        if (!$blockStatus['status']) {
            $message = $blockStatus['permanent_block']
                ? 'You have been permanently blocked. Contact admin.'
                : 'You are temporarily blocked for 15 minutes.';
            return response()->json(['status' => false, 'error' => $message], 401);
        }

        $user = User::where('email', $request->email)->first();
        $roleId = optional(Role::where('slug', $roleSlug)->first())->id;

        if (!$user || !$roleId || $user->role_id !== $roleId || !Hash::check($request->password, $user->password)) {
            return response()->json(['status' => false, 'error' => 'Invalid credentials.'], 401);
        }

        if ($user->status != 1 || $user->approval_status !== 'APPROVED') {
            return response()->json(['status' => false, 'error' => 'Account not approved.'], 401);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user->update([
                'last_ip' => $request->ip(),
                'last_latitude' => $request->latitude,
                'last_longitude' => $request->longitude
            ]);

            LoginHistory::create([
                'user_id' => $user->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ]);

            // $this->captureDeviceInfo($user->id);

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'redirect' => route('dashboard')
            ]);
        }

        return response()->json(['status' => false, 'error' => 'Login failed.'], 401);
    }

    public function postRegistration(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_no' => 'required|numeric|digits_between:7,15|unique:users,phone_no',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password',
        ]);

        $data = $request->all();
        $token = $this->random(40) . "abc" . Crypt::encrypt(now()->addMinutes(5));
        $role = Crypt::decrypt($data['role']);
        $statusApproved = isset($data['social_id']) ? "APPROVED" : "PENDING";
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'full_name' => $data['first_name'] . " " . $data['last_name'],
            'email' => $data['email'],
            'phone_no' => $data['phone_no'],
            'token' => $token,
            'token_expiry_time' => now()->addMinutes(5),
            'status' => 1,
            'approval_status' => $statusApproved,
            'password' => Hash::make($data['password']),
            'role_id' => Role::where('slug', $role)->first()->id ?? null
        ]);

        if ($user) {
            $url = rewriteRoute(url('email-verify/' . $token));
            Mailer::emailConfirmation($user->name, $url, $user->email);
            return RenderJson::send(true, 200, $user, 'Account registered. Please check your email.');
        }

        return RenderJson::send(false, 422, null, 'Something went wrong.');
    }

    public function emailVerify($token = null, Request $request)
    {
        $data = $this->getPageMeta(5);
        $isValid = User::where('token_expiry_time', '>=', now())
            ->where('token', $token)
            ->exists();

        if ($isValid) {
            User::where('token', $token)->update([
                'approval_status' => 'APPROVED',
                'email_verified_at' => now(),
                'token' => null,
                'token_expiry_time' => null
            ]);
        }

        return view('auth.email_verify', compact('data', 'token', 'isValid'));
    }

    public function forgot()
    {
        $data = $this->getPageMeta(3);
        return view('auth.forgetpass', $data);
    }

    public function submitForgot(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $token = $this->random(40);
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user->update([
                'token' => $token,
                'token_expiry_time' => now()->addMinutes(5)
            ]);
            $url = rewriteRoute(url('reset-password/' . $token));
            Mailer::forgot($user->name, $url, $user->email);
        }

        return [
            'status' => true,
            'message' => 'If your email exists, you will receive reset instructions.',
            'email' => substr($request->email, 0, 1) . '*******' . strstr($request->email, '@')
        ];
    }

    public function resetPass($token = null, Request $request)
    {
        $data = $this->getPageMeta(4);
        $formLayout = User::where('token_expiry_time', '>=', now())->where('token', $token)->exists();
        return view('auth.resetPass', compact('data', 'token', 'formLayout'));
    }

    public function setPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password',
        ]);

        $user = User::where('token', $request->token)->first();
        if ($user) {
            $user->update(['password' => bcrypt($request->password)]);
            return ['status' => true, 'message' => 'Password set successfully.'];
        }

        return response()->json(['error' => 'This token has expired.'], 401);
    }

    public function checkUniqueAvailability(Request $request)
    {
        $exists = false;
        if ($request->modalName === 'User') {
            $exists = User::where('email', $request->value)->exists();
        }
        return [
            'status' => !$exists,
            'message' => $exists ? 'Email already exists' : 'Available'
        ];
    }

   


}


