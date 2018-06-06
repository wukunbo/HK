<?php 
namespace app\shop\logic;
use think\Model;
use think\Db;

class Goods extends Model{

    public function __construct(){
        $this->db= new \app\userweb\model\PublicModel();
        $this->Cate_logic= new \app\shop\logic\Category();
        $this->Attr_Logic= new \app\shop\logic\Attr();
        $this->share_logic = new \app\share\logic\Share();
    }


    /*
        *$cate_id 所属分类id
        *$num 要检索的数量
        *type 商品种类:0为普通商品、1推荐、2促销、3预购、4热销、5积分商品、6新品、7具有赠品,101所有商品  
        *order 排序
        *field 需要检索的字段
        **/
    public function goods_lists($shop_id,$cate_id,$num,$type,$order="",$field,$keyword,$status,$search){

        $PRE="tl_";

        if(!$field){
            $field="tl_shop_goods.*";
        }

        if($order){
            if($shop_id==1 || $shop_id==''){
                $order=$order.",tl_shop_goods.sort DESC,tl_shop_goods.goods_id DESC";
            }else{
                //站内排序
                $order=$order.",tl_shop_goods.sort DESC,tl_shop_goods.goods_id DESC";
            }

        }else{
            $order="tl_shop_goods.sell_number DESC,tl_shop_goods.sort DESC,tl_shop_goods.is_top DESC";
             
        }


        if($search[cate_id_str]){ //多分类
            $tmp=explode(",",$search[cate_id_str]);
            for($i=0;$i<count($tmp);$i++){
        
                $Category=new \app\shop\logic\Category();         
                $cate_lists=$Category->get_cate_children_id($tmp[$i]);                     
                $where_tmp["tl_shop_goods.cate_id"]=array('in',$cate_lists);       

            }
            
        }



        //检索分类distinct
        if ($cate_id){
            $Category=new \app\shop\logic\Category();            
            $cate_lists=$Category->get_cate_children_id($cate_id);     
           
            $where_tmp["tl_shop_goods.cate_id"]=array('in',$cate_lists);       
        }  

       
        if ($keyword){

            $keyword=str_replace("  "," ",$keyword);
            $tmp_arr=explode(" ",$keyword);

            for($i=0;$i<count($tmp_arr);$i++){
                if($i>0){
                    $t=" OR ";
                }
                if($tmp_arr){
                    if($is_or){
                        $t=" AND ";
                    }
                    $s= $s.$t." ( tl_shop_goods.keyword LIKE '%".$tmp_arr[$i]."%' OR tl_shop_goods.goods_name  LIKE '%".$tmp_arr[$i]."%'  OR tl_shop_goods.goods_id  LIKE '%".$tmp_arr[$i]."%' OR tl_user.loginname LIKE '%".$tmp_arr[$i]."%' ) ";
                    $is_or=1;
                }
            }
            $map["_string"] = "   (  ".$s." )";
 
        }

        if ($shop_id){            
            $map["tl_shop_goods.shop_id"]=array('eq',$shop_id);     
        }   

        //现在时间
        $nowtime=time();
        switch ($type){    

            case '':
               
            break;
            case 'is_zhongchou':
                //是否推荐
                $map["".$PRE."shop_goods.is_zhongchou"]=array('eq','1');                
            break;  
            case 'is_pintuan':
                //是否推荐
                $map["".$PRE."shop_goods.is_pintuan"]=array('eq','1');              
            break;  
            case 'zhongchou':
                //是否推荐
                $map["".$PRE."shop_goods.is_zhongchou"]=array('eq','1');                
            break;      
            case 'recommended':
                //是否推荐
                $map["".$PRE."shop_goods.is_recommended"]=array('eq','1');              
            break;
            case 'is_recommended':
                //是否推荐
                $map["".$PRE."shop_goods.is_recommended"]=array('eq','1');              
            break;          
            case 'promote': //包括秒杀抢购is_qianggou
                //是否促销
                $map["".$PRE."shop_goods.is_promote"]=array('eq','1');          
                //$map["".$PRE."shop_goods.promote_start_date"]=array('ELT',$nowtime);          
                $map["".$PRE."shop_goods.promote_end_date"]=array('EGT',$nowtime);              
            break; 
            case 'is_promote': //包括秒杀抢购is_qianggou
                //是否促销
                $map["".$PRE."shop_goods.is_promote"]=array('eq','1');          
                //$map["".$PRE."shop_goods.promote_start_date"]=array('ELT',$nowtime);          
                $map["".$PRE."shop_goods.promote_end_date"]=array('EGT',$nowtime);              
            break;  
            case 'qianggou': //包括秒杀抢购is_qianggou
                //是否促销
                $map["".$PRE."shop_goods.is_qianggou"]=array('eq','1');         
                //$map["".$PRE."shop_goods.promote_start_date"]=array('ELT',$nowtime);          
                $map["".$PRE."shop_goods.promote_end_date"]=array('EGT',$nowtime);              
            break;  
            case 'is_qianggou': //包括秒杀抢购is_qianggou
                //是否促销
                $map["".$PRE."shop_goods.is_qianggou"]=array('eq','1');         
                //$map["".$PRE."shop_goods.promote_start_date"]=array('ELT',$nowtime);          
                $map["".$PRE."shop_goods.promote_end_date"]=array('EGT',$nowtime);              
            break;  
            case 'miaosha':
                //是否促销
                $map["".$PRE."shop_goods.is_miaosha"]=array('eq','1');          
                //$map["".$PRE."shop_goods.promote_start_date"]=array('ELT',$nowtime);          
                $map["".$PRE."shop_goods.promote_end_date"]=array('EGT',$nowtime);              
            break;  
            case 'is_miaosha':
                //是否促销
                $map["".$PRE."shop_goods.is_miaosha"]=array('eq','1');          
                //$map["".$PRE."shop_goods.promote_start_date"]=array('ELT',$nowtime);          
                $map["".$PRE."shop_goods.promote_end_date"]=array('EGT',$nowtime);              
            break;          
            case 'is_share':
                //是否分销
                $map["".$PRE."shop_goods.is_share"]=array('eq','1');                    
            break;
            case 'is_no_share':
                //是否分销
                $map["".$PRE."shop_goods.is_share"]=array('eq','0');                    
            break;          
           
            case 'hot':
                //热卖
                $map["".$PRE."shop_goods.is_hot"]=array('eq','1');              
            break;  
            case 'is_hot':
                //热卖
                $map["".$PRE."shop_goods.is_hot"]=array('eq','1');              
            break;  
            case 'new':
                //热卖
                $map["".$PRE."shop_goods.is_new"]=array('eq','1');              
            break;
            case 'is_new':
                //热卖
                $map["".$PRE."shop_goods.is_new"]=array('eq','1');              
            break;  
            case 'point':
                //积分
                $map[$PRE."shop_goods.is_point"]=array('eq','1');
                //积分商城
 
                //积分表的前缀
                if(!$field){
                    $field="".$PRE."shop_goods.*";
                }
                 
                 
                
            break;      
            case 'is_point':
                //积分
                $map[$PRE."shop_goods.is_point"]=array('eq','1');
                //积分商城
 
                //积分表的前缀
                if(!$field){
                    $field="".$PRE."shop_goods.*";
                }
                 
                 
                
            break;      
            case 7:
                //具有礼物
                $map["".$PRE."shop_goods.is_had_gift"]=array('eq','1');             
            break;

            case 8:
            //使用品
                $map["".$PRE."shop_goods.is_tra"]=array('eq','1');
                break;
            case 101:   
                        
                unset($map);            
            break;
        }
    
        if (isset($status)){    
            $map[$PRE."shop_goods.status"]=array('eq',$status);         
        }       
        
        if($search[shop_ids]){
            $map["".$PRE."shop_goods.shop_id"] = array("in",$search[shop_ids]) ;
        }
       

        //价款区间
        if($search[search_price]){
            $between=($search[search_price]-1000).",".$search[search_price];
            $map["".$PRE."shop_goods.shop_price"]  = array('between',$between);
        }
        
      
                
        // $join[]=array("tl_shop_goods_cate","tl_shop_goods_cate.goods_id=tl_shop_goods.goods_id","LEFT");

        
        $data['status']=10001;      
        $array['table']="shop_goods";       
        $array['where']=$map;           
        $array['field']=$field; 
        $array['join']=$join;       
        $array['num']=$num;     
        $array['order']=$order; 
        $result=$this->db->Page($array);    
        // dump($result);exit;
       
        for($i=0;$i<count($result['content']);$i++){

            $result['content'][$i][is_promote_running]=0; //秒杀抢购

            if($result['content'][$i][promote_start_date]<=time() && $result['content'][$i][promote_end_date]>=time()  ){
                $result['content'][$i][is_promote_running]=1; 
            }

            $result['content'][$i][is_promote_end]=0;
            if($result['content'][$i][promote_end_date]<=time()  ){
                $result['content'][$i][is_promote_end]=1; 
            }
            //计算库存
            $result['content'][$i]['goods_number']=$this->get_goods_stock($attr_array='',$result['content'][$i][goods_id],$all_stock=1);
            
            $tmp=$this->get_goods_price($result['content'][$i][goods_id]);
            // var_dump($tmp);
            $result['content'][$i][cur_price]=$tmp[price];
            $result['content'][$i][price_text]=$tmp[price_text];
            

            $result['content'][$i][share_discount]=$this->get_share_discount($search[login_user],$result['content'][$i][goods_id]);
            // var_dump($tmp);
            $result['content'][$i][cur_price]=$tmp[price];
            $result['content'][$i][price_text]=$tmp[price_text];
            
        }


         
        

        if ($result['content']==null){                  
            $data['status']=10002;  
            $data['lists']=$result;             
        }else {         
            $data['status']=10001;          
            $data['lists']=$result; 
            $data[setting][type]=$type;         
        }
        return $data;       
    }


