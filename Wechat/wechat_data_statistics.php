<?php
// +----------------------------------------------------------------------
// | 广西西途比网络科技有限公司 www.c2b666.com
// +----------------------------------------------------------------------
// | 功能描述: 管理员管理
// +----------------------------------------------------------------------
// | 时　　间: 2017/12/7 9:48
// +----------------------------------------------------------------------
// | 代码创建: 西途比
// +----------------------------------------------------------------------
// | 版本信息: V1.0.0
// +----------------------------------------------------------------------
// | 代码修改:（修改人 - 修改时间）
// +----------------------------------------------------------------------

class wechat_data_statistics extends Wechat
{
    private $access_token;

    public function __construct($access_token) {
        $this->access_token = $access_token;
    }

    //获取用户增减数据 最大时间跨度 7
    public function getUserSummary($data) {
        $url = "https://api.weixin.qq.com/datacube/getusersummary?access_token=" . $this->access_token;
        $result = $this->https_request($url, $data);
        return $result;
    }

    //获取累计用户数据 7
    public function getUserCumulate($data) {
        $url = "https://api.weixin.qq.com/datacube/getusercumulate?access_token=" . $this->access_token;
        $result = $this->https_request($url, $data);
        return $result;
    }

    //获取图文群发每日数据 1
    public function getArticleSummary($data) {
        $url = "https://api.weixin.qq.com/datacube/getarticlesummary?access_token=" . $this->access_token;
        $result = $this->https_request($url, $data);
        return $result;
    }

    //获取图文群发总数据 1
    public function getArticleTotal($data) {
        $url = "https://api.weixin.qq.com/datacube/getarticletotal?access_token=" . $this->access_token;
        $result = $this->https_request($url, $data);
        return $result;
    }

    //获取图文统计数据 3
    public function getUserRead($data) {
        $url = "https://api.weixin.qq.com/datacube/getuserread?access_token=" . $this->access_token;
        $result = $this->https_request($url, $data);
        return $result;
    }

    //获取图文统计分时数据 1
    public function getUserReadHour($data) {
        $url = "https://api.weixin.qq.com/datacube/getuserreadhour?access_token=" . $this->access_token;
        $result = $this->https_request($url, $data);
        return $result;
    }

    //获取图文分享转发数据 7
    public function getUserShare($data) {
        $url = "https://api.weixin.qq.com/datacube/getusershare?access_token=" . $this->access_token;
        $result = $this->https_request($url, $data);
        return $result;
    }

    //获取图文分享转发分时数据 1
    public function getUserShareHour($data) {
        $url = "https://api.weixin.qq.com/datacube/getusersharehour?access_token=" . $this->access_token;
        $result = $this->https_request($url, $data);
        return $result;
    }

    //获取消息发送概况数据
    public function getUpStreamMsg($data) {
        $url = "https://api.weixin.qq.com/datacube/getupstreammsg?access_token=" . $this->access_token;
        $result = $this->https_request($url, $data);
        return $result;
    }

    //获取消息分送分时数据
    public function getUpStreamMsgHour($data) {
        $url = "https://api.weixin.qq.com/datacube/getupstreammsghour?access_token=" . $this->access_token;
        $result = $this->https_request($url, $data);
        return $result;
    }

    //获取消息发送周数据
    public function getUpStreamMsgWeek($data) {
        $url = "https://api.weixin.qq.com/datacube/getupstreammsgweek?access_token=" . $this->access_token;
        $result = $this->https_request($url, $data);
        return $result;
    }

    //获取消息发送月数据
    public function getUpStreamMsgMonth($data) {
        $url = "https://api.weixin.qq.com/datacube/getupstreammsgmonth?access_token=" . $this->access_token;
        $result = $this->https_request($url, $data);
        return $result;
    }

    //获取消息发送分布数据
    public function getUpStreamMsgDist($data) {
        $url = "https://api.weixin.qq.com/datacube/getupstreammsgdist?access_token=" . $this->access_token;
        $result = $this->https_request($url, $data);
        return $result;
    }

    //获取消息发送分布周数据
    public function getUpStreamMsgDistWeek($data) {
        $url = "https://api.weixin.qq.com/datacube/getupstreammsgdistweek?access_token=" . $this->access_token;
        $result = $this->https_request($url, $data);
        return $result;
    }

    //获取消息发送分布月数据
    public function getUpStreamMsgDistMonth($data) {
        $url = "https://api.weixin.qq.com/datacube/getupstreammsgdistmonth?access_token=" . $this->access_token;
        $result = $this->https_request($url, $data);
        return $result;
    }

    //获取接口分析数据
    public function getInterFaceSummary($data) {
        $url = "https://api.weixin.qq.com/datacube/getinterfacesummary?access_token=" . $this->access_token;
        $result = $this->https_request($url, $data);
        return $result;
    }

    //获取接口分析分时数据
    public function getInterFaceSummaryHour($data) {
        $url = "https://api.weixin.qq.com/datacube/getinterfacesummaryhour?access_token=" . $this->access_token;
        $result = $this->https_request($url, $data);
        return $result;
    }

}