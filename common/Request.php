<?php
/**
 * Created by PhpStorm.
 * User: Demolady
 * Date: 2019/5/23
 * Time: 14:32
 */
namespace kwy\wechat\common;
trait Request
{
    protected function post($url,$data){
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);//url
        curl_setopt($ch, CURLOPT_POST, 1);//post
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//返回结果curl
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );//强制ipv4解析
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);      //忽略校验证书
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);

        #代理访问
        //curl_setopt($ch, CURLOPT_PROXY, "127.0.0.1"); //代理服务器地址
        //curl_setopt($ch, CURLOPT_PROXYPORT,'8888'); //代理服务器端口
        //curl_setopt($ch, CURLINFO_HEADER_OUT, true); //TRUE 时追踪句柄的请求字符串，从 PHP 5.1.3 开始可用。这个很关键，就是允许你查看请求header


        $ret = curl_exec($ch);
        $log_path='api.log';
        $log=date('Y-m-d H:i:s').' API_URL:'.$url."\n API_PARAMS: ".(is_string($data)?$data:json_encode($data))."\nAPI_RETURN: ".(($ret===false)?curl_errno($ch):$ret)."\n";
        if ($ret===false){
            throw new \Exception(curl_error($ch),curl_errno($ch));
        }
        $arr_ret=json_decode($ret,true);
        return $arr_ret;
    }

    protected function get($url){
        $ch = curl_init($url) ;
        curl_setopt($ch, CURLOPT_FRESH_CONNECT,  true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  //协议头 https，curl 默认开启证书验证，所以应关闭

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );//强制ipv4解析
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        $output = curl_exec($ch) ;
        curl_close($ch);
        return $output;
    }
}