<?php
namespace app\userweb\controller;
use Think\Controller;
use think\Db;

class Game extends Base{

    public function __construct(){
        parent::__construct();
        $this->logic= new \app\market\logic\Game();
    }

    //添加游戏
    public function add(){
        $id=input('id');
        $data=Db::name('game')->where('id',$id)->find();

        $this->assign('data',$data);
        return $this->fetch("Game/add");
    }

    public function add_action(){
        $post=$_REQUEST['post'];
        // dump($post);
        $post['user_id']=$this->user_id;
        $this->logic->add($post);

        return $this->showmsg("操作成功",url('lists'));
    }

    //游戏列表
    public function lists(){

        $data=$this->logic->lists($search);

        $this->assign('data',$data);
        return $this->fetch("Game/lists");
    }

    public function del(){
        $id=input('id');
        Db::name('game')->where('id',$id)->delete();
        return $this->showmsg("操作成功");
    }


}