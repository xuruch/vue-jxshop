<?php
namespace controllers;

use models\Admin; 

class AdminController extends BaseController{
    // 列表页
    public function index()
    {
        $model = new Admin;
        $data = $model->findAll([
            'fields'=>'a.*,GROUP_CONCAT(c.role_name) role_list',
            'join'=>' a LEFT JOIN admin_role b ON a.id=b.admin_id LEFT JOIN role c ON b.role_id=c.id ',
            'groupby'=>' GROUP BY a.id ',
        ]);
        view('admin/index', $data);
    }

    // 显示添加的表单
    public function create()
    {
        // 取出所有角色的数据
        $model = new \models\Role;
        $data = $model->findAll();
        view('admin/create', $data);
    }

    // 处理添加表单
    public function insert()
    {
        $model = new Admin;
        $model->fill($_POST);
        $model->insert();
        redirect('/admin/index');
    }
 
    // 显示修改的表单
    public function edit()
    {
        $model = new Admin;
        $data=$model->findOne($_GET['id']);
        $roleAll = $model->roleAll();
        $admin_role = $model->admin_role($data['id']);
        foreach($admin_role as $v){
            $role_id[]['id'] = $v['role_id'];
        }
        // foreach($roleAll['role_id'] as $v){
        //     var_dump($v);
        // }
        var_dump($roleAll);
        var_dump($role_id);
        view('admin/edit', [
            'data' => $data,
            'roleAll' => $roleAll,
            'role_id' => $role_id
        ]);
    }

    // 修改表单的方法
    public function update()
    {
        $model = new Admin;
        $model->fill($_POST);
        $model->update($_GET['id']);
        redirect('/admin/index');
    }

    // 删除
    public function delete()
    {
        $model = new Admin;
        $model->delete($_GET['id']);
        redirect('/admin/index');
    }
}