    //获取库存
    public function get_goods_stock($attr_array='',$goods_id,$all_stock=0){
        
        if($attr_array){
            $attr_array=str_replace(",","_",$attr_array);
            $AttrLogic= new \app\shop\logic\Attr();
            $data=$AttrLogic->get_goods_attr_detail($attr_array,$goods_id);
        }
        if(!$data['stock'] && !$attr_array){
            $stock=Db::name("shop_goods")->where(" goods_id='$goods_id'")->value("goods_number");
            $data[stock]=$stock;
        }

        if($all_stock==1){
            $is=Db::name("shop_goods_attr")->where("goods_id='$goods_id'  ")->find();
            if($is){
                $stock=Db::name("shop_goods_attr")->where(" goods_id='$goods_id'")->value("sum(stock) as t");
                $data[stock]=$stock;
            }
        }
        return $data[stock];
    }


    //获取单个属性
    public function goods_val($goods_id,$field){
        $goods=Db::name("shop_goods");
        if(strpos($field,",")){
            $detail=$goods->field($field)->where(" goods_id='$goods_id'")->find();
        }else{
            $detail=$goods->where(" goods_id='$goods_id'")->value($field);
        }
        return $detail;
    }


    //获取商品价格
    /*
    type =1 普通商品
    */
    public function get_goods_price($goods_id,$user_id="",$attr="",$num=1,$is_total=0,$search=array()){

        $res[is_point]=0; //非积分商品

        if($attr){
            //获得属性价格
            $attr=str_replace(",","_",$attr);
            $AttrLogic= new app\shop\logic\Attr();
            $arrt_price=$AttrLogic->get_attr_price($attr,$goods_id);
            $goods_price=$arrt_price;
            if(!$goods_price){
                $res[price]=-1;
                $res[status]="20001";
                return $res;
            }

        }else{
            $where="goods_id='".$goods_id."' ";
            $goods_price=Db::name("shop_goods")->where($where)->value("shop_price");
        }

        $price=$goods_price;
         
        //获取等级折扣
        $discount_grade=1;
       
        $price=$price*$discount_grade;

        //获取代理等级折扣
        $share_discount=1;
        if($user_id){
            $share_grade_id=Db::name("shop_share_user")->where("user_id='".$user_id."'")->value("share_grade_id");


            if($share_grade_id){
                $cash_content = M("shop_share_goods_config")->where("goods_id={$goods_id}")->value("cash_content") ;
                $pay_level_lists=json_decode($cash_content,true);
                
                #计算该商品代理折扣
                if($pay_level_lists && ($pay_level_lists[0][pay]>0 || $pay_level_lists[1][pay]>0 || $pay_level_lists[2][pay]>0)){
                    foreach ($pay_level_lists as $key1 => $val) {
                        if($val[level]==$share_grade_id){
                            $share_discount=$val[pay]*0.01;
                        }
                    }
                }else{
                    $share_discount=Db::name("shop_share_grade")->where("id={$share_grade_id}")->value("share_discount");
                    $share_discount=$share_discount*0.01;
                }
                #END计算该商品代理折扣
            }


        }

        $price=$price*$share_discount;

        
        //计算促销价
        
        $where=" is_promote_qm=1 AND promote_start_date<='".time()."'  AND promote_end_date>='".time()."' AND goods_id='".$goods_id."'";
        $promote_price=Db::name("shop_goods")->where($where)->value("promote_price");

        if($promote_price>0){
            $price=$promote_price;
            if($is_miaosha==1){
                $res[price_text]="秒杀价";
            }
            if($is_qianggou==1){
                $res[price_text]="抢购价";
            }
        }
       
         
        $res[discount_money]=$discount_money; // 件数优惠价
        $res[discount_grade]=$discount_grade; // 获取等级折扣

        $res[share_discount]=$share_discount; // 获取代理等级折扣

        $res[price]=$price; //支付价
        $res[goods_price]=$goods_price; //商品实际价
        
        //强制获得积分 积分商品优先
        $where="goods_id='".$goods_id."' ";
        $point_price=Db::name("shop_goods_point")->where($where)->value("point_price");
        
        if($point_price){
            $res[is_point]=1;
            $res[price]=0; //支付价
            $res[point_price]=$point_price;
            $res[price_text]="积分价";
        }
       
        //活动优先
        $ActivityLogic = new \app\shop\logic\Activity();
        $detail[activity_detail]=$ActivityLogic->is_goods_detail($goods_id);

        if($detail[activity_detail][is]==1){
            $res[is_point]=0;
            $res[price]=$detail[activity_detail][price];
            $res[point_price]=0;
 
        }

        return $res;
    }




