<?php
namespace controllers;

use models\Article_category; 

class Article_categoryController{
    // 列表页
    public function index()
    {
        $model = new Article_category;
        $data = $model->findAll();
        view('article_category/index', $data);
    }

    // 显示添加的表单
    public function create()
    {
        view('article_category/create');
    }

    // 处理添加表单
    public function insert()
    {
        $model = new Article_category;
        $model->fill($_POST);
        $model->insert();
        redirect('/article_category/index');
    }

    // 显示修改的表单
    public function edit()
    {
        $model = new Article_category;
        $data=$model->findOne($_GET['id']);
        view('article_category/edit', [
            'data' => $data,    
        ]);
    }

    // 修改表单的方法
    public function update()
    {
        $model = new Article_category;
        $model->fill($_POST);
        $model->update($_GET['id']);
        redirect('/article_category/index');
    }

    // 删除
    public function delete()
    {
        $model = new Article_category;
        $model->delete($_GET['id']);
        redirect('/article_category/index');
    }
}