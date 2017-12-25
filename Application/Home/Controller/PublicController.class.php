<?php 

namespace Home\Controller;
use Think\Controller;

/**
* 
*/
class PublicController extends Controller
{
	public function login(){
		if(IS_POST){
			$name = I('name');
			$pwd = md5(I('pwd'));
			$model = M('user');
			$result = $model->where(array('name'=>$name,'pwd'=>$pwd))->find();
			if($result){
				session_start();
				session('id',$result['id']);
				session('name',$name);
				$this->redirect('Home/Index/index');
			}
		}
		$this->display();
	}

	public function register(){
		if(IS_POST){
			$name = I('name');
			$pwd = md5(I('pwd'));
			$face = I('face');
			$model = M('user');
			$result = $model->add();
			if($result){
				session_start();
				session('id',$result['id']);
				session('name',$name);
//				$this->redirect('Home/Select/index');
			}
		}
		$this->display();
	}

	public function logout(){
		session_destroy();
		if(isset($_SESSION['name'])){
			session_unset($_SESSION['name']);
			if(isset($_SESSION['id'])){
				session_unset($_SESSION['id']);
				$this->redirect('login');
			}
		}

	}
	public function getName(){
		if(IS_POST){
			$name = I('name');
			$model = M('user');
			$result = $model->where(array('name'=>$name))->find();
			if($result) {
				$this->ajaxReturn('true');
			}else{
				$this->ajaxReturn('error');
			}
		}
	}
	public function getPwd(){
		if(IS_POST){
			$name = I('name');
			$pwd = md5(I('pwd'));
			$model = M('user');
			$result = $model->where(array('name'=>$name,'pwd'=>$pwd))->find();
			if($result) {
				$this->ajaxReturn('true');
			}else{
				$this->ajaxReturn('error');
			}
		}
	}
}

 ?>