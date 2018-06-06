<?php 
namespace app\shop\logic;
use think\Model;
use think\Db;

class Activity extends Model{

    public function __construct(){
        $this->db= new \app\userweb\model\PublicModel();
    }


    public function is_goods_detail($goods_id){

        $map['tl_shop_activity_goods.status']=['eq',1];
        $map['tl_shop_activity.start_date']=['lt',time()];
        $map['tl_shop_activity.end_date']=['gt',time()];

        $detail=Db::name("shop_activity_goods")
                ->join('tl_shop_activity','tl_shop_activity.id=tl_shop_activity_goods.activity_id')
                ->where($map)
                 ->field("tl_shop_activity_goods.*,tl_shop_activity.title as activity_title ")
                ->find();
        
        // echo Db::name("shop_activity_goods")->getLastsql();exit;
        $detail[is]=1;
        if(!$detail[id]){
            $detail[is]=0;
        }
                  
        return $detail;
    }



}