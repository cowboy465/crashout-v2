<?php
require __DIR__.'/api_bootstrap.php';
$topics = read_json('topics.json'); if(!is_array($topics)) $topics=[];
usort($topics, function($a,$b){ return strcmp($b['created_at'],$a['created_at']); });
respond($topics);
