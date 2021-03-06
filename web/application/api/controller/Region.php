<?php
namespace app\api\controller;
use think\Controller;
use think\Db;

class Region extends Base{

    public function __construct(){
        parent::__construct();
        // $this->logic=new \app\plus\logic\Region();
    }

    public function lists(){
        $parent_id=$_REQUEST['parent_id'];
        if(!$parent_id){
            $parent_id=1;
        }
        $ret=Db::name('region')->where('parent_id',$parent_id)->select();
        if($ret===null){
            $data['status']=10003;
            $data['msg']="无数据";
        }elseif($ret===false){
            $data['status']=10002;
            $data['msg']="数据查询错误";
        }else{
            $data['status']=10001;
            $data['msg']="成功";
            for($i=0;$i<count($ret);$i++){
                $data['lists'][$i]['id']=$ret[$i]['id'];
                $data['lists'][$i]['region_name']=$ret[$i]['region_name'];
            }
        }
        $this->return_data($data);
    }

}