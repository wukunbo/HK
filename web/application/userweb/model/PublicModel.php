<?php 
namespace app\userweb\model;
use think\Model;
use think\Db;

class PublicModel extends Model{


    public function Page($array){
        $table=$array['table'];
        $num=$array['num'];
        $where=$array['where'];
        $order=$array['order'];
        $field=$array['field'];
        $page=$array['page'];
        $join=$array['join'];
        $group=$array['group'];
        if($num==""){
            $num=10;
        }
        if ($order==""){
            $order="id desc";
        }

        if (!$field){
            $field="*";
        }
    
        $Sql=Db::name($table);
        
        
        if($join){
            $count= $Sql->where($where)->join($join)->count();
        }else{
            $count= $Sql->where($where)->count();
        }

        // echo $Sql->getLastsql();exit;

        if(!empty($page))
        {
            $Page= new \think\Page($page*$num,$num);
        }
        else{
            $Page= new \think\Page($count,$num);
        }
        $show = $Page->show();// 分页显示输出
        //$Page= new \Think\Page($count,$num);
    
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
    
        if(!empty($join))
        {
            $list = $Sql->where($where)->field($field)->join($join)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
        }
        else{
            $list = $Sql->where($where)->field($field)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();

            // echo $Sql->getLastSql();exit;
        }
        $result["sql"]=$Sql->getLastSql();
        //$list = $Sql->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
        $result['page']=$show;
        $result['content']=$list;
        $result["total"]=$count;
        $result["cur_total"]=count($lists);
        
        return $result;
    }




    public function Find($array){
        $table=$array['table'];
        $where=$array['where'];
        $order=$array['order'];
        $field=$array['field'];
        if($order==NULL){
            $order="id desc";
        }
        if ($field==NULL){
            $field='*';
        }
        $Sql=Db::name($table);
        $data=$Sql->where($where)->field($field)->order($order)->find();
        return $data;
    }

    public function Select($array){
        $table=$array['table'];
        $where=$array['where'];
        $order=$array['order'];
        $field=$array['field'];
        if($order==NULL){
            $order="id desc";
        }
        if ($field==NULL){
            $field='*';
        }
        $Sql=Db::name($table);
        $data=$Sql->field($field)->where($where)->order($order)->select();
    
        return $data;
        
        
    }






}