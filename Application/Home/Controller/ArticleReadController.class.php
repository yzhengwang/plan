<?php


// +----------------------------------------------------------------------
// | To say and To do and It will change yzhengwang.github.io
// +----------------------------------------------------------------------
// | 功能描述: xxxxx
// +----------------------------------------------------------------------
// | 时　　间: 2017 2017/8/26 15:46 
// +----------------------------------------------------------------------
// | 代码创建: 姚政旺 <1402205524@qq.com>
// +----------------------------------------------------------------------
// | 版本信息: V1.0.0
// +----------------------------------------------------------------------
// | 代码修改:（修改人 - 修改时间）
// +----------------------------------------------------------------------


namespace Home\Controller;

use Think\Controller;

class ArticleReadController extends Controller
{

    public function index() {
        $model = D('ArticleRead');
        $list = $model->getById($_SESSION['id']);
        $this->assign('list', $list);
        $this->display();
    }

    public function add(){
        $model = D('ArticleRead');
        $data['uid'] = $_SESSION['id'];
        $data['title'] = I('title');
        $data['content'] = I('content');
        $data['thumb'] = I('thumb');
        $data['create_time'] = time();
        $result = $model->add($data);
        if($result){

        }

    }


}