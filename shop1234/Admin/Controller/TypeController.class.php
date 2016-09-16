<?php
namespace Admin\Controller;
use Tools\AdminController;

//类型控制器
class TypeController extends AdminController {
    //列表展示
    function showlist(){
        //每个页面使用的导航信息定义
        $daohang = array(
            'first'=>'类型管理',
            'second'=>'类型列表',
            'act'=>'添加',
            'act_url'=>U('tianjia'),
        );
        $this -> assign('daohang',$daohang);

        $info = M('Type')->select();
        $this -> assign('info',$info);

        $this -> display();
    }

    //添加
    function tianjia(){
        $type = M('Type');
        if(IS_POST){
            $shuju = $type -> create();
            if($type->add($shuju)){
                $this -> success('添加类型成功',U('showlist'),1);
            }else{
                $this -> error('添加类型失败',U('tianjia'),1);
            }
        }else{
            //每个页面使用的导航信息定义
            $daohang = array(
                'first'=>'类型管理',
                'second'=>'类型添加',
                'act'=>'返回',
                'act_url'=>U('showlist'),
            );
            $this -> assign('daohang',$daohang);
            $this -> display();
        }

    }
}
