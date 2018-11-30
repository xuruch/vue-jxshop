<?php
namespace models;

class Admin extends Model
{
    // 设置这个模型对应的表
    protected $table = 'admin';
    // 设置允许接收的字段
    protected $fillable = ['username','password'];
    // 添加之前自动被执行
    public function _before_write()
    {
        $this->data['password'] = md5($this->data['password']);
    }

    // 添加、修改管理员之后自动被执行
    // 添加时，获取新添加的管理员ID： $this->data['id']
    // 修改时，获取要修改的管理员ID：$_GET['id']
    protected function _after_write()
    {
        // var_dump( $_POST );
        // exit;
        $id = isset($_GET['id']) ? $_GET['id'] : $this->data['id'];

        // 删除原数据
        $stmt = $this->_db->prepare('DELETE FROM admin_role WHERE admin_id=?');
        $stmt->execute([
            $id
        ]);

        // 重新添加新勾选的数据
        $stmt = $this->_db->prepare("INSERT INTO admin_role(admin_id,role_id) VALUES(?,?)");
        // 循环所有勾选的角色ID插入到中间表
        foreach($_POST['role_id'] as $v)
        {
            $stmt->execute([
                $id,
                $v,
            ]);
        }
    }

    //========== xrc ==========//
    // 修改管理员时也应该可以修改角色
    public function roleAll(){
        $sql = "SELECT * FROM role";
        $roleAll = $this->getAll($sql);
        return $roleAll;
    }

    public function admin_role($id){
        $sql = "SELECT * FROM admin_role where admin_id=?";
        $admin_role = $this->getAll($sql,[$id]);
        return $admin_role;
    }
    //========== xrc ==========// 
 
    public function login($username, $password)
    {
        $stmt = $this->_db->prepare('SELECT * FROM admin WHERE username=? AND password=?');
        $stmt->execute([
            $username,
            md5($password),
        ]);
        $info = $stmt->fetch(\PDO::FETCH_ASSOC);
        if($info)
        {
            $_SESSION['id'] = $info['id'];
            $_SESSION['username'] = $info['username'];
            
            // 查看该管理员是否有一个角色ID=1
            $stmt = $this->_db->prepare('SELECT COUNT(*) FROM admin_role WHERE role_id=1 AND admin_id=?');
            $stmt->execute([$_SESSION['id']]);
            $c = $stmt->fetch(\PDO::FETCH_COLUMN);
            if($c>0)
                $_SESSION['root'] = true;
            else
                // 取出这个管理员有限访问的路径
                $_SESSION['url_path'] = $this->getUalPath($_SESSION['id']);
        }
        else
        {
            throw new \Exception('用户名或者密码错误！');
        }
    }

    public function logout()
    {
        $_SESSION = [];
        session_destroy();
    }

    // 在删除之前执行
    protected function _before_delete()
    {
        $stmt = $this->_db->prepare("delete from admin_role where admin_id=?");
        $stmt->execute([
            $_GET['id']
        ]);
    }

    // 获取一个管理员有权访问的路径
    public function getUalPath($adminId)
    {
        $sql = "SELECT c.url_path
                    FROM admin_role a 
                    LEFT JOIN role_privlege b ON a.role_id=b.role_id
                    LEFT JOIN privilege c ON b.pri_id=c.id
                    WHERE a.admin_id=? AND c.url_path!=''";
        $stmt = $this->_db->prepare($sql);
        $stmt->execute([$adminId]);
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        // 把二维数组转成一维数组
        $_ret = [];

        foreach($data as $v)
        {
            // 判断是否有多个URL（包含,）
            if(FALSE === strpos($v['url_path'], ','))
            {
                // 如果没有,，就直接拿过来
                $_ret[] = $v['url_path'];
            }
            else
            {
                // 如果有，，就转成数组
                $_tt = explode(',', $v['url_path']);
                // 把转完之后的数组合并到一维数组中
                $_ret = array_merge($_ret, $_tt);
            }
            
        }

        return $_ret;
    }
}
