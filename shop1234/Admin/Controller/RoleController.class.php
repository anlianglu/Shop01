<?php
namespace Admin\Controller;
use Tools\AdminController;

//角色控制器
class RoleController extends AdminController {
    //列表展示
    function showlist(){

        //每个页面使用的导航信息定义
        $daohang = array(
            'first'=>'角色管理',
            'second'=>'角色列表',
            'act'=>'添加',
            'act_url'=>U('tianjia'),
        );
        $this -> assign('daohang',$daohang);

        //获得列表信息
        $info = M('Role')->select();

        $this -> assign('info',$info);
        $this -> display();
    }

    //给角色分配权限
    function distribute(){
        $role_id = I('get.role_id');
        if(IS_POST){
            //收集form表单信息，给角色设置权限
            //① 把收集的权限的id信息拼装为字符串
            $authids = implode(',',$_POST['authid']);
            //② 根据① 获得权限的“控制器和操作方法”
            $authinfo = M('Auth')
                ->where(array(
                    'auth_level'=>array('gt',0),
                    'auth_id'=>array('in',$authids)))
                ->select();
                //SELECT * FROM `sp_auth` WHERE `auth_level` > 0 AND `auth_id` IN ('101','104','105','106','102','107','108','109')
            //从$authinfo里边获得控制器和操作方法进行“拼装”
            $s = "";
            foreach($authinfo as $k => $v){
                $s .= $v['auth_c']."-".$v['auth_a'].",";
            }
            $s = rtrim($s,',');

            //③ 实现角色数据更新
            $arr['role_id'] = I('post.role_id');
            $arr['role_auth_ids'] = $authids;
            $arr['role_auth_ac'] = $s;
            if(M('Role')->save($arr)){
                //save()执行的sql语句：UPDATE `sp_role` SET `role_auth_ids`='101,104,105,106,102,107,108,109',`role_auth_ac`='Category-showlist,Goods-showlist,Goods-tianjia,Order-showlist,Order-dayin,Order-tianjia' WHERE `role_id` = 51
                $this -> success('权限分配成功',U('showlist'),1);
            }else{
                $this -> error('权限分配失败',U('distribute',array('role_id'=>$role_id)),1);
            }
        }else{
            //每个页面使用的导航信息定义
            $daohang = array(
                'first'=>'角色管理',
                'second'=>'分配权限',
                'act'=>'返回',
                'act_url'=>U('showlist'),
            );
            $this -> assign('daohang',$daohang);

            //把被分配权限的角色信息获取到
            $roleinfo = M('Role')->find($role_id);
            $this -> assign('roleinfo',$roleinfo); 

            //获取供选择设置的父、子级权限
            $authInfoA = M('Auth')->where(array('auth_level'=>0))->select();            
            $authInfoB = M('Auth')->where(array('auth_level'=>1))->select();

            $this -> assign('authInfoA',$authInfoA);            
            $this -> assign('authInfoB',$authInfoB);            
            $this -> display();
        }
    }
}
