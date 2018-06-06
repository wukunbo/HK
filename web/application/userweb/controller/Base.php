<?php
namespace app\userweb\controller;
use think\Controller;
use think\Session;
use think\Db;

class Base extends Controller{

    //初始化方法
    public function __construct(){
        parent::__construct();

        $request= \think\Request::instance();
        $this->controller_name=$request->controller();
        $this->action_name=$request->action();

        $this->wx_id=1;
        $this->shop_id=1;

        $page_title="购物";
        $this->assign('page_title',$page_title);

        // $cur_url=$this->curPageURL();
        // $this->assign('cur_url',$cur_url);
        // echo $_SESSION['userweb']['userid'];exit;
        if($this->controller_name!="Login"){

            if (!Session::get('userweb_userid')){
                // echo 1;exit;
                $this->redirect('Login/login');
                exit;
            }
         }

        $this->user_id=Session::get('userweb_userid');
        $this->assign('userweb_username',Session::get('userweb_username'));

        //左侧菜单栏
        if($this->user_id==1){
            $left=$this->left($this->user_id);
        }else{
            $left=$this->left_child($this->user_id);
            
        }
        // dump($left);exit;
        $this->assign('cur',$left["cur"]);
        $this->assign('left',$left);
        $this->assign('auth', $left["lists"]);
        $this->assign('auth_all', $left);

    }


