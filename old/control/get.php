﻿<?php
/* 文件名字: get.php */
/* 制作人:刘建涛 */
/* 修改时间: 2014-8-20 20:45:18 */
/* 功能介绍:获取GET到的订单ID,快递公司，快递单号，获取物理信息 */
include_once '../common/check.php';
$typeCom = $_GET["com"];//快递公司
$typeNu = $_GET["nu"];  //快递单号

//echo $typeCom.'<br/>' ;
//echo $typeNu ;

$AppKey='9f9a696878b61edb';//请将XXXXXX替换成您在http://kuaidi100.com/app/reg.html申请到的KEY
$url ='http://api.kuaidi100.com/api?id='.$AppKey.'&com='.$typeCom.'&nu='.$typeNu.'&show=2&muti=1&order=desc';

//请勿删除变量$powered 的信息，否者本站将不再为你提供快递接口服务。
$powered = '查询数据由：<a href="http://kuaidi100.com" target="_blank">KuaiDi100.Com （快递100）</a> 网站提供 ';
?>
<input type="button" name="button" class="button" onclick="javascript:history.go(-1)" value="返回" />

<?php
//优先使用curl模式发送数据
if (function_exists('curl_init') == 1){
  $curl = curl_init();
  curl_setopt ($curl, CURLOPT_URL, $url);
  curl_setopt ($curl, CURLOPT_HEADER,0);
  curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
  curl_setopt ($curl, CURLOPT_TIMEOUT,5);
  $get_content = curl_exec($curl);
  curl_close ($curl);
}else{
  include("snoopy.php");
  $snoopy = new snoopy();
  $snoopy->referer = 'http://www.google.com/';//伪装来源
  $snoopy->fetch($url);
  $get_content = $snoopy->results;
}
print_r($get_content . '<br/>' . $powered);
exit();
?>