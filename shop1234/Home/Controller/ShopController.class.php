<?php
namespace Home\Controller;
use Think\Controller;


//超市控制器

class ShopController extends Controller {
    //添加商品到购物车
    function addCart(){
        $goods_id = I('get.goods_id');//当前被添加到购物车的商品id
        //商品添加给购物车的具体信息有：id、name、price、number、total_price
        /*array(
            'goods_id'=>'10',
            'goods_name'=>'诺基亚',
            'goods_price'=>'1750',
            'goods_buy_number'=>'1',
            'goods_total_price'=>1750);
        */
        $goodsinfo = M('Goods')->find($goods_id);
        $shuju['goods_id']      = $goods_id;
        $shuju['goods_name']    = $goodsinfo['goods_name'];
        $shuju['goods_price']   = $goodsinfo['goods_price'];
        $shuju['goods_buy_number']  = 1;
        $shuju['goods_total_price'] = $goodsinfo['goods_price'];

        $cart = new \Tools\Cart();
        $cart -> add($shuju);//商品添加给购物车

        //获得购物车商品“总数量、总价格”并返回
        $numberprice = $cart -> getNumberPrice();
        echo json_encode($numberprice);
    }


    //修改购物车商品数量
    function changeNumber(){
        $goods_id = I('get.goods_id');
        $num = I('get.num');
        //把购物车商品id为$goods_id的商品数量改为$num

        $cart = new \Tools\Cart();
        $xiaojiprice = $cart -> changeNumber($num,$goods_id);

        //获得购物车商品"总金额"
        $numberprice = $cart -> getNumberPrice();

        //把商品修改数量后的小计价格 和 购物车最新总价格返回
        echo json_encode(array('xiaoji'=>$xiaojiprice,'zongji'=>$numberprice['price']));
    }


    //删除购物车商品
    function  delGoods(){
        $goods_id = I('get.goods_id');

        //调用购物车
        $cart = new \Tools\Cart();
        $cart -> del($goods_id); //删除

        //获得购物车商品总金额
        $numberprice = $cart -> getNumberPrice();
        echo json_encode($numberprice);
    }

    //展示购物车商品列表信息
    function flow1(){
        //获取购物车数据
        $cart = new \Tools\Cart();
        $cartinfo = $cart -> getCartInfo();

        //获得购物车商品图片信息
        $goods_ids = implode(',',array_keys($cartinfo));//string(8) "26,24,25"
        $logoinfo = M('Goods')
            ->field('goods_id,goods_small_logo')
            ->select($goods_ids);

        //把$logoinfo 的图片信息 整合到 $cartinfo里边去
        foreach($cartinfo as $k => $v){
            foreach($logoinfo as $kk => $vv){
                if($k == $vv['goods_id']){
                    $cartinfo[$k]['logo'] = $vv['goods_small_logo'];
                }
            }
        }
        $this -> assign('cartinfo',$cartinfo);

        //获得购物车"总金额"并传递
        $numberprice = $cart -> getNumberPrice();
        $this -> assign('numberprice',$numberprice);
        $this -> display();
    }


    //制作/生成订单方法
    function flow2(){
        if(IS_POST){
            //1) 生成订单信息：给两个数据表维护数据
            //(订单表、订单商品关联表)
            //a. 维护订单表数据
            $cart = new \Tools\Cart();
            $numberprice = $cart -> getNumberPrice();

            $order = M('Order');
            $shuju = $order -> create();  //收集post表单信息
            $shuju['order_number'] = 'itcast-php48-'.date('YmdHis').'-'.mt_rand(1000,9999); //类似 itcast-php48-20160823172051-5314
            $shuju['order_price'] =$numberprice['price'];
            $shuju['add_time'] =$shuju['upd_time'] = time();
            $shuju['user_id'] = session('user_id');
            $orderid = $order -> add($shuju);

            //b.维护"订单商品关联表"数据
            //  获得购物车的每个商品信息并添加给数据表sp_order_goods即可
            $cartinfo = $cart -> getCartInfo();
            $shuju2 = array();
            foreach($cartinfo as $k => $v){
                $shuju2['order_id']         = $orderid;
                $shuju2['goods_id']         = $k;
                $shuju2['goods_price']      = $v['goods_price'];
                $shuju2['goods_number']     = $v['goods_buy_number'];
                $shuju2['goods_total_price'] = $v['goods_total_price'];
                M('OrderGoods')->add($shuju2);
            }

            //2) 清空购物车信息
            $cart->delall();

            //3) 支付实现
            //   模拟一个有5个表单域的form表单，并通过post方式提交
            //   提交的目的地地址是alipayapi.php
    $number = $shuju['order_number'];
    $totalprice = $shuju['order_price'];
    $fm = <<<eof
        <form action="/Common/Plugin/alipay/alipayapi.php" method="post">
            <input type="hidden" size="30" name="WIDout_trade_no" value="$number" />
            <input type="hidden" size="30" name="WIDsubject" value="采购笔记本电脑" />
            <input type="hidden" size="30" name="WIDtotal_fee" value="$totalprice" />
            <input type="hidden" size="30" name="WIDbody" />
            <input type="hidden" size="30" name="WIDshow_url" />
        </form>
        <script type="text/javascript">
            document.getElementsByTagName('form')[0].submit();
        </script>
eof;
        echo $fm;
        
        }else{
            $user_name = session('user_name');
            //判断用户是否登录系统
            if(empty($user_name)){
                //为了使得用户登录完毕再跳转回来
                //把回跳地址通过session给定义起来
                session('back_url',"Shop/flow2");

                //跳转到登录页面去
                $this -> redirect('User/login');
            }

            /************获取购物车商品信息start*************/
            //获取购物车数据
            $cart = new \Tools\Cart();
            $cartinfo = $cart -> getCartInfo();

            //获得购物车商品图片信息
            $goods_ids = implode(',',array_keys($cartinfo));//string(8) "26,24,25"
            $logoinfo = M('Goods')
                ->field('goods_id,goods_small_logo')
                ->select($goods_ids);
            //把$logoinfo 的图片信息 整合到 $cartinfo里边去
            foreach($cartinfo as $k => $v){
                foreach($logoinfo as $kk => $vv){
                    if($k == $vv['goods_id']){
                        $cartinfo[$k]['logo'] = $vv['goods_small_logo'];
                    }
                }
            }
            $this -> assign('cartinfo',$cartinfo);
            //获得购物车"总金额"并传递
            $numberprice = $cart -> getNumberPrice();
            $this -> assign('numberprice',$numberprice);
            /************获取购物车商品信息end*************/

            $this -> display();
        }

    
    }
}