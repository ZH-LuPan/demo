<?php
namespace app\admin\controller;


use app\admin\model\User as UserModel;
use app\common\validate\User as UserValidate;
use think\Db;
use think\facade\Cookie;
use think\facade\Request;
use think\facade\Url;


class User extends Base
{

    protected $userModel;
    protected $userValidate;
    protected $paramArr;


    /**
     * 构造函数
     * Index constructor.
     * @param UserModel $user
     * @param UserValidate $validate
     */
     public function __construct(UserModel $user,UserValidate $validate){
         parent::__construct();
         $this->userModel = $user;
         $this->userValidate = $validate;
         $this->paramArr = [];
     }

    /**
     * @return mixed
     */
     public function index()
     {
         return $this->fetch('index/login');
     }

    /**
     * @return array|mixed
     * @throws \Exception
     */
     public function uList()
     {
         if(Request::isPost()){
             return $this->handleUserAction($this->paramArr,$this->userModel,'','get');
         }
         return $this->fetch('index/userList',[
             'count' => Db::name('user')->where('is_admin',2)->where('status',1)->count(),
             'editUrl' => Url::build('User/edit'),
             'getUrl' => Url::build('User/uList'),
             'delUrl' => Url::build('User/delete')
         ]);
     }

    /**
     * 登陆
     * @return array|mixed
     * @throws \Exception
     */
     public function login()
     {
         if(Request::isPost()){
             $this->paramArr = [
                 'account' => 'name'
             ];
             return $this->handleUserAction($this->paramArr,$this->userModel,$this->userValidate,'login');
         }
         return $this->fetch('index/login',array(
             'loginUrl' => Url::build('User/login')
         ));
     }


    /**
     * 注销
     */
     public function logout()
     {
         Cookie::set('uid',null);
         $this->redirect('/admin.php/User/index');
     }


    /**
     * 添加用户
     * @return array|mixed
     * @throws \Exception
     */
    public function addUser()
    {
        if(Request::isPost()){
            return $this->handleUserAction($this->paramArr,$this->userModel,$this->userValidate,'add');
        }
        return $this->fetch('index/addUser',array(
            'addUserUrl' => Url::build('User/addUser')
        ));
    }


    /**
     * 编辑用户
     * @return array|mixed
     * @throws \Exception
     */
    public function edit()
    {
        if(Request::isPost()){
            return $this->handleUserAction($this->paramArr,$this->userModel,'','edit');
        }
    }

    /**
     * 删除用户
     * @return array|mixed
     * @throws \Exception
     */
    public function delete()
    {
        if(Request::isPost()){
            return $this->handleUserAction($this->paramArr,$this->userModel,'','delete');
        }
        return $this->fetch('index/addUser');
    }






}
