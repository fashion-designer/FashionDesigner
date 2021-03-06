<?php
/**
 * garmentor Helpers
 */

use Illuminate\Support\Facades\Cookie;
use Carbon\Carbon;

if (! function_exists('garmentor_encrypt_with_time')) {
    /**
     * Encrypt String With Time
     * @param $string
     * @return string
     */
    function garmentor_encrypt_with_time($string)
    {
        $encryption = openssl_encrypt($string . microtime(true), env('CIPHERING_METHOD'), env('CIPHERING_KEY'), 0, env('CIPHERING_IV'));

        return base64_encode($encryption);
    }
}

if (! function_exists('garmentor_get_default_display_image')) {
    /**
     * Get Default Display Image
     */
    function garmentor_get_default_display_image()
    {
        $content = file_get_contents(public_path('images/default_image.jpeg'));

        return 'data:image/png;base64, ' . base64_encode($content);
    }
}

if (! function_exists('garmentor_set_alert_message_cookie')) {
    /**
     * Set alert message to cookie
     * @param $alertMessage
     * @param $alertType
     */
    function garmentor_set_alert_message_cookie($alertMessage, $alertType)
    {
        Cookie::queue('alertMessage', $alertMessage, 10);
        Cookie::queue('alertType', $alertType, 10);
    }
}

if (! function_exists('garmentor_get_alert_message_cookie')) {
    /**
     * Get alert message from cookie
     * @return array|bool
     */
    function garmentor_get_alert_message_cookie()
    {
        if(isset($_COOKIE['alertMessage']) && isset($_COOKIE['alertType']))
        {
            $alertMessage   = decrypt($_COOKIE['alertMessage']);
            $alertType      = decrypt($_COOKIE['alertType']);

            Cookie::queue(Cookie::forget('alertMessage'));
            Cookie::queue(Cookie::forget('alertType'));

            return [
                'alertMessage' => $alertMessage,
                'alertType' => $alertType
            ];
        }

        return false;
    }
}

if (! function_exists('garmentor_get_human_readable_time')) {
    /**
     * Get date time in human readable format
     * @param $dateString
     * @return array|bool
     */
    function garmentor_get_human_readable_time($dateString)
    {
        return Carbon::make($dateString)->diffForHumans();
    }
}