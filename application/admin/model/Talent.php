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

class Talent extends Base
{
     protected $pk = 'id';
     protected $table = 'demo_talent';
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
            isset($paramArr['keyword']) && $where .= "and  name like ". "'%".$paramArr['keyword']."%'";
            return Db::name('talent')->order('name')->where($where)->paginate(10)->toArray();
        }catch (\Exception $exception){
            return ReturnCode::returnCode(500);
        }
    }



    /**
     * 删除
     * @param array $paramArr
     * @return array|bool
     */
    public function delete($paramArr = array())
    {
        try{
            Db::name('talent')->where('id',$paramArr['id'])->delete();
            return ['code'=>200,'msg'=>'删除成功'];
        }catch (\Exception $exception){
            return ReturnCode::returnCode(500);
        }
    }


    /**
     * 修改
     * @param array $paramArr
     * @return array
     */
    public function edit($paramArr = array())
    {
        try{
            $result = Db::name('talent')->where('id',$paramArr['id'])->data($paramArr)->update();
            if(is_numeric($result)){
                return ['code'=>200,'msg'=>'修改成功'];
            }
        }catch (\Exception $exception){
            return ReturnCode::returnCode(500);
        }
    }


}