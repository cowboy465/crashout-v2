<?php
require __DIR__.'/api_bootstrap.php';
$post_id = param('post_id'); if($post_id==='') respond(['status'=>'error','message'=>'post_id required']);
$likes = read_json('likes.json'); if(!isset($likes[$post_id])) $likes[$post_id]=0;
if(!isset($_COOKIE['liked_'.$post_id])){ $likes[$post_id]++; setcookie('liked_'.$post_id,'1',time()+31536000,'/'); write_json('likes.json',$likes); }
respond(['status'=>'ok','likes'=>$likes[$post_id]]);
