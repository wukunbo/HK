<?php 
namespace app\market\logic;
use think\Model;
use think\Db;

class Welfare extends Model{

    public function __construct(){
        $this->db= new \app\userweb\model\PublicModel();
    }

    //添加
    public function add($post){
        $db=db::name('welfare');
        $id=$post['id'];
        
        if($id){
            unset($post['user_id']);
            $db->update($post);
        }else{
            $post['addtime']=time();
            $id=$db->insertGetId($post);
        }

        $res['status']=20001;
        if($id){
            $res['status']=10001;
        }

        return $res;

    }


    //列表
    public function lists($search){
        $map=array();

        if($search['user_id']){
            $map['user_id']=['eq',$search['user_id']];
        }

        if($search['type']){
            $map['type']=['eq',$search['type']];
        }

        if($search['title']){
            $map['title']=['like',"%{$search['user_id']}%"];
        }

        $db=Db::name('welfare');
        $data=$db->where($map)->select();
        return $data;
    }

}