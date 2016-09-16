<?php
return array(
	//'配置项'=>'配置值'

    //打开页面的跟踪信息
    'SHOW_PAGE_TRACE' => true,

    'SITE_URL' => 'http://www.lujiang.com/',
    //为img、css、js的访问设置配置变量
    //【前台】静态资源文件访问路径[配置]变量
    'CSS_URL'  => '/Public/Home/style/',
    'JS_URL'  => '/Public/Home/js/',
    'IMG_URL'  => '/Public/Home/images/',
    //【后台】静态资源文件访问路径[配置]变量
    'AD_CSS_URL'  => '/Public/Admin/css/',
    'AD_JS_URL'  => '/Public/Admin/js/',
    'AD_IMG_URL'  => '/Public/Admin/images/',

    //插件文件引入路径
    'PLUGIN' => '/Common/Plugin/',

    /* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'shop48',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'sp_',    // 数据库表前缀
    'DB_PARAMS'             =>  array(), // 数据库连接参数    
    'DB_DEBUG'              =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
    'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
    'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8

);
