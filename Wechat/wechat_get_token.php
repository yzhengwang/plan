<?php
// +----------------------------------------------------------------------
// | 广西西途比网络科技有限公司 www.c2b666.com
// +----------------------------------------------------------------------
// | 功能描述: 获取token
// +----------------------------------------------------------------------
// | 时　　间: 2017/12/6 19:08
// +----------------------------------------------------------------------
// | 代码创建: yzw
// +----------------------------------------------------------------------
// | 版本信息: V1.0.0
// +----------------------------------------------------------------------
// | 代码修改:（修改人 - 修改时间）
// +----------------------------------------------------------------------


class Wechat_get_token extends Wechat
{

    private $_appid;
    private $_appsecret;

    public function __construct($appid, $appsecret) {
        $this->_appid = $appid;
        $this->_appsecret = $appsecret;
    }

    public function getToken($token_file = 'access_token') {
        // 考虑过期问题，将获取的access_token存储到某个文件中
        $life_time = 7200;
        if (file_exists($token_file) && time() - filemtime($token_file) < $life_time) {
            // 存在有效的access_token
            return file_get_contents($token_file);
        }
        // 目标URL：
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->_appid}&secret={$this->_appsecret}";
        //向该URL，发送GET请求
        $result = $this->https_request($url);
        if (!$result) {
            return false;
        }
        // 存在返回响应结果
        $result = json_decode($result, true);
        // 写入
        file_put_contents($token_file, $result["access_token"]);
        return $result["access_token"];
    }

}
