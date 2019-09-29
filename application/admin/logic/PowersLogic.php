<?php
/**
 *
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/5
 * Time: 16:36
 */

namespace app\admin\logic;


use think\Model;


class PowersLogic extends Model
{



    public function abs($num)
    {
        return abs($num);
    }


}