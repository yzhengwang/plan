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

class Wechat_test{
    public function traceHttp()
    {
        $content = date('Y-m-d H:i:s')."\nREMOTE_ADDR:".$_SERVER["REMOTE_ADDR"]."\nQUERY_STRING:".$_SERVER["QUERY_STRING"]."\n\n";

        if (isset($_SERVER['HTTP_APPNAME'])){   //SAE
            sae_set_display_errors(false);
            sae_debug(trim($content));
            sae_set_display_errors(true);
        }else {
            $max_size = 100000;
            $log_filename = "log.xml";
            if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
            file_put_contents($log_filename, $content, FILE_APPEND);
        }
    }
}