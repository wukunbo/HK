<?php 
namespace app\user\logic;
use think\Model;
use think\Db;

class User extends Model{

    public function __construct(){
        $this->db= new \app\userweb\model\PublicModel();
    }

    //会员列表
    public function user_lists($search){

        $array[table]='user';

        //0 未认证 1 已认证 2 冻结 -2 非冻结
        if($search['status'] && $search['status']>0){
            $map["tl_user.status"]=array('eq',$search[status]);
        }

        
        if($search['start_time']){
            $start_time_tmp=date('Y-m-d',strtotime($search[start_time]));
            $start_time=strtotime(date("$start_time_tmp 00:00:00"));
            $map["tl_user.addtime"]=array("egt",$start_time);
        }

        if($search['end_time']){
            $end_time_tmp=date('Y-m-d',strtotime($search[end_time]));
            $end_time=strtotime(date("$end_time_tmp 23:59:59"));
            $map["tl_user.addtime"]=array("elt",$end_time);
        }

        if($search[user_id]){
            $map["tl_user.id"]=array('eq',$search[user_id]);
        }

        if($search[is_renzheng]>0){
            $map["tl_user.is_renzheng"]=array('eq',$search[is_renzheng]);
        }

        if($search[is_renzheng]=="0"){
            $map["tl_user.is_renzheng"]=array('eq',"0");
        }

        if($search[nick_phone]){
            $map["username"]=['like',"%{$search['nick_phone']}%"];
        }

        if($search[grade_id]){
            $map["tl_user.grade_id"]=array('eq',$search[grade_id]);
        }

        $map['id']=['neq',1];

        $array['where']=$map;
        $array['field']=" tl_user.*";
        $array['order']="tl_user.addtime DESC";
        $array['num']=20;
        $data=$this->db->Page($array);

        //获取微信相关内容和用户详细信息

        for($i=0;$i<count($data[content]);$i++){

            $user_id=$data['content'][$i]['id'];
            $parent_id=$data['content'][$i]['parent_id'];

            $data['content'][$i]['user_info']=Db::name('user_info')->where("user_id='$user_id'")->find();
            $data['content'][$i]['parent_user']=Db::name('user')->where("id='$parent_id'")->value("username");

        }

        $data['search_starttime']=$start_time;
        $data['search_endtime']=$end_time;
        $data['search_nick_phone']=$search['search_nick_phone'];
        $data['search_status']=$status;
        return $data;
    }

    //会员详情
    public function detail($user_id){
        $data=Db::name('user')->where('id',$user_id)->find();
        $data['userinfo']=Db::name('user_info')->where('user_id',$user_id)->find();
        return $data;  
    }


}