<?php
class BlogAction extends Action{
	private $model;//数据库模型

	public function index(){
		$this->initModel();
		$this->article=
			$this
				->model
				->field('`aid`,`title`,LEFT(`inner` COLLATE utf8_general_ci, 300) AS `inner`,`time`')
				->order('`aid` DESC')
				->limit(5)
				->select();
		$this->display();
		return ;
	}
	public function read(){
		$this->initModel();
		$this->article=
			$this
			->model
			->where('aid='.intval($_GET['aid']))
			->find();
		$this->display();
	}
	public function archive(){
		$this->initModel();
		$this->page=isset($_GET['page'])?intval($_GET['page']):1;
		$this->page<1 && $this->page=1;
		$limit_a=($this->page-1)*20;
		$this->article=
			$this
				->model
				->field('`aid`,`title`,LEFT(`inner` COLLATE utf8_general_ci, 300) AS `inner`,`time`')
				->order('`aid` DESC')
				->limit($limit_a.',20')
				->select();
		$this->display();
	}
	/**
	 * 页码生成函数
	 * @param int $page        当前页码
	 * @param int $allPage     总页数
	 * @param int $pageSize    显示页码个数,默认值5
	 * @param string $args     分页参数，同一页面存在多个分页时或分页条件,多个参数请直接以字符串形式传值
	 * @return string $str 样式： 首页 上一页【1】【2】【3】【4】【5】 下一页 末页
	 * @access private
	 *
	 */
	public static function pageNav($page,$allPage,$args=NULL,$before='',$pageSize=5)
	{
		$str='';//返回值初始化
		$lTags='';//左标签
		$rTags='';//右标签
		$offset=intval($pageSize/2);
		$str.='<div class="pagination">';
		$str.='<ul>';
		$str.='<li><a href="'.$before.'1'.$args.'">首页</a></li>';
		if(($page-1)>=1){
			$str.='<li><a href="'.$before.($page-1).$args.'">上一页</a></li>';
		}else{
			$str.='<li class="disabled"><a href="#">上一页</a></li>';
		}
		if($allPage>$pageSize){
			if($page>$offset && $page<$allPage-$offset){
				for($i=0;$i<$pageSize;$i++){
					if(($page+$i-$offset)<$allPage){
					   if($page+$i-$offset==$page){
						   $str.=$lTags.'<li>'.($page+$i-$offset).'</li>'.$rTags;
					   }else{
						   $str.=$lTags.'<li><a href="'.$before.($page+$i-$offset).$args.'">'.($page+$i-$offset).'</a></li>'.$rTags;
					   }			   
					}
				}
			}
			elseif($page<=$offset){
				for($i=1;$i<=$pageSize;$i++){
				   if($i==$page){
					   $str.=$lTags.'<li class="disabled"><a href="#">'.$i.'</a></li>'.$rTags;
				   }else{
					   $str.=$lTags.'<li><a href="'.$before.$i.$args.'">'.$i.'</a></li>'.$rTags;
				   }
				}
			}
			elseif($page>=$allPage-$offset){
				for($i=$pageSize-1;$i>=0;$i--){
				   if($allPage-$i==$page){
					  $str.=$lTags.'<li>'.($allPage-$i).'</li>'.$rTags;
				   }else{
					  $str.=$lTags.'<li><a href="'.$before.($allPage-$i).$args.'">'.($allPage-$i).'</a></li>'.$rTags;
				   }
				}
			}
		}else{
			for($i=1;$i<=$allPage;$i++){
			  if($i==$page){
				 $str.=$lTags.'<li class="disabled"><a href="#">'.$i.'</a></li>'.$rTags;
			  }else{
				   $str.=$lTags.'<li><a href="'.$before.$i.$args.'">'.$i.'</a></li>'.$rTags;
			  }
			}
		}
		if(($page+1)<=$allPage){
			$str.='<li><a href="'.$before.($page+1).$args.'">下一页</a></li> ';
		}else{
			$str.='<li class="disabled"><a href="#">下一页</a></li> ';
		}
			$str.='<li><a href="'.$before.$allPage.$args.'">末页</a></li>';
		$str.='</ul></div>';
		return $str;
	}
	public function about(){
		$this->display();
	}
	private function initModel(){
		if (empty($this->model)){
			$this->model= D(ucfirst(C('ARTICLE_DB_NAME')));
		}
		return TRUE;
	}
}