    public function left($user_id) {
        $request= \think\Request::instance();
        $controller_name=$request->controller();
        $action_name=$request->action();

        //获取当期路径参数
        $params=$this->page_params(1);
        // dump($params);exit;

        //根据session用户id信息查询角色id信息
        $role_id = \think\Db::name('user')->where("id={$user_id}")->value('role_id');
        //根据角色信息获得权限ids的信息
        $detail = \think\Db::name('user_role')->where("id={$role_id}")->find();
        
        $auth_arr=explode(",",$detail["app"]);
        $text_arr=explode(",",$detail["text"]);
 
        //序列化$auth_arr
        $search=array();
     
        for($i=0;$i<count($auth_arr);$i++){
            $search[]=$auth_arr[$i];
            $app_lists[$i]["title"]=$text_arr[$i];
            $app_lists[$i]["val"]=$auth_arr[$i];
            $app_lists[$i]["icon"] = \think\Db::name('app')->where("value='{$app_lists[$i]['val']}'")->value('icon');
        }

        $search=implode(",",$search);
        // dump($app_lists);exit;

        //默认基础权限
        // echo $search;exit;
        $map['app']=['in',$search];
        $map['auth_pid']=0;
        $data = \think\Db::name('auth')->where($map)->order("auth_id asc,sort DESC")->select();
        // echo \think\Db::name('auth')->getLastsql();exit;
        // dump($data);exit;

        for($i=0;$i<count($data);$i++){
             
             
            $data[$i]["sub"]= \think\Db::name('auth')->where(" app ='".$data[$i]['app']."' AND auth_pid=".$data[$i]['sourse_id']."")->order("sort DESC,auth_id ASC")->select();
            // dump($data);exit;

            for($j=0;$j<count($data[$i]["sub"]);$j++){
                //判断是否存在两个相关的
 
                    //重组
                    $tmp="c=".$data[$i]["sub"][$j]["auth_c"]."&a=".$data[$i]["sub"][$j]["auth_a"];
                    $cur="c=".$controller_name."&a=".$action_name;
                     
                    $is_cur=0;
                    if($tmp==$cur){ //相同的控制器及函数
                    
                        $is=\think\Db::name('auth')->where("auth_c='".$controller_name."' AND auth_a='".$action_name."' AND app='".$data[$i]["sub"][$j]["app"]."'")->count(); 
                        // dump($data[$i]["sub"][$j]);exit;
                        if($is>1 && $data[$i]["sub"][$j]["parameters"]){ //存在相同的 项目组
                            if(strpos($params,$data[$i]["sub"][$j]["parameters"])){ //判断字符是否存在 similar_text 参数要求一直
                                $is_cur=1;
                            }else{
                                 
                            }
                         
                        }else{
                             
                            $tmp_lists=\think\Db::name('auth')->where("auth_c='".$controller_name."' AND auth_a='".$action_name."'")->select();

                            $tmp_id="";
                            for($k=0;$k<count($tmp_lists);$k++){
                                // echo $tmp_lists[$k]["parameters"];exit;
                                if($tmp_lists[$k]["parameters"]){
                                    if(strpos($params,$tmp_lists[$k]["parameters"])){
                                        $tmp_id=$tmp_lists[$k]["auth_id"];
                                    }
                                }
                                
                            }

                            if(count($tmp_lists)==0){
                                $is_cur=1;
                            }

                            if($tmp_id=="" && $data[$i]["sub"][$j]["parameters"]==""){
                                $is_cur=1;
                            }

                            if($tmp_id!="" && $tmp_id==$data[$i]["sub"][$j]["auth_id"]){
                                $is_cur=1;
                            }

                            $is_cur=1;
                        }
                        
                    }else{
                    
                        $tmp="c=".$data[$i]["sub"][$j]["auth_c"]."&a=".$data[$i]["sub"][$j]["auth_a"].$data[$i]["sub"][$j]["parameters"];
                        
                    }
             
                 
                    
                    if($is_cur==1){
                        $data[$i]["cur"]=1;
                        $data[$i]["sub"][$j]["cur"]=1;
                        $res["cur"]["CONTROLLER_NAME"]=$data[$i]["auth_name"];
                        $res["cur"]["ACTION_NAME"]=$data[$i]["sub"][$j]["auth_name"];
                        $res["cur"]["app"]=$data[$i]["sub"][$j]["app"];
                        // dump($data[$i]);exit;
                    }
            } 
        }

        // dump($data);exit;

        if(!isset($res["cur"]["app"])){ //没有选中,重新筛选
            $where=" auth_c='".$controller_name."' AND auth_a='".$action_name."' AND parameters='' ";
            if(isset($_REQUEST["menu_app"])){
                $where.=" AND app='".$_REQUEST["menu_app"]."'";
            }else{
                $where.=" AND app LIKE  '".substr($controller_name,0,3)."%' ";
            }
            $is=\think\Db::name('auth')->where($where)->value("auth_id"); 
        
            for($i=0;$i<count($data);$i++){
                $data[$i]["sub"]= \think\Db::name('auth')->where(" app ='".$data[$i]["app"]."' AND auth_pid=".$data[$i]["sourse_id"]." ")->order("sort DESC,auth_id ASC")->select();
                for($j=0;$j<count($data[$i]["sub"]);$j++){
                    
                    $data[$i]["sub"][$j]["cur"]=0;

                    if($data[$i]["sub"][$j]["auth_id"]==$is){
                        $data[$i]["cur"]=1;
                        $data[$i]["sub"][$j]["cur"]=1;
                        $res["cur"]["CONTROLLER_NAME"]=$data[$i]["auth_name"];
                        $res["cur"]["ACTION_NAME"]=$data[$i]["sub"][$j]["auth_name"];
                        $res["cur"]["app"]=$data[$i]["sub"][$j]["app"];
                    }
                }
            }

        }
        if(isset($_REQUEST["menu_app"])){
            $res["cur"]["app"]=$_REQUEST["menu_app"];
        }
        
        if(!isset($res["cur"]["app"])){
            $res["cur"]["app"]=$app_lists[0]["val"];
            $res["cur"]["no_app"]=1;//选用默认
        }
        $res["app_lists"]=$app_lists;
         
        $res["lists"]=$data;
        return $res;
    }


