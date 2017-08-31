<?php

// +----------------------------------------------------------------------
// | To say and To do and It will change yzhengwang.github.io
// +----------------------------------------------------------------------
// | 功能描述: xxxxx
// +----------------------------------------------------------------------
// | 时　　间: 2017 2017/8/26 11:34 
// +----------------------------------------------------------------------
// | 代码创建: 姚政旺 <1402205524@qq.com>
// +----------------------------------------------------------------------
// | 版本信息: V1.0.0
// +----------------------------------------------------------------------
// | 代码修改:（修改人 - 修改时间）
// +----------------------------------------------------------------------


namespace Home\Controller;

use Think\Auth;
use Think\Controller;

class FatherController extends Controller{

    protected $userInfo;
    protected $MODULE;
    //是否使用关联模型
    protected $relation;

    public function _initialize() {

        $this->relation = false;

        $this->MODULE = 2;
        //检查登录状态
        if (!session('?userInfo')) {
            $this->redirect('Public/login');
        }
        //获取用户登录信息
        $this->userInfo = session('userInfo');
        if (!$this->userInfo['status']) {
            $this->error('您的帐号已被禁止', U('Public/login'));
        }
        //$this->checkStatus();
        $suModel = D('StoreUser');
        $curUserInfo = $suModel->getByUid($this->userInfo['id']);
        if (!$curUserInfo) {
            $this->error('请您先登录', U('Public/login'));
        }
        $this->userInfo['sid'] = $curUserInfo['sid'];
        $this->userInfo['is_admin'] = $curUserInfo['is_admin'];
        //验证账户权限,查询登录用户是否为该商户的超级管理员,是则放行所有权限
        if (!$this->userInfo['is_admin']) {
            $auth = new \Think\Auth();
            if (!$auth->check(MODULE_NAME . '/' . CONTROLLER_NAME . '/' . ACTION_NAME, $this->userInfo['id'])) {
                $this->display("Error/accesserror");
                exit;
            }
        }
    }


    protected function checkStatus() {
        //检查当前加盟商状态
        $storeStatus = D('Store')->where(array('id' => $this->userInfo['sid']))->getField('status');
        switch ($storeStatus) {
            //加盟商被禁止
            case -1:
                break;
            //审核中
            case 0:
                $this->redirect('Pending/index');
                break;
            default:
        }
    }

    protected function checkRule($rule, $uid) {
        static $Auth = null;
        if (!$Auth) {
            $Auth = new \Think\Auth();
        }
        return $Auth->check($rule, $uid) ? true : false;
    }

    public function index() {
        $model = D(CONTROLLER_NAME);
        if (method_exists($this, "_setModel")) {
            $this->_setModel($model);
        }
        $map = $this->_search($model);
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        $order = 'id desc';
        if (method_exists($this, '_order')) {
            $this->_order($order);
        }
        $this->lists($model, $map, $order);
        $this->display();
    }

    //构造查询条件
    public function _search($model) {
        $map = array();
        foreach ($model->getDbFields() as $key => $val) {
            if (isset($_REQUEST[$val]) && $_REQUEST[$val] != '') {
                $map[$val] = $_REQUEST[$val];
            }
        }
        return $map;
    }

    protected function lists($model, $map, $order) {
        if ($this->relation) {
            $count = $model->relation(true)->where($map)->count();
        } else {
            $count = $model->where($map)->count();
        }
        $page = new \Think\Page($count, C('PAGE_COUNT'));
        if ($count > 0) {
            $list = null;
            if ($this->relation) {
                $list = $model->relation(true)->where($map)->order($order)->limit($page->firstRow . ',' . $page->listRows)->select();
            } else {
                $list = $model->where($map)->order($order)->limit($page->firstRow . ',' . $page->listRows)->select();
            }
            //重新构建查询参数,保证分页携带查询参数
            $map = $this->_search($model);
            foreach ($map as $key => $val) {
                $page->parameter[$key] = urlencode($val);
            }
            $this->assign('list', $list);
            $show = $page->show();
            $this->assign('page', $show);
        }
        return;
    }

    public function add() {
        $this->actionName = '添加';
        $this->defaultTitle = date('Y-m-d') . ' 结算申请';
        $model = D(CONTROLLER_NAME);
        if (method_exists($this, "_setWriteModel")) {
            $this->_setWriteModel($model);
        }
        if (IS_POST) {
            if ($model->create()) {
                if ($model->add()) {
                    $this->success("新增成功", U('index'));
                } else {
                    $this->error("新增失败");
                }
            } else {
                $this->error($model->getError());
            }
        } else {
            $this->display('edit');
        }
    }

    public function edit() {
        $this->actionName = '编辑';
        $model = D(CONTROLLER_NAME);
        if (method_exists($this, "_setWriteModel")) {
            $this->_setWriteModel($model);
        }
        if (IS_POST) {
            if ($model->create()) {
                if ($model->save()) {
                    $this->success("更新成功", U('index'));
                } else {
                    $this->error("更新失败");
                }
            } else {
                $this->error($model->getError());
            }
        } else {
            $emtity = $model->getById(I($model->getPk()));
            $this->assign("entity", $emtity);
            $this->display();
        }
    }

    public function save() {
        $model = D(CONTROLLER_NAME);
        if (method_exists($this, "_setWriteModel")) {
            $this->_setWriteModel($model);
        }
        if (IS_POST) {
            if (false === $model->create()) {
                $this->error("数据对象创建失败");
            } else {
                if (isset($_REQUEST[$model->getPk()]) && !empty($_REQUEST[$model->getPk()])) {
                    if ($model->save()) {
                        $this->success("更新成功", U('index'));
                    } else {
                        $this->error("更新失败");
                    }
                } else {
                    if ($model->add()) {
                        $this->success("新增成功", U('index'));
                    } else {
                        $this->error("新增失败");
                    }
                }
            }
        } else {
            $emtity = $model->getById($_REQUEST[$model->getPk()]);
            $this->assign("entity", $emtity);
            $this->display("edit");
        }
    }

    //彻底删除记录
    public function delete() {
        $model = D(CONTROLLER_NAME);
        if (method_exists($this, "_setDelModel")) {
            $this->_setDelModel($model);
        }
        if (!empty($model)) {
            $pk = $model->getPk();
            $id = $_REQUEST [$pk];
            if (isset($id)) {
                $condition = array($pk => array('in', explode(',', $id)));
                if ($model->where($condition)->delete()) {
                    $this->success("删除成功");
                } else {
                    $this->error("删除失败");
                }
            } else {
                $this->error("未知数据");
            }
        }
    }

    protected function ajaxResult($code, $message, $list = array()) {
        $data['code'] = $code;
        $data['message'] = $message;
        $data['result'] = $list;
        $this->ajaxReturn($data, "JSON");
    }

    //文件上传
    public function upload() {
        $upload = new \Think\Upload(); // 实例化上传类
        $upload->maxSize = 3145728; // 设置附件上传大小
        $upload->autoSub = false;
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型
        $upload->rootPath = './uploads/'; // 设置附件上传根目录
        // 设置附件上传（子）目录
        $upload->savePath = MODULE_NAME .'/' . $this->userInfo['id'] . '/' . I('save') . '/';
        // 上传文件
        $info = $upload->upload();
        if (!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        } else {// 上传成功
            $data = array();
            foreach ($info as $file) {
                array_push($data, '/uploads/' . $file['savepath'] . $file['savename']);
            }
            $this->ajaxReturn(array('code' => 200, 'message' => '上传成功', 'result' => $data));
        }
    }

}