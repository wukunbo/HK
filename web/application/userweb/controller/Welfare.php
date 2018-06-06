<?php
namespace app\userweb\controller;
use Think\Controller;
use think\Db;

class Welfare extends Base{

    public function __construct(){
        parent::__construct();
        $this->logic= new \app\market\logic\Welfare();
    }

    //添加福利
    public function add(){
        $id=input('id');
        $data=Db::name('welfare')->where('id',$id)->find();
        if($id && $data['status']==1){
            return $this->showmsg("已上架，不能修改");exit;
        }

        $this->assign('data',$data);
        return $this->fetch("Welfare/add");
    }


    public function add_action(){
        $post=$_REQUEST['post'];
        // dump($post);
        $post['start_time']=strtotime($post['start_time']);
        $post['end_time']=strtotime($post['end_time']);

        $post['user_id']=$this->user_id;
        $this->logic->add($post);

        return $this->showmsg("操作成功",url('lists'));
    }

    //福利列表
    public function lists(){
        
        $data=$this->logic->lists($search);

        $this->assign('data',$data);
        return $this->fetch("Welfare/lists");
    }

    public function del(){
        $id=input('id');
        Db::name('welfare')->where('id',$id)->delete();
        return $this->showmsg("操作成功");
    }

    public function set_status(){
        $id=input('id');
        $status=input('status');
        Db::name('welfare')->where('id',$id)->setField("status",$status);
        return $this->showmsg("操作成功");
    }


}