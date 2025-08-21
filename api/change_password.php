<?php
require __DIR__.'/api_bootstrap.php';
require_login();
verify_csrf();
$u = current_user(); $old = param('oldpass'); $new = param('newpass');
$users = read_json('users.json');
if(!isset($users[$u])) respond(['status'=>'error','message'=>'User not found']);
$rec = $users[$u];
$ok = isset($rec['passwordHash']) && (
  (function_exists('password_verify') && password_verify($old,$rec['passwordHash'])) || (!function_exists('password_verify') && md5($old)===$rec['passwordHash'])
);
if(!$ok) respond(['status'=>'error','message'=>'Old password incorrect']);
$users[$u]['passwordHash'] = function_exists('password_hash') ? password_hash($new,PASSWORD_DEFAULT) : md5($new);
write_json('users.json',$users);
respond(['status'=>'ok','message'=>'Password changed']);
