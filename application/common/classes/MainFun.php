<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/5
 * Time: 18:21
 */

namespace app\common\classes;

use think\facade\Session;

class MainFun
{

    /**
     * 獲取登陸用戶信息
     * @param string $field
     * @return mixed
     */
    public static function getLoginUserInfo($field='')
    {
        if (empty($field)) return Session::get('uid','Global');
        return Session::get($field,'Global');
    }
}