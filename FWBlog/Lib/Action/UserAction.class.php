<?php
class UserAction extends Action{
	public function Index(){
		$this->display();
	}
	public function Login(){
		if ($this->isAjax()){
			$this->ajaxReturn(
				array(
				
					'message'=>$_POST['user'].',欢迎登陆',
					'status'=>1,
					'jump'=>'/',
					'title'=>"登陆成功"
				)
			);
		}
		var_dump($_POST);
	}
}