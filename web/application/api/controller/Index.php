<?php
namespace app\api\controller;
use think\Controller;
use think\Db;

class Index extends Controller {
   

    //接口展示
    public function index(){
        
        return $this->fetch();
    }


    public function get_key_lists(){
        $c=$_REQUEST[get_c];
        $a=$_REQUEST[get_a];
        $detail=Db::name("api")->where("a='".$a."' AND c='".$c."'")->find();
        // echo Db::name("api")->getLastSql();exit;
        $title=Db::name("api_cate")->where(" c='".$c."'")->value("title");
        $title=$title.",".Db::name("api")->where("a='".$a."' AND c='".$c."'")->value("title");
        $content=Db::name("api")->where("a='".$a."' AND c='".$c."'")->value("content");
        // echo Db::name("api")->getLastSql();
        // dump($content);exit;
        $lists=json_decode($detail[param],true);
        // dump($lists);exit;
         
        $data[title]=$title;
        $data[content]=$content;
        $data[detail]=$detail;
        $data[lists]=$lists;
        $data[act]=$_REQUEST[act];
        $this->data=$data;
        $this->assign('data',$data);
        if($_REQUEST[act]=="add"){
             $html=$this->fetch("key_lists_add_tpl");
        }else{
             
            $html=$this->fetch("key_lists_tpl");
        }
        $res[html]=$html;
        $res[title]=$title;
        $res[content]=$content;
        echo json_encode($res);
    }


    public function get_api(){

         $c=$_REQUEST[get_c];
         $cur_c=$_REQUEST[cur_c];
         $str='<option value="">请选择</option>';
         if($c==""){
            $lists=Db::name("api_cate")->where("")->order("c ASC")->select();
         
            for($i=0;$i<count($lists);$i++){
                $sel="";
                if($cur_c==$lists[$i][c]){
                    $sel="selected";
                }
                $str.='<option value="'.$lists[$i][c].'" '.$sel.'>'.$lists[$i][c].'['.$lists[$i][title].']</option>';
            }
         }else{
            $lists=Db::name("api")->where("c='".$c."'")->select();
            for($i=0;$i<count($lists);$i++){
                $str.='<option value="'.$lists[$i][a].'">'.$lists[$i][a].'['.$lists[$i][title].']</option>';
            }
         }
          
          
         $res[html]=$str;
         echo json_encode($res);
          
    }

    public function add(){
          $tmp_post=$_REQUEST[post];
          $key_lists=$_REQUEST[key_lists];
          $val_lists=$_REQUEST[val_lists];
          
          $tmp_post[title]=str_replace("，",",",$tmp_post[title]);
          $title_arr=explode(",",$tmp_post[title]);
          //var_dump($title_arr);
          if($tmp_post[c_1]){
                 
                $post[c]=$tmp_post[c_1];
                $post[a]=$tmp_post[a_1];        
          }else{
                $post[c]=$tmp_post[c];
                $post[a]=$tmp_post[a];  
          }
          $is=Db::name("api_cate")->where("c='".$post[c]."'")->value("id");
          if($is==""){
                $cate_post[title]=$title_arr[0];
                $cate_post[c]=$post[c];
                Db::name("api_cate")->insert($cate_post);
          }
          $id=Db::name("api")->where("c='".$post[c]."' AND a='".$post[a]."'")->value("id");
          if($id==""){
                $api_post[title]=$title_arr[1];
                $api_post[c]=$post[c];
                $api_post[a]=$post[a];
                $api_post[content]=$tmp_post[content];
                $id=Db::name("api")->insertGetId($api_post);
          }
          $j=0;
          for($i=0;$i<count($key_lists);$i++){
            if($key_lists[$i]){
                $arr[$j]["key"]=$key_lists[$i];
                $arr[$j]["val"]=$val_lists[$i];
                $j++;
            }
          }
          $api_post[param]=json_encode($arr);
          Db::name("api")->where("id='".$id."'")->update($api_post);
           
          
    }



}
