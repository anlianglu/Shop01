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

  <tr>
    <td>
    <form action="/index.php/Admin/Role/distribute/role_id/50.html" method="post" enctype="multipart/form-data">
    <input type="hidden" name="role_id" value="<?php echo ($roleinfo["role_id"]); ?>" />
    <table id="general-tab-show" width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce">
      <tr>
        <td colspan='100'>当前正在给<span style='font-size:20px; color:red;'>【<?php echo ($roleinfo["role_name"]); ?>】</span>角色分配权限</td>
      </tr>
      <?php if(is_array($authInfoA)): foreach($authInfoA as $key=>$v): ?><tr>
        <td width="15%" height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="left" style="font-weight:bold;"><span class="STYLE19">
        <input type="checkbox" name="authid[]" value="<?php echo ($v["auth_id"]); ?>" 
          <?php if(in_array(($v["auth_id"]), is_array($roleinfo["role_auth_ids"])?$roleinfo["role_auth_ids"]:explode(',',$roleinfo["role_auth_ids"]))): ?>checked="checked"<?php endif; ?>
        />
        <?php echo ($v["auth_name"]); ?></span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19">
          <?php if(is_array($authInfoB)): foreach($authInfoB as $key=>$vv): if(($vv["auth_pid"]) == $v["auth_id"]): ?><div style="width:200px;float:left">
          <input type="checkbox" name="authid[]" value="<?php echo ($vv["auth_id"]); ?>" 
            <?php if(in_array(($vv["auth_id"]), is_array($roleinfo["role_auth_ids"])?$roleinfo["role_auth_ids"]:explode(',',$roleinfo["role_auth_ids"]))): ?>checked="checked"<?php endif; ?>
          />
          <?php echo ($vv["auth_name"]); ?></div><?php endif; endforeach; endif; ?>
        </td>
      </tr><?php endforeach; endif; ?>
    </table>
    
    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" >
      <tr>
        <td height="20" colspan='2' bgcolor="#FFFFFF" class="STYLE6">
        <div align="center">
          <input type="submit" value="分配权限" />
        </div>
        </td>
      </tr>
    </table>
    </form>
    </td>
  </tr>



</table>
</body>
</html>