<?php
namespace Admin\Controller;
use Tools\AdminController;

class IndexController extends AdminController {
    function __construct(){
        parent::__construct(); //先执行父类的构造方法，避免重写
        layout(false); //当前类的全部方法都会生效
                       //不使用布局
    }
    //index集成页
    function index(){
        C('SHOW_PAGE_TRACE',false);
        $this -> display();  //调用模板
    }
    //center集成页
    function center(){
        C('SHOW_PAGE_TRACE',false);
        $this -> display();  //调用模板
    }
    function head(){
        C('SHOW_PAGE_TRACE',false);
        $this -> display();
    }
    function left(){
        //根据管理员获得对应的操作权限
        $mg_id = session('mg_id'); //管理员id
        $mg_name = session('mg_name'); //管理员名字

        if($mg_name==='admin'){
            //1) 给admin获取全部权限
            $authInfoA = M('Auth')
                ->where(array('auth_level'=>0))
            ->select();            
            $authInfoB = M('Auth')
                ->where(array('auth_level'=>1))
            ->select();
        }else{
            //2） 普通管理员想获取权限
            //管理员(role_id)---->角色---->权限
            //根据管理员的角色获得对应的权限ids信息
            $roleinfo = M('Manager')
                -> alias('m')
                -> join('left join __ROLE__ as r on m.role_id=r.role_id')
                -> field('r.role_auth_ids')
                -> where(array('m.mg_id'=>$mg_id))
                -> find();
                //SELECT r.role_auth_ids FROM sp_manager m left join sp_role as r on m.role_id=r.role_id WHERE m.mg_id = '11' LIMIT 1
            
            $auth_ids = $roleinfo['role_auth_ids'];
            //根据$auth_ids获得权限的信息
            //顶级权限
            $authInfoA = M('Auth')
                ->where(array(
                    'auth_level'=>0,
                    'auth_id'=>array('in',$auth_ids)))
                ->select();
                //SELECT * FROM `sp_auth` WHERE `auth_level` = 0 AND `auth_id` IN ('102','107','108')
            //次级权限
            $authInfoB = M('Auth')
                ->where(array(
                    'auth_level'=>1,
                    'auth_id'=>array('in',$auth_ids)))
                ->select();
                //SELECT * FROM `sp_auth` WHERE `auth_level` = 1 AND `auth_id` IN ('102','107','108')
        }

        $this -> assign('authInfoA',$authInfoA);
        $this -> assign('authInfoB',$authInfoB);
        $this -> display();

    }
    function right(){$this -> display();}
    function down(){
        C('SHOW_PAGE_TRACE',false);
        $this -> display();
    }
}
