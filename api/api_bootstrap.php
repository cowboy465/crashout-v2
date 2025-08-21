<?php
if(session_status()===PHP_SESSION_NONE){ session_start(); }
if(empty($_SESSION['csrf_token'])){ $_SESSION['csrf_token']=bin2hex(random_bytes(32)); }
date_default_timezone_set('UTC');
$DATA_DIR = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data';
if (!file_exists($DATA_DIR)) { @mkdir($DATA_DIR, 0755, true); }

function data_path($f){ global $DATA_DIR; return $DATA_DIR . DIRECTORY_SEPARATOR . $f; }
function read_json($f){ $p=data_path($f); if(!file_exists($p)) return array(); $s=@file_get_contents($p); $d=json_decode($s,true); return is_array($d)?$d:array(); }
function write_json($f,$arr){
  $p=data_path($f); $tmp=$p.'.tmp'; $j=json_encode($arr, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
  $fp=@fopen($tmp,'w'); if(!$fp) return false; fwrite($fp,$j); fclose($fp); @chmod($tmp,0644); return @rename($tmp,$p);
}
function respond($arr){ header('Content-Type: application/json; charset=utf-8'); echo json_encode($arr); exit;}
function param($key){ return isset($_POST[$key])?trim($_POST[$key]):(isset($_GET[$key])?trim($_GET[$key]):''); }
function csrf_token(){ return $_SESSION['csrf_token'] ?? ''; }
function verify_csrf(){ $t=param('csrf_token'); if(!$t || !hash_equals($_SESSION['csrf_token'] ?? '', $t)){ respond(['status'=>'error','message'=>'Invalid CSRF token']); } }
function current_user(){ return $_SESSION['user'] ?? null; }
function require_login(){ if(!current_user()){ respond(['status'=>'error','message'=>'Login required']); } }
?>
