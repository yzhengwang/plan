<?php

    require("Wechat/wechat.php");
    require("Wechat/wechat_get_token.php");
    require("Wechat/wechat_base_api.php");
    require("Wechat/wechat_menu_create.php");
    require("Wechat/wechat_send_msg.php");
    require("Wechat/wechat_test.php");
    require("Wechat/wechat_data_statistics.php");
    //    require("weather.php");

    /*   $result = Weather::getWeatherInfo('南宁');
       print_r($result);
       exit();*/

    /*    define("TOKEN", "weixin");
        define("APPID", "wx39c8a13cdd898abc");
    //    	define("APPID","wxeeb93f9b57e07efb");
        define("APPSECRET", "02a46d14ac9feb1ed8751959dc0c1ce2");
    //    	define("APPSECRET","4d1d1a4dc2497c2ba50ff38890aef68e");*/

    define("TOKEN", "weixin");
    define("APPID", "wxed8d84e7740d03c6");
    define("APPSECRET", "150ca0768a2999070b32bb28b34ca517");

    $wechat_test = new Wechat_test();
    $wechat_test->traceHttp();

    // 获取token
    $wechat_get_token = new Wechat_get_token(APPID, APPSECRET);
    $access_token = $wechat_get_token->getToken();

    // 数据统计
    $ds = new wechat_data_statistics($access_token);
    /*$date = date('Y-m-d', strtotime("-1 day"));
    var_dump($date);
    $data = array('begin_date' => $date, 'end_date' => $date);
    $data = json_encode($data);*/
    $data = '{
            "begin_date": "2017-12-15", 
            "end_date": "2017-12-15"
            }';
    $function = $_GET['functionName'];
    $result = $ds->$function($data);
    print_r(json_decode($result, true));

/*    // 生成菜单
    $wechat_menu_create = new Wechat_menu_create();
    $wechat_menu_create->createMenu($access_token);

    $wechat = new Wechat_base_api();
    if (!isset($_GET['echostr'])) {
        //调用响应消息函数
        $wechat->responseMsg();
    } else {
        //实现网址接入，调用验证消息函数
        $wechat->valid();
    }*/


?>