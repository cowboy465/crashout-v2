<?php
require __DIR__.'/api_bootstrap.php';
$msg = param('message'); $author = current_user() ?: (param('author')?:'anon');
if($msg==='') respond(['status'=>'error','message'=>'message required']);
$chat = read_json('live_chat.json'); if(!is_array($chat)) $chat=[];
$chat[] = ['author'=>$author,'message'=>$msg,'created_at'=>date('c')];
write_json('live_chat.json',$chat); respond(['status'=>'ok']);
