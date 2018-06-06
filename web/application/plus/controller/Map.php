<?php
namespace app\plus\controller;
use think\Controller;
use think\Db;


class Map extends Controller{

    public function __construct(){
        parent::__construct();
    }

    public function select(){
        $res=$this->fetch();
        echo $res;
    }

    public function map_iframe(){
        $res=$this->fetch();
        echo $res;
    }


}