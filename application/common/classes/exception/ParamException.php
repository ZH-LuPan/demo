<?php
namespace app\helpers\exception;

class ParamException extends BaseException
{
    public function __construct($message = '')
    {
        parent::__construct('参数错误', $message, 400);
    }
}
