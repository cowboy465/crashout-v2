<?php
require __DIR__.'/api_bootstrap.php';
$u = current_user(); if(!$u){ respond(['status'=>'ok']); }
$users = read_json('users.json');
if(isset($users[$u])){
  $users[$u]['last_seen'] = date('c');
  write_json('users.json',$users);
}
respond(['status'=>'ok']);
