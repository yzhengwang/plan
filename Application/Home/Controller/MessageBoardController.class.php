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

class MessageBoardController extends Controller
{
    public function index() {
        if (IS_POST) {
            $pageCount = 5;
            $page = I('page');
            $model = M('message_board');
            $result = $model->where(array('sid' => 0))->limit($page * $pageCount, $pageCount)->order('create_time desc')->select();
            foreach ($result as $k => $v) {
                $result[$k]['create_time'] = date('Y-m-d H:i:s', $v['create_time']);
                $result[$k]['reply'] = $model->where(array('sid' => $v['id']))->order('create_time asc')->select();
                foreach ($result[$k]['reply'] as $k1 => $v1) {
                    $result[$k]['reply'][$k1]['create_time'] = date('Y-m-d H:i:s', $v1['create_time']);
                }
            }
            if ($result) {
                $this->ajaxResult(200, 'success', $result);
            } else {
                $this->ajaxResult(300, 'error');
            }
        } else {
            $this->display();
        }
    }

    public function add() {
        if (IS_POST) {
            if (!empty(I('content'))) {
                $data['content'] = I('content');
                $data['create_time'] = time();
                $data['uid'] = 1;
//                $data['uid'] = $_SESSION['id'];
                $data['sid'] = I('sid');
                $model = M('message_board');
                $result = $model->add($data);
                if ($result) {
                    $rel = $model->where(array('id' => $result))->find();
                    $this->ajaxResult(200, 'success', $rel);
                } else {
                    $this->ajaxResult(300, 'error');
                }
            } else {
                $this->ajaxResult(300, 'error');
            }
        }
    }

    protected function ajaxResult($code, $message, $list = array(), $callBack = '') {
        $data['code'] = $code;
        $data['message'] = $message;
        $data['result'] = $list;
        $data['callback'] = $callBack;
        $this->ajaxReturn($data, "JSON");
    }
}