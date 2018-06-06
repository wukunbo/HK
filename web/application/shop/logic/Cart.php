<?php 
namespace app\shop\logic;
use think\Model;
use think\Db;

class Cart extends Model{

    public function __construct(){
        $this->db= new \app\userweb\model\PublicModel();
        $this->shop_id=1;
    }



    //购物车列表
    // $search  address_id  shipping_id  shop_id cart_id
    public function cart_lists($user_id,$search){
        
        //读取全部的购物车列表        
        $array[table]="shop_cart";
        if(!$search[cart_id]){
            $array[where]="user_id='".$user_id."'  ";
            $map['user_id']=['eq',$user_id];
        }else{
            $array[where]=" cart_id in (".$search[cart_id].") ";
            $map['cart_id']=['in',$search[cart_id]];
        }

        $array[num]=100;

        //关联到上架的商品
        // $array[join]=" LEFT JOIN tl_shop_goods ON tl_shop_goods.goods_id=tl_shop_cart.goods_id";
        $array['join']=array("tl_shop_goods","tl_shop_goods.goods_id=tl_shop_cart.goods_id AND tl_shop_goods.status=1");

        $array[order]=$search[order]="tl_shop_cart.addtime desc";   
        $array[field]='*';
        $array[where]=$map;
        // dump($array);exit;
        $data=$this->db->Page($array);  
        // echo Db::name("shop_cart")->getLastsql();exit;
        // dump($data);exit;
        //获取 商品信息
        $GoodsLogic= new \app\shop\logic\Goods();
     
        $total_goods_price=0;//购物车总价

        $give_points_all=0;//购买赠送积分

        for ($i=0;$i<count($data[content]);$i++){   //遍历购物车 ,获取商品数据 更新数据和库存

            $goods_id=$data[content][$i][goods_id];
            $attr=$data[content][$i][attr];
            $amount=$data[content][$i][amount];
            $user_id=$data[content][$i][user_id];
           
            //获取库存
            $stock=$GoodsLogic->get_goods_stock($attr,$goods_id);
 
            if($amount>$stock){
                 
                if($stock<1){ //删除
                    Db::name("shop_cart")->where("cart_id='".$data[content][$i][cart_id]."'")->delete();
                    unset($data[content][$i]);
                }else{//更新库存
                    Db::name("shop_cart")->where("cart_id='".$data[content][$i][cart_id]."'")->setField("amount",$stock);
                    $data[content][$i][amount]=$stock;
                }
            }
            if($data[content][$i]){//统计
                $data[content][$i][goods_name]=$GoodsLogic->goods_val($goods_id,"goods_name"); 
                $data[content][$i][img_thumb]=$GoodsLogic->goods_val($goods_id,"img_thumb"); 
                
                //获取价格
                $tmp=$GoodsLogic->get_goods_price($goods_id,$user_id,$attr,$num=amount,$is_total=0,$tmp_array);
                //var_dump($tmp);
                $goods_price=$tmp[goods_price];
                $share_price=$tmp[price];

                //更新价格
                Db::name("shop_cart")->where("cart_id='".$data[content][$i][cart_id]."'")->setField("price",$goods_price);
                
                $total_goods_price=$total_goods_price+$goods_price*$data[content][$i][amount];
                $total_share_price=$total_share_price+$share_price*$data[content][$i][amount];

                $give_points=Db::name("shop_goods")->where("goods_id='".$goods_id."'")->value("buy_give_point");
                $give_points_all+=$give_points*$data[content][$i][amount];

            }
             
           
            
        }
        
        $data[total_goods_price]=$total_goods_price;
        $data[total_share_price]=$total_share_price;
        $data[give_points_all]=$give_points_all;

        $share_grade_id=Db::name("shop_share_user")->where("user_id='".$user_id."'")->value("share_grade_id");
        if($share_grade_id){
            $data[share_discount]=M("shop_share_grade")->where("id={$share_grade_id}")->value("share_discount");
        }
        
        return $data;
        
    }



    //购物车详情
    public function cartd_detail($cart_id){
        
        $data[detail]=Db::name("shop_cart")->where("cart_id='".$cart_id."'")->find();
        $data[status]=10001;
        return $data;
    }




