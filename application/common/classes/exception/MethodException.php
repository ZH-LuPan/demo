<?php
/**
 * Created by PhpStorm.
 * User: aiChenK
 * Date: 2019-01-23
 * Time: 15:24
 */

namespace app\helpers\exception;

class MethodException extends BaseException
{
    public function __construct($message = '请求错误')
    {
        parent::__construct($message, '暂不支持该方法', 405);
    }
}
