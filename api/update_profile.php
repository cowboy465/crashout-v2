<?php
require __DIR__.'/api_bootstrap.php'; require_login();
$u = current_user();
$users = read_json('users.json');
if(!isset($users[$u])) respond(['status'=>'error','message'=>'User not found']);

$display = substr(param('displayname'),0,40);
$bio = substr(param('bio'),0,280);
$theme = param('theme'); if(!in_array($theme,['dark','light','chaos'])) $theme='dark';
$twitch = substr(param('twitch_channel'),0,50);

$users[$u]['display_name'] = $display ?: $users[$u]['display_name'];
$users[$u]['bio'] = $bio;
$users[$u]['theme'] = $theme;
$users[$u]['twitch_channel'] = $twitch;

// Avatar upload
if(isset($_FILES['avatar']) && is_uploaded_file($_FILES['avatar']['tmp_name'])){
  $f = $_FILES['avatar'];
  $okTypes = [
    'image/jpeg'=>['jpg','jpeg'],
    'image/png'=>['png'],
    'image/webp'=>['webp']
  ];
  $fileInfo = @getimagesize($f['tmp_name']);
  $mime = $fileInfo['mime'] ?? '';
  $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
  if($fileInfo && isset($okTypes[$mime]) && in_array($ext,$okTypes[$mime],true) && $f['size'] <= 2*1024*1024){
    $safeUser = preg_replace('/[^a-zA-Z0-9_-]/','',$u);
    $name = $safeUser.'-'.bin2hex(random_bytes(8)).'.'.$ext;
    $destDir = dirname(__DIR__,2).'/uploads/avatars';
    if(!is_dir($destDir)) @mkdir($destDir,0755,true);
    $dest = $destDir.'/'.$name;
    if(move_uploaded_file($f['tmp_name'],$dest)){
      $users[$u]['avatar'] = $name;
    }
  }
}

write_json('users.json',$users);
respond(['status'=>'ok','message'=>'Profile updated','user'=>$users[$u]]);
