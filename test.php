<?php


require_once __DIR__ . '/server.php';
session_start();
$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
header('Access-Control-Allow-Origin:' . $origin);
header('Access-Control-Allow-Methods:OPTIONS, GET, POST'); // 允许option，get，post请求
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Credentials:true');
header('Access-Control-Max-Age:86400');
//授权码是否为空
$code = empty($_GET['code']) ? '' : $_GET['code'];
//默认的参数
$config = array('client_id' => 'testclient', 'client_secret' => 'testpass');
$query = array(
    //授权类别
    'grant_type' => 'authorization_code',
    //授权码
    'code' => $code,
    'client_id' => $config['client_id'],
    'client_secret' => $config['client_secret'],
);
//模拟Post请求 请求access_token
$url = "http://127.0.0.1:8881/token.php";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$output = curl_exec($ch);
curl_close($ch);
$res = json_decode($output, true);


//使用access_token 模拟post
$resource = array('access_token' => $res['access_token']);
$url = "http://127.0.0.1:8881/resource.php";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
//must be http_build_query_build 将数组格式转为 url-encode模式
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($resource));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
$output = curl_exec($ch);
curl_close($ch);
//因为是json格式所以直接输出就行
echo $output;





