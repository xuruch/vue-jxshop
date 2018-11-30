<?php

// 接收 github 发来的 json 数据
$data = file_get_contents('php://input');
// file_put_contents('./gitdata', $data);
// 收到消息之后，自动拉
$sign = 'sha1='.hash_hmac('sha1', $data, 'abc');
if($_SERVER['HTTP_X_HUB_SIGNATURE'] == $sign){
    exec('git pull');
}