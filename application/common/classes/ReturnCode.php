<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/4
 * Time: 10:39
 */

namespace app\common\classes;

class ReturnCode
{
    /**
     * Power by lp
     * @param $code
     * @param $data
     * @param $msg
     */
    static public $returnCode = [
        '200' => '操作成功',
        '302' => '未登录',
        '401' => '请求类型错误',   //非法的请求方式 非ajax
        '402' => '请求参数错误',   //如参数不完整,类型不正确
        '403' => '登录过期',       //未登录 或者 未授权
        '405' => '数据添加失败',
        '406' => '数据不存在',
        '407' => '模块不存在',
        '500' => '系统异常'
    ];


    /**
     * 封装code信息
     * @param string $code
     * @param array $data
     * @param string $msg
     * @return array
     * @author lp
     */
    static public function showReturnCode($code = '', $msg = '',$data = [])
    {
        $returnData = [
            'code' => '500',
            'msg' => '系统异常',
        ];
        if (empty($code)) return $returnData;
        $returnData['code'] = $code;
        ($code == 200 && $data) && $returnData['data'] = $data ;
        if (!empty($msg)) {
            $returnData['msg'] = $msg;
        } else if (isset(self::$returnCode[$code])) {
            $returnData['msg'] = self::$returnCode[$code];
        }
        return $returnData;
    }

    /**
     * @param string $code
     * @param string $msg
     * @param array $data
     * @return array
     */
    static public function returnCode($code = '', $msg = '',$data = [])
    {
        return self::showReturnCode($code,$msg,$data);
    }

    /**
     * @param string $data
     * @return string $data
     */
    static public  function returnJsonData($data = '')
    {
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    static public function sendMsgResponse()
    {

    }
}