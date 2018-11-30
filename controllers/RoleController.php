<?php
namespace controllers;

use models\Role;

class RoleController{
    // 列表页
    public function index()
    {
        $model = new Role;
        $data = $model->findAll();
        view('role/index', $data);
    }

    // 显示添加的表单
    public function create()
    {
        view('role/create');
    }

    // 处理添加表单
    public function insert()
    {
        $model = new Role;
        $model->fill($_POST);
        $model->insert();
        redirect('/role/index');
    }

    // 显示修改的表单
    public function edit()
    {
        $model = new Role;
        $data=$model->findOne($_GET['id']);
        view('role/edit', [
            'data' => $data,    
        ]);
    }

    // 修改表单的方法
    public function update()
    {
        $model = new Role;
        $model->fill($_POST);
        $model->update($_GET['id']);
        redirect('/role/index');
    }

    // 删除
    public function delete()
    {
        $model = new Role;
        $model->delete($_GET['id']);
        redirect('/role/index');
    }
}