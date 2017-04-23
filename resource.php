<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/4/21
 * Time: 上午6:27
 */
//curl http://127.0.0.1:8881/resource.php -d 'access_token=6cc91965580691ba1d3032778d53cd4e0d117de0'

require_once __DIR__.'/server.php';




//echo file_put_contents("test.txt",json_encode($_POST));
//var_dump($_POST);die;
if(!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals())){
    $server->getResponse()->send();
    die;
}


$token = $server->getAccessTokenData(OAuth2\Request::createFromGlobals());
echo file_put_contents("test.txt","Hello World. Testing!");
print_r($token);die;
//echo json_encode(array('success' => true, 'message' => 'You accessed my APIs!'));