<?php
/**
 * 加载视图
 * 参数一、必填，加载的视图文件，index.index
 * 参数二、选填，传递的数据
 */
function view($file, $data=[])
{
    // 压缩数组（为了页面中可以直接使用变量）
    extract($data);
    include(ROOT . 'views/'.$file.'.html');
}

function redirect($url)
{
    header('Location:'.$url);
    exit;
}