<?php
require __DIR__.'/api_bootstrap.php';
$users = read_json('users.json');
$now = time(); $online=[]; $live=[];
foreach($users as $u=>$rec){
  $ls = isset($rec['last_seen']) ? strtotime($rec['last_seen']) : 0;
  if($ls && ($now - $ls) <= 90){
    $online[] = $u;
    if(!empty($rec['live'])) $live[] = $u;
  }
}
respond(['online'=>$online,'live'=>$live,'currentUser'=>current_user()]);