    //添加商品
    /*
     * post 表单中数据
     * 
     * */
    public function add_goods($goods_id,$post,$attr,$cate_lists,$gallery_thumb,$gallery_orogin,$data=array()){

         $shop_id=$post[shop_id];
       
        
        /*
        * 是否促销
        * */    
        if(trim($post[promote_start_date]) && trim($post[promote_end_date]) && $post[is_promote]){
            $post[promote_start_date]=strtotime(trim($post[promote_start_date]));       
            $post[promote_end_date]=strtotime(trim($post[promote_end_date]));   
        }else{
            $post[promote_start_date]="";
            $post[promote_end_date]="";
        }
       
        /*
         * 修改时间
         */
        $post[edittime]=time();
        
        $goods=Db::name('shop_goods');

        if (!$goods_id){
            //新商品
            $post[addtime]=time();
            $check=$goods_id=$goods->insertGetId($post);
            $map_option[goods_id]=$check;//型号--颜色属性中用到
            $goods_id=$check;
             
        }else { 
            //修改商品      
 
            $check=$goods->where("goods_id='$goods_id'")->update($post);
 
            $map_option[goods_id]=$goods_id;//型号--颜色属性中用到
                    
        }       
         
            
        //属性 处理价格处理
        $goods_attr=Db::name('shop_goods_attr');
        
        //删除目前的商品的所有属性值
        $goods_attr->where("goods_id='$goods_id'")->delete();
        $good_stock=0;
        $AttrLogic=new \app\shop\logic\Attr();

        for($i=0;$i<count($attr[stock]);$i++){
            if($attr[stock][$i] || $attr[price][$i]  ||  $attr[sn][$i]){
                if($attr[stock][$i]==""){
                    $attr[stock][$i]="0";
                }
           
                $attr_data[sn]=$attr[sn][$i];
                $attr_data[stock]=$attr[stock][$i];
                $attr_data[title]=$attr[title][$i];
                
                if(!$attr[price][$i]){
                    $attr[price][$i]=$post[shop_price];
                }
                $attr_data[price]=$attr[price][$i];
                //重新排序 字符串,转字符串

                $tmp="";
                for($k=0;$k<count($attr[text_select][$i]);$k++){
                    $tmp.=$attr[text_select][$i][$k]."_";
                }

                $tmp=substr($tmp,0,-1);
                $attr_data[text]=$tmp;
                
                $attr_data[goods_id]=$goods_id;
                $goods_attr->insert($attr_data);
                //统计库存
                $good_stock=$attr[stock][$i]+$good_stock;
                
            }
        }
        
        
        //重新更新库存
        if($good_stock>0){
            $search[stock]=$good_stock;
            $this->update_stock($goods_id,$search);
        }

        //标签处理
        //属性 处理价格处理
        $attr_tags=$data[attr_tags];
        //var_dump($attr_tags);
        $shop_goods_tags=Db::name('shop_goods_tags');
        //var_dump($attr_tags);
        //删除目前的商品的所有属性值
        $shop_goods_tags->where("goods_id='$goods_id'")->delete();
        for($i=0;$i<count($attr_tags[attr_id]);$i++){
            $arr=$attr_tags[val][$attr_tags[attr_id][$i]];
            if(count($arr)>0){
                 
                $tmp_data[val]=implode(",",$arr);
                $tmp_data[title]=$attr_tags[title][$i];
                $tmp_data[attr_id]=$attr_tags[attr_id][$i];
                $tmp_data[goods_id]=$goods_id;
                //var_dump($tmp_data);
                $shop_goods_tags->insert($tmp_data);
 
                //echo M()->getLastsql();
            }
        }
         
 
 
        //商品相册
        $goods_gallery=Db::name('shop_goods_gallery');     
 
        $goods_gallery->where("goods_id='$goods_id'")->delete(); 
 
        
        for ($i=1;$i<count($gallery_thumb);$i++){           
            $gallery_data[img_orogin]=$gallery_thumb[$i];           
            $gallery_data[img_thumb]=$gallery_orogin[$i];           
            $gallery_data[goods_id]=$goods_id;          
            $gallery_data[addtime]=time();          
            $goods_gallery->insert($gallery_data);         
        }       
        
         
        //商品分类   
        //删除所有分类
        $goods_cate=Db::name('shop_goods_cate');       
 
        $goods_cate->where(" goods_id='$goods_id'")->delete();  
     
 
        for($i=0;$i<count($cate_id);$i++){          
            $tmp_cate_id=$cate_id[$i];
 
            $cate_data[cate_id]=$tmp_cate_id;           
            $cate_data[goods_id]=$goods_id;         
            $cate_data[addtime]=time();         
            $goods_cate->insert($cate_data);
         
        }
        //主分类
        $cate_data[cate_id]=$post[cate_id];         
        $cate_data[goods_id]=$goods_id;         
        $cate_data[addtime]=time();         
        $goods_cate->insert($cate_data);   
 
 
 
        
        //分销处理
        $pay_level_lists = $_REQUEST[post][pay_level_lists] ;
 
        
        
        if(!$post[share_price]){
            $post[share_price]=$post[shop_price]; //采用商品价格
        }

        if($pay_level_lists[0]==-1 || $pay_level_lists[1]==-1  || $pay_level_lists[2]==-1 ){ //非分销商品
            $post[share_price]=$post[shop_price]; 
            //删除分销记录
            Db::name("shop_goods")->where("goods_id='".$goods_id."'")->setField("is_share",0);
             
            $array = "" ;
            $array['business_id'] = $post[shop_id] ;
            $array['goods_id'] = $goods_id ;
            $this->share_logic->goods_share_config_del($array);

        }else{
            $array = "" ;
            $array['pay_level_lists'] = $pay_level_lists;
            $array['business_id'] = $post[shop_id] ;
            $array['app'] = "shop" ;
            $array['share_price'] = $post[share_price] ;
            $array['goods_id'] = $goods_id ;
            $array['is_add'] = 1;
            
            if($pay_level_lists){
                $this->share_logic->goods_share_config($array);
                Db::name("shop_goods")->where("goods_id='".$goods_id."'")->setField("is_share",1);
            }
            
           
        }
         
        
        if ($check!=false){
            $data[status]=10001;                
        }else{              
            $data[status]=10002;        
        }
     
        return $data;       
    }




