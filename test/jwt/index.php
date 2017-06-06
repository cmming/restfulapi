<?php

include "vendor/autoload.php";
use \Firebase\JWT\JWT;


//??相当于做混合运算的头部 已经被封装
$key = "example_key";
//
$token = array(
	//issuer 请求实体，可以是发起请求的用户的信息，也可是jwt的签发者。
    "iss" => "http://example.org",
	//接收该JWT的一方。可以是登录者的id(每个用户必须不一样的表示)
    "aud" => "http://example.com",
	//issued at。 token创建时间，unix时间戳格式
    "iat" => 1356999524,
	//not before。如果当前时间在nbf里的时间之前，则Token不被接受；一般都会留一些余地，比如几分钟。用于清空一些 过期的token
    "nbf" => 1357000000,
	//expires token什么时候过期
	"exp" => 1356999536
);

/**
 * IMPORTANT:
 * You must specify supported algorithms for your application. See
 * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
 * for a list of spec-compliant algorithms.
 * 指定对应的加密算法
 */
//加密生成 $jwt
$jwt = JWT::encode($token, $key);
//解密
$decoded = JWT::decode($jwt, $key, array('HS256'));

var_dump($jwt);
echo '<br>';
var_dump(date('Y-m-d H:i:s',1356999524));
echo '<br>';
var_dump(date('Y-m-d H:i:s',1357000000));
echo '<br>';
var_dump(date('Y-m-d H:i:s',1957000600));
echo '<br>';
//exit();
var_dump($decoded);
echo '<br>';
print_r($decoded);

/*
 NOTE: This will now be an object instead of an associative array. To get
 an associative array, you will need to cast it as such:
注意上面的生成的是一个类数组对象，而不是一个数组，需要进行类型转换
*/

$decoded_array = (array) $decoded;
echo '<br>';
var_dump($decoded_array);

/**
 * You can add a leeway to account for when there is a clock skew times between
 * the signing and verifying servers. It is recommended that this leeway should
 * not be bigger than a few minutes.
 * 当签名和验证服务器之间存在时钟偏移时间时，可以添加一个回旋余地。
 * 建议这种回旋余地不应大于几分钟。
 *
 * 每次接口刷新后将 $token 进行刷行 保证token 的时效性
 * 退出登录
 *
 * Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
 */
JWT::$leeway = 60; // $leeway in seconds
$decoded = JWT::decode($jwt, $key, array('HS256'));
echo '<br>';
var_dump($decoded);
?>