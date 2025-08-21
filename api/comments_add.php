<?php
require __DIR__.'/api_bootstrap.php';
$pid = param('post_id'); $message = param('message'); $author = current_user() ?: (param('author')?:'anon');
if($pid===''||$message==='') respond(['status'=>'error','message'=>'post_id & message required']);
$all = read_json('comments.json'); if(!isset($all[$pid])) $all[$pid]=array();
$all[$pid][] = ['author'=>$author, 'message'=>$message, 'created_at'=>date('c')];
write_json('comments.json',$all); respond(['status'=>'ok']);
