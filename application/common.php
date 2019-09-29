<?php

/**
 * 自定义公共加密方法
 */
if(!function_exists('mdPassword')){
    function mdPassword($password){
        return substr(md5(sha1($password)),1,20);
    }
}

/**
 * 自定义公共加密方法
 */
if(!function_exists('dd')){
    function dd($data){
        print_r($data);exit;
    }
}
