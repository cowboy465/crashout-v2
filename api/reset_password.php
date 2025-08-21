<?php
require __DIR__.'/api_bootstrap.php';
$u = strtolower(param('username')); $token = param('token'); $new = param('newpass');
$users = read_json('users.json');
if(!isset($users[$u])||!isset($users[$u]['reset'])) respond(['status'=>'error','message'=>'Invalid token']);
$rec = $users[$u]['reset'];
if($rec['token']!==$token || strtotime($rec['expires'])<time()) respond(['status'=>'error','message'=>'Invalid/expired token']);
$users[$u]['passwordHash'] = function_exists('password_hash') ? password_hash($new,PASSWORD_DEFAULT) : md5($new);
unset($users[$u]['reset']);
write_json('users.json',$users);
respond(['status'=>'ok','message'=>'Password reset']);
