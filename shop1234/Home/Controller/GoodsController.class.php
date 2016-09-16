<?php
namespace Home\Controller;
use Think\Controller;
class GoodsController extends Controller {
    //商品列表展示页
    public function showlist(){
        //获得商品列表信息
        $info = M('Goods')
            ->order('goods_id desc')
            ->field('goods_id,goods_name,goods_price,goods_small_logo')
            ->select();
        $this -> assign('info',$info);

        $this -> display();  //调用模板
    }
    
    //商品详情页面
    public function detail(){
        $goods_id = I('get.goods_id');

        //获得商品的基本信息
        $goodsinfo = M('Goods')->find($goods_id);
        $this -> assign('goodsinfo',$goodsinfo);

        //获得商品的"多选"属性信息(sp_goods_attr sp_attribute)
        $muchattr = M('GoodsAttr')
            -> alias('ga')
            -> join('__ATTRIBUTE__ a on ga.attr_id=a.attr_id')
            -> where(array('ga.goods_id'=>$goods_id,'a.attr_sel'=>'1'))
            -> field('a.attr_id,a.attr_name,group_concat(ga.attr_value) attr_values')
            -> group('a.attr_id')
            -> select();
            //SELECT a.attr_id,a.attr_name,group_concat(ga.attr_value) attr_values FROM sp_goods_attr ga INNER JOIN sp_attribute a on ga.attr_id=a.attr_id WHERE ga.goods_id = '27' AND a.attr_sel = '1' GROUP BY a.attr_id
        //dump($muchattr);
        //把$muchattr中的attr_values字符串变为array数组
        foreach($muchattr as $k => $v){
            $muchattr[$k]['values'] = explode(',',$v['attr_values']);
        }
        $this -> assign('muchattr',$muchattr);

        //获得商品的"单选"属性信息(sp_goods_attr sp_attribute)
        $singleattr = M('GoodsAttr')
            -> alias('ga')
            -> join('__ATTRIBUTE__ a on ga.attr_id=a.attr_id')
            -> where(array('ga.goods_id'=>$goods_id,'a.attr_sel'=>'0'))
            -> field('a.attr_id,a.attr_name,ga.attr_value')
            -> select();
        $this -> assign('singleattr',$singleattr);

        //获得商品相册信息
        $picsinfo = M('GoodsPics')
            ->where(array('goods_id'=>$goods_id))
            ->select();
        $this -> assign('picsinfo',$picsinfo);

        $this -> display();
    }
}
