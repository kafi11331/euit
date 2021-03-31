<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function message($type, $message)
    {
        if ($type == 'success') {
            Session::flash('success', $message);
        } elseif ($type == 'error') {
            Session::flash('error', $message);
        }
    }

    protected function courseFeeCalculate($account, $course_fee)
    {
        if (isset($account->discount_percent) && $account->discount_percent > 0) {
            $total_fee = $course_fee - (($course_fee * $account->discount_percent) / 100);
        } elseif (isset($account->discount_amount) && $account->discount_amount > 0) {
            $total_fee = $course_fee - $account->discount_amount;
        } else {
            $total_fee = $course_fee;
        }
        return $total_fee;
    }

    function containsDecimal( $value ) {
        if ( strpos( $value, "." ) !== false ) {
            return true;
        }
        return false;
    }

    public function sendSms($mobile,$text)
    {
        $url = 'http://users.sendsmsbd.com/smsapi';
        $fields = array(
            'api_key' => urlencode('C20046445d94a3c54b6d14.48937019'),
            'type' => urlencode('text'),
            'contacts' => urlencode($mobile),
            'senderid' => 'European IT',
            'msg' => $text
        );
        $fields_string='';
        foreach($fields as $key=>$value){
            $fields_string .= $key.'='.$value.'&';
        }
        rtrim($fields_string, '&');
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);

        if (strpos($result, 'SMS SUBMITTED: ID') !== false) {
            return true;
        } elseif ($result == '1002') {
            return "Sender Id/Masking Not Found";
        } elseif ($result == '1003') {
            return "API Not Found";
        } elseif ($result == '1004') {
            return "SPAM Detected";
        } elseif ($result == '1005' || $result == '1006') {
            return "Internal Error";
        } elseif ($result == '1007') {
            return "Balance Insufficient";
        } elseif ($result == '1008') {
            return "Message is empty";
        } elseif ($result == '1009') {
            return "Message Type Not Set (text/unicode)";
        } elseif ($result == '1010') {
            return "Invalid User & Password";
        } elseif ($result == '1011') {
            return "Invalid User Id";
        } elseif ($result == '1012') {
            return "Invalid Number Found";
        }
        return "Something went wrong :(";
    }

}
