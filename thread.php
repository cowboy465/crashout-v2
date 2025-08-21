<?php $active='forum'; include __DIR__.'/partials/header.php'; ?>
<section class="section"><div class="container">
  <a class="btn" href="/forum.php"><i class="fa-solid fa-arrow-left"></i> Back to Forum</a>
  <article id="threadCard" class="card reveal" style="margin-top:12px"></article>
  <h2 style="margin-top:18px">Replies</h2>
  <div id="replies" class="grid"></div>
  <form class="form" id="replyForm" action="/api/forum_reply.php" method="post" style="margin-top:14px">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id'] ?? '', ENT_QUOTES); ?>">
    <textarea class="textarea" name="message" placeholder="Reply..." required></textarea>
    <button class="btn primary" type="submit"><i class="fa-solid fa-reply"></i> Reply</button>
  </form>
</div></section>
<?php
$pageScripts = <<<'HTML'
<script>
const id = new URLSearchParams(location.search).get('id');
function esc(s){return s? s.replace(/</g,'&lt;') : ''}
async function loadThread(){
  const res = await fetch('/api/forum_thread.php?id='+encodeURIComponent(id)); const t = await res.json();
  if(t && !t.error){
    const card = document.getElementById('threadCard');
    card.innerHTML = `<h3 style="margin:0">${esc(t.title)}</h3><div class="meta"><span class="tag">${esc(t.author||'anon')}</span><span>·</span><span>${new Date(t.created_at).toLocaleString()}</span></div>`;
    const replies = document.getElementById('replies'); replies.innerHTML='';
    (t.replies||[]).forEach(r=>{ const c=document.createElement('div'); c.className='card reveal';
      c.innerHTML = `<div class="meta"><span class="tag">${esc(r.author||'anon')}</span><span>·</span><span>${new Date(r.created_at).toLocaleString()}</span></div><p style="margin:8px 0 0">${esc(r.message)}</p>`; replies.appendChild(c); });
  }
}
document.getElementById('replyForm').addEventListener('submit', async (e)=>{
  e.preventDefault(); const fd = new FormData(e.target);
  const res = await fetch(e.target.action, {method:'POST', body:fd}); const data = await res.json();
  if(data.status==='ok'){ e.target.reset(); loadThread(); } else alert(data.message||'Error');
});
document.addEventListener('DOMContentLoaded', loadThread);
</script>
HTML;
include __DIR__.'/partials/footer.php';
?>
