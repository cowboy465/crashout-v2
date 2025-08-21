<?php $active='home'; include __DIR__.'/partials/header.php'; ?>
<section class="hero">
  <div class="container">
    <h1 class="h1">CrashOut — Shatter the Narrative</h1>
    <p class="sub">A neon-noir social feed for unfiltered posts. Drop your signal. Amplify the undercurrent.</p>
    <div class="row">
      <a class="btn primary" href="/post.php"><i class="fa-solid fa-upload"></i> New Post</a>
      <a class="btn" href="/forum.php"><i class="fa-solid fa-comments"></i> Forum</a>
      <a class="btn" href="/live.php"><i class="fa-solid fa-tower-broadcast"></i> Live</a>
      <a class="btn" href="/settings.php"><i class="fa-solid fa-sliders"></i> Settings</a>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <h2>Reels</h2>
    <div id="reelPlayer" class="card reveal" style="padding:0; overflow:hidden">
      <div id="reelInner" class="reel-player" style="aspect-ratio:9/16;background:#0f111a;display:grid;place-items:center;color:#9aa0a6">Loading…</div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <h2>Featured Stream</h2>
    <div id="featured" class="card reveal" style="padding:0; overflow:hidden">
      <div id="featuredInner" style="aspect-ratio:16/9; background:#0f111a; display:grid; place-items:center; color:#9aa0a6">Loading…</div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <h2>Latest Posts</h2>
    <div class="tools">
      <input id="search" class="search" type="text" placeholder="Search posts by title, content, or author">
      <label class="tag"><input id="toggleTrending" type="checkbox" style="vertical-align:middle;margin-right:6px">Trending first</label>
    </div>
    <div id="feed" class="grid cards"></div>
    <div style="margin-top:12px"><button id="loadMore" class="btn"><i class="fa-solid fa-angles-down"></i> Load more</button></div>
  </div>
<?php
$pageScripts = <<<'HTML'
<script src="/assets/js/feed.js"></script>
<script>
// Featured: show first live user's Twitch, else autoplay YouTube loop
async function setupFeatured(){
  try{
    const res = await fetch('/api/get_users_online.php'); const data = await res.json();
    const users = await (await fetch('/data/users.json',{cache:'no-store'})).json();
    let liveUser = (data.live||[])[0];
    if(liveUser && users[liveUser] && users[liveUser].twitch_channel){
      const ch = users[liveUser].twitch_channel;
      document.getElementById('featuredInner').innerHTML = `<iframe src="https://player.twitch.tv/?channel=${ch}&parent=${location.hostname}" allowfullscreen style="width:100%;height:100%;border:0"></iframe>`;
      return;
    }
  }catch(e){ /* ignore */ }
  const vids = ['xeymqocqVAo','M1Z-Ub3VA_c'];
  const id = vids[Math.floor(Math.random()*vids.length)];
  document.getElementById('featuredInner').innerHTML = `<iframe src="https://www.youtube.com/embed/${id}?autoplay=1&mute=1&controls=1&rel=0" allow="autoplay; encrypted-media" allowfullscreen style="width:100%;height:100%;border:0"></iframe>`;
}
setupFeatured();

// Autoplay reel of short videos
const reelVideos = [
  'https://samplelib.com/lib/preview/mp4/sample-5s.mp4',
  'https://samplelib.com/lib/preview/mp4/sample-10s.mp4'
];
const reelInner = document.getElementById('reelInner');
const reelVideo = document.createElement('video');
reelVideo.autoplay = true; reelVideo.muted = true; reelVideo.playsInline = true; reelVideo.controls = false;
reelVideo.style.width = '100%'; reelVideo.style.height = '100%';
reelInner.innerHTML=''; reelInner.appendChild(reelVideo);
let reelIndex = 0;
function playReel(){
  reelVideo.src = reelVideos[reelIndex];
  reelVideo.play();
  reelIndex = (reelIndex + 1) % reelVideos.length;
}
reelVideo.addEventListener('ended', playReel);
playReel();
</script>
HTML;
include __DIR__.'/partials/footer.php';
?>
