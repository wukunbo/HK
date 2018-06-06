<?php 
namespace app\basic\logic;
use think\Model;
use think\Db;

class Basic extends Model{

    public function __construct(){
        $this->db= new \app\userweb\model\PublicModel();
    }

    public function wx_config($wx_id,$user_id='',$appid=''){
        $where="id='{$wx_id}'";
        
        if($user_id){
            $where="user_id='".$user_id."'";
        }
        if($appid){
            $where="appid='".$appid."'";
        }
        $db=Db::name('tlwx_config');
        $detail=$db->where($where)->find();
        $detail[sql]=$db->getLastsql();
        return $detail;
    }

}