<?php $active='login'; include __DIR__.'/partials/header.php'; ?>
<section class="section"><div class="container">
  <h2>Login</h2>
  <form id="loginForm" class="form" action="/api/login.php" method="post">
      <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
      <input class="input" type="text" name="username" placeholder="Username" required>
      <input class="input" type="password" name="password" placeholder="Password" required>
    <button class="btn primary" type="submit"><i class="fa-solid fa-right-to-bracket"></i> Sign In</button>
  </form>
  <h2 style="margin-top:24px">Register</h2>
  <form id="registerForm" class="form" action="/api/register.php" method="post">
      <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
      <input class="input" type="text" name="newuser" placeholder="New username" required>
      <input class="input" type="password" name="newpass" placeholder="New password" required>
    <button class="btn" type="submit"><i class="fa-solid fa-user-plus"></i> Create Account</button>
  </form>
  <h2 style="margin-top:24px">Forgot Password</h2>
  <form id="resetReq" class="form" action="/api/request_reset.php" method="post">
      <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
      <input class="input" type="text" name="username" placeholder="Your username" required>
      <button class="btn" type="submit">Get Reset Link</button>
  </form>
  <div class="tag" id="resetLink"></div>
</div></section>
<?php include __DIR__.'/partials/footer.php'; ?>
<script>
function bind(formId){
  const f=document.getElementById(formId);
  f.addEventListener('submit', async (e)=>{
    e.preventDefault();
    const res = await fetch(e.target.action, {method:'POST', body:new FormData(e.target)});
    const data = await res.json();
    if(formId==='resetReq' && data.reset_link){ document.getElementById('resetLink').textContent = location.origin + data.reset_link; }
    else alert(data.message||data.status||'Done');
    if(data.status==='ok' && formId==='loginForm'){ location.href='/' }
  });
}
['loginForm','registerForm','resetReq'].forEach(bind);
</script>
