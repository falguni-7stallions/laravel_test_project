<?php

namespace App\Services;

use App\Models\Otp;
use Carbon\Carbon;
use Twilio\Rest\Client;

class TwilioService
{
    protected $twilio;

    public function __construct()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');

        if (!$sid || !$token) {
            throw new \Exception("Twilio credentials are missing.");
        }

        $this->twilio = new Client($sid, $token);
    }

    //for sms sending
    public function sendSms($to, $message)
    {
        $this->twilio->messages->create($to, [
            'from' => getenv('TWILIO_PHONE_NUMBER'),
            'body' => $message,
        ]);
    }

    //for otp verification
    public function sendOtp($phone)
    {
        $otp = rand(100000, 999999);

        Otp::updateOrCreate(
            ['phone' => $phone],
            [
                'otp' => $otp,
                'expires_at' => Carbon::now()->addMinutes(10)
            ]
        );

        $this->twilio->messages->create($phone, [
            'from' => env('TWILIO_PHONE_NUMBER'),
            'body' => "Your OTP code is: $otp. It is valid for 10 minutes."
        ]);
    }

}


?>
