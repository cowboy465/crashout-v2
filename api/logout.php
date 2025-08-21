<?php
require __DIR__.'/api_bootstrap.php';
session_destroy();
respond(['status'=>'ok','message'=>'Logged out']);
