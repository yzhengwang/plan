<?php

// +----------------------------------------------------------------------
// | 广西西途比网络科技有限公司 www.c2b666.com
// +----------------------------------------------------------------------
// | 功能描述: 生成菜单
// +----------------------------------------------------------------------
// | 时　　间: 2017/12/6 19:08
// +----------------------------------------------------------------------
// | 代码创建: yzw
// +----------------------------------------------------------------------
// | 版本信息: V1.0.0
// +----------------------------------------------------------------------
// | 代码修改:（修改人 - 修改时间）
// +----------------------------------------------------------------------


class Wechat_menu_create extends Wechat
{
    public function createMenu($access_token) {
        //curl模拟POST请求
        $create_menu_url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$access_token}";
        /*$data =  '{
        "button":[
            {
                "name":"努力", 
                "type":"view", 
                "url":"https://yzhengwang.github.io/"
            },
			{
                "name":"实现",
                "type":"view", 
                "url":"https://yzhengwang.github.io/"
			},
			{
                "name":"梦想",
                "type":"view", 
                "url":"https://yzhengwang.github.io/"
            }
			]
		}';*/
        $data = '{
            "button":[
                {
                    "type":"view",
                    "name":"进入官网",
                    "url":"https:\/\/www.syd666.com"
                },
                {
                    "name":"热门活动",
                    "sub_button":[
                    {
                        "type":"view",
                        "name":"黄氏青年创业",
                        "url":"https:\/\/www.syd666.com\/Webapp\/Vote\/test?reurl=\/bss\/detail\/6"
                    }
                    ]
                },
                {
                    "name":"更多服务",
                    "sub_button":[
                    {
                        "type":"view",
                        "name":"我是导游",
                        "url":"https:\/\/www.syd666.com\/Webapp\/Iguide\/index.html"
                    },
                    {
                        "type":"view",
                        "name":"异业联盟",
                        "url":"https:\/\/www.syd666.com\/Webapp\/alliance#\/alliances\/myshop"
                    }
                    ]
                }
                ]
            }';
        $outopt = $this->_requestPost($create_menu_url, $data);
        echo $outopt;
    }

}