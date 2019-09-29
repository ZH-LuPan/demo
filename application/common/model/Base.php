<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/5
 * Time: 11:11
 */

namespace app\common\model;


use think\Model;

class Base extends Model
{


    /**
     * @param array $map
     * @param string $field
     * @param array $append
     * @return array
     * @throws \think\exception\DbException
     */
    protected function getArrayByMap($map = [],$field='',$append=[])
    {
        $object = $this->where($map)->field($field)->findOrEmpty();
        if(!empty($object)&&!empty($append)){
            $return = $object->append($append);
        }else{
            $return = $object;
        }
        return empty($return) ? [] : $return->toArray();
    }


    /**
     * @param array $map
     * @param string $field
     * @param array $append
     * @return array
     * @throws \think\exception\DbException
     */
    protected function getListByMap($map = [],$field='',$append=[])
    {
        $list=[];
        $objectList = $this->where($map)->field($field)->select();
        if(!empty($objectList)){
            foreach($objectList as $item=>$value){
                if(!empty($append)){
                    $list[]= $value->append($append)->toArray();
                }else{
                    $list[]= $value->toArray();
                }
            }
        }
        return $list;
    }
}