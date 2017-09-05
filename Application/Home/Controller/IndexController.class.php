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

  public function index(){
    $model = D('User');
    //dump($model->relation(true)->select());
    if (empty($_SESSION)) {
        $this->redirect('Public/login',1,'请先登陆。。。');
    }
    dump($_SESSION);
    $this->display();
  }

  public function add(){
    
    //$model = D('User');
    if (IS_POST) {
        echo $_POST['morning'];

    }
  }


  /*  //输入模板
    public function _setModel(&$model){
        $model = D('content');
    }

    //读写操作
    public function _setWriteModel(&$model){
        $model = D('content');
    }

    //删除操作
    public function _setDelModel(&$model){
        $model = D('content');
    }*/

   /* public function addPlan(){
        $result = $this->add();
        if($result){
            $this->ajaxResult(200,'添加成功',$result);
        }else{
            $this->ajaxResult(300,'添加失败');
        }
    }*/



}
