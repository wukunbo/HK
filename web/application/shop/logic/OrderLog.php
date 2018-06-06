<?php 
namespace app\shop\logic;
use think\Model;
use think\Db;

class OrderLog extends Model{

    public function __construct(){
        $this->db= new \app\userweb\model\PublicModel();
    }


}