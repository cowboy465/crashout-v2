<?php
require __DIR__.'/api_bootstrap.php';
$pid = param('post_id'); if($pid==='') respond(['status'=>'error','message'=>'post_id required']);
$all = read_json('comments.json'); $comments = isset($all[$pid])?$all[$pid]:array(); respond($comments);
