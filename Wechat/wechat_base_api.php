<?php

//微信公众平台基础接口PHP SDK （面向对象版）

class Wechat_base_api extends Wechat
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if($tmpStr == $signature){
            return true;
        }else{
            return false;
        }
    }

    //响应消息
    public function responseMsg() {
        //根据用户传过来的消息类型进行不同的响应
        //1、接收微信服务器POST过来的数据，XML数据包
        $postData = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");
        if (!$postData) {
            echo "error";
            exit();
        }
        $this->logger("R ".$postData);
        //2、解析XML数据包
        $object = simplexml_load_string($postData, "SimpleXMLElement", LIBXML_NOCDATA);
        //获取消息类型
        $MsgType = $object->MsgType;
        switch ($MsgType) {
            case 'event':
                //接收事件推送
                $this->receiveEvent($object);
                break;
            case 'text':
                //接收文本消息
                echo $this->receiveText($object);
                break;
            case 'image':
                //接收图片消息
                echo $this->receiveImage($object);
                break;
            case 'location':
                //接收地理位置消息
                echo $this->receiveLocation($object);
                break;
            case 'voice':
                //接收语音消息
                echo $this->receiveVoice($object);
                break;
            case 'video':
                //接收视频消息
                echo $this->receiveVideo($object);
                break;
            case  'link':
                //接收链接消息
                echo $this->receiveLink($object);
                break;
            default:
                echo $this->receiveOther($object);
                break;
        }
    }

    private function receiveOther($obj) {
        $replyXml = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[text]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						</xml>";
        $msgType = "text";
        $content = date("Y-m-d H:i:s", time());
        $resultStr = sprintf($replyXml, $obj->FromUserName, $obj->ToUserName, time(), $msgType, $content);
        return $resultStr;
    }

    //接收事件推送
    private function receiveEvent($obj) {
        switch ($obj->Event) {
            //关注事件
            case 'subscribe':
                echo $this->replyText($obj, "感谢关注!送你一句鸡汤:向前走，走过不属于自己的风景，潇洒的，不是唯美而是心情；收获的，不是沧桑而是淡定!");
                break;
            //取消关注事件
            case 'unsubscribe':
                break;
            //扫描带参数的二维码，用户已关注时，进行关注后的事件
            case 'SCAN':
                //做相关的处理
                break;
            //自定义菜单事件
            case 'CLICK':
                //
                switch ($obj->EventKey) {
                    case 'C4':
                        echo $this->replyText($obj, "...");
                        break;
                    default:
                        echo $this->replyText($obj, "...");
                        break;
                }
                break;
        }
    }

    //接收文本消息
    private function receiveText($obj) {
        //获取文本消息的内容
        $content = $obj->Content;
        //发送文本消息
        return $this->replyText($obj, $content);
    }

    //接收图片消息
    private function receiveImage($obj) {
        //获取图片消息的内容
        $imageArr = array(
            "PicUrl" => $obj->PicUrl,
            "MediaId" => $obj->MediaId
        );
        //发送图片消息
        return $this->replyImage($obj, $imageArr);
    }

    //接收地理位置消息
    private function receiveLocation($obj) {
        //获取地理位置消息的内容
        $locationArr = array(
            "Location_X" => $obj->Location_X,
            "Location_Y" => "地址位置经度：" . $obj->Location_Y,
            "Label" => $obj->Label
        );
        //回复文本消息
        return $this->replyText($obj, $locationArr);
    }

    //接收语音消息
    private function receiveVoice($obj) {
        if (isset($obj->Recognition)) {
            $recognition_content = $obj->Recognition;
            //图灵机器人api请求地址，同时带有参数
            $url = "http://www.tuling123.com/openapi/api?key=ac5653d3e6744371b6466b952373b730=" . $recognition_content;
            $tulingArr = $this->https_request($url);
            //回复文本消息
            return $this->replyText($obj, $tulingArr['text']);
        } else {
            //获取语音消息内容
            $voiceArr = array(
                "MediaId" => $obj->MediaId,
                "Format" => $obj->Format
            );
            //回复语音消息
            return $this->replyVoice($obj, $voiceArr);
        }
    }

    //接收视频消息
    private function receiveVideo($obj) {
        //获取视频消息的内容
        $videoArr = array(
            "MediaId" => $obj->MediaId
        );
        //回复视频消息
        return $this->replyVideo($obj, $videoArr);
    }

    //接收链接消息
    private function receiveLink($obj) {
        //接收链接消息的内容
        $linkArr = array(
            "Title" => $obj->Title,
            "Description" => $obj->Description,
            "Url" => $obj->Url
        );
        //回复文本消息
        return $this->replyText($obj, "你发过来的链接地址是{$linkArr['Url']}");
    }

    //发送文本消息
    private function replyText($obj, $content) {
        $replyXml = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[text]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						</xml>";
        //返回一个进行xml数据包
        $resultStr = sprintf($replyXml, $obj->FromUserName, $obj->ToUserName, time(), $content);
        return $resultStr;
    }

    //发送图片消息
    private function replyImage($obj, $imageArr) {
        $replyXml = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[image]]></MsgType>
						<Image>
						<MediaId><![CDATA[%s]]></MediaId>
						</Image>
						</xml>";
        //返回一个进行xml数据包
        $resultStr = sprintf($replyXml, $obj->FromUserName, $obj->ToUserName, time(), $imageArr['MediaId']);
        return $resultStr;
    }

    //回复语音消息
    private function replyVoice($obj, $voiceArr) {
        $replyXml = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[voice]]></MsgType>
						<Voice>
						<MediaId><![CDATA[%s]]></MediaId>
						</Voice>
						</xml>";
        //返回一个进行xml数据包
        $resultStr = sprintf($replyXml, $obj->FromUserName, $obj->ToUserName, time(), $voiceArr['MediaId']);
        return $resultStr;
    }

    //回复视频消息
    private function replyVideo($obj, $videoArr) {
        $replyXml = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[video]]></MsgType>
						<Video>
						<MediaId><![CDATA[%s]]></MediaId>
						</Video> 
						</xml>";
        //返回一个进行xml数据包
        $resultStr = sprintf($replyXml, $obj->FromUserName, $obj->ToUserName, time(), $videoArr['MediaId']);
        return $resultStr;
    }

    //回复音乐消息
    private function replyMusic($obj, $musicArr) {
        $replyXml = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[music]]></MsgType>
						<Music>
						<Title><![CDATA[%s]]></Title>
						<Description><![CDATA[%s]]></Description>
						<MusicUrl><![CDATA[%s]]></MusicUrl>
						<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
						<ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
						</Music>
						</xml>";
        //返回一个进行xml数据包
        $resultStr = sprintf($replyXml, $obj->FromUserName, $obj->ToUserName, time(), $musicArr['Title'], $musicArr['Description'], $musicArr['MusicUrl'], $musicArr['HQMusicUrl'], $musicArr['ThumbMediaId']);
        return $resultStr;
    }

    //回复图文消息
    private function replyNews($obj, $newsArr) {
        $itemStr = "";
        if (is_array($newsArr)) {
            foreach ($newsArr as $item) {
                $itemXml = "<item>
						<Title><![CDATA[%s]]></Title> 
						<Description><![CDATA[%s]]></Description>
						<PicUrl><![CDATA[%s]]></PicUrl>
						<Url><![CDATA[%s]]></Url>
						</item>";
                $itemStr .= sprintf($itemXml, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
            }
        }
        $replyXml = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[news]]></MsgType>
						<ArticleCount>%s</ArticleCount>
						<Articles>
							{$itemStr}
						</Articles>
						</xml> ";
        //返回一个进行xml数据包
        $resultStr = sprintf($replyXml, $obj->FromUserName, $obj->ToUserName, time(), count($newsArr));
        return $resultStr;
    }

    //日志记录
    private function logger($log_content)
    {
        if(isset($_SERVER['HTTP_APPNAME'])){   //SAE
            sae_set_display_errors(false);
            sae_debug($log_content);
            sae_set_display_errors(true);
        }else if($_SERVER['REMOTE_ADDR'] != "127.0.0.1"){ //LOCAL
            $max_size = 500000;
            $log_filename = "log.xml";
            if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
            file_put_contents($log_filename, date('Y-m-d H:i:s').$log_content."\r\n", FILE_APPEND);
        }
    }
}