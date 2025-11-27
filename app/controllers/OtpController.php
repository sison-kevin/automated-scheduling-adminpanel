<?php namespace App\Controllers;

use App\Models\UserModel;
use App\Services\SmsService;

class OtpController extends \LavaLust\Controller
{
    public function showPhoneForm()
    {
        return view('otp_phone');
    }

    public function sendOtp()
    {
        $phone = $this->request->post('phone');

        // generate code & expiry
        $otp = rand(100000, 999999);
        $expiry = date("Y-m-d H:i:s", strtotime("+5 minutes"));

        $userModel = new UserModel();
        $user = $userModel->where('phone', $phone)->first();

        if ($user) {
            $userModel->update($user['id'], [
                'otp_code'   => $otp,
                'otp_expiry' => $expiry
            ]);
        } else {
            $userModel->insert([
                'phone'      => $phone,
                'otp_code'   => $otp,
                'otp_expiry' => $expiry
            ]);
        }

        $sms = new SmsService();
        $sms->send($phone, "Your login code is: {$otp}");

        session()->set('otp_phone', $phone);

        return redirect()->to('verify-otp')->with('message', 'OTP sent to your phone.');
    }

    public function showVerifyForm()
    {
        return view('otp_verify');
    }

    public function verifyOtp()
    {
        $phone = session()->get('otp_phone');
        $otp   = $this->request->post('otp');

        $userModel = new UserModel();
        $user = $userModel->where('phone', $phone)
                           ->where('otp_code', $otp)
                           ->first();

        if ($user && strtotime($user['otp_expiry']) > time()) {
            // login success: set user session
            session()->set('user_id', $user['id']);
            // clear OTP
            $userModel->update($user['id'], [
                'otp_code' => NULL,
                'otp_expiry'=> NULL
            ]);

            return redirect()->to('dashboard')->with('success', 'Logged in!');
        }

        return redirect()->back()->with('error', 'Invalid or expired code!');
    }
}
