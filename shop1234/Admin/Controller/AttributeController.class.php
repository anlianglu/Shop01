<?php
namespace Admin\Controller;
use Tools\AdminController;

//属性控制器
class AttributeController extends AdminController {
    //列表展示
    function showlist(){
        //每个页面使用的导航信息定义
        $daohang = array(
            'first'=>'属性管理',
            'second'=>'属性列表',
            'act'=>'添加',
            'act_url'=>U('tianjia'),
        );
        $this -> assign('daohang',$daohang);

        $info = M('Attribute')
            ->alias('a')
            ->join('__TYPE__ t on a.type_id=t.type_id')
            ->field('a.*,t.type_name')
            ->select();
        //SELECT a.*,t.type_name FROM sp_attribute a INNER JOIN sp_type t on a.type_id=t.type_id
        $this -> assign('info',$info);

        //获取可供选取的类型列表
        $typeinfo = M('Type')->select();
        $this -> assign('typeinfo',$typeinfo);


        $this -> display();
    }

    //根据类型获得属性列表信息
    function getInfoByType(){
        $type_id = I('get.type_id');

        //根据$type_id获得“属性列表”信息
        if($type_id>0){
            $attrinfo = M('Attribute')
                -> alias('a')
                -> join('__TYPE__ t on a.type_id=t.type_id')
                -> field('a.*,t.type_name')
                -> where(array('a.type_id'=>$type_id))
                -> select();
        }else{
            $attrinfo = M('Attribute')
                -> alias('a')
                -> join('__TYPE__ t on a.type_id=t.type_id')
                -> field('a.*,t.type_name')
                -> select();
        }

        //给$attrinfo做遍历，使得数据与html(tr/td)标记结合，并返回给ajax
        $s = "";
        foreach($attrinfo as $k => $v){
            $s .= '<tr> <td height="20" bgcolor="#FFFFFF"><div align="center"> <input type="checkbox" id="checkbox2" name="checkbox2"> </div></td> <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE19">'.$v['attr_id'].'</span></div></td> <td height="20" bgcolor="#FFFFFF" class="STYLE19"> <div align="left">'.$v['attr_name'].'</div></td> <td height="20" bgcolor="#FFFFFF" class="STYLE19"> <div align="left">'.$v['type_name'].'</div></td> <td height="20" bgcolor="#FFFFFF" class="STYLE19"> <div align="left">';
            $s .= $v['attr_sel']=='0'?'单选':'多选';
            $s .= '</div></td> <td height="20" bgcolor="#FFFFFF" class="STYLE19"> <div align="left">';
            $s .= $v['attr_write']=='0'?'手工录入':'从列表选取';
            $s .= '</div></td> <td height="20" bgcolor="#FFFFFF" class="STYLE19"> <div align="left">'.$v['attr_vals'].'</div></td> <td height="20" bgcolor="#FFFFFF"><div align="center" class="STYLE21"> <img width="10" height="10" src="/Public/Admin/images/del.gif"> 删除 | 查看 | <a href="/index.php/Admin/Attribute/upd.html"><img width="10" height="10" src="/Public/Admin/images/edit.gif"> 编辑</a></div></td> </tr>';
        }
        echo $s;
    }

    //添加
    function tianjia(){
        $Attribute = M('Attribute');
        if(IS_POST){
            //把“可选值”信息中的中文逗号替换为英文逗号
            $_POST['attr_vals'] = str_replace("，",",",$_POST['attr_vals']);

            $shuju = $Attribute -> create();
            if($Attribute->add($shuju)){
                $this -> success('添加属性成功',U('showlist'),1);
            }else{
                $this -> error('添加属性失败',U('tianjia'),1);
            }
        }else{
            //每个页面使用的导航信息定义
            $daohang = array(
                'first'=>'属性管理',
                'second'=>'属性添加',
                'act'=>'返回',
                'act_url'=>U('showlist'),
            );
            $this -> assign('daohang',$daohang);

            //获取可供选取的类型列表
            $typeinfo = M('Type')->select();
            $this -> assign('typeinfo',$typeinfo);

            $this -> display();
        }

    }
}
