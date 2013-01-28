<?php
return array(
	//'配置项'=>'配置值'
	'SITE_TITLE'      => '时晞博客',
	'URL_MODE'        => 1,
	'URL_ROUTER_ON'   => true, //开启路由
	'URL_ROUTE_RULES' => array( //定义路由规则
	    'login'=>'Admin/login',
	),
	// 数据库配置信息
	'DB_TYPE'   => 'mysql', // 数据库类型
	'DB_HOST'   => '127.11.14.129', // 服务器地址
	'DB_NAME'   => 'tp', // 数据库名
	'DB_USER'   => 'admin', // 用户名
	'DB_PWD'    => 'PTKb77tT-gZC', // 密码
	'DB_PORT'   => 3306, // 端口
	'DB_PREFIX' => 'sx_', // 数据库表前缀
	'ARTICLE_DB_NAME'      => 'article',//文章数据表名
	'URL_CASE_INSENSITIVE' => true,//URL路由忽略大小写
	'SHOW_PAGE_TRACE'      => true,//显示TRACE
	'DEFAULT_MODULE'       => 'Admin',//默认Module
	'ADMIN_USER'=>'shixi',
	'ADMIN_PWD'=>'a00000',
	'ADMIN_KEY'=>'afiudndaxadubsc2749749cdklncdsfudsf93790ejbdjaausidhiuascb',
);
?>