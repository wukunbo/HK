<?php
namespace app\index\controller;

class Test
{
    public function index(){
        echo "test";
        echo $_REQUEST["name"];
    }
}
