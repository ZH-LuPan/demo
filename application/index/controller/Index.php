<?php
namespace app\index\controller;




use think\Controller;
use think\Db;
use think\Request;

class Index extends Controller
{

    public function index()
    {
        return $this->fetch('',array(
            'count' => Db::name('skill')->where('status',1)->count()
        ));
    }


    /**
     * @param Request $request
     * @return array
     * @throws \think\exception\DbException
     */
    public function getList(Request $request)
    {
        if($request->isPost()){
            $result = array();
            $postArr = $request->param();
            $where = 'status = 1 ';
            if($postArr['type'] == 'skill'){   //技术库skill
                if($postArr['searchType'] == 1) {  //搜索技术名称
                    isset($postArr['keyword']) && $where .= "and  name like ". "'%".$postArr['keyword']."%'";
                }
                if($postArr['searchType'] == 3){    //搜索描述
                    isset($postArr['keyword']) && $where .= "and  description like ". "'%".$postArr['keyword']."%'";
                }
                $result = Db::name('skill')->order('id')->where($where)->paginate(10)->toArray();

            }else if($postArr['type'] == 'talent'){
                if($postArr['searchType'] == 2){    //搜索描述
                    isset($postArr['keyword']) && $where .= "and  name like ". "'%".$postArr['keyword']."%'";
                }
                $result = Db::name('talent')->orderRaw("convert(`name` using gbk) asc")->where($where)->paginate(10)->toArray();
            }
            $indexId = (($postArr['page'] - 1) * $postArr['size']);
            if(is_array($result['data'])) foreach ($result['data'] as $key => $value){
                $result['data'][$key]['indexId'] = ($indexId + $key + 1);
            }
            return array('code'=>200,'data'=>$result);
        }
    }



}
