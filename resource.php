<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/4/21
 * Time: 上午6:27
 */
//curl http://127.0.0.1:8881/resource.php -d 'access_token=6cc91965580691ba1d3032778d53cd4e0d117de0'

require_once __DIR__.'/server.php';

if(!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals())){
    $server->getResponse()->send();
    die;
}
$res = $server->getAccessTokenData(OAuth2\Request::createFromGlobals());

echo json_encode($res);
//此处应该定义返回
//echo json_encode(array('success' => true, 'message' => 'You accessed my APIs!'));