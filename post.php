<?php $active='home'; include __DIR__.'/partials/header.php'; ?>
<section class="section"><div class="container">
  <h2>Create Post</h2>
  <form class="form" id="postForm" action="/api/post_create.php" method="post">
    <input class="input" type="text" name="title" placeholder="Post title" required>
    <textarea class="textarea" name="content" placeholder="Drop your fire..." required></textarea>
    <button class="btn primary" type="submit"><i class="fa-solid fa-upload"></i> Publish</button>
    <div class="tag">Tip: Posts appear instantly on the Home feed.</div>
  </form>
</div></section>
<?php include __DIR__.'/partials/footer.php'; ?>
<script>
document.getElementById('postForm').addEventListener('submit', async (e)=>{
  e.preventDefault();
  const fd = new FormData(e.target);
  const res = await fetch(e.target.action, {method:'POST', body:fd});
  const data = await res.json();
  if(data.status==='ok'){ alert('Posted!'); location.href='/'; } else alert(data.message||'Error');
});
</script>
