<?php
namespace app\admin\controller;

class Index extends Base
{

    protected $mobileModel;
    protected $paramArr;


    public function initialize()
    {
        parent::initialize();
        if(!$this->checkLogin()){
            $this->redirect('/admin.php/User/login');
        }
    }

    /**
     * 首页(数据列表)
     * @return mixed
     * @throws \Exception
     */
     public function index()
     {
         $this->redirect('User/uList');
     }








}
