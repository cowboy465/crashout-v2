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
  $okTypes = ['image/jpeg'=>'.jpg','image/png'=>'.png','image/webp'=>'.webp'];
  if(isset($okTypes[$f['type']]) && $f['size'] <= 2*1024*1024){
    $ext = $okTypes[$f['type']];
    $name = $u.'-'.bin2hex(random_bytes(4)).$ext;
    $destDir = dirname(__DIR__).'/uploads/avatars';
    if(!file_exists($destDir)) @mkdir($destDir,0755,true);
    $dest = $destDir.'/'.$name;
    if(move_uploaded_file($f['tmp_name'],$dest)){
      $users[$u]['avatar'] = '/uploads/avatars/'.$name;
    }
  }
}

write_json('users.json',$users);
respond(['status'=>'ok','message'=>'Profile updated','user'=>$users[$u]]);
