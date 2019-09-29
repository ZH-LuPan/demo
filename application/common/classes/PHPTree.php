<?php
namespace app\common\classes;

/**
 * @name PHPTree
 * @des PHP生成树形结构,无限多级分类
 */
class PHPTree{	

	protected static $config = array(
		'primary_key' 	=> 'id',        //主键
		'parent_key'  	=> 'pid',       //父键
		'expanded_key'  => 'expanded',  //展开属性
		'leaf_key'      => 'leaf',      //叶子节点属性
		'children_key'  => 'children',  //孩子节点属性
		'expanded'    	=> false        //是否展开子节点
	);

	public static $list;

	/* 结果集 */
	protected static $result = array();
	
	/* 层次暂存 */
	protected static $level = array();
	/**
	 * 生成树形结构
	 * @param array $data 二维数组
	 * @param array $options
	 * @return mixed 多维数组
	 */
	public static function makeTree($data,$options=array() ){
		$dataset = self::buildData($data,$options);
		$r = self::makeTreeCore(0,$dataset,'normal');
		return $r;
	}

    /**
     * #方法说明：创建终极目录
     * @param $data
     * @param $field
     * @return array
    # Created by zsc
     */
	public static function createUltimate($data,$field='ultimate'){
        if (is_array($data) ) {
            foreach($data as $key => $value){
                if($data[$key]['children']){
                    $data[$key][$field] = 0;
                    $data[$key]['children']  = self::createUltimate($data[$key]['children'],$field);
                }else{
                    $data[$key][$field] = 1;
                }
            }
        }
       return $data;
    }

    /**
     * #方法说明：获取所有终极目录
     * @param $data
     * @return array
    # Created by zsc
     */
    public static function getAllUltimate($data){
        $result = array();
        if (is_array($data) ) {
            foreach($data as $key => $value){
                if($data[$key]['children']){
                    $children = self::getAllUltimate($data[$key]['children']);
                    $result = array_merge($result,$children);
                }else{
                    $result[] = $value;
                }
            }
        }
        return $result;
    }


    /**
     * #方法说明：查找第一个终极目录
     * @param $data
     * @return array
    # Created by zsc
     */
    public static function findFirstUltimate($data=array()){
        if (is_array($data) ) {
            foreach($data as $key => $value){
                if($value['children']){
                   return PHPTree::findFirstUltimate($value['children']);
                }else{
                    return $value;
                }
            }
        }else return [];
    }

    /**
     * @param array $data
     * @param string $field
     * @return bool
     */
    public static function dateList($data=array(),$field='children'){
        if (is_array($data) ) {
            foreach($data as $key => $value){
                unset($value[$field]);
                static::$list[] = $value;
                if($data[$key][$field]){
                    $data[$key][$field]  = self::dateList($data[$key][$field],$field);
                }
            }
        }
        return static::$list;
    }

    /**
     * @param array $data
     * @param int $level
     * @param string $field
     * @param string $childrenField
     * @return array
     */
    public static function getLevel($data=array(),$level=1,$field='level',$childrenField='children'){
        if (is_array($data)) {
            foreach($data as $key => $value){
                $data[$key][$field] = $level;
                if($data[$key][$childrenField]){
                    $data[$key][$childrenField]  = self::getLevel($data[$key][$childrenField],($level+1),$field,$childrenField);
                }
            }
        }
        return $data;
    }

    /**
     * #方法说明：展开判断
     * @param $data
     * @param $field
     * @return array
    # Created by zsc
     */
    public static function createSpread($data,$field='spread'){
        if (is_array($data) ) {
            foreach($data as $key => $value){
                if($data[$key]['children']){
                    $data[$key][$field] = true;
                    $data[$key]['children']  = self::createSpread($data[$key]['children'],$field);
                }else{
                    $data[$key][$field] = false;
                }
            }
        }
        return $data;
    }






    /* 生成线性结构, 便于HTML输出, 参数同上 */
	public static function makeTreeForHtml($data,$options=array()){
	
		$dataset = self::buildData($data,$options);
		$r = self::makeTreeCore(0,$dataset,'linear');
		return $r;	
	}
	
	/* 格式化数据, 私有方法 */
	private static function buildData($data,$options){
		$config = array_merge(self::$config,$options);
		self::$config = $config;
		extract($config);

		$r = array();
		foreach($data as $item){
			$id = $item[$primary_key];
			$parent_id = $item[$parent_key];
			$r[$parent_id][$id] = $item;
		}
		
		return $r;
	}
	
	/* 生成树核心, 私有方法  */
	private static function makeTreeCore($index,$data,$type='linear')
	{
		extract(self::$config);
		if(is_array($data[$index]))foreach($data[$index] as $id=>$item)
		{
			if($type=='normal'){
				if(isset($data[$id]))
				{
					$item[$expanded_key]= self::$config['expanded'];
					$item[$children_key]= self::makeTreeCore($id,$data,$type);
				}
				else
				{
					$item[$leaf_key]= true;  
				}
				$r[] = $item;
			}else if($type=='linear'){
				$parent_id = $item[$parent_key];
				self::$level[$id] = $index==0?0:self::$level[$parent_id]+1;
				$item['level'] = self::$level[$id];
				self::$result[] = $item;
				if(isset($data[$id])){
					self::makeTreeCore($id,$data,$type);
				}
				
				$r = self::$result;
			}
		}
		return $r;
	}

}


