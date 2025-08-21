<?php
if(session_status()===PHP_SESSION_NONE){ session_start(); }
date_default_timezone_set('UTC');
$DATA_DIR = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data';
if (!file_exists($DATA_DIR)) {
    if (!mkdir($DATA_DIR, 0755, true)) {
        error_log("Failed to create data directory: {$DATA_DIR}");
    }
}

function data_path($f){ global $DATA_DIR; return $DATA_DIR . DIRECTORY_SEPARATOR . $f; }
function read_json($f){
    $p = data_path($f);
    if (!file_exists($p)) {
        return array();
    }
    $s = file_get_contents($p);
    if ($s === false) {
        error_log("Failed to read {$p}");
        return array();
    }
    $d = json_decode($s, true);
    return is_array($d) ? $d : array();
}

function write_json($f, $arr){
    $p = data_path($f);
    $tmp = $p . '.tmp';
    $j = json_encode($arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    if (file_put_contents($tmp, $j, LOCK_EX) === false) {
        error_log("Failed to write temp file {$tmp}");
        return false;
    }
    if (!chmod($tmp, 0644)) {
        error_log("Failed to set permissions on {$tmp}");
    }
    if (!rename($tmp, $p)) {
        error_log("Failed to rename {$tmp} to {$p}");
        return false;
    }
    return true;
}
function respond($arr){ header('Content-Type: application/json; charset=utf-8'); echo json_encode($arr); exit;}
function param($key){ return isset($_POST[$key])?trim($_POST[$key]):(isset($_GET[$key])?trim($_GET[$key]):''); }
function current_user(){ return $_SESSION['user'] ?? null; }
function require_login(){ if(!current_user()){ respond(['status'=>'error','message'=>'Login required']); } }
?>
