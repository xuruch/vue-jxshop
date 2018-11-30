<?php
namespace models;

class Category extends Model
{
    // 设置这个模型对应的表
    protected $table = 'category';
    // 设置允许接收的字段
    protected $fillable = ['cat_name','parent_id','path'];

    // 取出一个分类的子分类
    // 参数：上级分类的ID
    public function getCat($parent_id = 0)
    {
        return $this->findAll([
            'where' => "parent_id=$parent_id"
        ]);
    }
 
    // ================= xrc ==============//
    // 添加、修改分类时的下拉框
    public function category(){
        $sql = "SELECT * FROM category";
        $categoryAll = $this->getAll($sql);
        return $categoryAll;
    }

    // ================= xrc ==============//

    // 递归排序
    public function tree()
    {
        // 取出所有的分类
        $data = $this->findAll([
            'per_page' => 99999999999,
        ]);
        // 递归排序
        return $this->_sort($data['data']);
    }
    /**
     * 第一个参数：排序的数据
     * 第二个参数：顶级父分类的ID
     * 第三个参数：当前分类的级别
     */
    public function _sort($data, $parent_id=0, $level=0)
    {
        // 定义保存挑出来的分类
        static $_arr = [];
        // 循环挑分类
        foreach($data as $v)
        {
            if($v['parent_id'] == $parent_id)
            {
                // 把level值放到 $v 里用来标记它是第几级的
                $v['level'] = $level;
                $_arr[] = $v;
                // 继承挑子分类
                $this->_sort($data, $v['id'], $level+1);
            }
        }
        // 把挑完的数组返回
        return $_arr;
    }
}