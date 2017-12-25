<?php

// +----------------------------------------------------------------------
// | To say and To do and It will change yzhengwang.github.io
// +----------------------------------------------------------------------
// | 功能描述: xxxxx
// +----------------------------------------------------------------------
// | 时　　间: 2017 2017/12/25 15:21 
// +----------------------------------------------------------------------
// | 代码创建: 姚政旺 <1402205524@qq.com>
// +----------------------------------------------------------------------
// | 版本信息: V1.0.0
// +----------------------------------------------------------------------
// | 代码修改:（修改人 - 修改时间）
// +----------------------------------------------------------------------

namespace Admin\Controller;

use \Think\Controller;

class ArticleEditController extends Controller
{
    public function index() {
        $model = D('ArticleRead');
        $list = $model->select();
        foreach ($list as $k => $v) {
            if (mb_strlen($v['content'], 'utf8') > 100) {
                $list[$k]['content'] = mb_substr($v['content'], 0, 100, 'utf8').'...';
            }
        }
        $this->assign('list', $list);
        $this->display();
    }
    
    public function edit(){
        $model = D('ArticleRead');
        if (IS_POST) {
            if ($model->create()) {
                if ($model->save()) {
                    $this->ajaxResult(200, '更新成功');
                } else {
                    $this->ajaxResult(300, '更新失败');
                }
            } else {
                $this->ajaxResult(300, $model->getError());
            }
        } else {
            $list = $model->getById(I('id'));
            $this->assign("list", $list);
            $this->display();
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
