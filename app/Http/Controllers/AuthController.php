<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\RecaptchaService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class AuthController extends Controller
{
    // Register Function
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'f_name' => 'required|string',
            'l_name' => 'required|string',
            'password' => 'required|min:8|confirmed',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = array_values($validator->errors()->messages());
            return response()->json(['success' => false, 'message' => $messages]);
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->f_name,
                'l_name' => $request->l_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
            ]);

            if (!$user) {
                throw new Exception('User creation failed.');
            }

            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
            ];

            if (!Auth::attempt($credentials)) {
                throw new Exception('Authentication failed after registration.');
            }

            DB::commit();
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => [$e->getMessage()],
            ]);
        }
    }

    // Login Function
    public function signin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = array_values($validator->errors()->messages());
            toastr()->error($messages[0][0]);
            return redirect()->back();
        }

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            toastr()->error('Wrong password. Try again or reset your password.');
            return redirect('/');
        }

        // Check if user has already signed release agreement
        if (Auth::user()->release_signed) {
            return redirect('/gratitude');
        }
        
        return redirect('/release');
    }

    // Forget Password Function
    public function forget(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);
        if ($validator->fails()) {
            $messages = array_values($validator->errors()->messages());
            toastr()->error($messages[0][0]);
            return redirect()->back();
        }
        
        DB::beginTransaction();
        try {
            $otp = rand(1000, 9999);
            $updated = User::where('email', $request->email)->update(['otp_code' => $otp]);

            if (!$updated) {
                throw new Exception('Unable to generate OTP. Please try again.');
            }

            // Send email (if needed)
            // Mail::to($request->email)->send(new NotificationsVerifyEmail($otp));

            Session::put('otpEmail', $request->email);

            DB::commit();
            return redirect('/verify-otp');
        } catch (Exception $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }

    // OTP Verification
    public function verifyOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp_code' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = array_values($validator->errors()->messages());
            toastr()->error($messages[0][0]);
            return redirect()->back();
        }

        $email = Session::get('otpEmail');

        $exists = User::where([
            ['email', '=', $email],
            ['otp_code', '=', $request->otp_code],
        ])->exists();

        if (!$exists) {
            toastr()->error('Invalid OTP Code');
            return redirect()->back();
        }

        return redirect('/reset-password');
    }

    // Update Password Function
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            $messages = array_values($validator->errors()->messages());
            toastr()->error($messages[0][0]);
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            $email = Session::get('otpEmail');

            $updated = User::where('email', $email)->update([
                'otp_code' => null,
                'password' => bcrypt($request->password),
            ]);

            if (!$updated) {
                throw new Exception('Password update failed.');
            }

            DB::commit();
            return redirect('/');
        } catch (Exception $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }

    // Store Release Agreement
    public function storeRelease(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'signature' => 'required',
            'g-recaptcha-response' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false, 
                'message' => 'Please complete all required fields.'
            ]);
        }

        // Verify reCAPTCHA
        $recaptchaResponse = $request->input('g-recaptcha-response');
        $clientIp = $request->ip();
        
        if (!RecaptchaService::verify($recaptchaResponse, $clientIp)) {
            return response()->json([
                'success' => false,
                'message' => 'reCAPTCHA verification failed. Please try again.'
            ]);
        }

        DB::beginTransaction();
        try {
            // Update user record to mark release as signed
            $updated = User::where('id', Auth::id())->update([
                'release_signed' => true,
                'release_signature' => $request->signature,
                'release_signed_at' => now(),
            ]);

            if (!$updated) {
                throw new Exception('Failed to save release agreement.');
            }

            DB::commit();
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    // Logout
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }
}
