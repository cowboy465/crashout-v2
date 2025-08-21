<?php
require __DIR__.'/api_bootstrap.php';
$chat = read_json('live_chat.json'); respond(array_slice($chat, -120));
