<?php $active='login'; include __DIR__.'/partials/header.php'; ?>
<section class="section"><div class="container">
  <h2>Reset Password</h2>
  <form id="resetForm" class="form" action="/api/reset_password.php" method="post">
    <input class="input" type="hidden" name="username" id="u">
    <input class="input" type="hidden" name="token" id="t">
    <input class="input" type="password" name="newpass" placeholder="New password" required>
    <button class="btn primary" type="submit">Reset</button>
  </form>
</div></section>
<?php include __DIR__.'/partials/footer.php'; ?>
<script>
const qs = new URLSearchParams(location.search);
document.getElementById('u').value = qs.get('u')||'';
document.getElementById('t').value = qs.get('token')||'';
document.getElementById('resetForm').addEventListener('submit', async (e)=>{
  e.preventDefault(); const fd=new FormData(e.target);
  const res = await fetch(e.target.action,{method:'POST',body:fd});
  const data = await res.json(); alert(data.message||'Done'); if(data.status==='ok') location.href='/login.php';
});
</script>
