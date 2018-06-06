<?php

namespace app\shop\controller;
use think\Controller;
use think\Db;

class Cms extends Base{

    public function __construct(){
        parent::__construct();
    }


    public function detail(){
        $id=input('id');
        $data=Db::name('cms_content')->where('id',$id)->field("id,title,summary,img_thumb,context")->find();

        $this->assign('page_title',"文章详情");

        $this->assign('data',$data);
        return $this->fetch("Cms/detail");
    }

}