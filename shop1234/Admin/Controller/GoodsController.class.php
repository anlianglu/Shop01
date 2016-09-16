<?php
namespace Admin\Controller;
use Tools\AdminController;

//空间类元素引入
//use Model\GoodsModel;

class GoodsController extends AdminController {
    //商品列表
    public function showlist1(){
        //使用GoodsModel
        //没有上边的use就是失败的
        //其会在当前的Admin\Controller空间下获得该类，因此找不到
        $goods = new GoodsModel();


        //完全限定名称方式获得元素
        $goods = new \Model\GoodsModel();  //成功的
        //dump($goods);

        //$goods = M('Goods');
        //dump($goods);


        $this -> display();  //调用模板
    }    

    function showlist(){
        //每个页面使用的导航信息定义
        $daohang = array(
            'first'=>'商品管理',
            'second'=>'商品列表',
            'act'=>'添加',
            'act_url'=>U('tianjia'),
        );
        $this -> assign('daohang',$daohang);

        //获得商品列表信息
        $info = M('Goods')->order('goods_id desc')->select();
        $this -> assign('info',$info);
        
        $this -> display();
    }
    //添加商品
    public function tianjia(){

        //两个逻辑：展示页面、收集数据
        if(IS_POST){

            //logo图片上传处理
            $this -> deal_logo();

            //收集商品数据入库
            //I()函数除了收集表单信息，还有防止XSS攻击效果
            $shuju = I('post.');

            //使得I()函数回避，制作一个xss攻击效果
            //$shuju = $_POST;
            //富文本编辑器信息暂时不要被编码
            $shuju['goods_introduce'] = \fangXSS($_POST['goods_introduce']);

            $shuju['add_time'] = $shuju['upd_time'] = time();
            $goods = M('Goods');
            if($newid = $goods -> add($shuju)){
                //给商品进行相册的添加
                $this -> deal_pics($newid);  //添加、处理相册
                $this -> deal_attr($newid);//商品对应“属性”的处理

                $this -> success('添加商品成功',U('showlist'),1);
            }else{
                $this -> error('添加商品失败',U('tianjia'),1);
            }
        }else{
            //每个页面使用的导航信息定义
            $daohang = array(
                'first'=>'商品管理',
                'second'=>'商品添加',
                'act'=>'返回',
                'act_url'=>U('showlist'),
            );
            $this -> assign('daohang',$daohang);

            //获取可供选取的类型列表
            $typeinfo = M('Type')->select();
            $this -> assign('typeinfo',$typeinfo);

            //展示(添加商品)页面
            $this -> display();  //调用模板
        }
    }    

    /***
        给新商品维护“属性”信息
        就是给sp_goods_attr表填充信息
    */
    private function deal_attr($goods_id){
        //删除商品旧的属性
        M('GoodsAttr')->where(array('goods_id'=>$goods_id))->delete();

        //添加信息的商品属性
        foreach($_POST['goods_attr_id'] as $k => $v){
            //$k是属性的id值信息
            foreach($v as $vv){
                if(!empty($vv)){
                    //给sp_goods_attr表填充数据
                    $arr['goods_id'] = $goods_id;
                    $arr['attr_id'] = $k;
                    $arr['attr_value'] = $vv;
                    M('GoodsAttr')->add($arr);
                }
            }
        }
    }

