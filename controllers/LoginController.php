<?php
namespace controllers;

use models\Admin;

class LoginController
{
    public function test()
    {
        $model = new Admin;
        $model->getUalPath(7);
        
    }
    // 显示登录的表单
    public function login()
    {
        view('login/login');
    }    
  
    // 处理登录的表单
    public function dologin()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // var_dump($_POST);die;
        $model = new Admin;
        try
        {
            $model->login($username,$password);
            // 如果登录成功进入后台
            redirect('/');
        }
        catch(\Exception $e)
        {
            // 如果这个方法中抛出了异常就执行到这里
            redirect('/login/login');
        }
        
    }

    // 退出
    public function logout()
    {
        $model = new Admin;
        $model->logout();
        redirect('/login/login');
    }
}