<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/4
 * Time: 11:08
 */

namespace app\common\validate;


use think\Validate;

class User extends Validate
{

    /**
     * 验证规则
     * @var array
     */
    protected $rule = [
        'account' => 'require',
        'password' => 'require',
    ];


    /**
     * 提示信息
     * @var array
     */
    protected $message = [
        'account.require'  => '请填写用户名',
        'password.require'   => '请填写密码'
    ];


    /**
     * 验证场景
     * @var array
     */
    protected $scene = [
        'logIn'    => ['account', 'password'],
        'addUser'  => ['account', 'password']
    ];
}