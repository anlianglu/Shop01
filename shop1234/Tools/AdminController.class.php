<?php

//命名空间:除了项目shop，其他的上级目录都设置为命名空间的信息
namespace Tools;
use Think\Controller;

class AdminController extends Controller{
    //构造方法
    function __construct(){
        parent::__construct(); //先执行父类构造方法，避免其被覆盖

        $mg_id = session('mg_id');
        $mg_name = session('mg_name');

        //对用户访问的权限进行限制
        $nowAC = CONTROLLER_NAME."-".ACTION_NAME; //当前请求操作

        $allowAC2 = "Manager-login,Manager-verifyImg";
        //用户没有登录系统，并且其访问的权限在$allowAC2里边不出现
        //就要跳转到登录页去
        if(empty($mg_name) && strpos($allowAC2,$nowAC)===false){
            //跳转到登录页
            //通过一段js代码，使得全部的frameset页面都跳转
            $js = <<<eof
            <script type="text/javascript">
                window.top.location.href = "/index.php/Admin/Manager/login";
            </script>
eof;
            echo $js;
        }else{
            //获取当前用户角色的权限信息
            $roleinfo = M('Manager')
                -> alias('m')
                -> join('left join __ROLE__ r on m.role_id=r.role_id')
                -> where("m.mg_id='$mg_id'")
                -> field('r.role_auth_ac')
                -> find();
            $authAC = $roleinfo['role_auth_ac'];//当前用户“拥有”的权限
            
            //系统许可权限
            $allowAC = "Manager-login,Manager-logout,Index-index,Index-left,Index-right,Index-center,Index-head,Index-down,Manager-verifyImg";

            //权限访问控制
            //① 没有访问本身拥有的权限
            //② 没有访问系统许可的权限
            //③ 用户还"不是"超级管理员admin
            //以上①、②、③ 同时满足就是“越权访问”
            //判断$nowAC在$authAC中是否存在
            if(strpos($authAC,$nowAC)===false && strpos($allowAC,$nowAC)===false &&$mg_name!=='admin' ){
                exit('没有权限访问！');
            }
        }
    }
}
