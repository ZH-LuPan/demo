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

class Policy extends Base
{
     protected $pk = 'id';
     protected $table = 'demo_policy';
     protected $autoWriteTimestamp = true;



    /**
     * @param null $parameters
     * @return mixed
     */
    public function find($parameters = null)
    {
        return parent::find($parameters)->toArray();
    }


    /**
     * @param null $parameters
     * @param string $field
     * @return array
     */
    public function findAll($parameters = null,$field='')
    {
        return parent::where($parameters)->column($field);
    }


    /**
     * @param array $parameters
     * @return float|string|\think\db\Query
     * @return int
     */
    public function count($parameters)
    {
        return parent::where($parameters)->count();
    }


    /**
     * 获取数据列表
     * @param array $paramArr
     * @return array|mixed|\think\Paginator
     */
    public function get($paramArr = array())
    {
        try{
            $where = 'status = 1 ';
            if($paramArr['keyword']) {  //搜索技术名称
                isset($paramArr['keyword']) && $where .= "and  name like ". "'%".$paramArr['keyword']."%'";
            }
            return Db::name('policy')->where($where)->order('id')->paginate(10)->toArray();
        }catch (\Exception $exception){
            return ReturnCode::returnCode(500);
        }
    }




    /**
     * @param array $paramArr
     * @return array|bool
     */
    public function delete($paramArr = array())
    {
        try{
            Db::name('policy')->where('id',$paramArr['id'])->delete();
            return ['code'=>200,'msg'=>'删除成功'];
        }catch (\Exception $exception){
            return ReturnCode::returnCode(500);
        }
    }


    /**
     * @param array $paramArr
     * @return array
     */
    public function edit($paramArr = array())
    {
        try{
            $result = Db::name('policy')->where('id',$paramArr['id'])->data($paramArr)->update();
            if(is_numeric($result)){
                return ['code'=>200,'msg'=>'编辑成功'];
            }
        }catch (\Exception $exception){
            return ReturnCode::returnCode(500);
        }
    }


}