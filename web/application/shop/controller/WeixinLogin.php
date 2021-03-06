<?php

namespace app\shop\controller;
use think\Controller;
use think\Db;
use think\Session;

class WeixinLogin extends Controller{

    public function __construct(){
        parent::__construct();
    }

     //微信授权
    public function authorize(){

        $wx_id=$_REQUEST[wx_id] ? $_REQUEST[wx_id] : 1;

        $BasicLogic=new \app\basic\logic\Basic();
        $wx_config=$BasicLogic->wx_config($wx_id);
        if(!$wx_config){
            echo "微信无配置资料";
            exit;
        }

        //推荐人ID
        $parent_id=input('parent_id');

        $wx_config["appid"]=$wx_config["appid"];
        $wx_config["secret"]=$wx_config["appsecret"];

        $url=input('url');
        // $url=urldecode($url); 
        $Get=new \app\weixin\sever\GetSever();
        $GLOBALS['pf']=new \app\weixin\sever\FunctionSever();

        if(!$url_self){
            $url_self='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];

            // echo $url_self;
        }

        // 获取openid start
        if (!Session::get('wx_openid')){

            

            if($_REQUEST["state"]!="188"){
                $wx_config["scope"]="snsapi_userinfo";

                $wx_config["state"]="188";
                $wx_config["redirect_uri"]=$url_self;
                
                $Get->config($wx_config);
                $Get->get_code();
            }


            if($_REQUEST["state"]=="188"){
                $code = $_REQUEST["code"];
                $wx_config["scope"]="snsapi_userinfo";//拉取资料
                $wx_config["state"]="188";
                $Get->config($wx_config);
                
                $data=$Get->get_openid($code);

                Session::set('wx_openid',$data['openid']);
                Session::set('wx_code',$code);
                // dump($data);exit;
                $openid=Session::get('wx_openid');

                $access_token=$data['access_token'];
                Session::set('access_token',$data['access_token']);

            }


        }

        //END
        
        
        if(Session::get('wx_openid')){
            $openid=Session::get('wx_openid');
            $weixin=Db::name("weixin")->where("openid='".$openid."'")->find();

            // dump($weixin);
            // 拉取微信资料
            if(!$weixin){

                $wx_config["scope"]="snsapi_userinfo";//拉取资料
                $wx_config["state"]="188";
                if(!$access_token){
                    $access_token=Session::get('access_token');
                }
                $weixin_data=$Get->get_user_info($openid,$access_token);//拉取资料

                // dump($weixin_data);exit;

                // $weixin_data['privilege']=json_decode($weixin_data[privilege]);
                $weixin_data['wx_id']=$wx_id;
                $weixin_data['openid']=$openid;
                $weixin_data['addtime']=time();

                Db::name("weixin")->insert($weixin_data);
            }

            $user_id=Db::name("user")->where("openid='".$openid."'")->value('id');
            $username=Db::name("user")->where("openid='".$openid."'")->value('username');

            // 添加用户
            if(!$user_id){
                $weixin_data=Db::name("weixin")->where("openid='".$openid."'")->find();
                $user_data=array();
                $user_data['wx_id']=$wx_id;
                $user_data['openid']=$openid;
                $user_data['username']=$weixin_data[nickname];
                $user_data['headimgurl']=$weixin_data[headimgurl];
                $user_data['sex']=$weixin_data[sex];
                $user_data['unionid']=$weixin_data[unionid];
                $user_data['addtime']=time();
                $user_data['parent_id']=$parent_id;
                $user_id=Db::name("user")->insertGetId($user_data);
            }else{
                $user_parent=Db::name("user")->where("id={$user_id}")->value("parent_id");
                if(!$user_parent && $parent_id){
                    Db::name("user")->where("id={$user_id}")->setField("parent_id",$parent_id);
                }
            }

            $token=Db::name("user")->where("openid='{$openid}'")->value("token");
            if(!$token){
                $token=md5($user_id);
                Db::name("user")->where("id='{$user_id}'")->setField("token",$token);
            }

            if($user_id){
                Session::set('user_id',$user_id);
            }

            $url=urldecode($url);
            if(strpos($url,"?")){
                $url.="&token={$token}";
            }else{
                $url.="?&token={$token}";
            }
            
            // echo $url;exit;
            header("location:".$url."&return=weixin");
            exit;


        }
        

    }


}