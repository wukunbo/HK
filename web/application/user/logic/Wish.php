<?php 
namespace app\user\logic;
use think\Model;
use think\Db;

class Wish extends Model{

    public function __construct(){
        $this->db= new \app\userweb\model\PublicModel();
    }

    //添加商品收藏
    public function add_wish($user_id,$goods_id,$status){
        
        $wish=Db::name('shop_wish');
        $result=$wish->where(" user_id='$user_id' and goods_id='$goods_id'")->find();

        $options[user_id]=$user_id;
        $options[goods_id]=$goods_id;
        $options[status]=$status;
        
        if (!$result){
            $options[addtime]=time();
            $check=$wish->insertGetId($options);
        
        }else {
            $wish->where('id',$result['id'])->update($options);
            $check=$result['id'];
        }       
        if ($check){
            $data[status]=10001;
        }else {
            $data[status]=10002;
        }       
        return $data;
        
    }


    //商品收藏列表
    public function wish_lists($user_id,$search=array()){
    
        $array[table]='shop_wish';
        $array[where]="tl_shop_wish.user_id='$user_id'  AND tl_shop_wish.status=1";

        $db_goods=Db::name('shop_goods');

        if($search[num]){
            $array[num]=$search[num];
        }

        $array[field]="tl_shop_wish.*";

        $array[join][]=['tl_shop_goods','tl_shop_goods.goods_id=tl_shop_wish.goods_id'];

        $data=$this->db->Page($array);
        // dump($data);exit;

        $GoodsLogic=new \app\shop\logic\Goods();

        for ($i=0;$i<count($data['content']);$i++){
                $goods_id=$data['content'][$i]['goods_id'];
                $goods_detail=$db_goods->field("goods_id,goods_name,img_thumb,img_promote,market_price,shop_price,shop_id")->where(" goods_id='$goods_id'")->find();
                $tmp=$GoodsLogic->get_goods_price($goods_id,'','',$num='');
            
                $data['content'][$i]['goods']=$goods_detail;
                
     
                
        }
        
        
        
        return $data;
    }


}