    //添加商品表
    public function goods_form($goods_id,$shop_id){ 
        
        
        
        if ($goods_id){
            
            $data=$this->goods_detail($goods_id);                                         
            //商品相册
            $goods_image=$this->goods_image($goods_id);                         
                                            
        }else {
 
        }   

        $array['business_id'] = $shop_id ;
        $array['app'] = "shop" ;
        $array['goods_id'] = $goods_id ;
        $data['detail']['share']=$this->share_logic->goods_share_config($array);    
  
        $data['detail']['goods_image']=$goods_image;
        
 
        return $data;   
    }


    //商品相册
    public function goods_image($goods_id){     
        $goods_gallery=Db::name('shop_goods_gallery');     
        $result=$goods_gallery->where("  goods_id='$goods_id'")->select();  
        return $result;     
    }


    //获取商品相册
    public function get_goods_gallery($goods_id){
        $goods_gallery=Db::name('shop_goods_gallery');     
        $gallery=$goods_gallery->where("  goods_id='$goods_id'")->select();
        return $gallery;
    }


    //商品详情
    public function goods_detail($goods_id,$field="",$type=""){

        $goods=Db::name('shop_goods');     
        $detail=$goods->where(" goods_id='$goods_id'")->find();

        if (!$detail[goods_id]){           
            $data[status]=10002;            
            return $data;           
        }elseif ($detail[goods_id]!=NULL){

            //积分优先
            if($detail[is_point]==1){
            
                $detail[point_price]=$this->get_goods_point($goods_id); 
            }
            //促销优先 //秒杀
            $detail[is_promote_running]=0;

            if($detail[is_promote]==1 && $detail[promote_start_date]<=time() && $detail[promote_end_date]>=time()  ){
                $detail[is_promote_running]=1; 
            }
            
            //活动属性置顶
            $ActivityLogic = new \app\shop\logic\Activity();
            $detail[is_activity]=0;
            $detail[activity_detail]=$ActivityLogic->is_goods_detail($goods_id);
            if($detail[activity_detail][is]==1){
                $detail[is_activity]=1;
                $detail[is_promote_running]=0; //取消促销部分
                $detail[activity_price]=$detail[activity_detail][price];
            }
          
            
            $data[detail]=$detail;   
            //获取多个分类列表
            $data[detail][cate_lists]=$this->get_goods_cate($goods_id);
   
            //获取等级价格
            $data[detail][grade_price_lists]=Db::name("shop_goods_grade")->where("goods_id=".$goods_id."")->select(); 
            
            //获取标签列表
            $data[detail][tags_lists]=Db::name("shop_goods_tags")->where("goods_id=".$goods_id."")->select();
            
            $data[status]=10001;    
                    
        }else {         
            $data[status]=10003;            
            return $data;           
        }               
        return $data;       
    }


