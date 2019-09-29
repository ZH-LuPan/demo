<?php
/**
 * Created by PhpStorm.
 * User: aiChenK
 * Date: 2019-01-23
 * Time: 15:24
 */

namespace app\helpers\exception;


abstract class BaseException extends \Exception
{

    protected $description;

    /**
     * BaseException constructor.
     * @param string|null $message
     * @param string $description
     * @param int|null $code
     */
    public function __construct($message = null, $description = '', $code = null)
    {
        $this->message      = $message;
        $this->description  = $description;
        $this->code         = $code;
        parent::__construct();
    }


    final public function getDescription($jsonEncode = false)
    {
        return $jsonEncode ? json_encode($this->description, JSON_UNESCAPED_UNICODE) : $this->description;
    }
}
