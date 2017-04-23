<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 2017/4/20
 * Time: 下午6:29
 */

$dsn      = 'mysql:dbname=oauth2;host=127.0.0.1;port=3308';
$username = 'root';
$password = '';
date_default_timezone_set("PRC");
ini_set('display_errors',1);error_reporting(E_ALL);
require_once ('oauth2-server-php/src/OAuth2/Autoloader.php');
//自动注册路由
OAuth2\Autoloader::register();

$storage = new \OAuth2\Storage\Pdo(array('dsn' => $dsn, 'username' => $username, 'password' => $password));

// Pass a storage object or array of storage objects to the OAuth2 server class
$server = new OAuth2\Server($storage);

// Add the "Client Credentials" grant type (it is the simplest of the grant types)
$server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));

// Add the "Authorization Code" grant type (this is where the oauth magic happens)
$server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));