    //获取编号
    public function get_goods_sn($attr_array='',$goods_id){
        
        if($attr_array){
            $attr_array=str_replace(",","_",$attr_array);
            $AttrLogic= new \app\shop\logic\Attr();
            $data=$AttrLogic->get_goods_attr_detail($attr_array,$goods_id);
        }
        if(!$data){
            $goods_sn=Db::name("shop_goods")->where(" goods_id='$goods_id'")->value("goods_sn");
            $data[sn]=$goods_sn;
        }
        return $data[sn];
    }


    //获取赠送的积分
    public function get_buy_give_point($goods_id,$user_id="",$search=array()){
        $db_goods=Db::name('shop_goods');
        $where="goods_id='".$goods_id."'";
        $buy_give_point=$db_goods->where($where)->value("buy_give_point");
        if(!$buy_give_point){
            $buy_give_point=0;
        }
        return $buy_give_point;
    }




    //获取积分属性
    public function get_goods_point($goods_id,$is_string=1){ 

        $goods_point=Db::name('shop_goods_point');     
 
        $point_price=$goods_point->where(" goods_id='$goods_id'")->value("point_price"); 
            
 
        if ($point_price==NULL){            
            $data[status]=10002;            
        }else {
            $data[status]=10001;
            $data[detail]=$point_price;         
        }
        if($is_string==1){
            return $point_price;
        }else{
            return $data;
        }
         
    }




