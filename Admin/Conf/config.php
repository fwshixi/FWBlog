<?php
return array(
	//'配置项'=>'配置值'
	'SITE_TITLE'      => '时晞博客',
	'URL_MODE'        => 1,
	'URL_ROUTER_ON'   => true, //开启路由
	'URL_ROUTE_RULES' => array( //定义路由规则
	    'login'=>'Admin/login',
	),
	'DB_PREFIX' => 'sx_', // 数据库表前缀
	'ARTICLE_DB_NAME'      => 'article',//文章数据表名
	'URL_CASE_INSENSITIVE' => true,//URL路由忽略大小写
	'SHOW_PAGE_TRACE'      => true,//显示TRACE
	'DEFAULT_MODULE'       => 'Admin',//默认Module
	'ADMIN_USER'=>'shixi',
	'ADMIN_PWD'=>'a00000',
	'ADMIN_KEY'=>'afiudndaxadubsc2749749cdklncdsfudsf93790ejbdjaausidhiuascb',
	'LOAD_EXT_CONFIG'=>'deployment,db',
);
?>