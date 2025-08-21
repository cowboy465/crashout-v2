<?php
require __DIR__.'/api_bootstrap.php';
$id = param('id'); $message = param('message'); $author = current_user() ?: (param('author')?:'anon');
if($id===''||$message==='') respond(['status'=>'error','message'=>'id & message required']);
$topics = read_json('topics.json');
for($i=0;$i<count($topics);$i++){
  if($topics[$i]['id']===$id){
    if(!isset($topics[$i]['replies'])) $topics[$i]['replies']=array();
    $topics[$i]['replies'][] = ['author'=>$author,'message'=>$message,'created_at'=>date('c')];
    write_json('topics.json',$topics); respond(['status'=>'ok']);
  }
}
respond(['status'=>'error','message'=>'Not found']);
