<?php
require __DIR__.'/api_bootstrap.php';
verify_csrf();
$topic = param('topic'); $message = param('message'); $author = current_user() ?: (param('author')?:'anon');
if($topic===''||$message==='') respond(['status'=>'error','message'=>'Topic & message required']);
$topics = read_json('topics.json'); if(!is_array($topics)) $topics=[];
$id = uniqid();
$topics[] = ['id'=>$id, 'title'=>$topic, 'author'=>$author, 'created_at'=>date('c'), 'replies'=>[['author'=>$author,'message'=>$message,'created_at'=>date('c')]]];
write_json('topics.json',$topics); respond(['status'=>'ok','message'=>'Topic created','id'=>$id]);
