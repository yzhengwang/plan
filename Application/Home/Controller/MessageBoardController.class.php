<?php

// +----------------------------------------------------------------------
// | To say and To do and It will change yzhengwang.github.io
// +----------------------------------------------------------------------
// | 功能描述: xxxxx
// +----------------------------------------------------------------------
// | 时　　间: 2017 2017/9/7 14:39 
// +----------------------------------------------------------------------
// | 代码创建: 姚政旺 <1402205524@qq.com>
// +----------------------------------------------------------------------
// | 版本信息: V1.0.0
// +----------------------------------------------------------------------
// | 代码修改:（修改人 - 修改时间）
// +----------------------------------------------------------------------

namespace Home\Controller;
use Think\Controller;

class MessageBoardController extends Controller{
    public function index(){
        $model = M('message_board');
        $count = $model->count();
        $page = new \Think\Page($count, 10);
        $show = $page->show();
        $result = $model->limit($page->firstRow.','.$page->listRows)->select();
        foreach ($result as $k => $v){
            $result[$k]['create_time'] = date('Y-m-d H:i:s', $result[$k]['create_time']);
        }
        $this->assign('list', $result);
        $this->assign('page', $show);
        $this->display();
    }

    public function add(){
        if (IS_POST){
            if (!empty(I('content'))){
                $data['content'] = I('content');
                $data['create_time'] = time();
                $data['author'] = $_SESSION['name'];
                $model = M('message_board');
                $result = $model->add($data);
                if($result){
                    $this->success("添加成功！", U('index'));
                }else{
                    $this->error("添加失败！");
                }
            }
        }
    }
}