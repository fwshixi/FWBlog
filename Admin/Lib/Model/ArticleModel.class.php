<?php
class ArticleModel extends Model{
	// 定义自动验证
    protected $_validate    =   array(
        array('title','require','标题必须',1),
        array('inner','require','内容必须',1),
        );
    // 定义自动完成
    protected $_auto    =   array(
        array('time','time',3,'function'),
    );
}