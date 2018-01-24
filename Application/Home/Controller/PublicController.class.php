<?php

namespace Home\Controller;

use Think\Controller;

/**
 *
 */
class PublicController extends Controller
{
    public function login() {
        if (IS_POST) {
            $name = I('name');
            $pwd = md5(I('pwd'));
            $model = M('user');
            $result = $model->where(array('name' => $name, 'pwd' => $pwd))->find();
            if ($result) {
                session_start();
                session('id', $result['id']);
                session('name', $name);
                session('real_name', $result['real_name']);
                $this->redirect('Home/Index/index');
            } else {
                $this->error('您输入的用户名或密码错误！');
            }
        }
        $this->display();
    }

    public function register() {
        if (IS_POST) {
            if (!empty(I('name')) && !empty(I('pwd') && I('rcode') == '0928')) {
                $data['name'] = I('name');
                $data['pwd'] = md5(I('pwd'));
                $data['face'] = I('face');
                $model = M('user');
                $result = $model->add($data);
                if ($result) {
                    session_start();
                    session('id', $result['id']);
                    session('name', $data['name']);
//				    $this->success('注册成功！','login', 3);
                    $this->redirect('Home/Index/index');
                } else {
                    $this->error('您填写的信息有误，请重新填写！');
                }
            } else {
                $this->error('您填写的信息有误，请重新填写！');
            }
        }
        $this->display();
    }

    public function logout() {
        session_destroy();
        if (isset($_SESSION['name'])) {
            session_unset($_SESSION['name']);
            if (isset($_SESSION['id'])) {
                session_unset($_SESSION['id']);
                $this->redirect('login');
            }
        }

    }

    public function getName() {
        if (IS_POST) {
            $name = I('name');
            $model = M('user');
            $result = $model->where(array('name' => $name))->find();
            if ($result) {
                $this->ajaxReturn('true');
            } else {
                $this->ajaxReturn('error');
            }
        }
    }

    public function getPwd() {
        if (IS_POST) {
            $name = I('name');
            $pwd = md5(I('pwd'));
            $model = M('user');
            $result = $model->where(array('name' => $name, 'pwd' => $pwd))->find();
            if ($result) {
                $this->ajaxReturn('true');
            } else {
                $this->ajaxReturn('error');
            }
        }
    }
}

?>