<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/23
 * Time: 15:10
 */

namespace kwy\wechat\common;


class WechatApiUrl
{
    //自主  小程序用户获取openid
   const APPLET_USER_LOGIN_URL = 'https://api.weixin.qq.com/sns/jscode2session?appid=APPID&secret=APPSECRET&js_code=CODE&grant_type=authorization_code';

    //自主  公众号用户获取openid
   const APP_USER_LOGIN_URL ='https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=APPSECRET&code=CODE&grant_type=authorization_code';

   //自主  小程序发送模板消息
   const APPLET_TEMPLATE_MESSAGE_SEND_URL='https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=ACCESS_TOKEN';
}