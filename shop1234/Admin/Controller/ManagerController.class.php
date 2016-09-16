<?php
namespace Admin\Controller;
use Tools\AdminController;

class ManagerController extends AdminController {
    //后台管理员登录
    public function login(){
        //两个逻辑：展示、收集
        $manager = M('Manager');
        if(IS_POST){
            $shuju = $manager->create();  //收集数据，其会自动过滤非法字段
            //校验用户名和密码
            $info = $manager
                ->where(array('mg_name'=>$shuju['mg_name'],'mg_pwd'=>$shuju['mg_pwd']))
                ->find();
            if($info!==null){
                //session持久化用户信息
                session('mg_id',$info['mg_id']);
                session('mg_name',$info['mg_name']);

                //页面跳转到后台首页面去
                //redirect($url,$params=array(),$delay=0,$msg='')
                //$this -> redirect('Index/index',array(),3,'登录成功'); //提示信息，3秒后跳转 
                //立即跳转
                $this -> redirect('Index/index');
            }
            echo "用户名或密码不正确";
        }
        $this -> display();  //调用模板
    }

    //管理员退出系统
    function logout(){
        session(null);   //清空session
        $this -> redirect('login');  //跳转到登录页
    }
}
