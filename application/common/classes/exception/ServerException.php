<?php
/**
 * Created by PhpStorm.
 * User: aiChenK
 * Date: 2019-01-23
 * Time: 15:24
 */

namespace app\helpers\exception;

class ServerException extends BaseException
{
    public function __construct($message = '', $description = '', $code = 500)
    {
        parent::__construct($message, $description, $code);
    }
}