    //更新库存
    /*
    $search[stock]=$stock
    $search[type]=1,-1 //1 直接更新叠加库存 -1 减  2补回库存
    $search[attr]=
    $search[sell]=1 销量 
    */
        
    public function update_stock($goods_id,$search){
        if($search[type]==1){
            $goods=Db::name('shop_goods')->where(" goods_id='$goods_id'")->setField("goods_number",$search[stock]);
        }
        if($search[type]==-1){
            $attr=$search[attr];
            $attr=str_replace(",","_",$attr);
             
            $goods=Db::name('shop_goods')->where(" goods_id='$goods_id'")->setDec("goods_number",$search[stock]);
            $goods=Db::name('shop_goods_attr')->where(" goods_id='$goods_id' AND text='".$attr."'")->setDec("stock",$search[stock]);
        }
        if($search[type]==2){
            $attr=$search[attr];
            $attr=str_replace(",","_",$attr);
             
            $goods=Db::name('shop_goods')->where(" goods_id='$goods_id'")->setInc("goods_number",$search[stock]);
            $goods=Db::name('shop_goods_attr')->where(" goods_id='$goods_id' AND text='".$attr."'")->setInc("stock",$search[stock]);
        }
        if($search[sell]==1){
            $goods=Db::name('shop_goods')->where(" goods_id='$goods_id'")->setInc("sell_number",$search[stock]*1); //增加销量
        }
    }