    /***
        给商品添加相册图片
    */
    private function deal_pics($goods_id){
        //做判断，至少需要选中一个相册，我们才给做上传处理
        $havePics = false;  //默认没有选取相册
        foreach($_FILES['goods_pics']['error'] as $v){
            if($v===0){
                $havePics = true;
                break;
            }
        }
        //判断至少选择一个相册,才做上传处理
        if($havePics === true){
            //批量上传多个图片的处理
            $up = new \Think\Upload();
            $up -> rootPath = "./Public/Pics/";

            $z = $up -> upload(array($_FILES['goods_pics']));
            //把上传好的相册图片存储给数据库
            //即给sp_goods_pics表填充数据
            //现在需要制作缩略图800*800  350*350  50*50

            //遍历$z，获得上传好的每个相册图片，给其制作缩略图
            $im = new \Think\Image();
            foreach($z as $k => $v){
                $nowpic = $up->rootPath.$v['savepath'].$v['savename'];//当前相册图片
                //给“当前相册图片”制作缩略图,一图变三个小图,先大图再小图
                $im -> open($nowpic);
                //2016-08-15/big_57b12c2d39bb3,jpg
                //2016-08-15/mid_57b12c2d39bb3,jpg
                //2016-08-15/sma_57b12c2d39bb3,jpg
                //thumb(800,800,6=严格尺寸缩放)
                $im -> thumb(800,800,6);
                $pics_b = $up->rootPath.$v['savepath']."big_".$v['savename'];
                $im -> save($pics_b);

                $im -> thumb(350,350,6);
                $pics_m = $up->rootPath.$v['savepath']."mid_".$v['savename'];
                $im -> save($pics_m);

                $im -> thumb(50,50,6);
                $pics_s = $up->rootPath.$v['savepath']."sma_".$v['savename'];
                $im -> save($pics_s);

                //把制作好的缩略图存储给sp_goods_pics表
                $info['goods_id'] = $goods_id;
                $info['pics_big'] = $pics_b;
                $info['pics_mid'] = $pics_m;
                $info['pics_sma'] = $pics_s;
                M('GoodsPics')->add($info);
            }
        }
    }

    //给商品添加logo图片处理
    private function deal_logo(){
        //判断附件有上传，并且没有问题
        //error=0   ok
        //error=1/2 附件大小超出限制
        //error=3   附件只上传一部分
        //error=4   没有上传附件
        if($_FILES['goods_logo']['error']===0){
            //修改商品的时候，如果有上传新的logo图片，就要删除之前的logo
            if(!empty($_POST['goods_id'])){//判断是"修改商品"逻辑
                //查询判断当前被修改商品是否有logo图片
                $logoinfo = M('Goods')->find($_POST['goods_id']);
                if(!empty($logoinfo['goods_big_logo'])){
                    //删除存在的logo图片
                    unlink($logoinfo['goods_big_logo']);
                }
                if(!empty($logoinfo['goods_small_logo'])){
                    unlink($logoinfo['goods_small_logo']);
                }
            }

            /**************************************/
            //1) 上传logo原图
            //使用Upload.class.php功能类，实现附件上传
            $up = new \Think\Upload();
            $up -> rootPath = "./Public/Logo/";
            //上传附件
            //uploadOne()进行附件上传，成功后会返回信息
            //① 附件在服务器上存储的名字
            //② 附件在服务器上存储的目录相关信息
            //...
            $z = $up -> uploadOne($_FILES['goods_logo']);
            //拼装图片的路径名
            //例如：./Public/Logo/2016-08-15/57b12c2d39bb3,jpg
            $bigPathName = $up->rootPath.$z['savepath'].$z['savename'];
            //把图片的路径名设置给$_POST，后续代码会给其存储到数据库
            $_POST['goods_big_logo'] = $bigPathName;

            //2) 根据logo原图再制作一个缩略图 (150*150)
            //   有现成功能类Image.class.php供使用
            $im = new \Think\Image(); //①实例化对象
            $im -> open($bigPathName); //② 打开原图
            $im -> thumb(150,150);//③制作缩略图
            //④ 存储缩略图到服务器指定位置
            //原图：./Public/Logo/2016-08-15/57b12c2d39bb3,jpg
            //缩略图：./Public/Logo/2016-08-15/small_57b12c2d39bb3,jpg
            //缩略图路径名设置
            $smallPathName = $up->rootPath.$z['savepath']."small_".$z['savename'];
            $im -> save($smallPathName);

            //把缩略图存储给数据库
            $_POST['goods_small_logo'] = $smallPathName;
            /**************************************/
        }
    }

