<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;  // You can use Cache to store OTP temporarily.

class OtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        // Generate a 6-digit OTP
        $otp = rand(100000, 999999);

        // Store OTP in the cache for 5 minutes (you can adjust the expiry time)
        Cache::put('otp_' . $request->mobile_number, $otp, now()->addMinutes(5));

        // Send OTP to the user's mobile number or email (you can use a service like Twilio, etc.)
        // For now, we'll just return the OTP in the response for testing purposes.
        
        return response()->json([
            'message' => 'OTP sent successfully.',
            'otp' => $otp,  // Only for testing, remove it in production.
        ], 200);
    }

    public function verifyOTP(Request $request)
    {
        // Validate OTP input
        $validator = Validator::make($request->all(), [
            'otp' => 'required|digits:6',
            'mobile_number' => 'required|string',  // Ensure mobile number is included to match the OTP
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid OTP format.',
                'errors' => $validator->errors(),
            ], 400);
        }

        // Get OTP from cache based on the user's mobile number
        $storedOtp = Cache::get('otp_' . $request->mobile_number);

        // Check if the OTP matches
        if ($storedOtp && $request->otp == $storedOtp) {
            return response()->json([
                'message' => 'OTP successfully verified.',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Invalid or expired OTP.',
            ], 400);
        }
    }
}
