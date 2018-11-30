<?php
namespace models;

class Article_category extends Model
{
    // 设置这个模型对应的表
    protected $table = 'article_category';
    // 设置允许接收的字段
    protected $fillable = ['cat_name'];
    
}