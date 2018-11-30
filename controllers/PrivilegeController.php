<?php
namespace controllers;

use models\Privilege; 

class PrivilegeController extends BaseController
{
    // 列表页
    public function index()
    {
        $model = new Privilege;
        $data = $model->tree();
        view('privilege/index', [
            'data'=>$data
        ]);
    }

    // 显示添加的表单
    public function create()
    {
        view('privilege/create');
    }

    // 处理添加表单
    public function insert()
    {
        $model = new Privilege;
        $model->fill($_POST);
        $model->insert();
        redirect('/privilege/index');
    }

    // 显示修改的表单
    public function edit()
    {
        $model = new Privilege;
        $data=$model->findOne($_GET['id']);
        $privilege = $model->privilege();
        view('privilege/edit', [
            'data' => $data,
            'privilege' => $privilege
        ]);
    }

    // 修改表单的方法
    public function update()
    {
        $model = new Privilege;
        $model->fill($_POST);
        $model->update($_GET['id']);
        redirect('/privilege/index');
    }

    // 删除
    public function delete()
    {
        $model = new Privilege;
        $model->delete($_GET['id']);
        redirect('/privilege/index');
    }
}