<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/4/21
 * Time: 上午6:36
 */

require_once __DIR__ . '/server.php';
session_start();
$request = OAuth2\Request::createFromGlobals();
$response = new OAuth2\Response();
//跨域请求开始
$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
header('Access-Control-Allow-Origin:' . $origin);
header('Access-Control-Allow-Methods:OPTIONS, GET, POST'); // 允许option，get，post请求
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Credentials:true');
header('Access-Control-Max-Age:86400');
//跨域请求结束

if (!$server->validateAuthorizeRequest($request, $response)) {
    $response->send();
    die;
}

// request payload
//$request_body = file_get_contents('php://input');
//$res = json_decode($request_body, true);
////获取用户名和密码
//$email = isset($res['params']['email']) ? $res['params']['email'] : '';
//$password = isset($res['params']['password']) ? $res['params']['password'] : '';

$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
//check 请求是否合法
$res = $storage->checkUserCredentials($email, $password);
if ($res) {
    //查找其user_id
    $user_id = $storage->getUser($email)['user_id'];
    $_SESSION['user_id'] = $user_id;

    echo json_encode(array('code' => 0, 'message' => '成功!'));
    die;
} else {
    echo json_encode(array('code' => 1, 'message' => '失败!'));
    die;
}
// validate the authorize request

//insert into oauth_users(username,password,first_name,last_name) values('gewenrui','40bd001563085fc35165329ea1ff5c5ecbdbbeef','ge','wenrui');
//如果没有登录状态的话,让其登录





