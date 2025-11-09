<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\LoginHistory;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Lib\Mailer;

class AuthController extends BaseController
{
    /**
     * Register a new user
     */
    public function register(Request $request)
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

        $statusApproved =  "APPROVED";
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
            'role_id' => Role::where('slug','user')->first()->id ?? null
        ]);

        if ($user) {
            // $url = rewriteRoute(url('email-verify/' . $token));
            // Mailer::emailConfirmation($user->name, $url, $user->email);
            return response()->json([
                'message' => 'User Account Successfully Created',
                'user'    => $user,
            ], 201);
        }

    }

    /**
     * Login user
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

    
        $user = User::where('email', $request->email)->first();
        $roleId = optional(Role::where('slug', 'user')->first())->id;

        if (!$user || !$roleId || $user->role_id !== $roleId || !Hash::check($request->password, $user->password)) {
            return response()->json(['status' => false, 'error' => 'Invalid credentials.'], 401);
        }

        if ($user->status != 1 || $user->approval_status !== 'APPROVED') {
            return response()->json(['status' => false, 'error' => 'Account not approved.'], 401);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user->update([
                'last_ip' => $request->ip(),
                'last_latitude' => $request->latitude ?? null,
                'last_longitude' => $request->longitude ?? null
            ]);

            LoginHistory::create([
                'user_id' => $user->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                'latitude' => $request->latitude ?? null,
                'longitude' => $request->longitude ?? null
            ]);

            // $this->captureDeviceInfo($user->id);

             $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'token'   => $token
            ]);
        }

        return response()->json(['status' => false, 'error' => 'Login failed.'], 401);
    }

    /**
     * Logout user (revoke token)
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
