<?php

namespace App\Http\Controllers;

use App\Models\Otp;
use App\Services\TwilioService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    public function showForm()
    {
        return view('sms.sms_form');
    }

    public function sendSms(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'message' => 'required|string|max:160',
        ]);

        $otp = mt_rand(100000, 999999);
        $to = $request->input('phone');
        $message = $request->input('message');

        $this->twilioService->sendSms($to, $message.$otp);

        return redirect()->back()->with('status', 'SMS sent successfully!');
    }

    //for otp verification
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        $phone = $request->input('phone');
        $this->twilioService->sendOtp($phone);

        return response()->json(['status' => 'OTP sent successfully!']);
    }

    // Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'otp' => 'required|string'
        ]);

        $phone = $request->input('phone');
        $otp = $request->input('otp');

        // Find the OTP entry for this phone
        $otpEntry = Otp::where('phone', $phone)->first();

        if (!$otpEntry) {
            return response()->json(['status' => 'OTP not found for this phone number'], 404);
        }

        // Check if OTP is valid
        if ($otpEntry->otp === $otp && Carbon::now()->lessThanOrEqualTo($otpEntry->expires_at)) {
            // OTP is valid, you can proceed with your logic (e.g., login, registration)

            // Optionally, delete the OTP record after successful verification
            $otpEntry->delete();

            return response()->json(['status' => 'OTP verified successfully']);
        }

        return response()->json(['status' => 'Invalid or expired OTP'], 400);
    }
}
