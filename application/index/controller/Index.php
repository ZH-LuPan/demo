<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\facade\Cookie;
use think\facade\Url;
use think\Request;

class Index extends Controller
{

    public function initialize()
    {
        parent::initialize();
        if (!Cookie::get('uid')) {
            header('Location:http://' . $_SERVER['SERVER_NAME'] . '/admin.php/User/login');
            return false;
        }
    }


    /**
     * 首页
     * @return mixed
     */
    public function index()
    {
        return $this->fetch('', array(
            'count' => Db::name('skill')->where('status', 1)->count(),
            'skillUrl' => Url::build('Index/skillList'),
            'getSkill' => Url::build('Index/getList'),
            'getDetail' => Url::build('Index/getDetail'),
            'priseUrl' => Url::build('Index/enterprise'),
            'policyUrl' => Url::build('Index/policy'),
            'talentUrl' => Url::build('Index/talentList'),
            'adminUrl' => 'http://' . $_SERVER['SERVER_NAME'] . '/admin.php'
        ));
    }


    /**
     * @param Request $request
     * @return array
     * @throws \think\exception\DbException
     */
    public function getList(Request $request)
    {
        if ($request->isPost()) {
            $result = array();
            $postArr = $request->param();
            $where = 'status = 1 ';
            if ($postArr['type'] == 'skill') {   //技术库skill
                if ($postArr['searchType'] == 1) {  //搜索技术名称
                    isset($postArr['keyword']) && $where .= "and  name like " . "'%" . $postArr['keyword'] . "%'";
                }
                if ($postArr['searchType'] == 2) {  //搜索名负责人称
                    isset($postArr['keyword']) && $where .= "and  leader like " . "'%" . $postArr['keyword'] . "%'";
                }
                if ($postArr['searchType'] == 3) {    //搜索描述
                    isset($postArr['keyword']) && $where .= "and  description like " . "'%" . $postArr['keyword'] . "%'";
                }
                $result = Db::name('skill')->order('id')->where($where)->paginate(10)->toArray();

            } else if ($postArr['type'] == 'talent') {
                if ($postArr['searchType'] == 2) {    //搜索描述
                    isset($postArr['keyword']) && $where .= "and  name like " . "'%" . $postArr['keyword'] . "%'";
                }
                $result = Db::name('talent')->orderRaw("convert(`name` using gbk) asc")->where($where)->paginate(10)->toArray();
            }
            $indexId = (($postArr['page'] - 1) * $postArr['size']);
            if (is_array($result['data'])) foreach ($result['data'] as $key => $value) {
                $result['data'][$key]['indexId'] = ($indexId + $key + 1);
            }
            return array('code' => 200, 'data' => $result);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getDetail(Request $request)
    {
        try {
            $name = $request->param('name');
            $type = $request->param('type');
            $result = Db::name($type)->where(['status' => 1, 'name' => $name])->find();
            if(empty($result)) return array('code' => 400, 'data' => '没有找到相关信息');
            $template = ($type === 'talent') ? 'index/talentDetail' : 'index/skillDetail';
            return $this->fetch($template, array(
                'info' => $result ?: []
            ));
        } catch (\Exception $exception) {
            return array('code' => 500, 'data' => '系统异常');
        }
    }


    /**
     * @param Request $request
     * @return array|mixed
     */
    public function skillList(Request $request)
    {
        try {
            if ($request->isPost()) {
                $result = array();
                $postArr = $request->param();
                $where = 'status = 1 ';
                if ($postArr['type'] == 'skill') {   //技术库skill
                    if ($postArr['level']) $where .= 'and second_cate = ' . '"' . $postArr['level'] . '"';
                    if ($postArr['searchType'] == 1) {  //搜索技术名称
                        isset($postArr['keyword']) && $where .= " and  name like " . "'%" . $postArr['keyword'] . "%'";
                    }
                    if ($postArr['searchType'] == 2) {  //搜索名负责人称
                        isset($postArr['keyword']) && $where .= " and  leader like " . "'%" . $postArr['keyword'] . "%'";
                    }
                    if ($postArr['searchType'] == 3) {    //搜索描述
                        isset($postArr['keyword']) && $where .= " and  description like " . "'%" . $postArr['keyword'] . "%'";
                    }
                    $result = Db::name('skill')->order('id')->where($where)->paginate(10)->toArray();
                }
                $indexId = (($postArr['page'] - 1) * $postArr['size']);
                if ($result && is_array($result['data'])) foreach ($result['data'] as $key => $value) {
                    $result['data'][$key]['indexId'] = ($indexId + $key + 1);
                    $result['data'][$key]['description'] = mb_substr($value['description'], 0, 56) . '...';
                }
                return array('code' => 200, 'data' => $result);
            }
        } catch (\Exception $exception) {
            return array('code' => 500, 'data' => '系统异常');
        }
        return $this->fetch('index/skillList', array(
            'count' => Db::name('skill')->where('status', 1)->count(),
            'skillUrl' => Url::build('Index/skillList'),
            'getDetail' => Url::build('Index/getDetail'),
            'talentUrl' => Url::build('Index/talentList'),
            'priseUrl' => Url::build('Index/enterprise'),
            'policyUrl' => Url::build('Index/policy'),
            'indexUrl' => Url::build('/'),
            'adminUrl' => 'http://' . $_SERVER['SERVER_NAME'] . '/admin.php'
        ));
    }

    /**
     * @param Request $request
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function talentList(Request $request)
    {
        if ($request->isPost()) {
            $postArr = $request->param();
            $where = 'status = 1 ';
            if ($postArr['level']) $where .= 'and second_part = ' . '"' . $postArr['level'] . '"';
            if ($postArr['searchType'] == 4) {    //搜索描述
                isset($postArr['keyword']) && $where .= " and  name like " . "'%" . $postArr['keyword'] . "%'";
            }
            if ($postArr['searchType'] == 5) {    //搜索描述
                isset($postArr['keyword']) && $where .= " and  subject_part like " . "'%" . $postArr['keyword'] . "%'";
            }
            $result = Db::name('talent')->orderRaw("convert(`name` using gbk) asc")->where($where)->paginate(10)->toArray();

            $indexId = (($postArr['page'] - 1) * $postArr['size']);
            if (is_array($result['data'])) foreach ($result['data'] as $key => $value) {
                $result['data'][$key]['indexId'] = ($indexId + $key + 1);
            }
            return array('code' => 200, 'data' => $result);
        }
        return $this->fetch('index/talentList', array(
            'count' => Db::name('talent')->where('status', 1)->count(),
            'skillUrl' => Url::build('Index/skillList'),
            'getDetail' => Url::build('Index/getDetail'),
            'talentUrl' => Url::build('Index/talentList'),
            'priseUrl' => Url::build('Index/enterprise'),
            'policyUrl' => Url::build('Index/policy'),
            'indexUrl' => Url::build('/'),
            'adminUrl' => 'http://' . $_SERVER['SERVER_NAME'] . '/admin.php'
        ));
    }


    public function enterprise()
    {
        return $this->fetch('index/enterprise', array(
            'skillUrl' => Url::build('Index/skillList'),
            'getDetail' => Url::build('Index/getDetail'),
            'talentUrl' => Url::build('Index/talentList'),
            'priseUrl' => Url::build('Index/enterprise'),
            'policyUrl' => Url::build('Index/policy'),
            'indexUrl' => Url::build('/'),
            'adminUrl' => 'http://' . $_SERVER['SERVER_NAME'] . '/admin.php'
        ));
    }


    public function policy()
    {
        return $this->fetch('index/policy', array(
            'skillUrl' => Url::build('Index/skillList'),
            'getDetail' => Url::build('Index/getDetail'),
            'talentUrl' => Url::build('Index/talentList'),
            'priseUrl' => Url::build('Index/enterprise'),
            'policyUrl' => Url::build('Index/policy'),
            'indexUrl' => Url::build('/'),
            'adminUrl' => 'http://' . $_SERVER['SERVER_NAME'] . '/admin.php'
        ));
    }


}
