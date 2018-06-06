<?php
namespace app\api\controller;
use think\Controller;
use think\Db;

class Test extends Controller{

    public function __construct(){
        parent::__construct();
    }


    public function get_img(){

       set_time_limit(0);

        $data=Db::name("shop_category")->where("parent_id!=0")->field("cate_id,cat_name,img_thumb")->order("sort_order DESC")->select();
        foreach ($data as $key => $value) {
            $img_thumb=str_replace('"',"",$value['img_thumb']);
            // $img_thumb=str_replace('"',"",img);
            // echo $img_thumb."<br>";
            Db::name("shop_category")->where('cate_id',$value['cate_id'])->setField("img_thumb",$img_thumb);    
        }


        dump($data);exit;


        foreach ($data as $key => $value) {
            $keyword = $value['cat_name'];  
            $keyword = urlencode($keyword);  
            $url = "http://image.baidu.com/search/index?tn=baiduimage&word=" . $keyword;  
            $html = file_get_contents($url);  
            preg_match_all("/\"[^\"]*[^0]\.jpg\"/", $html, $arr);  
            // dump($arr);exit;  
            $img=$arr[0][1];
            echo $img;exit;
            Db::name("shop_category")->where('cate_id',$value['cate_id'])->setField("img_thumb",$img);       
        }

        echo "成功";
    }

    public function down_img(){

        set_time_limit(0);

        $data=Db::name('shop_goods')->field("goods_id,img_thumb")->select();

        foreach ($data as $key => $value) {
            $url=$value['img_thumb'];
            $filename="Uploads/goods/img_".$value[goods_id].".png";
            // $res=$this->download($url, $filename);
            if($res){
                Db::name('shop_goods')->where('goods_id',$value['goods_id'])->setField('img_orogin',$filename);
                echo "<p>文件".$imgSavePath."保存成功</p>";
            }

        }
        
    }


    function download($url,$filename)
    {
        $imgFile = file_get_contents($url);
        $flag = file_put_contents($filename, $imgFile);
        if ($flag) {
            // echo "<p>文件".$imgSavePath."保存成功</p>";
            return 1;
        }else{
            return 0;
        }
    }





    public function get_cate(){
        // $html=file_get_contents("http://baojia.3hk.cn/306");
        // // echo $html;
        // //匹配第一级分类
        // // $reTag='#<h2 class="zm-list-content-title"><a data-tip=".*?" href="(.*?)" class="zg-link" title="(.*?)">#';
        // $reTag='#<a  class="gray" target="_blank" href="http://baojia.3hk.cn/(.*?)">(.*?)</a>#';
        // preg_match_all($reTag,$html,$arr);
        // // dump($arr);exit;
        // $sourse_arr=$arr[1];
        // $name_arr=$arr[2];
        // // dump($sourse_arr);exit;

        // foreach ($sourse_arr as $key => $value) {
        //    // echo $key."<br>";
        //    if($key>141 && $key<=146){
        //         $dataList=array("cat_name"=>$name_arr[$key],"parent_id"=>24,"sourse_id"=>$value);
        //         // dump($dataList);exit;
        //         // Db::name('shop_category')->insert($dataList);
        //    }else{
            
        //    }
        // }
        set_time_limit(0);
        // $data=Db::name('shop_category')->where("parent_id!=0")->field("cate_id,cat_name,sourse_id")->select();
        // dump($data);exit;
        
        foreach ($data as $key => $value) {

            $html=file_get_contents("http://baojia.3hk.cn/{$value[sourse_id]}");
            $reTag='#<div class="field_box1"><span class="bold">品名：</span>(.*?)</div>#';
            preg_match_all($reTag,$html,$arr);
            // dump($arr);exit;
            $name_arr=$arr[1];

            $reTag='#<div class="field_box1"><span class="bold">价格：</span><span class="red">(.*?)</span> <span></span></div>#';
            preg_match_all($reTag,$html,$arr1);
            $price_arr=$arr1[1];
            // dump($price_arr);exit;
            // 
            
            

            $reTag='#data-original="(.*?)"#';
            preg_match_all($reTag,$html,$arr2);
            $img_arr=$arr2[1];
            // dump($img_arr);exit;
            foreach ($name_arr as $k => $val) {
                $dataList=array("goods_name"=>$val,"cate_id"=>$value['cate_id'],"hk_price"=>$price_arr[$k],"img_thumb"=>$img_arr[$k]);
                // Db::name('shop_goods')->insert($dataList);
            }

            sleep(5);

        }


        
        

        echo "成功";

    }


    public function set_price(){
        set_time_limit(0);

        $data=Db::name('shop_goods')->field("goods_id,cate_id,goods_name,img_thumb,hk_price")->select();
        // dump($data);exit;

        foreach ($data as $key => $value) {
            if($value['hk_price']){

                // $market_price=sprintf("%d",$value['hk_price']);
                // echo $market_price;

                $pattern = '/\d+/';
                preg_match($pattern, $value['hk_price'], $arr);
                // dump($arr);
                $market_price=$arr[0];
                // Db::name('shop_goods')->where("goods_id",$value['goods_id'])->setField('market_price',$market_price);

                // dump($value);
                // $hk_price=str_replace(",","",$value['hk_price']);
                // $price_arr=explode("/",$value[hk_price]);
                // $hk_price=$attr_arr[0];
                // $attr_title=$attr_arr[1];
                // $goods_name=$value['goods_name']."(".$attr_title.")";
                // $dataList=array("goods_name"=>$goods_name,"hk_price"=>$hk_price,"attr_title"=>$attr_title);
                // Db::name('shop_goods')->where("goods_id",$value['goods_id'])->update($dataList);
                // echo $hk_price."<br>";
                // Db::name('shop_goods')->where("goods_id",$value['goods_id'])->setField('hk_price',$hk_price);
            }
        }
        // dump($data);exit;
        // foreach ($data as $key => $value) {
        //     $price_arr=explode(" ",$value[hk_price]);

        //     $price_arr=array_filter($price_arr); 
        //     // dump($price_arr);
        //     if(count($price_arr)>1){
        //         dump($value);
        //         // dump($price_arr);
        //         Db::name('shop_goods')->where("goods_id",$value['goods_id'])->delete();
        //         foreach ($price_arr as $k => $val) {
        //             $attr_arr=explode("/",$val);
        //             $hk_price=$attr_arr[0];
        //             $attr_title=$attr_arr[1];
        //             $goods_name=$value['goods_name']."(".$attr_title.")";
        //             $dataList=array("goods_name"=>$goods_name,"cate_id"=>$value['cate_id'],"hk_price"=>$hk_price,"img_thumb"=>$value['img_thumb'],"attr_title"=>$attr_title);
        //             // dump($dataList);
        //             // Db::name('shop_goods')->insert($dataList);
        //         }
        //     }

        //     // sleep(5);
        // }
        echo "成功";
    }






}