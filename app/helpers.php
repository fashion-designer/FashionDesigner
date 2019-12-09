<?php
/**
 * HYD Helpers
 */

if (! function_exists('hyd_encrypt_with_time')) {
    /**
     * Encrypt String With Time
     * @param $string
     * @return string
     */
    function hyd_encrypt_with_time($string)
    {
        $encryption = openssl_encrypt($string . microtime(true), env('CIPHERING_METHOD'), env('CIPHERING_KEY'), 0, env('CIPHERING_IV'));

        return base64_encode($encryption);
    }
}

if (! function_exists('hyd_encrypt_string')) {
    /**
     * Encrypt String With Time
     * @param $string
     * @return string
     */
    function hyd_encrypt_string($string)
    {
        $encryption = openssl_encrypt($string, env('CIPHERING_METHOD'), env('CIPHERING_KEY'), 0, env('CIPHERING_IV'));

        return base64_encode($encryption);
    }
}

if (! function_exists('hyd_get_default_display_image')) {
    /**
     * Get Default Display Image
     */
    function hyd_get_default_display_image()
    {
        $content = file_get_contents(public_path('images/default_image.jpeg'));

        return 'data:image/png;base64, ' . base64_encode($content);
    }
}