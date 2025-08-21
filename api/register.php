<?php
require __DIR__.'/api_bootstrap.php';
verify_csrf();
$u = strtolower(param('newuser')); $p = param('newpass');
if($u===''||$p===''){ respond(['status'=>'error','message'=>'Username & password required']); }
if(!preg_match('/^[a-z0-9_\-]{3,20}$/',$u)){ respond(['status'=>'error','message'=>'Username must be 3-20 chars, a-z, 0-9, _, -']); }
$users = read_json('users.json'); if(!is_array($users)) $users=[];
if(isset($users[$u])) respond(['status'=>'error','message'=>'User exists']);
$hash = function_exists('password_hash') ? password_hash($p,PASSWORD_DEFAULT) : md5($p);
$users[$u] = [
  'username'=>$u,'passwordHash'=>$hash,'display_name'=>$u,'bio':'','theme':'dark',
  'avatar':'','twitch_channel':'','created_at'=>date('c'),'last_seen':null,'live':false
];
write_json('users.json',$users);
respond(['status'=>'ok','message'=>'Registered']);
