<?php
namespace models;

class Privilege extends Model
{
    // 设置这个模型对应的表
    protected $table = 'privilege';
    // 设置允许接收的字段
    protected $fillable = ['pri_name','url_path','parent_id'];

    // ===========  xrc  ============//
    // 修改管理员时修改角色
    public function privilege(){
        $sql = "SELECT * FROM privilege";
        $privilege = $this->getAll($sql);
        return $privilege;
    }
    // ===========  xrc  ============//

} 