<?php
require __DIR__.'/api_bootstrap.php';
$u = strtolower(param('username')); $offset=max(0,intval(param('offset'))); $limit=min(60,max(1,intval(param('limit'))?:12));
$posts = read_json('posts.json'); $likes = read_json('likes.json');
$posts = array_values(array_filter($posts, function($p) use ($u){ return strtolower($p['author']??'')===$u; }));
foreach($posts as &$p){ $pid=$p['id']; $p['likes']=isset($likes[$pid])?intval($likes[$pid]):0; } unset($p);
usort($posts,function($a,$b){ return strcmp($b['created_at'],$a['created_at']); });
respond(array_slice($posts,$offset,$limit));
?>
