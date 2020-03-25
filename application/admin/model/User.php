<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/5
 * Time: 11:09
 */

namespace app\admin\model;


use app\common\classes\ReturnCode;
use think\Db;
use think\facade\Url;


class User extends Base
{
     protected $pk = 'id';
     protected $table = 'demo_user';
     protected $autoWriteTimestamp = true;


    /**
     * 登陆
     * @param array $userInfo
     * @return array
     * @throws \think\exception\DbException
     */
    public function login($userInfo = array())
    {
        $userName = $userInfo['account'];
        $password = $userInfo['password'];
        $user = $this->getArrayByMap(['name'=>$userName,'status'=>1],'id,name');
        if(!$user)
            return ReturnCode::returnCode(402,'用户不存在');
        $user = $this->getArrayByMap(['name'=>$userName,'password'=>$password]);
        if(!$user)
            return ReturnCode::returnCode(402,'用户名或密码不正确');
        $expire = 3600*24*7;
        cookie('uid',$user['id'],$expire);
        cookie('type',$user['is_admin'],$expire);
        cookie('name',$user['name'],$expire);
        return ReturnCode::returnCode(200,'登陆成功','http://'.$_SERVER['SERVER_NAME'].'/index.php');
    }


    /**
     * @param null $parameters
     * @return mixed
     */
    public function find($parameters = null)
    {
        return parent::find($parameters)->toArray();
    }


    /**
     * 获取用户
     * @param array $paramArr
     * @return array
     */
    public function get($paramArr = array())
    {
        try{
            $where = 'is_admin = 2 and status = 1 ';
            isset($paramArr['keyword']) && $where .= "and  name like ". "'%".$paramArr['keyword']."%'";
            return Db::name('user')->where($where)->paginate(10)->toArray();
        }catch (\Exception $exception){
            return ReturnCode::returnCode(500);
        }
    }


    /**
     * 添加用户
     * @param array $paramArr
     * @return array
     */
    public function add($paramArr = array())
    {
        try{
            $isHave = User::where('name',$paramArr['account'])->where('status',1)->count();
            if($isHave) return ['code'=>400,'msg'=>'此用户已存在'];
            $paramArr['create_time'] = time();
            $paramArr['update_time'] = time();
            $paramArr['name'] = trim($paramArr['account']);
            $result = User::create($paramArr);
            if($result){
                return ['code'=>200,'msg'=>'添加成功'];
            }
        }catch (\Exception $exception) {
            return ['code'=>500,'msg'=>'系统异常'];
        }
    }

    /**
     * 修改用户
     * @param array $paramArr
     * @return array
     */
    public function edit($paramArr = array())
    {
        try{
            User::isUpdate()->where('id',$paramArr['id'])->update($paramArr);
            return ['code'=>200,'msg'=>'修改成功'];
        }catch (\Exception $exception){
            return ['code'=>500,'msg'=>'系统异常'];
        }

    }


    /**
     * 删除用户
     * @param array $paramArr
     * @return array
     */
    public function delete($paramArr = array())
    {
        try{
            Db::name('user')->where('id',$paramArr['id'])->update(['status'=>0]);
            return ['code'=>200,'msg'=>'操作成功'];
        }catch (\Exception $exception){
            return ['code'=>500,'msg'=>'系统异常'];
        }
    }

}