<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/4/22
 * Time: 下午4:09
 */


require_once __DIR__ . '/server.php';
$server->handleTokenRequest(OAuth2\Request::createFromGlobals())->send();