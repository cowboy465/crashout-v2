<?php
require __DIR__.'/api_bootstrap.php';
verify_csrf();
$u = strtolower(param('username')); $p = param('password');
$users = read_json('users.json');
if(!isset($users[$u])) respond(['status'=>'error','message'=>'Invalid credentials']);
$rec = $users[$u];
$ok = isset($rec['passwordHash']) && (
  (function_exists('password_verify') && password_verify($p,$rec['passwordHash'])) || (!function_exists('password_verify') && md5($p)===$rec['passwordHash'])
);
if(!$ok) respond(['status'=>'error','message'=>'Invalid credentials']);
$_SESSION['user'] = $u;
$users[$u]['last_seen'] = date('c');
write_json('users.json',$users);
respond(['status'=>'ok','message'=>'Login ok','user'=>$u]);
