<?php $active='home'; include __DIR__.'/partials/header.php'; ?>
<section class="section"><div class="container">
  <a class="btn" href="/"><i class="fa-solid fa-arrow-left"></i> Back</a>
  <article id="postCard" class="card reveal" style="margin-top:12px"></article>
  <h2 style="margin-top:18px">Comments</h2>
  <div id="comments" class="grid"></div>
  <form id="commentForm" class="form" action="/api/comments_add.php" method="post" style="margin-top:12px">
    <input type="hidden" name="post_id" id="pid">
    <input class="input" type="text" name="author" placeholder="Name (optional)">
    <textarea class="textarea" name="message" placeholder="Write a comment…" required></textarea>
    <button class="btn primary" type="submit"><i class="fa-regular fa-paper-plane"></i> Send</button>
  </form>
</div></section>
<?php include __DIR__.'/partials/footer.php'; ?>
<script>
const id = new URLSearchParams(location.search).get('id'); document.getElementById('pid').value = id;
function esc(s){return s? s.replace(/</g,'&lt;') : ''}
async function loadPost(){
  const res = await fetch('/api/posts.php?offset=0&limit=999'); const posts = await res.json();
  const p = posts.find(x=>x.id===id);
  const el = document.getElementById('postCard');
  if(!p){ el.innerHTML='<div class="tag">Not found</div>'; return; }
  el.innerHTML = `<h3 style="margin:0 0 4px">${esc(p.title)}</h3>
    <div class="meta"><span class="tag"><a href="/user/${esc(p.author||'anon')}">${esc(p.author||'anon')}</a></span><span>·</span><span>${new Date(p.created_at).toLocaleString()}</span></div>
    <p style="margin:10px 0">${esc(p.content)}</p>
    <div class="actions"><button class="btn" onclick="likePost('${p.id}', this)"><i class="fa-regular fa-heart"></i> <span>${p.likes||0}</span></button></div>`;
}
async function loadComments(){
  const res = await fetch('/api/comments_get.php?post_id='+encodeURIComponent(id)); const arr = await res.json();
  const list = document.getElementById('comments'); list.innerHTML='';
  arr.forEach(c=>{ const card=document.createElement('div'); card.className='card reveal';
    card.innerHTML = `<div class="meta"><span class="tag">${esc(c.author||'anon')}</span><span>·</span><span>${new Date(c.created_at).toLocaleString()}</span></div><p style="margin:8px 0 0">${esc(c.message)}</p>`; list.appendChild(card); });
}
document.getElementById('commentForm').addEventListener('submit', async (e)=>{
  e.preventDefault(); const fd = new FormData(e.target);
  await fetch(e.target.action,{method:'POST',body:fd}); e.target.message.value=''; loadComments();
});
document.addEventListener('DOMContentLoaded', ()=>{ loadPost(); loadComments(); });
</script>