    //添加商品到购物车
    public function add_cart($user_id,$goods_id,$amount,$attr,$cart_id,$post=array()){
    
        if(!$user_id){
            $data[status]=10006;
            $data[msg]="您尚未登录，请登录";
            return $data;
        }

        $goods_logic= new \app\shop\logic\Goods();

        $db_cart=Db::name('shop_cart');

        if($cart_id){ 
            //购物车存在,重新获取
            $detail=$db_cart->where("cart_id='".$cart_id."'")->find();
            $goods_id=$detail[goods_id];
            $attr=$detail[attr];
            $user_id=$detail[user_id];
        }

        //判断商品是否下架
        $goods_status=Db::name("shop_goods")->where("goods_id={$goods_id}")->value("status");
        if(!$goods_status){
            $data[status]=50001;
            $data[msg]="该商品已下架";
            return $data;
        }

        //获取商品类别
        $type=1;
        
        //获取商店id
         
        $shop_id=$this->shop_id;
                 
        
        //该属性下的商品数量 ,如果属性为空,返回goods库存
        $stock=$goods_logic->get_goods_stock($attr,$goods_id);

        //判断库存
        if ($stock<intval($amount)){
            $data[status]=10003;
            $data[amount]=$stock;
            $data[msg]="库存不足";
            return $data;
        }
        
    
        
        //强制 是积分购买，判断积分是否够。 
        $goods_point=$goods_logic->get_goods_point($goods_id);
        
        $point_price=0;

        if($goods_point){ //积分存在
            //获取用户
           
            $point=Db::name('user')->where("id='".$user_id."'")->value("points");
            if($point<($goods_point*$amount)){
                $data[point]=$point;
                $data[status]=10005;
                $data[msg]="用户积分不足";
                return $data;
            }
            $point_price=$goods_point;
        
        }
        
        //是否选择了属性 获取本属性的购买
        
        if ($attr!=null){   
            $cart_where="goods_id='$goods_id' and user_id='$user_id'  and attr='$attr' and type='$type'";
            $where="goods_id='$goods_id' and attr='$attr' ";
            $cart[attr]=$attr;      
        }else {         
            $cart_where="goods_id='$goods_id' and user_id='$user_id' and attr is NULL and type='$type'";
            $where="goods_id='$goods_id'";          
        }

        if(!$cart_id){
            $cart_id=$db_cart->where($cart_where)->value('cart_id');
        }
 
        
      
        $tmp=$goods_logic->get_goods_price($goods_id,$user_id,$attr,$amount,$is_total=0,$tmp_array);
        // dump($tmp);exit;
        $price=$tmp[price];
        
        //编号
        $goods_sn=$goods_logic->get_goods_sn($attr,$goods_id);
    
         
        //获取购买赠送的积分
        $buy_give_point=$goods_logic->get_buy_give_point($goods_id);

        //写入购物车 数据库
        $cart_post[type]=$type;
        $cart_post[price]=$price;
        $cart_post[point_price]=$point_price;
        $cart_post[attr]=$attr;     
        $cart_post[goods_sn]=$attr;     
        $cart_post[amount]=$amount;     
        $cart_post[goods_id]=$goods_id;     
        $cart_post[goods_sn]=$goods_sn;     
        $cart_post[shop_id]=$shop_id;       
        $cart_post[status]=0;   
        $cart_post[buy_give_point]=$buy_give_point;
        $cart_post[user_id]=$user_id;
        $cart_post[addtime]=time(); 
        
         
        //判断购物车是否存在改商品
        if (!$cart_id){     
            $cart_id=$db_cart->insertGetId($cart_post);                         
        }else {                         
            $db_cart->where("cart_id={$cart_id}")->update($cart_post);                                
        }
        //加入成功
        if ($cart_id){         
            $data[cart_id]=$cart_id;        
            $data[status]=10001;                    
        }else {                 
            $data[status]=10002;                    
        }

        return $data;       
    }



    //计算购物车价钱   
    public function calculate($cart_id_lists,$search,$user_id){             
     
        $GoodsLogic=new \app\shop\logic\Goods();

        $shipping_fee=0; //运费
        $total_goods_price=0;//商品总价
        $total_price=0;//总费用
        $min_point=0;//必须支付的积分，仅对存在积分商品有用
        $max_point=0;//可以使用的最多积分
        $all_point=0;//一共的积分
        $give_points_all=0; //计算总的可赠送的积分
        
        $dis_coupon=0;
        
        
        //获取购物车列表
        $search[cart_id]=$cart_id_lists;

        if(is_array($cart_id_lists)){
            $search[cart_id]=implode(",",$cart_id_lists);
        }
         
        $cart_data=$this->cart_lists($user_id,$search);
        $lists=$cart_data[content];

        //可赠送的积分
        $give_points_all=$cart_data[give_points_all];
        //总价 
        $total_goods_price=$cart_data[total_goods_price];
        //代理总价
        $total_share_price=$cart_data[total_share_price];

        $kuaidi_set=Db::name("kuaidi_set")->where("id=1")->find();
        $shipping_fee=$kuaidi_set[kuaidi_fee];
        if($total_share_price>=$kuaidi_set[full_free]){
            $shipping_fee=0;
        }

        

        $total_price=$shipping_fee+$total_goods_price;

        

        
        $real_fee=$total_share_price+$shipping_fee; //实付
        
    
        
        $user_points=0;
        $exchange_price=0;
        //用户是否使用积分
        if($search[is_use_points]){
            $user_points=Db::name("user")->where("id={$user_id}")->value("all_points");
            $exchange_point=Db::name("point_set")->where("id=1")->value("exchange_point");
            if(!$exchange_point){
                $exchange_point=100;
            }
            if($user_points){
                $exchange_price=$user_points/$exchange_point;
            }
            

            if($exchange_price>=$total_share_price){
                $user_points=$total_share_price*$exchange_point;
            }
        }

        $use_price=0;
        if($user_points){
            $use_price=$user_points/$exchange_point;
        }
        
        
         
        
        
        // $real_fee=(float)$cart_data[total_goods_price]-$fee_dis_for_point-$fee_dis_for_coupon+$shipping_fee;
        $real_fee=(float)$cart_data[total_share_price]-$use_price+$shipping_fee;
        
        
        
        $data[give_points_all]=$give_points_all; //获取积分
        $data[user_points]=$user_points; //抵扣积分
        $data[exchange_price]=$exchange_price; //积分抵扣比例

        $data[points_fee]=$use_price;//积分抵扣金额
         
        $data[total_goods_price]=$cart_data[total_goods_price]; //商品总价

        $data[total_share_price]=$cart_data[total_share_price]; //代理总价
        
        $data[shipping_fee]=$shipping_fee; //运费
        $data[total_price]=$total_price; //总费用
        $data[real_fee]=$real_fee; //实付

        $data[lists]=$lists;    
    
        return $data;       
    
    }



    //删除购物车(根据购物车id字符串，如：1,2,3)
    public function delete_cart($cart_id_str){
        if($cart_id_str!=""){
            $where='cart_id in ('.$cart_id_str.')';
        }else{
            $where=" 1=-1 ";
        }
        $data=Db::name('shop_cart')->where($where)->delete();
        return $data;
    }


}