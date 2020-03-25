<?php

namespace app\admin\controller;


class Base extends \app\common\controller\Base
{
    protected $menu;
    protected $user;


    public function __construct()
    {
        parent::__construct();
        $this->assignCommon();
    }


    public function initialize()
    {
        parent::initialize();
    }

    /**
     * 公共部分渲染
     */
    public function assignCommon()
    {
        $menu = [
            ['name' => '用户管理', 'url' => url('User/uList')],
            ['name' => '技术库', 'url' => url('Skill/index')],
            ['name' => '人才库', 'url' => url('Talent/index')]
        ];
        $this->view->assign('menus', $menu);
    }

}