<?php

// +----------------------------------------------------------------------
// | To say and To do and It will change yzhengwang.github.io
// +----------------------------------------------------------------------
// | 功能描述: xxxxx
// +----------------------------------------------------------------------
// | 时　　间: 2017 2017/12/25 14:56 
// +----------------------------------------------------------------------
// | 代码创建: 姚政旺 <1402205524@qq.com>
// +----------------------------------------------------------------------
// | 版本信息: V1.0.0
// +----------------------------------------------------------------------
// | 代码修改:（修改人 - 修改时间）
// +----------------------------------------------------------------------

namespace Admin\TagLib;

use Think\Template\TagLib;

class At extends TagLib
{
    protected $tags = array(
        //编辑器
        'editor' => array('attr' => 'id,name,style,width,height,type', 'close' => 0),
        //静态显示
        'static' => array('attr' => 'title,text', 'close' => 0),
    );

    public function _editor($tag, $content) {
        $title = $tag['title'];
        $name = $tag["name"];
        $value = empty($tag["value"]) ? "" : $tag["value"];
        $tips = empty($tag["tips"]) ? "" : $tag["tips"];
        $width = empty($tag["width"]) ? "400px" : $tag['width'] . 'px';
        $height = empty($tag["height"]) ? "400px" : $tag["height"] . 'px';
        //产生随机数，设置组件ID
        $id = 'date-' . $name . rand(100, 99999);
        $value = $this->getTvar($value);
        $template = '<div class="form-group">
                          <label class="control-label"> ' . $title . ' </label>
                          <div class="control-box">
                              <textarea id="' . $id . '" name="' . $name . '" class="form-control" rows="{$row}" cols="{$size}">' . $value . '</textarea>
                              <div class="control-tips">' . $tips . '</div>
                          </div>
                      </div>
                      <script>
                          KindEditor.ready(function (K) {
                              var editor = K.create("textarea[id=\'{$id}\']", {
                                  cssPath: "/Public/kindeditor/plugins/code/prettify.css",
                                  uploadJson: "/Admin/Admin/kindUpload.html",
                                  fileManagerJson: "/Admin/Admin/fileManager.html",
                                  allowFileManager: true,
                                  width:"' . $width . '",
                                  height: "' . $height . '",
                                  resizeType: 1,
                                  items:[
                                          "source", "|", "undo", "redo", "|",  "cut", "copy", "paste",
                                          "plainpaste", "wordpaste", "|", "justifyleft", "justifycenter", "justifyright",
                                          "justifyfull", "insertorderedlist", "insertunorderedlist", "indent", "outdent", "subscript",
                                          "superscript", "clearhtml", "quickformat", "selectall", "|","preview","anchor", "/",
                                          "formatblock", "fontname", "fontsize", "|", "forecolor", "hilitecolor", "bold",
                                          "italic", "underline", "strikethrough", "lineheight", "removeformat", "|", "image", "multiimage",
                                          "flash", "media", "insertfile", "table", "hr", "emoticons", "baidumap", "pagebreak",
                                           "link", "unlink"
                                  ]
                              });
                              prettyPrint();
                          });
                       </script>';
        return $template;
    }

    public function _static($tag, $content) {
        $title = empty($tag["title"]) ? "" : $tag["title"];
        $text = empty($tag["text"]) ? "" : $tag["text"];
        $template = '<div class="form-group">
                          <label class="control-label"> %s </label>
                          <div class="control-static">
                            %s
                          </div>
                     </div>';
        $template = sprintf($template, $title, $text);
        return $template;
    }

    //获取模版标签
    private function getTvar($v) {
        //判断是否为PHP变量
        $match = preg_match('/^\$/', $v);
        if ($match) {
            //去掉$符号
            $v = preg_replace('/^\$/', '', $v);
            //判断是否为二维数组
            $flag = preg_match('/(.+?)\[(.+?)\]/is', $v, $result);
            if ($flag) {
                return $this->tpl->get($result[1])[trim($result[2], "'")];
            } else {
                return $this->tpl->get($v);
            }
        }
        return $v;
    }

}