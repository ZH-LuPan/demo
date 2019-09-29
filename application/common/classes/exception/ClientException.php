<?php
/**
 * Created by PhpStorm.
 * User: aiChenK
 * Date: 2019-01-23
 * Time: 15:24
 */

namespace app\helpers\exception;

class ClientException extends BaseException
{
    public function __construct($message = '', $description = '', $code = 400)
    {
        parent::__construct($message, $description, $code);
    }
}
