<?php
namespace controllers;

use models\Brand;

class BrandController extends BaseController{
    // 列表页
    public function index()
    { 
        $model = new Brand;
        $data = $model->findAll();
        view('brand/index', $data);
    }

    // 显示添加的表单
    public function create()
    {
        view('brand/create');
    }

    // 处理添加表单
    public function insert()
    {
        $model = new Brand;
        $model->fill($_POST);
        $model->insert();
        redirect('/brand/index');
    }

    // 显示修改的表单
    public function edit()
    {
        $model = new Brand;
        $data=$model->findOne($_GET['id']);
        view('brand/edit', [
            'data' => $data,    
        ]);
    }

    // 修改表单的方法
    public function update()
    {
        $model = new Brand;
        $model->fill($_POST);
        $model->update($_GET['id']);
        redirect('/brand/index');
    }

    // 删除
    public function delete()
    {
        $model = new Brand;
        $model->delete($_GET['id']);
        redirect('/brand/index');
    }
}