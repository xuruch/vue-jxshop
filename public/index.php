<?php
define('ROOT', __DIR__ . '/../');

// 设置时区
date_default_timezone_set('PRC');

// 使用 redis 保存 SESSION
ini_set('session.save_handler', 'redis');
// 设置 redis 服务器的地址、端
ini_set('session.save_path', 'tcp://127.0.0.1:6379?database=1');
session_start();

 

// 引入函数文件
require(ROOT.'libs/functions.php');

// 引入 composer 安装的包
require(ROOT.'vendor/autoload.php');

/**
 * 类的自动加载
 */
function load($class)
{
    $path = str_replace('\\', '/', $class);
    require(ROOT . $path . '.php');
}
spl_autoload_register('load');


/**
 * 解析路由
 */
$controller = '\controllers\IndexController';
$action = 'index';
if(isset($_SERVER['PATH_INFO']))
{
    //     0  1      2
    //      /user/register
    $router = explode('/', $_SERVER['PATH_INFO']);
    $controller = '\controllers\\'.ucfirst($router[1]) . 'Controller';
    $action = $router[2];
}

$c = new $controller;
$c->$action();