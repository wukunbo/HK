<?php
namespace app\api\controller;
use think\Controller;
use think\Db;

class UserAddress extends Base{

    public function __construct(){
        parent::__construct();
        $this->logic=new \app\user\logic\Address();
    }

    /**
     * 新增地址
     */
    public function add(){
        $post=$_REQUEST['post'];
        $post_id=$post['address_id'];
        $ret=$this->logic->address_add_back($post_id,$this->user_id,$post);
        if($ret['id']===false){
            $data['status']=10002;
            $data['msg']="添加失败";
        }else{
            $data['status']=10001;
            $data['msg']="成功";
            $data['id']=$ret['id'];
        }
        $this->return_data($data);
    }


    /**
     * 地址详情
     */
    public function detail(){
        $address_id=$_REQUEST['address_id'];
        $ret=$this->logic->address_detail($address_id,$this->user_id);
        $this->return_data($ret);
    }


    /**
     * 删除地址
     */
    public function delete(){
        $address_id=$_REQUEST['address_id'];
        $ret=Db::name('address')->where('id',$address_id)->delete();
        $data['status']=10001;
        $data['msg']="成功";
        $this->return_data($data);
    }


    /**
     * 地址列表
     */
    public function lists(){

        $ret=$this->logic->address_lists($this->user_id,$search);
        $ret=$ret['lists'];
        if($ret['content']===null){
            $data['status']=10003;
            $data['msg']="无数据";
        }elseif($ret['content']===false){
            $data['status']=10002;
            $data['msg']="数据查询错误";
        }else{
            $data['status']=10001;
            $data['msg']="成功";
            $data['lists']=$ret['content'];
        }
        $this->return_data($data);
    }


}