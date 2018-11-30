namespace controllers;
 
use models\<?=$mname?>;

class <?=$cname?>
{
    // 列表页
    public function index()
    {
        $model = new <?=$mname?>;
        $data = $model->findAll();
        view('<?=$tableName?>/index', $data);
    }

    // 显示添加的表单
    public function create()
    {
        view('<?=$tableName?>/create');
    }

    // 处理添加表单
    public function insert()
    {
        $model = new <?=$mname?>;
        $model->fill($_POST);
        $model->insert();
        redirect('/<?=$tableName?>/index');
    }

    // 显示修改的表单
    public function edit()
    {
        $model = new <?=$mname?>;
        $data=$model->findOne($_GET['id']);
        view('<?=$tableName?>/edit', [
            'data' => $data,    
        ]);
    }

    // 修改表单的方法
    public function update()
    {
        $model = new <?=$mname?>;
        $model->fill($_POST);
        $model->update($_GET['id']);
        redirect('/<?=$tableName?>/index');
    }

    // 删除
    public function delete()
    {
        $model = new <?=$mname?>;
        $model->delete($_GET['id']);
        redirect('/<?=$tableName?>/index');
    }
}