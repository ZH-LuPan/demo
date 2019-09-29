<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/5
 * Time: 18:21
 */

namespace app\common\classes;


class Tool
{

    /**
     * 判断文件是否可写权限
     * @param $file
     * @return bool
     */
    function is_really_writable($file)
    {
        if (DIRECTORY_SEPARATOR == '/' AND @ini_get("safe_mode") == FALSE)
        {
            return is_writable($file);
        }
        if (is_dir($file))
        {
            $file = rtrim($file, '/').'/'.md5(mt_rand(1,100).mt_rand(1,100));
            if (($fp = @fopen($file, FOPEN_WRITE_CREATE)) === FALSE)
            {
                return FALSE;
            }
            fclose($fp);
            @chmod($file, DIR_WRITE_MODE);
            @unlink($file);
            return TRUE;
        } elseif ( ! is_file($file) OR ($fp = @fopen($file, FOPEN_WRITE_CREATE)) === FALSE) {
            return FALSE;
        }
        fclose($fp);
        return TRUE;
    }


    /**
     * bi
     * @param $dir
     * @return array
     */
    function my_scandir($dir)
    {
        $files=array();
        if(is_dir($dir))
        {
            if($handle=opendir($dir))
            {
                while(($file=readdir($handle))!==false)
                {
                    if($file!="."&& $file!="..")
                    {
                        if(is_dir($dir."/".$file))
                        {
                            $files[$file]=my_scandir($dir."/".$file);
                        }
                        else
                        {
                            $files[]=$dir."/".$file;
                        }
                    }
                }
                closedir($handle);
                return $files;
            }
        }
    }
}