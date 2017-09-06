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
}

 ?>