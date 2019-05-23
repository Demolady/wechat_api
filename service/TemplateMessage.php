<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/23
 * Time: 15:48
 */

namespace kwy\wechat\service;


use kwy\wechat\common\Request;
use kwy\wechat\common\WechatApiUrl;

class TemplateMessage
{
    use Request;
    /**
     * @var WechatApp
     */
    private $app;

    /**
     * @param WechatApp $app
     * @param string $openid
     * @param string $form_id
     * @param string $page
     * @param string $msg_template_id
     * @param array $msg
     * @throws \Exception
     */
    public function sendMessage(WechatApp $app,string $openid,string $form_id,string $page,string $msg_template_id,array $msg){
        $this->app = $app;
        $content = $this->buildContent($msg);
        $post_data=array(
            "touser"=>$openid,
            "template_id"=>$msg_template_id,
            "page"=>$page,
            'form_id'=>$form_id,
            "data"=>$content,
        );
        #加粗放大字
        if(!empty($msg['emphasis_keyword'])){
            $emphasis_keyword = $msg['emphasis_keyword'];
            $post_data['emphasis_keyword'] = $emphasis_keyword;
            unset($post_data['data']['emphasis_keyword']);
        }

        $post_data=$this->protect_chs_array($post_data);
        $jsonStr = urldecode(json_encode($post_data));//还原中文
        $this->post_data($jsonStr);
    }

    private function buildContent($msg){
        $content=array();
        foreach ($msg as $k=>$v){
            $content[$k]=array("value"=>$v,"color"=>"#173177");
        }
        return $content;
    }

    private function post_data($data){
        $url=WechatApiUrl::APPLET_TEMPLATE_MESSAGE_SEND_URL;
        $backdata=$this->post($this->app->createApiUrl($url), $data);
        $jsonObj = json_decode($backdata,true);
        if($jsonObj['errcode']!=0){
            throw new \Exception("模板消息发送失败:errcode=".$jsonObj['errcode'].',errmsg='.$jsonObj['errmsg']);
        }
    }

    /**
     * 中文保护  json encode 保护中文，微信api不支持中文转义的json结构
     * Enter description here ...
     * @param $arr
     */
    private function protect_chs_array($arr){
        array_walk_recursive($arr, function(&$value){$value = urlencode($value);});
        return $arr;
    }
}