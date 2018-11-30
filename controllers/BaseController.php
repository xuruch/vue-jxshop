<?php
/* 必须登录才能访问 */
namespace controllers;

class BaseController
{
    public function __construct()
    {
        // 判断登录
        if(!isset($_SESSION['id']))
        {
            redirect('/login/login');
        }

        // 是否超级管理员，直接退出该函数通过
        if(isset($_SESSION['root']))
        {
            return ;
        }

        // 获取将要访问的路径 
        $path = isset($_SERVER['PATH_INFO'])? trim($_SERVER['PATH_INFO'], '/') : 'index/index';
        // 设置一个白名单
        $whiteList = ['index/index','index/menu','index/top','index/main'];
        // 判断是否有权访问
        if(!in_array($path, array_merge($whiteList, $_SESSION['url_path'])))
        {
            die('无权访问！');
        }

    }

}