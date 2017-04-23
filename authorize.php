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
$request_body = file_get_contents('php://input');
$res = json_decode($request_body, true);
//获取用户名和密码
$email = isset($_POST['params']['email']) ? $_POST['params']['email'] : '';
$password = isset($_POST['params']['password']) ? $_POST['params']['password'] : '';
//使用sha1加密密码
//echo $email.''.$pass
//check 请求是否合法
if (!$server->validateAuthorizeRequest($request, $response)) {
    $response->send();
    die;
}
$res = $storage->checkUserCredentials($email, $password);

if($res){
    //查找其user_id
    $user_id = $storage->getUser($email)['user_id'];
    $_SESSION['userId'] = $user_id;
    echo json_encode(array('code' => 0 ,'message' => '成功!'));
}else{
    echo json_encode(array('code' => 1 ,'message' => '失败!'));
}
// validate the authorize request

//insert into oauth_users(username,password,first_name,last_name) values('gewenrui','40bd001563085fc35165329ea1ff5c5ecbdbbeef','ge','wenrui');
//如果没有登录状态的话,让其登录


die;
if (empty($_SESSION['userId'])) {

    echo '您未在第三方平台登录';
    exit('
<form method="post">
  <label>是否认证testclient</label><br />
  <input type="text" name="authorized" value="yes">
  <input type="text" name="authorized" value="no">
   <input type="submit" name="authorized" value="提交">
</form>');

}

// display an authorization form
if (empty($_POST)) {
    exit('
<form method="post">
  <label>是否认证testclient</label><br />
  <input type="submit" name="authorized" value="yes">
  <input type="submit" name="authorized" value="no">
</form>');
}
$user_id = 1;
//curl -u testclient:testpass http://127.0.0.1:8881/token.php -d 'grant_type=authorization_code&code=2ddb4a94b24ac2fd8a368b6707af087a88a7f576'
// print the authorization code if the user has authorized your client
$is_authorized = ($_POST['authorized'] === 'yes');
$server->handleAuthorizeRequest($request, $response, $is_authorized, $user_id);
//if ($is_authorized) {
//    // this is only here so that you get to see your code in the cURL request. Otherwise, we'd redirect back to the client
//    $code = substr($response->getHttpHeader('Location'), strpos($response->getHttpHeader('Location'), 'code=')+5, 40);
//    exit("SUCCESS! Authorization Code: $code");
//}
$response->send();



