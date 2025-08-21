<?php
require __DIR__.'/api_bootstrap.php';
verify_csrf();
$u = strtolower(param('username'));
$users = read_json('users.json');
if(!isset($users[$u])) respond(['status'=>'error','message'=>'No such user']);
$token = bin2hex(random_bytes(16));
$users[$u]['reset'] = ['token'=>$token,'expires'=>date('c', time()+3600)];
write_json('users.json',$users);
respond(['status'=>'ok','reset_link'=>'/reset.php?token='.$token.'&u='.$u]);
