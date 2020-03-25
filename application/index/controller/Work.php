<?php
namespace app\index\controller;

use think\Controller;
use think\facade\Url;
use think\Request;

class Work extends Controller
{


    public function contentCompare(Request $request)
    {
        try{
            return false;
            if($request->isPost()){
                $postArr = $request->param();
                preg_match_all('/1[356789]\d{9}/',$postArr['one'],$one);
                preg_match_all('/1[356789]\d{9}/',$postArr['two'],$two);
                $duplicate = array_intersect_assoc($one[0],$two[0]);
                $result = array_merge(array_diff($two[0], $duplicate));
                return array('code'=>200,'data'=>implode('
',$result));
            }
        }catch (\Exception $exception){
            return array('code'=>500,'data'=>'系统异常');
        }
        return $this->fetch('work/contentCompare',array(
            'apiUrl' => Url::build('Work/contentCompare')
        ));
    }


}
