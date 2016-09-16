<?php
namespace Admin\Controller;
use Tools\AdminController;

//权限控制器
class AuthController extends AdminController {
    //列表展示
    function showlist(){
        //每个页面使用的导航信息定义
        $daohang = array(
            'first'=>'权限管理',
            'second'=>'权限列表',
            'act'=>'添加',
            'act_url'=>U('tianjia'),
        );
        $this -> assign('daohang',$daohang);

        //获得列表信息
        $info = M('Auth')->order('auth_path')->select();

        $this -> assign('info',$info);
        $this -> display();
    }

    //添加权限
    function tianjia(){
        $auth = M('Auth');
        if(IS_POST){
            //1) 先根据已有信息形成insert语句执行
            $shuju = $auth -> create(); 
            $newid = $auth -> add($shuju);

            //2) 执行update语句更新path和level
            //① 计算path全路径信息
            if($shuju['auth_pid']==0){
                //a. 顶级权限  全路径==== 本身记录的主键id值
                $path = $newid;
            }else{
                //b. 非顶级权限  全路径 ==== 父级全路径-本身主键id值
                $pinfo = $auth -> find($shuju['auth_pid']);  //获得父级权限信息
                $path = $pinfo['auth_path']."-".$newid;
            }
            //② 计算level 等级信息
            //   规律：等级 ====  全路径里边"-"的个数
            $level = substr_count($path,'-');

            $arr['auth_id']     = $newid;
            $arr['auth_path']   = $path;
            $arr['auth_level']  = $level;
            if($auth -> save($arr)){
                $this -> success('添加权限成功',U('showlist'),1);
            }else{
                $this -> error('添加权限失败',U('tianjia'),1);
            }
        }else{
            //每个页面使用的导航信息定义
            $daohang = array(
                'first'=>'权限管理',
                'second'=>'权限添加',
                'act'=>'返回',
                'act_url'=>U('showlist'),
            );
            $this -> assign('daohang',$daohang);

            //获取供选择使用的上级权限
            $authInfoA = $auth->where(array('auth_level'=>0))->select();
            $this -> assign('authInfoA',$authInfoA);

            $this -> display();
        }
    }
}
