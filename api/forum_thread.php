<?php
require __DIR__.'/api_bootstrap.php';
$id = param('id'); if($id==='') respond(['status'=>'error','message'=>'id required']);
$topics = read_json('topics.json'); foreach($topics as $t){ if($t['id']===$id){ respond($t); } }
respond(['status'=>'error','message'=>'Not found']);
