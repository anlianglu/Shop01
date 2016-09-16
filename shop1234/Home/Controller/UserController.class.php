<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
    //会员登录
    public function login(){
        if(IS_POST){
            $name = I('post.user_name');
            $pwd = I('post.user_pwd');
            //判断用户名、密码是否正确
            $info = M('User')
                ->where(array('user_name'=>$name,'user_pwd'=>$pwd))
                ->find();
            if($info!==null){
                //持久化用户信息
                session('user_id',$info['user_id']);
                session('user_name',$info['user_name']);

                //判断是否有定义回跳地址
                $back_url = session('back_url');
                if(!empty($back_url)){
                    session('back_url',null);  //清除回跳地址，避免后续干扰
                    $this -> redirect($back_url);
                }

                $this -> redirect('Index/index');
            }
            echo "用户名或密码错误";
        }
        $this -> display();  //调用模板
    }
    
    //qq登录系统
    function qqlogin(){
        //根据二级秘钥、三级秘钥把当前qq账号信息获得出来并session持久化
        //使得qq账号登录商城系统

        //print_r($_SESSION);
        //向user/get_user_info.php发起请求
        $access_token = $_SESSION['access_token'];
        $openid = $_SESSION['openid'];
        $url = "http://www.51lfgl.cn/Common/Plugin/qq/user/get_user_info.php?access_token=$access_token&openid=$openid";
        //file_get_contents()对其他地址进行访问，当前页面的session信息与被请求其他地址不能共享
        //需要通过get方式把access_token和openid传递给get_user_info.php
        $userinfo = file_get_contents($url); //向$url触发请求

        //给json反编码
        $userinfo = json_decode($userinfo,true);

        //把获得的qq账号信息存储给数据库
        $shuju['user_name'] = $userinfo['nickname'];
        $shuju['openid']    = $_SESSION['openid'];
        $shuju['user_sex']  = $userinfo['gender'];

        //判断该qq账号之前是否有登录过系统
        $exists = M('User')->where(array('openid'=>$openid))->find();
        if($exists===null){
            $user_id = M('User')->add($shuju);//没有登录就添加新会员记录
        }else{
            //否则就是更新会员记录
            $shuju['user_id'] = $user_id = $exists['user_id'];
            M('User')->save($shuju);
        }
        //持久化用户信息
        session('user_id',$user_id);
        session('user_name',$shuju['user_name']);
        //页面跳转到首页
        $this -> redirect('Index/index');
    }

    //会员退出
    public function logout(){
        session(null);
        $this -> redirect('Index/index');
    }

    //会员注册
    public function register(){
        $this -> display();
    }
}
