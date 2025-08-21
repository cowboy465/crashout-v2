<?php
require __DIR__.'/api_bootstrap.php';
$users = read_json('users.json');
$safe = ['display_name','bio','avatar','twitch_channel','last_seen','live'];
$public = [];
foreach ($users as $u => $rec) {
    $public[$u] = [];
    foreach ($safe as $k) {
        if (isset($rec[$k])) {
            $public[$u][$k] = $rec[$k];
        }
    }
}
respond($public);
?>
