<?php
namespace app\plus\controller;
use think\Controller;
use think\Db;


class Region extends Controller{

    public function __construct(){
        parent::__construct();
    }


    public function set_city(){

        $parent_id=$_REQUEST[parent_id];
        $select=$_REQUEST[select];
        $city=Db::name('region')->where('parent_id',$parent_id)->select();

        $city_list="<option value=-1>请选择</option>";
        $id=$_REQUEST[id];
        for ($i=0;$i<count($city);$i++){
            $selected="";
            if($select==$city[$i]['id']){
                $selected="selected";
            }
            $city_list.="<option value=". $city[$i]['id']." ".$selected.">".$city[$i]['region_name']."</option>";   
        }
        $res['status']=10001;
        $res['data']=$city_list;
        //echo $city_list;
        echo  json_encode($res);
         
    }

}