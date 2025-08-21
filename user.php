<?php $active='home'; include __DIR__.'/partials/header.php'; ?>
<section class="section"><div class="container">
<?php
$u = $_GET['u'] ?? '';
$users = json_decode(file_get_contents(__DIR__.'/data/users.json'), true);
if(!$u || !isset($users[$u])){ echo '<div class="tag">User not found</div>'; include __DIR__.'/partials/footer.php'; exit; }
$rec = $users[$u];
$badge = '⚫️ Offline';
if(!empty($rec['live'])) $badge = '🔥 Live';
else if(!empty($rec['last_seen']) && time()-strtotime($rec['last_seen'])<=90) $badge = '🟢 Online';
?>
  <div class="card reveal" style="display:grid;grid-template-columns:120px 1fr;gap:16px;align-items:center">
    <img class="avatar" src="<?php echo $rec['avatar']?:'https://placehold.co/96x96'; ?>" alt="avatar">
    <div>
      <h2 style="margin:0"><?php echo htmlspecialchars($rec['display_name']?:$u); ?> <span class="status-badge"><?php echo $badge; ?></span></h2>
      <div class="meta"><span class="tag">@<?php echo htmlspecialchars($u); ?></span></div>
      <p style="margin:10px 0"><?php echo htmlspecialchars($rec['bio']?:''); ?></p>
      <?php if(!empty($rec['twitch_channel'])): ?>
        <div style="margin-top:10px;aspect-ratio:16/9">
          <iframe src="https://player.twitch.tv/?channel=<?php echo urlencode($rec['twitch_channel']); ?>&parent=<?php echo htmlspecialchars($_SERVER['HTTP_HOST']); ?>" allowfullscreen style="width:100%;height:100%;border:0"></iframe>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <h2 style="margin-top:18px">Posts by <?php echo htmlspecialchars($rec['display_name']?:$u); ?></h2>
  <div id="userPosts" class="grid cards"></div>
</div></section>
<?php include __DIR__.'/partials/footer.php'; ?>
<script>
const user = <?php echo json_encode($u); ?>;
function esc(s){return s? s.replace(/</g,'&lt;') : ''}
async function loadUserPosts(){
  const res = await fetch('/api/posts.php?offset=0&limit=999'); const posts = await res.json();
  const list = document.getElementById('userPosts'); list.innerHTML='';
  posts.filter(p=>String(p.author).toLowerCase()===user.toLowerCase()).forEach(p=>{
    const el = document.createElement('article'); el.className='card';
    el.innerHTML = `<h3 style="margin:0 0 4px"><a href="/post_view.php?id=${encodeURIComponent(p.id)}">${esc(p.title)}</a></h3>
      <div class="meta"><span class="tag">${new Date(p.created_at).toLocaleString()}</span></div>
      <p style="margin:10px 0">${esc(p.content)}</p>`;
    list.appendChild(el);
  });
}
document.addEventListener('DOMContentLoaded', loadUserPosts);
</script>
