<?php
namespace app\admin\controller;

use think\facade\Url;

class Index extends Base
{

    protected $mobileModel;
    protected $paramArr;


    public function initialize()
    {
        parent::initialize();
        if(!$this->checkLogin()){
            $this->redirect(Url::build('User/login'));
        }
    }

    /**
     * 首页(数据列表)
     * @return mixed
     * @throws \Exception
     */
     public function index()
     {
         $this->redirect(Url::build('User/uList'));
     }








}
