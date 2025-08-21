<?php
  if(session_status()===PHP_SESSION_NONE){ session_start(); }
  $active = $active ?? '';
  $me = $_SESSION['user'] ?? null;
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CrashOut — Shatter the Narrative</title>
  <meta name="description" content="The raw-energy hub for fearless creators to post, debate, stream, and customize profiles.">
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
<header class="site">
  <div class="navwrap">
    <a class="brand" href="/index.php">
      <span class="logo"><i class="fa-solid fa-bolt"></i></span>
      <span>CrashOut</span>
    </a>
    <nav class="menu">
      <a class="<?php echo $active==='home'?'active':''?>" href="/index.php"><i class="fa-solid fa-house"></i> Home</a>
      <a class="<?php echo $active==='forum'?'active':''?>" href="/forum.php"><i class="fa-solid fa-comments"></i> Forum</a>
      <a class="<?php echo $active==='live'?'active':''?>" href="/live.php"><i class="fa-solid fa-tower-broadcast"></i> Live</a>
      <?php if($me): ?>
        <a class="<?php echo $active==='settings'?'active':''?>" href="/settings.php"><i class="fa-solid fa-sliders"></i> Settings</a>
        <a href="/user/<?php echo urlencode($me); ?>"><i class="fa-solid fa-user"></i> Profile</a>
        <a href="/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
      <?php else: ?>
        <a class="<?php echo $active==='login'?'active':''?>" href="/login.php"><i class="fa-solid fa-right-to-bracket"></i> Login</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
