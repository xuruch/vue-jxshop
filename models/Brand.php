<?php
namespace models;

class Brand extends Model
{
    // 设置这个模型对应的表
    protected $table = 'brand';
    // 设置允许接收的字段
    protected $fillable = ['brand_name','logo'];
    
    // 会在添加、修改之前自动被调用（钩子函数：定义好之后自动被调用）
    public function _before_write()
    {
        $this->_delete_logo();
        // 实现上传图片的代码
        $uploader = \libs\Uploader::make();
        $logo = '/uploads/' . $uploader->upload('logo', 'brand');
        // $this->data ：将要插入到数据库中的数据（数组）
        // 把 logo 加到数组中，就可以插入到数据库
        $this->data['logo'] = $logo;   
    }

 

    // 删除之前被调用（钩子函数：定义好之后自动被调用）
    public function _before_delete()
    {
        $this->_delete_logo();
    }

    protected function _delete_logo()
    {
        // 如果是修改就删除原图片
        if(isset($_GET['id']))
        {
            // 先从数据库中取出原LOGO
            $ol = $this->findOne($_GET['id']);
            // 删除
            @unlink(ROOT . 'public'. $ol['logo']);
        }
    }

     // 添加之后执行的钩子函数 上传到七牛云
     public function _after_write()
     {
         
         // 构造数据（上传七牛云）
         $data = [
             'logo' => $this->data['logo'],
             'id' => $this->data['id'],
             'table' => 'brand',
             'column' => 'logo',
         ];
         $client = new \Predis\Client([
             'scheme' => 'tcp',
             'host'   => 'localhost',
             'port'   => 6379,
         ]);
         // 转成字符串保存到队列中
         $a = $client->lpush('jxshop:niqui', serialize($data));
     }
}