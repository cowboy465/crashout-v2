<?php
require __DIR__.'/api_bootstrap.php';
$title = param('title'); $content = param('content'); $author = current_user() ?: 'anon';
if ($title === '' || $content === '') { respond(['status' => 'error', 'message' => 'Title & content required']); }
$posts = read_json('posts.json'); if(!is_array($posts)) $posts=[];
$posts[] = ['id'=>uniqid(), 'title'=>$title, 'content'=>$content, 'author'=>$author, 'created_at'=>date('c')];

write_json('posts.json',$posts);
respond(['status'=>'ok','message'=>'Posted']);
