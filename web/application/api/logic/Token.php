<?php 
namespace app\api\logic;
use think\Model;
use think\Db;

class Token{

    public function user_token($token,$user_id=""){
        if($user_id){

            $id=Db::name("user")->where("id={$user_id}")->setField("token",$token);
            $res[status]=10001;
            $user_status=Db::name("user")->where("id={$user_id}")->value("user_status");
            if($user_status){
                $res[status]=30001;
                $res[msg]="该用户已被冻结";
            }
        }else{
            $is=Db::name("user")->where(" token='{$token}' ")->find();
            // echo M("user")->getLastsql();exit;
            $res[status]=20000;
            if($is){
                $res[status]=10001;
                $res[user_id]=$is[id];
            }

            if($is[user_status]){
                $res[status]=30001;
                $res[msg]="该用户已被冻结";
            }
            
        }

        return $res;
    }

    
}