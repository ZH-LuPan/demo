<?php

/**
 * 数组操作工具类
 *
 * PHP Version 7.2
 *
 * @category  可以写部门(英文)
 * @package   可以写模块(英文)
 * @author    moShi
 * @time      2019/6/5 11:48
 * @copyright 2019 学海教育科技有限公司
 * @license   公司网址 license
 * @link      1432748004@qq.com
 */


namespace app\common\classes;


class Attr
{

    /**
     * @power luPan
     * @param array $array 数组分页数据
     * @param int $page 当前页数
     * @param int $pageSize 每页多少条
     * @param int $order 排序
     * @return array  分页数据
     */
    public static function arrayPage($array = [], $page = 1, $pageSize = 100, $order = 0)
    {
        if ($pageSize <= 0) return [];
        $page = (empty($page)) ? '1' : $page; #判断当前页面是否为空 如果为空就表示为第一页面
        $start = ($page - 1) * $pageSize;     #计算每次分页的开始位置
        $order == 1 && $array = array_reverse($array);
        $totals = count($array);
        $pageCount = ceil($totals / $pageSize); #计算总页面数
        $data = array_slice($array, $start, $pageSize);
        return ['data' => $data, 'count' => $totals, 'page' => $page, 'pageCount' => $pageCount];  #返回查询数据
    }


    /**
     * 方法说明：对二维数组按照某个字段进行排序
     * @param array $arr 二维数组
     * @param string $str 字段名称
     * @param string $sortType
     * @return array   返回排序后的数组
     * @create by lp
     */
    public static function arraySortByField($arr = array(), $str = "", $sortType = 'SORT_ASC')
    {
        $sort = array(
            'direction' => $sortType, //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
            'field' => $str,       //排序字段
        );
        $arrSort = array();
        if (is_array($arr)) foreach ($arr AS $uniqId => $row) {
            if (is_array($row)) foreach ($row AS $key => $value) {
                $arrSort[$key][$uniqId] = $value;
            }
        }
        if ($sort['direction'] && is_array($arrSort[$sort['field']])) {
            @array_multisort($arrSort[$sort['field']], constant($sort['direction']), $arr);
        }
        return $arr;
    }

    /**
     * 使用递归实现无限级分类
     * @param array $nodeArr
     * @param int $pid
     * @return array|string
     *
     * @author lp
     */
    public static function recursionAttr($nodeArr = [],$pid = 0)
    {
        $nodeData = [];
        if (is_array($nodeArr)) foreach ($nodeArr as $key => $val)
        {
            if ($val['parent_id'] == $pid)
            {
                $val['children'] = self::recursionAttr($nodeArr, $val['id']);
                $nodeData[] = $val;
            }
        }
        return $nodeData;
    }

    /**
     * 方法说明：判断数组维度
     * @param $array
     * @return int
     *
     * @author lp
     */
    public static function arrayDepth($array)
    {
        if (!is_array($array)) return 0;
        $maxDepth = 1;
        foreach ($array as $value)
        {
            if (is_array($value))
            {
                $depth = self::arrayDepth($value) + 1;
                if ($depth > $maxDepth) {
                    $maxDepth = $depth;
                }
            }
        }
        return $maxDepth;
    }


    /**
     * 移除二位数组中相同的元素并保留一个
     * @param $array
     * @return array
     *
     * @author lp
     */
    public static function removeDuplicate($array=[])
    {
        $out = array();
        foreach ($array as $key=>$value)
        {
            if (!in_array($value, $out))
            {
                $out[$key] = $value;
            }
        }
        $out = array_values($out);
        return $out;
    }


    /**
     * 递归形成 菜单树
     * @param array $data   结果集 (整个表的结果)
     * @param int $pid      父类ID
     * @param array $result 结果数据
     * @param int $deep     分类级数
     *
     * @return array
     */
    public static function getTreeList($data, $pid = 0, &$result = array(), $deep = 0)
    {
        $deep += 1;
        foreach($data as $key => $val)   //遍历之后，此处的$key是键(其实是数组的序列号)，$val是一条数据结果
        {
            if($pid == $val['parent_id'])
            {
                $result[$key]['name'] = "|".str_repeat("--", $deep).$val['name'];
                $result[$key]['parent_id'] = $val['parent_id'];
                self::getTreeList($data, $val['id'], $result, $deep);
            }
        }
        return $result;
    }


    /**
     * 挑选一维数组数组中的一些字段
     * array_flip [将数组的键和值对调]
     * array_intersect_key [使用键名比较计算数组的交集]
     * @param $array
     * @param $keys
     * @return array
     */
    public static function optionArr(array $array, array $keys)
    {
        return array_intersect_key($array, array_flip($keys));
    }


    /**
     * 挑选二维数组中的一些字段
     * @param array $data
     * @param array $optionFields
     * @return array
     */
    public static function optionArrFields(array $data=array(),$optionFields=array())
    {
        $result = array();
        if($data)foreach ($data as $key => $value){
            foreach ($optionFields as $k){
                $result[$key][$k] = $value[$k];
            }
        }
        return $result;
    }


    /**
     * 数组去重  性能优于array_unique()
     * @param array $data
     * @return array|null
     */
    public static function arrayUnique(array $data = [])
    {
        return array_flip(array_flip($data));
    }

    /**
     * 反转数组
     * @param  array $arr
     * @return array
     */
    public static function reverse($arr)
    {
        $n = count($arr);
        $left = 0;
        $right = $n - 1;
        while ($left < $right) {
            $temp = $arr[$left];
            $arr[$left++] = $arr[$right];
            $arr[$right--] = $temp;
        }
        return $arr;
    }


}