    //获取商品分类
    public function get_goods_cate($goods_id){
        $goods_cate=Db::name('shop_goods_cate');       
 
        $cate_id=$goods_cate->where("goods_id='$goods_id'")->select();
 
        return $cate_id;
        
    }


    //获取代理等级折扣
    public function get_share_discount($user_id,$goods_id){

        $share_grade_id=Db::name("shop_share_user")->where("user_id='".$user_id."'")->value("share_grade_id");
        $goods_price=Db::name("shop_goods")->where("goods_id={$goods_id}")->value("shop_price");
        $res[goods_price]=$goods_price;

        if($share_grade_id){
            $cash_content = Db::name("shop_share_goods_config")->where("goods_id={$goods_id}")->value("cash_content") ;
            $pay_level_lists=json_decode($cash_content,true);
            
            #计算该商品代理折扣
            if($pay_level_lists && ($pay_level_lists[0][pay]>0 || $pay_level_lists[1][pay]>0 || $pay_level_lists[2][pay]>0)){
                foreach ($pay_level_lists as $key1 => $val) {
                    if($val[level]==$share_grade_id){
                        $share_discount=$val[pay];
                    }
                }
            }else{
                $share_discount=Db::name("shop_share_grade")->where("id={$share_grade_id}")->value("share_discount");
                $share_discount=$share_discount;
            }
            #END计算该商品代理折扣
            
            $res[share_grade_id]=$share_grade_id;
            $res[share_discount]=$share_discount;
            $res[share_price]=$goods_price*$share_discount*0.01;

            $res[share_title]=Db::name("shop_share_grade")->where("id={$share_grade_id}")->value("title");

            
        }else{
            $res[share_grade_id]=0;
            $res[share_discount]=100;
            $res[share_price]=$goods_price;
            
            $res[share_title]="会员";

        }

        return $res;


    }



}