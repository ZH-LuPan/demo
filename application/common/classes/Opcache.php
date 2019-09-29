<?php
/**
 * Opcache缓存封装类
 * Powers by PhpStorm.
 * User: Administrator
 * DateTime: 2019/6/5  18:21
 */

namespace app\common\classes;


class Opcache{

    private $configuration;     //配置信息
    private $status;            //状态


    public function __construct()
    {
        $this->configuration = opcache_get_configuration();
        $this->status = opcache_get_status();
    }


    /**
     * 获取配置
     * @return array
     */
    public function getConfig()
    {
        return $this->configuration;
    }

    /**
     * 获取状态
     * @return array
     */
    public function getStatus()
    {
        return $this->status;
    }


    /**
     * 指定某脚本缓存失效
     * @param $script
     * @return bool
     */
    public function invalidate($script)
    {
        return opcache_invalidate($script);
    }

    /**
     * 重置或清除整个字节码缓存
     * @return bool
     */
    public function reset()
    {
        return opcache_reset();
    }


    /**
     * 无需运行，就可以编译并缓存脚本
     * @param $file
     * @return bool
     */
    public function compile($file)
    {
        return opcache_compile_file($file);
    }

    /**
     * 判断某个脚本是否已经缓存到Opcache
     * @param $script
     * @return bool
     */
    public function isCached($script)
    {
        return opcache_is_script_cached($script);
    }


}