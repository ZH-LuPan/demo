<?php
namespace app\helpers\exception;

class PowerException extends BaseException
{
    public function __construct()
    {
        parent::__construct('拒绝访问', '无权限', 403);
    }
}
