<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/4
 * Time: 10:48
 */

namespace app\common\controller;

use think\App;
use think\Controller;
use think\facade\Cookie;
use think\facade\Request;
use think\facade\Config;
use app\common\classes\ReturnCode;

class Base extends Controller
{
    protected $isLogin;
    protected $loginType;
    protected $userInfo;
    protected $userId;
    protected $userName;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
    }


    public function initialize()
    {
        $this->loginType = Config::get('login_type') ?: 'session';
        parent::initialize();
    }

    /**
     * 封装处理用户的请求
     * @param array $paramArr      请求参数
     * @param string $validate 验证器名
     * @param string $model        模型
     * @param string $actionName   操作名称
     * @return array
     * @throws \Exception
     */
    protected function handleUserAction($paramArr = array(), $model = '', $validate = '',$actionName='')
    {
        try{
            $actionName = $actionName ?: Request::action();
            //是否登录验证
//            if(empty(MainFun::getLoginUserInfo()) && $actionName == 'login'){
//                return ReturnCode::returnCode(403);
//            }
            //获取网络参数
            $paramArr = $this->buildParam($paramArr);
            //数据验证
            if ($validate) {
                $result = $validate->scene($actionName ?: '')->check($paramArr);
                if ($result !== true) {
                    return ReturnCode::returnCode(402, $validate->getError());
                }
            }
            return $model->$actionName($paramArr);
        }catch(\Exception $exception){
             throw $exception;
        }
    }


    /**
     * 网络字段和数据库字段映射
     * @param $paramArr
     * @return array
     */
    protected function buildParam($paramArr=[])
    {
        $paramArr1  = [];
        $paramArr2 = Request::param()?:[];
        if($paramArr)foreach( $paramArr as $item => $value ){
            $paramArr1[$item] = Request::param($value)?:[];
            unset($paramArr2[$value]);
        }
        return array_merge($paramArr1,$paramArr2);
    }


    /**
     * @return bool
     */
    protected function checkLogin()
    {
        $check_success = false;
        if (Cookie::get('uid')) {
            $check_success = true;
        }
        return $check_success;
    }




}