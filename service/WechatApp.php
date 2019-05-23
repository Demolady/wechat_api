<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/23
 * Time: 14:38
 */
namespace kwy\wechat\service;
use kwy\wechat\common\WechatApiUrl;

class WechatApp
{

    private $appid;

    private $appsecret;
    /**
     * 小程序/公众号
     */
    private $type;

    private $code;

    private $access_token;

    public static function getApp($appid,$appsecret,$type='小程序',$access_token=""){
        $app = new self();
        $app->setAppid($appid);
        $app->setAppsecret($appsecret);
        $app->setType($type);
        $app->setAccessToken($access_token);
        return $app;
    }

    private function setAppid($appid){
        $this->appid = $appid;
    }

    private function setAppsecret($appsecret){
        $this->appsecret = $appsecret;
    }

    private function setType($type){
        $this->type = $type;
    }

    private function setAccessToken($access_token){
        $this->access_token = $access_token;
    }

    public function createApiUrl($url){
        if (strpos($url, 'ACCESS_TOKEN')!==false){
            $url=str_replace('ACCESS_TOKEN', $this->access_token, $url);
        }elseif(strpos($url, 'APPID') !== false){
            $url = str_replace('APPID',$this->appid,$url);
        }elseif(strpos($url, 'APPSECRET') !== false){
            $url = str_replace('APPSECRET',$this->appsecret,$url);
        }elseif(strpos($url,'CODE') !== false){
            $url = str_replace('CODE',$this->code,$url);
        }
        return $url;
    }

    /**
     * 获取openid
     * @param $code
     * @throws \Exception
     */
    public function getOpenidByCode($code){
        if(empty($this->appid)){
            throw new \Exception("请先调用getApp()");
        }
        $this->code = $code;
        if($this->type == '小程序'){
            $url = WechatApiUrl::APPLET_USER_LOGIN_URL;
        }else{
            $url = WechatApiUrl::APP_USER_LOGIN_URL;
        }
        $ret = $this->createApiUrl($url);
        return $ret;
    }

}