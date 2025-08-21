<?php
require __DIR__.'/api_bootstrap.php'; require_login();
$u = current_user(); $flag = param('live')==='1';
$users = read_json('users.json');
if(isset($users[$u])){
  $users[$u]['live'] = $flag;
  $users[$u]['last_seen'] = date('c');
  write_json('users.json',$users);
}
respond(['status'=>'ok','live'=>$flag]);
