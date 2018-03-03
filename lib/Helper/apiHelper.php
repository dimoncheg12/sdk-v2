<?php
namespace Fondy\Helper;


class ApiHelper
{
    /**
     * @var string sign separator
     */
    const signatureSeparator = '|';

    /**
     * @param array $params
     * @param $secret_key
     * @param $version
     */
    public static function generateSignature($params = [], $secret_key, $version, $encoded = true)
    {

        if ($version == '2.0') {
            if ($encoded) {
                $signature = sha1($secret_key . self::signatureSeparator . base64_encode(json_encode($params)));
            } else {
                $signature = $secret_key . self::signatureSeparator . base64_encode(json_encode($params));
            }

        } else {
            $data = array_filter($params,
                function ($var) {
                    return $var !== '' && $var !== null;
                });
            ksort($data);
            $sign_str = $secret_key;
            foreach ($data as $k => $v) {
                $sign_str .= self::signatureSeparator . $v;
            }
            if ($encoded) {
                $signature = sha1($sign_str);
            } else {
                $signature = $sign_str;
            }
        }
        return strtolower($signature);
    }

}