    //修改商品
    public function upd(){
        $goods_id = I('get.goods_id');
        $goods = M('Goods');
        if(IS_POST){
            //logo图片的上传处理
            $this -> deal_logo();
            //pics相册图片上传处理
            $this -> deal_pics($goods_id);
            //收集【属性】信息入库
            $this -> deal_attr($goods_id);

            //收集数据，入库处理
            $shuju = I('post.');
            $shuju['upd_time'] = time();
            //富文本编辑器信息额外通过htmlpurifier进行过滤
            $shuju['goods_introduce'] = \fangXSS($_POST['goods_introduce']);

            if($goods->save($shuju)){
                $this -> success('修改商品成功',U('showlist'),1);
            }else{
                $this -> error('修改商品失败',U('upd',array('goods_id'=>$goods_id)),1);
            }
        }else{
            //每个页面使用的导航信息定义
            $daohang = array(
                'first'=>'商品管理',
                'second'=>'商品修改',
                'act'=>'返回',
                'act_url'=>U('showlist'),
            );
            $this -> assign('daohang',$daohang);

            //展示表单
            //获得被修改商品的基本信息
            $info = $goods->find($goods_id);//一维
            $this -> assign('info',$info);

            //获得商品相册信息
            $picsinfo = M('GoodsPics')
                ->where(array('goods_id'=>$goods_id))
                ->select();//二维
            $this -> assign('picsinfo',$picsinfo);

            //获取可供选取的类型列表
            $typeinfo = M('Type')->select();
            $this -> assign('typeinfo',$typeinfo);

            $this -> display();  //调用模板
        }
    }

    //删除单个相册图片
    function delPics(){
        $pics_id = I('get.pics_id');

        $picsinfo = M('GoodsPics')->find($pics_id);
        //删除3幅物理相册图片
        unlink($picsinfo['pics_big']);
        unlink($picsinfo['pics_mid']);
        unlink($picsinfo['pics_sma']);

        //删除相册记录
        M('GoodsPics')->delete($pics_id);
    }

    //根据类型id获得对应的属性列表信息[添加商品]
    function getAttrInfoByType(){
        $type_id = I('get.type_id');

        //获取属性列表信息
        $attrinfo = M('Attribute')
            -> where(array('type_id'=>$type_id))
            -> field('attr_id,attr_name,attr_sel,attr_vals')
            -> select();
        //$attrinfo是一个二维数组,一维是索引下标，二维是关联下标
        // array(array(id=>xx,name=>xx,sel,vals),array(id,name,sel,vals),array(...)..)
        echo json_encode($attrinfo); //  [{},{},{}...]
        //[{"attr_id":"12","attr_name":"\u4f5c\u8005","attr_sel":"0","attr_vals":""},{"attr_id":"13","attr_name":"\u51fa\u7248\u793e","attr_sel":"0","attr_vals":""},{"attr_id":"14","attr_name":"\u51fa\u7248\u65f6\u95f4","attr_sel":"0","attr_vals":""}]
    }

    //根据"类型id"、"商品id"获得对应的属性列表信息[修改商品]
    //① "空壳"属性列表信息
    //② "实体"属性列表信息
    function getAttrInfoByType2(){
        $type_id = I('get.type_id');
        $goods_id = I('get.goods_id');

        //获取【实体】属性values信息
        $attrvals = M('Attribute')
            -> alias('a')
            -> join('left join __GOODS_ATTR__ ga on a.attr_id=ga.attr_id')
            -> where(array('a.type_id'=>$type_id,'ga.goods_id'=>$goods_id))
            -> field('a.attr_id,group_concat(ga.attr_value) attr_values')
            -> group('a.attr_id')
            -> select();

        //dump($attrvals);

        //获取【空壳】属性列表信息
        $attrinfo = M('Attribute')
            -> where(array('type_id'=>$type_id))
            -> field('attr_id,attr_name,attr_sel,attr_vals')
            -> select();
        //select attr_id,attr_name,attr_sel,attr_vals from sp_attribute where type_id=1
        //dump($attrinfo);

        //把$attrinfo中的attr_id提取出来设置为一维的下标
        $newattrinfo = array();
        foreach($attrinfo as $k => $v){
            $newattrinfo[$v['attr_id']] = $v;
        }
        
        //把$newattrinfo 和 $attrvals合并到一起
        foreach($newattrinfo as $k => $v){
            foreach($attrvals as $kk => $vv){
                if($k == $vv['attr_id']){
                    $newattrinfo[$k]['attr_values'] = $vv['attr_values'];
                }
            }
        }
        echo json_encode($newattrinfo); //  [{},{},{}...]
    }
}
