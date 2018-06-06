<?php 
namespace app\market\logic;
use think\Model;
use think\Db;

class Welfare extends Model{

    public function __construct(){
        $this->db= new \app\userweb\model\PublicModel();
    }


}