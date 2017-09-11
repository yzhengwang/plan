<?php

// +----------------------------------------------------------------------
// | To say and To do and It will change yzhengwang.github.io
// +----------------------------------------------------------------------
// | 功能描述: xxxxx
// +----------------------------------------------------------------------
// | 时　　间: 2017 2017/9/11 17:03 
// +----------------------------------------------------------------------
// | 代码创建: 姚政旺 <1402205524@qq.com>
// +----------------------------------------------------------------------
// | 版本信息: V1.0.0
// +----------------------------------------------------------------------
// | 代码修改:（修改人 - 修改时间）
// +----------------------------------------------------------------------

namespace Home\Controller;
use Think\Controller;

class LifeRecordController extends Controller{
    public function index(){
        $model = M('each_month');
        $data = $model->select();
        $result = $data[sizeof($data)-1];
        $model = M('each_record');
        $result['each_record'] = $model->where(array('sid'=>$result['id']))->select();
//        print_r($model->getLastSql());exit();
//        print_r($result);exit();
        $this->assign('list', $result);
        $this->display();
    }

    public function save(){
        if(IS_POST){
            if(!empty(I('each_record'))&&substr_count(I('each_record'), '-')==1){
                $each_record = I('each_record');
                $each_record = explode('-', $each_record);
                $data['content'] = $each_record[0];
                $data['output_money'] = $each_record[1];
                $data['create_time'] = time();
                $data['sid'] = I('sid');
                $model = M('each_record');
                $result = $model->add($data);
                if($result){
                    $model = M('each_month');
                    $go_money = $model->where(array('id' => $data['sid']))->getField('goutput');
                    $model->goutput = $go_money+$data['output_money'];
                    $result = $model->where(array('id' => $data['sid']))->save();
                    if(!$result){
                        $this->error('余额更新失败！');
                    }
                    $this->success('添加成功！');
                }else{
                    $this->error('添加失败！');
                }
            }else{
                $this->error('未输入内容或内容格式不正确！');
            }
        }
    }
}