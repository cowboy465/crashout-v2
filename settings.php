<?php $active='settings'; include __DIR__.'/partials/header.php'; ?>
<section class="section"><div class="container">
  <h2>Settings</h2>
  <form id="profileForm" class="form" action="/api/update_profile.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
      <input class="input" type="text" name="displayname" placeholder="Display Name">
    <textarea class="textarea" name="bio" placeholder="Bio (280 chars max)"></textarea>
    <select class="select" name="theme">
      <option value="dark">Dark</option>
      <option value="light">Light</option>
      <option value="chaos">Chaos</option>
    </select>
    <input class="input" type="text" name="twitch_channel" placeholder="Twitch Channel">
    <div class="tag">Avatar (jpg/png/webp ≤ 2MB)</div>
    <input class="input" type="file" name="avatar" accept="image/*">
    <button class="btn primary" type="submit">Save</button>
  </form>

  <h2 style="margin-top:20px">Change Password</h2>
  <form id="passForm" class="form" action="/api/change_password.php" method="post">
      <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
      <input class="input" type="password" name="oldpass" placeholder="Old password" required>
      <input class="input" type="password" name="newpass" placeholder="New password" required>
    <button class="btn" type="submit">Change</button>
  </form>
</div></section>
<?php include __DIR__.'/partials/footer.php'; ?>
<script>
function bind(id){ const f=document.getElementById(id); f.addEventListener('submit', async (e)=>{
  e.preventDefault(); const res = await fetch(f.action,{method:'POST', body:new FormData(f)}); const data = await res.json(); alert(data.message||'Done');
}); }
bind('profileForm'); bind('passForm');
</script>
