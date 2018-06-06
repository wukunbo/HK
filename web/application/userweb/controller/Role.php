<?php
namespace app\userweb\controller;
use Think\Controller;
use think\Db;

class Role extends Base{

    public function __construct(){
        parent::__construct();
        $this->logic= new \app\userweb\logic\Role();
    }

    //显示列表
    public function add_role(){
        $detail=$this->logic->add_role($this->user_id);
        // dump($detail);exit;
        
        $id=input("id");
        $this->id=$id;
        $detail2 = Db::name('user_child_role')->where("role_id='$id'")->find();

        $this->assign("detail", $detail);
        $this->assign("detail2", $detail2);
        
        return $this->fetch("Role/add_role");
    }

    public function add_role_action() {
        $role_id = $_REQUEST["role_id"];
        $post=$_REQUEST["post"];
        $role_name=$post['role_name'];
        // dump($post);exit;
        $role = new \app\userweb\model\RoleModel();

        if ($role_id) {
            //利用RoleModel模型里边的一个专门方法实现权限分配
            
            Db::name('user_child_role')->where("role_id='$role_id'")->setField('role_name',$role_name);
            //saveAuth接收到一维数组信息
            $z = $role->saveAuth($_POST['authname'], $role_id);
            return $this->showmsg('操作成功！',url("Role/role_lists"));
        } else {
            $post["wx_id"]=$this->wx_id;
            $role_id = $role->add($post);
            $z = $role->saveAuth($_POST['authname'], $role_id);
            return $this->showmsg('操作成功！',url("Role/role_lists"));
        }
    }


    public function role_lists(){

        // echo url("Role/add_role");exit;

        $wx_id=$this->wx_id;
        $data=$this->logic->role_lists($wx_id);

        // dump($data);exit;

        $this->assign("data",$data);

        return $this->fetch("Role/role_lists");
    }

    public function del_role(){
        $id=input("id");
        Db::name("user_child_role")->where("role_id={$id}")->delete();
        return $this->showmsg("操作成功！");
    }






}