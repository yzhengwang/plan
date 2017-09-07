<?php

// +----------------------------------------------------------------------
// | XXXXXXXXXXXXXXXXXX www.xxxxx.com
// +----------------------------------------------------------------------
// | 功能描述: 首页
// +----------------------------------------------------------------------
// | 时　　间: 2017.08.26 11:00
// +----------------------------------------------------------------------
// | 代码创建: 姚政旺<1402205524@qq.com>
// +----------------------------------------------------------------------
// | 版本信息: V1.0.0
// +----------------------------------------------------------------------
// | 代码修改:（修改人 - 修改时间）
// +----------------------------------------------------------------------


namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {

  public function __construct() {
    parent::__construct();
    if (empty($_SESSION)) {
      $this->redirect('Home/Public/login');
    }
  }
  public function index(){
    $model = D('User');
    $result = $model
        ->relation(true)
        ->where(array('name'=>$_SESSION['name']))
        ->field('id,name')
        ->find();
    foreach ($result['plan_content'] as $k=>$v){
      $result['plan_content'][$k]['create_time'] = date('Y-m-d H:i:s', $result['plan_content'][$k]['create_time']);
    }
    $this->assign('info', $result);
    $this->assign('list', $result['plan_content'][sizeof($result['plan_content'])-1]);

    $this->assign('url_list', $result['url_collect']);
    $this->display();
  }

  public function addPlan(){
    $model = M('plan_content');
    if (IS_POST) {
      if($model->create()){
        $data['uid'] = $_SESSION['id'];
        $data['morning'] = I('morning');
        $data['afternoon'] = I('afternoon');
        $data['night'] = I('night');
        $data['create_time'] = time();
        if($model->add($data)){
          $this->success('添加成功！', U('index'));
        }else{
          $this->error('添加失败！');
        }
      }else{
        $this->error('读取数据失败！', $model->getError());
      }
    }
  }

  public function addCollect(){
    $model = M('url_collect');
    if (IS_POST) {
      if($model->create()){
        $data['uid'] = $_SESSION['id'];
        $data['url'] = I('url');
        $data['url_name'] = I('url_name');
        if($model->add($data)){
          $this->success('添加成功！', U('index'));
        }else{
          $this->error('添加失败！');
        }
      }else{
        $this->error('读取数据失败！', $model->getError());
      }
    }
  }

}
