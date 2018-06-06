<?php 
namespace app\userweb\logic;
use think\Model;
use think\Db;

class Role extends Model{

    public function __construct(){
        $this->db= new \app\userweb\model\PublicModel();
    }


    public function add_role($user_id){

        //获取管理员的权限，在管理员权限下分配子账号
        if($user_id==1){
            $role_id=1;
            $tmp=$this->left($role_id,$user_id);
        }else{
            $role_id=Db::name('user_child')->where("id='".$user_id."'")->getField('role_id');
            $tmp=$this->left_child($role_id,$user_id);
        }
        
        // echo $role_id;exit;
        
        return $tmp["lists"];
    }


    public function role_lists($wx_id){
        
        $array[table]='user_child_role';
        $array[order]='role_id desc';
        $array[where]="wx_id='$wx_id'";
        $array2[table]='auth';
        $detail=$this->db->Page($array);
        // dump($detail);exit;

        for($i=0;$i<count($detail[content]);$i++){
            $role_auth_ids=$detail[content][$i]["role_auth_ids"];
            $role_auth_id[$i]=explode(",",$role_auth_ids);
            $auth_name='';
            for($j=0;$j<count($role_auth_id[$i]);$j++){
                $role_auth_id2=$role_auth_id[$i][$j];
                $array2[where]="auth_id='$role_auth_id2'";
                $array2[order]='auth_id asc';
                $detail2=$this->db->Find($array2);
                if($j==count($role_auth_id[$i])-1){
                    $auth_name.=$detail2['auth_name'];
                }else{
                    $auth_name.=$detail2['auth_name'].',';
                }
                
           }
             $detail[content][$i][auth_name]=$auth_name;
        }   
        return $detail;
    }





    public function left($role_id,$user_id) {
        //获取当期路径参数
        $params=$this->page_params(1);

        //根据角色信息获得权限ids的信息

        //根据角色信息获得权限ids的信息
        $detail= Db::name('user_role')->where("id='".$role_id."'")->find();
        $auth_arr=explode(",",$detail["app"]);
        $text_arr=explode(",",$detail["text"]);
                 
        //序列化$auth_arr
        $search=array();
        for($i=0;$i<count($auth_arr);$i++){
            $search[]=$auth_arr[$i];
            $app_lists[$i]["title"]=$text_arr[$i];
            $app_lists[$i]["val"]=$auth_arr[$i];
             
        }
        //默认基础权限
        $search=implode(",",$search);
        
        $map['app']=['in',$search];
        $map['auth_pid']=0;
        $data = Db::name('auth')->where($map)->order("auth_id asc,sort DESC")->select();        
        
        for($i=0;$i<count($data);$i++){
             
             
            
            $data[$i]["sub"]= Db::name('auth')->where(" app ='".$data[$i]["app"]."' AND auth_pid=".$data[$i]["sourse_id"]." ")->order("sort DESC,auth_id ASC")->select();
            
            for($j=0;$j<count($data[$i]["sub"]);$j++){
                //重组
                $tmp="c=".$data[$i]["sub"][$j]["auth_c"]."&a=".$data[$i]["sub"][$j]["auth_a"].$data[$i]["sub"][$j]["parameters"];
                 
                if(strpos($params,$tmp)){
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


    //子账号
    public function left_child($role_id,$user_id) {
        //根据session用户id信息查询角色id信息
        // dump($role_id);exit;
        //根据角色信息获得权限ids的信息
        $detail=Db::name('user_child_role')->where("role_id='{$role_id}'")->find();
        $auth_ids = $detail['role_auth_ids'];
        // dump($detail);exit;
        //根据$auth_ids查询全部拥有的权限信息
        
        $where_auth_ids=" and auth_id in ('{$auth_ids}') ";
        
        $sql_app="select distinct app from tl_auth where auth_pid=0 and auth_id in ('{$auth_ids}') order by sort asc";
        // echo $sql_app;exit;
        $detail=Db::query($sql_app);
        // dump($detail);exit;

        $search=array();

        for($i=0;$i<count($detail);$i++){
            $search[]=$auth_arr[$i];
            $text_arr[$i]=Db::name("app")->where("value='".$detail[$i]["app"]."'")->getField("title");
            $app_lists[$i]["title"]=$text_arr[$i];
            $app_lists[$i]["val"]=$detail[$i]["app"];
            
        }

        // dump($app_lists);exit;
        
        $search=implode(",",$search);
        
        $map['app']=['in',$search];
        $map['auth_pid']=0;
        $data = Db::name('auth')->where($map)->order("auth_id asc,sort DESC")->select();
        
        for($i=0;$i<count($data);$i++){
             
             
            $data[$i]["sub"]= Db::name('auth')->where(" app ='".$data[$i]["app"]."' AND auth_pid=".$data[$i]["sourse_id"]." ".$where_auth_ids."")->order("sort DESC,auth_id ASC")->select();
            
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