    //子账号
    public function left_child($user_id) {
        //根据session用户id信息查询角色id信息
        $role_id = Db::name('user_child')->where("id='$user_id'")->value('role_id');
        // dump($role_id);exit;
        //根据角色信息获得权限ids的信息
        $detail=Db::name('user_child_role')->where("role_id='{$role_id}'")->find();
        $auth_ids = $detail['role_auth_ids'];
        // dump($detail);exit;
        //根据$auth_ids查询全部拥有的权限信息
        
        $where_auth_ids=" and auth_id in ({$auth_ids}) ";
        
        $sql_app="select distinct app from tl_auth where auth_pid=0 and auth_id in ('{$auth_ids}') order by sort asc";
        // echo $sql_app;exit;
        $detail=Db::query($sql_app);
        // dump($detail);

        $search=array();

        for($i=0;$i<count($detail);$i++){
            $search[]=$detail[$i]['app'];
            $text_arr[$i]=Db::name("app")->where("value='".$detail[$i]["app"]."'")->value("title");
            $app_lists[$i]["title"]=$text_arr[$i];
            $app_lists[$i]["val"]=$detail[$i]["app"];
            
        }

        // dump($app_lists);exit;
        
        $search=implode(",",$search);
        // dump($search);exit;

        $map['app']=['in',$search];
        $map['auth_pid']=0;
        $map1['auth_id']=['in',$auth_ids];

        $data = Db::name('auth')->where($map)->where($map1)->order("auth_id asc,sort DESC")->select();
        // dump($data);exit;

        for($i=0;$i<count($data);$i++){
             
             
            $data[$i]["sub"]= Db::name('auth')->where(" app ='".$data[$i]["app"]."' AND auth_pid=".$data[$i]["sourse_id"]." ".$where_auth_ids."")->order("sort DESC,auth_id ASC")->select();
            // echo Db::name('auth')->getLastsql();exit;
            // dump($data);exit;

            for($j=0;$j<count($data[$i]["sub"]);$j++){
                //重组
                $tmp="c=".$data[$i]["sub"][$j]["auth_c"]."&a=".$data[$i]["sub"][$j]["auth_a"];
                $cur="c=".$this->controller_name."&a=".$this->action_name;
                $is_cur=0;
                if($tmp==$cur){
                    $is_cur=1;
                }else{
                    $tmp="c=".$data[$i]["sub"][$j]["auth_c"]."&a=".$data[$i]["sub"][$j]["auth_a"].$data[$i]["sub"][$j]["parameters"];
                    
                }
                 
 
                if($is_cur==1){
                    $data[$i]["cur"]=1;
                    $data[$i]["sub"][$j]["cur"]=1;
                    $res["cur"]["CONTROLLER_NAME"]=$data[$i]["auth_name"];
                    $res["cur"]["ACTION_NAME"]=$data[$i]["sub"][$j]["auth_name"];
                    $res["cur"]["app"]=$data[$i]["sub"][$j]["app"];
                }
            } 
        }
       
        if(!isset($res["cur"]["app"])){
            $res["cur"]["app"]="Basic";
        }
        $res["app_lists"]=$app_lists;
        $res["lists"]=$data;
 
        return $res;
    }


    public function showmsg($msg,$url='',$sure=0){//空 不跳转 sure 0 不需要确认 1 需要确认 
        
        $this->assign("msg",$msg);
        $this->assign("url",$url);
        // echo $msg;exit;
        return $this->fetch("Public/showmsg");
        // exit;
    }




    //获取当前链接
    function curPageURL() {
        $pageURL = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';

        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }


    /*
    $type 1 全部，2 re 3 post
    */
    public function page_params($type=1){

        $request= \think\Request::instance();
        // dump($_REQUEST);exit;
        $str="";
        //接收参数值
        if($type==1){
              
            foreach($_REQUEST as $_k=>$_v){
                // echo $_k;exit;
                 if(strlen($_k)<0){
                    exit('Request var not allow!');
                 }else{
                    if($str){
                        $str.="&";
                    }
                    $str.="".$_k."=".$_v;
                 }
            }

            $controller_name=$request->controller();
            $action_name=$request->action();

            $str="c=".$controller_name."&a=".$action_name."&".$str;
             
        }
        //接收参数值
        if($type==2){
            $request='';
            foreach($_GET as $_k=>$_v){
                 if( strlen($_k)>0 && eregi('^(cfg_|GLOBALS)',$_k) && !isset($_COOKIE[$_k]) ){
                    exit('Request var not allow!');
                 }else{
                    $str="&".$_k."=".$_v;
                 }
            }
        }
        //接收参数值
        if($type==3){
            foreach($_POST as $_k=>$_v){
                 if( strlen($_k)>0 && eregi('^(cfg_|GLOBALS)',$_k) && !isset($_COOKIE[$_k]) ){
                    exit('Request var not allow!');
                 }else{
                    //$request[$_k]=$_v;
                    $str="&".$_k."=".$_v;
                 }
            }
        }
        return $str;
    }

}
