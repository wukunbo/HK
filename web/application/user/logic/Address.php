<?php 
namespace app\user\logic;
use think\Model;
use think\Db;

class Address extends Model{

    public function __construct(){
        $this->db= new \app\userweb\model\PublicModel();
    }


    //获取用户地址表的数据 详细
    public function address_detail_name($address_id){   
        $db_address=Db::name('address');   
        $data=$db_address->where("id='$address_id'")->find();
        $region=Db::name('region');
        
        $province_id=$data[province];
        $city_id=$data[city];
        $area_id=$data[area];
        
        $data[province_name]=$region->where("id='$province_id'")->value('region_name');
        $data[city_name]=$region->where("id='$city_id'")->value('region_name');
        $data[area_name]=$region->where("id='$area_id'")->value('region_name');
            
        $data[address]=$data[province_name].$data[city_name].$data[area_name].$data[details_site];
        $data[phone]=$data[phone];
        $data[name]=$data[name];
        return $data;
        
    }


    public function address_detail($address_id,$user_id=""){

        $data['status']=10001;

        $db=Db::name("address");
        $data['detail']=$db->where("id",$address_id)->find();
        

        $region=Db::name('region');
        
        $province_id=$data['detail']['province'];
        $city_id=$data['detail']['city'];
        $area_id=$data['detail']['area'];


        $data['detail']['province_name']=$region->where("id='$province_id'")->value('region_name');
        $data['detail']['city_name']=$region->where("id='$city_id'")->value('region_name');
        $data['detail']['area_name']=$region->where("id='$area_id'")->value('region_name');
            
        $data['detail']['address']=$data['detail']['province_name'].$data['detail']['city_name'].$data['detail']['area_name'].$data['detail']['details_site'];
        
 
        return $data;
    }


    //添加地址
    public function address_add_back($post_id,$user_id,$post=''){
        
         
        
        $data[province]=$post[province];
        $data[city]=$post[city];
        $data[area]=$post[area];
        $data[details_site]=$post[details_site];
        $data[postalcode] = $post[postalcode] ;
        $data[name]=$post[name];
        $data[phone]=$post[phone];
        $data[is_receive]=$post[is_receive];
        $data[time]=time();
        $userid=$data[user_id]=$user_id;

        if($post[type]=="1"){
            $data[type]="1";
            $array[where]="user_id='$userid' and type='1'";

            if($post['is_receive']){
                $array[where].=" AND is_receive={$post['is_receive']} ";
            }

            $array[table]="address";
            $array[data][type]="0";
            Db::name('address')->where($array[where])->update($data);
        }else{
            $data[type]="0";
        }
        

        $array[data]=$data;
        $array[table]="address";
 
        if ($post_id==NULL){
            
            $data[id]=Db::name('address')->where($array[where])->insertGetId($data);
            return $data;
        }else {
            $array[where]="user_id='$userid' and id='$post_id'";
            Db::name('address')->where($array[where])->update($data);
            $data[id]=$post_id;
        }
        
        return $data;
    }


    public function address_lists($userid,$search=''){
        
        $db=Db::name('address');

        $where="user_id='$userid'";

        if($search['is_receive']){
            $where.=" AND is_receive={$search['is_receive']} ";
        }
        
        $lists=$db->where($where)->select();

        if(!$lists){
            $data['status']="10002";
            return $data;
        }

        for ($i=0;$i<count($lists);$i++){
           $lists[$i]=$this->address_detail_name($lists[$i][id]);
        }
        $data[lists][content]=$lists;

        return $data;
    }


}