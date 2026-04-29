<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerifyCode;
use App\Mail\ForgotPasswordCode;
use App\Models\EmailVerification;
use App\Models\ForgotPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // user info
    public function user_info(Request $request) {
        return response()->json($request->user(), 200);
    }

    // sign up
    public function sign_up(Request $request) {
        $fields = $request->validate([
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['required', 'string'],
            'user_type' => ['required', 'string', 'in:provider_individual,provider_society,renter_individual,renter_society'],
            'receive_notifications_from' => ['required', 'string', 'in:renter_individual,renter_society,both,none'],
            'profile_picture' => ['image'],
            'documents' => ['required'],
            'documents.*' => ['file']
        ]);

        if (in_array($fields['user_type'], ['renter_individual', 'renter_society']) && $fields['receive_notifications_from'] !== 'none') {
            return response()->json(['message' => 'Receive notifications from must be "none" for renter individuals or societies.'], 422);
        }

        $user = User::create([
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'email' => $fields['email'],
            'phone' => $fields['phone'],
            'user_type' => $fields['user_type'],
            'receive_notifications_from' => $fields['receive_notifications_from'],
            'password' => Hash::make($fields['password']),
        ]);

        if ($request->hasFile('profile_picture')) {
            $profile_picture = $request->file('profile_picture');
            $path = $profile_picture->store('public/users/pfps');
            $user->profile_picture = $path;
            $user->save();
        }

        $documents = $request->file('documents');

        foreach ($documents as $document) {
            $path = $document->store('public/users/documents');
            $user->documents()->create(['path' => $path]);
        }

        return response()->json($user, 201);
    }

    // sign in
    public function sign_in(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {

            throw ValidationException::withMessages([
                'message' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => $user,
            'access_token' => $token,
            'message' => 'Login successful',
        ], 200);
    }

    // sign out
    public function sign_out(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out'], 200);
    }

    // update user
    public function update_user(Request $request) {
        $fields = $request->validate([
            'first_name' => ['string'],
            'last_name' => ['string'],
            'email' => ['string', 'email', 'unique:users,email'],
            'phone' => ['string'],
            'receive_notifications_from' => ['string', 'in:renter_individual,renter_society,both,none'],
            'profile_picture' => ['image'],
            'documents' => ['array'],
            'documents.*' => ['file']
        ]);

        $user = $request->user();

        if ($request->hasFile('profile_picture')) {
            $profile_picture = $request->file('profile_picture');
            $path = $profile_picture->store('public/users/pfps');
            $user->profile_picture = $path;
            $user->save();
        }

        if ($request->hasFile('documents')) {
            $documents = $request->file('documents');

            foreach ($documents as $document) {
                $path = $document->store('public/users/documents');
                $user->documents()->create(['path' => $path]);
            }
        }

        $user->update([
            'first_name' => $fields['first_name'] ?? $user->first_name,
            'last_name' => $fields['last_name'] ?? $user->last_name,
            'email' => $fields['email'] ?? $user->email,
            'phone' => $fields['phone'] ?? $user->phone,
            'receive_notifications_from' => $fields['receive_notifications_from'] ?? $user->receive_notifications_from,
        ]);

        return response()->json($user, 200);
    }

    public function sendEmailVerificationCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $code = Str::random(6);
        $code_expires_at = now()->addMinutes(10);

        EmailVerification::create([
            'email' => $request->email,
            'code' => $code,
            'code_expires_at' => $code_expires_at
        ]);

        Mail::to($request->email)->send(new EmailVerifyCode($code));

        return response()->json([
            'success' => true,
            'message' => 'Verification code sent successfully'
        ]);
    }

    public function verifyEmailCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $email_verification = EmailVerification::where('email', $request->email)
            ->where('code', $request->code)
            ->latest()
            ->first();

        if (!$email_verification) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid code'
            ], 400);
        }

        if ($email_verification->code !== $request->code) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid code'
            ], 400);
        }

        if ($email_verification->code_expires_at < now()) {
            return response()->json([
                'success' => false,
                'message' => 'Code expired'
            ], 400);
        }

        $user->email_verified_at = now();
        $user->save();

        $email_verification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Email verified successfully'
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
            ],
        ]);

        $user = $request->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'Old password is incorrect'], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password updated successfully'], 200);
    }

    public function sendForgotPasswordCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $code = Str::random(6);
        $token = Str::random(64);
        $code_expires_at = now()->addMinutes(10);

        ForgotPassword::create([
            'email' => $request->email,
            'code' => $code,
            'code_expires_at' => $code_expires_at,
            'token' => $token
        ]);

        Mail::to($request->email)->send(new ForgotPasswordCode($code));

        return response()->json([
            'success' => true,
            'message' => 'Verification code sent successfully'
        ]);
    }

    public function verifyForgotPasswordCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string'
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        // Find the email verification record
        $forgot_password = ForgotPassword::where('email', $request->email)
            ->where('code', $request->code)
            ->latest() // Ensure we get the latest code attempt
            ->first();

        if (!$forgot_password) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid code'
            ], 400);
        }

        if ($forgot_password->code !== $request->code) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid code'
            ], 400);
        }

        // Check if the code has expired
        if ($forgot_password->code_expires_at < now()) {
            return response()->json([
                'success' => false,
                'message' => 'Code expired'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Code verified successfully',
            'token' => $forgot_password->token // Return the token
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'new_password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
            ],
            'token' => 'required|string' // Add token validation
        ]);

        $forgot_password = ForgotPassword::where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$forgot_password) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token'
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        // Optionally, delete the verification code record after successful verification
        $forgot_password->delete();

        return response()->json(['message' => 'Password reset successfully'], 200);
    }

    // delete user
    public function delete_user(Request $request) {
        $user = $request->user();
        $user->delete();

        return response()->json(['message' => 'User deleted'], 200);
    }
}
