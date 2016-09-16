<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<script type="text/javascript" src="<?php echo C('JS_URL');?>jquery-1.8.3.min.js"></script>
<style type="text/css">
<!--
body { 
    margin-left: 3px;
    margin-top: 0px;
    margin-right: 3px;
    margin-bottom: 0px;
}
.STYLE1 {
    color: #e1e2e3;
    font-size: 12px;
}
.STYLE6 {color: #000000; font-size: 12; }
.STYLE10 {color: #000000; font-size: 12px; }
.STYLE19 {
    color: #344b50;
    font-size: 12px;
}
.STYLE21 {
    font-size: 12px;
    color: #3b6375;
}
.STYLE22 {
    font-size: 12px;
    color: #295568;
}
a:link{
    color:#e1e2e3; text-decoration:none;
}
a:visited{
    color:#e1e2e3; text-decoration:none;
}
-->
</style>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="24" bgcolor="#353c44"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="6%" height="19" valign="bottom"><div align="center"><img src="<?php echo C('AD_IMG_URL');?>tb.gif" width="14" height="14" /></div></td>
                <td width="94%" valign="bottom"><span class="STYLE1"> <?php echo ($daohang["first"]); ?> -> <?php echo ($daohang["second"]); ?></span></td>
              </tr>
            </table></td>
            <td><div align="right"><span class="STYLE1">
              <a href="<?php echo ($daohang["act_url"]); ?>" target="_self"><img src="<?php echo C('AD_IMG_URL');?>add.gif" width="10" height="10" /> <?php echo ($daohang["act"]); ?></a>   &nbsp; 
              </span>
              <span class="STYLE1"> &nbsp;</span></div></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
<!--“代表”当前访问的具体模板页面内容-->

<script type="text/javascript" src="<?php echo C('PLUGIN');?>ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="<?php echo C('PLUGIN');?>ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" src="<?php echo C('PLUGIN');?>ueditor/lang/zh-cn/zh-cn.js"></script>



  <tr>
    <td colspan='100'>
      <style type="text/css">
      #tabbar-div {
          background: none repeat scroll 0 0 #80BDCB;
          height: 22px; font-size: 12px;
          padding-left: 10px; margin-bottom:3px;
          padding-top: 1px;
      }
      #tabbar-div p {margin: 2px 0 0; }
      .tab-front {
          background: none repeat scroll 0 0 #BBDDE5;
          border-right: 2px solid #278296;
          cursor: pointer;
          font-weight: bold;
          line-height: 20px;
          padding: 4px 15px 4px 18px;
      }
      .tab-back {
          border-right: 1px solid #FFFFFF;
          color: #FFFFFF;
          cursor: pointer;
          line-height: 20px;
          padding: 4px 15px 4px 18px;
      }
      </style>
      <div id="tabbar-div">
          <p>
          <span id="general-tab" class="tab-front">通用信息</span>
          <span id="detail-tab" class="tab-back">详细描述</span>
          <span id="mix-tab" class="tab-back">其他信息</span>
          <span id="properties-tab" class="tab-back">商品属性</span>
          <span id="gallery-tab" class="tab-back">商品相册</span>
          <span id="linkgoods-tab" class="tab-back">关联商品</span>
          <span id="groupgoods-tab" class="tab-back">配件</span>
          <span id="article-tab" class="tab-back">关联文章</span>
          </p>
      </div>
<script type="text/javascript">
//页面加载好给上边几个标签设置点击事件
$(function(){
  $('#tabbar-div span').click(function(){
    //1)标签切换
    $('#tabbar-div span').attr('class','tab-back');//全部的都变暗
    $(this).attr('class','tab-front');//当前点击的高亮
    

    //2)标签对应内容切换
    //$("[属性名称=属性值]")  jquery属性选择器的使用
    $('table[id$=-show]').hide();//全部内容隐藏,是table表格并且id属性值以-show"结尾"
    
    var idflag = $(this).attr('id');//获得被点击标签的id属性值
    $('#'+idflag+'-show').show();//当前被点击标签对应内容显示
  });
});
</script>

      </td>
  </tr>
  <tr>
    <td>
    <form action="/index.php/Admin/Goods/upd/goods_id/28.html" method="post" enctype="multipart/form-data">
    <input type="hidden" name="goods_id" value="<?php echo ($info["goods_id"]); ?>" />

    <table id="general-tab-show" width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce">
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">商品名称：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
        <input type="text" name="goods_name" value="<?php echo ($info["goods_name"]); ?>" />
        </div></td>
      </tr>
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">价格：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left"><input type="text" name="goods_price"  value="<?php echo ($info["goods_price"]); ?>"/></div></td>
      </tr>
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">数量：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left"><input type="text" name="goods_number" value="<?php echo ($info["goods_number"]); ?>" /></div></td>
      </tr>
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">重量：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left"><input type="text" name="goods_weight" value="<?php echo ($info["goods_weight"]); ?>" /></div></td>
      </tr>
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">logo图片：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
        <input type="file" name="goods_logo" />
        <img src="<?php echo C('SITE_URL'); echo (substr($info["goods_small_logo"],2)); ?>" alt="没有logo" width='100' height='100' />
        </div></td>
      </tr>
    </table>
    <table id="detail-tab-show" width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" style="display:none;">
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">详情描述：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
        <textarea rows="5" cols="30" id="goods_introduce" name="goods_introduce" 
          style="width:610px;height:260px;"
        > <?php echo ($info["goods_introduce"]); ?></textarea>
        </div></td>
      </tr>
    </table>
    <table id="mix-tab-show" width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" style="display:none;">
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">其他信息：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"></td>
      </tr>
    </table>
    <table id="properties-tab-show" width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" style="display:none;">
      <tr>
        <td width="40%" height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19" style='font-weight:bold;'>商品类型：</span></div></td>
        <td width="*" height="20" bgcolor="#FFFFFF" class="STYLE19">
          <div align="left"><span class="STYLE19">
          <select id="type_id" name="type_id" onchange="goods_attr_info2()">
            <option value='0'>-请选择-</option>
            <?php if(is_array($typeinfo)): foreach($typeinfo as $key=>$v): if(($info["type_id"]) == $v["type_id"]): ?><option value="<?php echo ($v["type_id"]); ?>" selected='selected'>
              <?php else: ?>
              <option value="<?php echo ($v["type_id"]); ?>"><?php endif; ?>
              <?php echo ($v["type_name"]); ?></option><?php endforeach; endif; ?>
          </select>
          </span></div>
        </td>
      </tr>
    </table>
    <script type="text/javascript">
//多选属性点击[+]可以增加项目
function add_attr(obj){
  //通过obj找到对应的tr并复制
  var futr = $(obj).parent().parent().parent().clone();

  //把futr里边的[+] 变为 [-]
  futr.find('span').remove();  //删除[+]
  futr.find('font').before('<span onclick="$(this).parent().parent().parent().remove()">[-]</span>');//增加[-]

  //把futr追加给当前tr，兄弟关系追加
  $(obj).parent().parent().parent().after(futr);

}

    //页面加载完毕，就自动调用goods_attr_info2,使得类型展示对应属性
    $(function(){
      goods_attr_info2();
    });



    //根据类型展示属性信息
    function goods_attr_info2(){
      var type_id = $('#type_id').val();//当前选中类型

      var goods_id = $('[name=goods_id]').val(); //当前商品的id

      //走Ajax，通过type_id去服务器端获得对应的属性列表信息回来
      $.ajax({
        url:'/index.php/Admin/Goods/getAttrInfoByType2',
        data:{'type_id':type_id,'goods_id':goods_id},
        dataType:'json',
        type:'get',
        success:function(msg){
          //遍历msg，使得其中数据与tr/td标签做结合显示给页面
          var s = "";
          $.each(msg,function(n,v){
            //n代表每个单元的下标序号
            //v代表遍历出来的小的单元
            //表单域两种情况attr_sel：输入框(单选)、下拉列表(多选)
            if(v.attr_sel=='0'){
              s += '<tr><td height="20" bgcolor="#FFFFFF" class="STYLE6 STYLE19"><div align="right">'+v.attr_name+'：</div></td><td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="left">';


              if(typeof v.attr_values=='undefined'){
                s += "<input type='text' name='goods_attr_id["+v.attr_id+"][]' />";
              }else{
                s += "<input type='text' name='goods_attr_id["+v.attr_id+"][]' value='"+v.attr_values+"'/>";
              }
              s += "</div></td>";
              s += "</tr>";
            }else{
              if(typeof v.attr_values=='undefined'){

                //展示【空壳】多选属性
                s += '<tr><td height="20" bgcolor="#FFFFFF" class="STYLE6 STYLE19"><div align="right"><span onclick="add_attr(this)">[+]</span><font>'+v.attr_name+'</font>：</div></td><td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="left">';
                //获得可选取的信息值attr_vals，显示给下拉列表
                //v.attr_vals  白色,红色,绿色,蓝色
                var showvals = v.attr_vals.split(','); //把String变为Array

                s += "<select name='goods_attr_id["+v.attr_id+"][]'><option value='0'>-请选择-</option>";
                for(var i=0; i<showvals.length; i++){
                  s += '<option value="'+showvals[i]+'">'+showvals[i]+'</option>';
                }
                s += '</select>';
                s += "</div></td>";
                s += "</tr>";
              }else{
                //展示【实体】多选属性
                //把实体属性值通过","拆分为一个array出俩
                //attr_values = "白色,绿色";
                var arr_values = v.attr_values.split(',');  //['白色','绿色']
                for(var m=0; m<arr_values.length; m++){
                  s += '<tr><td height="20" bgcolor="#FFFFFF" class="STYLE6 STYLE19"><div align="right">';
                  if(m===0){
                    s += '<span onclick="add_attr(this)">[+]</span>';
                  }else{
                    s += '<span onclick="$(this).parent().parent().parent().remove()">[-]</span>';
                  }
                  s += '<font>'+v.attr_name+'</font>：</div></td><td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="left">';
                  //获得可选取的信息值attr_vals，显示给下拉列表
                  //v.attr_vals  白色,红色,绿色,蓝色
                  var showvals = v.attr_vals.split(','); //把String变为Array

                  s += "<select name='goods_attr_id["+v.attr_id+"][]'><option value='0'>-请选择-</option>";
                  for(var i=0; i<showvals.length; i++){
                    if(arr_values[m]==showvals[i]){
                      s += '<option value="'+showvals[i]+'" selected="selected">'+showvals[i]+'</option>';
                    }else{
                      s += '<option value="'+showvals[i]+'">'+showvals[i]+'</option>';
                    }
                  }
                  s += '</select>';
                  s += "</div></td>";
                  s += "</tr>";
                }
              }
            }

          });
          //清除之前的属性
          $('#properties-tab-show tr:gt(0)').remove();
          //把s追加给页面
          $('#properties-tab-show').append(s);
        }
      });
    }

    //增加相册项目
    function add_pics_item(spanobj){
      //$(dom对象)：dom对象变为jquery对象
      //$()[0]: jquery对象变dom对象
      var picstr = $(spanobj).parent().parent().parent();
      var futr = picstr.clone();

      var sp = "<span class='STYLE19' onclick='$(this).parent().parent().parent().remove()'>[-]商品相册：</span>";
      //从futr中把[+]号span给删除
      futr.find('span').remove();
      //再给futr追加一个[-]号span
      futr.find('div').append(sp);

      $('#gallery-tab-show')[0].appendChild(futr[0]);
    }


    //删除单个相册图片
    function del_pics(pics_id){
      //ajax去服务器删除物理的相册图片
      $.ajax({
        url:"<?php echo U('delPics');?>",
        data:{'pics_id':pics_id},
        dataType:'html',
        type:'get',
        success:function(msg){
          //通过dom方式删除页面的相册
          $('#pics_show_'+pics_id).remove();
        }
      });
    }
    </script>
    <table id="gallery-tab-show" width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" style="display:none;">
      <tr>
        <td colspan='100'>
          <ul>
          <!--显示商品对应的相册图片-->
          <?php if(is_array($picsinfo)): foreach($picsinfo as $key=>$pc): ?><li style='list-style:none;float:left;' id='pics_show_<?php echo ($pc["pics_id"]); ?>'><img src="<?php echo C('SITE_URL'); echo (substr($pc["pics_mid"],2)); ?>" alt=""
             width="160"/><span style='color:red;' 
             onclick="if(confirm('确认要真删除该相册？')){del_pics(<?php echo ($pc["pics_id"]); ?>)}">[-]</span></li><?php endforeach; endif; ?>
          </ul>
        </td>
      </tr>
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6" width="30%">
        <div align="right"><span class="STYLE19" onclick="add_pics_item(this)">[+]商品相册：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19">
          <input type="file" name="goods_pics[]" />
        </td>
      </tr>
    </table>
    <table id="linkgoods-tab-show" width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" style="display:none;">
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">关联商品：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"></td>
      </tr>
    </table>
    <table id="groupgoods-tab-show" width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" style="display:none;">
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">配件：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"></td>
      </tr>
    </table>
    <table id="article-tab-show" width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" style="display:none;">
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">关联文章：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"></td>
      </tr>
    </table>
    
    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" >
      <tr>
        <td height="20" colspan='2' bgcolor="#FFFFFF" class="STYLE6">
        <div align="center">
          <input type="submit" value="修改" />
        </div>
        </td>
      </tr>
    </table>
    </form>
    </td>
  </tr>

<script type="text/javascript">
var ue = UE.getEditor('goods_introduce',{toolbars: [[
            'fullscreen', 'source', '|', 'undo', 'redo', '|',
            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
            'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
            'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
            'directionalityltr', 'directionalityrtl', 'indent', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
            'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
            'simpleupload', 'insertimage', 'emotion'
        ]]});
</script>

</table>
</body>
</html>