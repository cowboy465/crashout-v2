<?php
require __DIR__.'/api_bootstrap.php';
$q = strtolower(param('q')); $sort = param('sort'); $offset=max(0,intval(param('offset'))); $limit = min(60, max(1,intval(param('limit'))?:12));
$posts = read_json('posts.json'); $likes = read_json('likes.json');
foreach($posts as &$p){ $pid=$p['id']; $p['likes']= isset($likes[$pid])?intval($likes[$pid]):0; } unset($p);
if($q!==''){ $posts = array_values(array_filter($posts, function($p) use ($q){ return (strpos(strtolower($p['title']),$q)!==false)||(strpos(strtolower($p['content']),$q)!==false)||(strpos(strtolower($p['author']??''),$q)!==false);})); }
if($sort==='trending'){ usort($posts,function($a,$b){ return ($b['likes']<=>$a['likes']) ?: strcmp($b['created_at'],$a['created_at']); }); } else { usort($posts,function($a,$b){ return strcmp($b['created_at'],$a['created_at']); }); }
respond(array_slice($posts,$offset,$limit));
