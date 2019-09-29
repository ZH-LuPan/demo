<?php
namespace app\helpers\exception;

class LoginException extends BaseException
{
    public function __construct()
    {
        parent::__construct('未登录', '请求无效', 401);
    }
}
