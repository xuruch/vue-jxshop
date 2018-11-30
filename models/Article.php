<?php
namespace models;
use PDO;
class Article extends Model
{
    // 设置这个模型对应的表
    protected $table = 'article';
    // 设置允许接收的字段
    protected $fillable = ['title','content','link','article_category_id'];

    public function cat_name(){
        $stmt = $this->_db->prepare("SELECT * FROM article_category");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 修改article表时、查询书article_category分类信息
    // public function articleCatName($id){
    //     $stmt = $this->_db->prepare("SELECT * FROM article_category WHERE id=?");
    //     $stmt->execute([$id]);
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }
}