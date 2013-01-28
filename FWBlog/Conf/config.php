<?php
return array (
	'SITE_TITLE' => '时晞博客',
	'URL_MODE' => 1,
	'URL_ROUTER_ON' => true,
	'URL_HTML_SUFFIX'=>'html|htm',
	'URL_ROUTE_RULES' => 
	array(
	  	'Blog/:aid\\d' => 'Blog/read',
	  	'archive/:page\\d' => 'Blog/archive',
	  	'Archive' => 'Blog/archive',
	  	'Blog/read/:aid\\d' => 'Blog/read',
		'about'=>'Blog/about',
	),
	'DB_PREFIX' => 'sx_',
	'ARTICLE_DB_NAME' => 'article',
	'URL_CASE_INSENSITIVE' => true,
	'SHOW_PAGE_TRACE' => false,
	'DEFAULT_MODULE' => 'Blog',
	'DB_SQL_BUILD_CACHE' => true,
	'HTML_CACHE_ON' => true,
	'HTML_CACHE_RULES' => array(
  		'blog:Read' => array(
      		0 => '{:module}_{:action}_{$_GET.id}',
      		1 => '3600',
      	),
  		'blog:index' => array(
      		0 => '{:module}_{:action}',
      		1 => '7200',
		),
  		'blog:archive' => array(
      		0 => '{:module}_{:action}_{$_GET.page}',
      		1 => '86400',
		),
	),
	'TMPL_PARSE_STRING'=>array(
		'[code]'=>'<pre class="prettyprint linenums">',
		'[/code]'=>'</pre>',
	),
	'LOAD_EXT_CONFIG'=>'deployment,db',
);