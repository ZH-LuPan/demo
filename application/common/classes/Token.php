<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/5
 * Time: 14:18
 */

namespace app\common\classes;


class Token
{

    protected  static $secret = 'xh';  //秘钥

    protected static $header = array(
        "alg" => "HS256",
        "typ" => "JWT"
    );


    /**
     * @param array $userInfo
     * @return array
     */
    protected static function  playLoad($userInfo=array())
    {
         return [
             "iat"       => $_SERVER['REQUEST_TIME'],
             "exp"       => $_SERVER['REQUEST_TIME'] + config('token_time'),
             "userId"    => $userInfo['userId'],
             "userName"  => $userInfo['userName'],
         ];
    }

    /**
     * @param $header
     * @param $payload
     * @return string
     */
    public static function signature($header = '',$payload = '')
    {
        return hash_hmac('sha256', $header.$payload, self::$secret );
    }


    /**
     * @param array $userInfo
     * @return string
     */
    public static function createToken($userInfo=array())
    {
        $header = base64_encode(json_encode(self::$header));
        $payload = base64_encode(json_encode(self::playLoad($userInfo)));
        $signature = self::signature($header, $payload);
        return $header . '.' .$payload . '.' . $signature;
    }


    /**
     * @param $jwt
     * @return array|string
     */
    public static function checkToken($jwt)
    {
        $token = explode('.', $jwt);
        list($header64, $payload64, $sign) = $token;
        if (count($token) != 3)
            return false;
        if (self::signature($header64 , $payload64) !== $sign)
            return false;
        $header = json_decode(base64_decode($header64), JSON_OBJECT_AS_ARRAY);
        $payload = json_decode(base64_decode($payload64), JSON_OBJECT_AS_ARRAY);
        if ($header['typ'] != 'JWT' || $header['alg'] != 'HS256')
            return false;
        if (isset($payload['exp']) && $payload['exp'] < time())
            return false;
        return [
            'userId' => $payload['userId'],
            'userName' => $payload['userName']
        ];
    }


    /**
     * 获取token
     * @return string
     */
    public static function getToken()
    {
        $token = '';
        isset($_SERVER['HTTP_AUTHORIZATION']) && $token = $_SERVER['HTTP_AUTHORIZATION'];
        return $token;
    }


}