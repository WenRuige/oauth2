<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/4/23
 * Time: 下午3:47
 */


require_once __DIR__ . '/server.php';
session_start();
$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
header('Access-Control-Allow-Origin:' . $origin);
header('Access-Control-Allow-Methods:OPTIONS, GET, POST'); // 允许option，get，post请求
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Credentials:true');
header('Access-Control-Max-Age:86400');

$request = OAuth2\Request::createFromGlobals();
$response = new OAuth2\Response();
if (!$server->validateAuthorizeRequest($request, $response)) {
    $response->send();
    die;
}
$user_id = $_SESSION['user_id'];
if (empty($user_id)) {
    //跳转至授权界面
}
//curl -u testclient:testpass http://127.0.0.1:8881/token.php -d 'grant_type=authorization_code&code=2ddb4a94b24ac2fd8a368b6707af087a88a7f576'
// print the authorization code if the user has authorized your client
//更改为确认
$is_authorized = true;
$server->handleAuthorizeRequest($request, $response, $is_authorized, $user_id);
if ($is_authorized) {
    // this is only here so that you get to see your code in the cURL request. Otherwise, we'd redirect back to the client
    $code = substr($response->getHttpHeader('Location'), strpos($response->getHttpHeader('Location'), 'code=') + 5, 40);
    echo json_encode(array('code' => 0, 'message' => 'success', 'res' => $code));
}
//ajax 需要返回,不能再内部进行跳转,前端进行跳转
//$response->send();