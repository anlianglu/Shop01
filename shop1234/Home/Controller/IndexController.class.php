<?php
namespace Home\Controller;
use Think\Controller;

//父类Controller:ThinkPHP/Library/Think/Controller.class.php

class IndexController extends Controller {
    public function index(){
        $this -> display();  //调用模板
    }
}
