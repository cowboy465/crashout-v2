<?php
require __DIR__.'/api_bootstrap.php';
$id = param('id'); if($id==='') respond(['status'=>'error','message'=>'id required']);
$posts = read_json('posts.json'); $likes = read_json('likes.json');
foreach($posts as $p){ if((string)$p['id']===(string)$id){ $pid=$p['id']; $p['likes']=isset($likes[$pid])?intval($likes[$pid]):0; respond($p); }
}
respond(['status'=>'error','message'=>'Not found']);
?>
