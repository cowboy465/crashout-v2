<?php $active='live'; include __DIR__.'/partials/header.php'; ?>
<section class="section"><div class="container">
  <h2>Live</h2>
  <div class="grid" style="grid-template-columns:1.2fr .8fr; gap:18px">
    <div class="card reveal">
      <div class="tag"><b>Embed</b>: Twitch player uses your saved channel.</div>
      <div id="livePlayer" style="aspect-ratio:16/9;background:#0f111a;border:1px dashed var(--border);border-radius:12px;display:grid;place-items:center;color:#9aa0a6">No channel set</div>
    </div>
    <div class="card reveal">
      <h3 style="margin:0">Live Chat</h3>
      <ul id="chat" style="list-style:none;padding-left:0;max-height:380px;overflow:auto;margin:12px 0"></ul>
      <form id="chatForm" class="form" action="/api/live_chat_post.php" method="post">
        <input class="input" type="text" name="author" placeholder="Name (optional)">
        <input class="input" type="text" name="message" placeholder="Type a message…" required>
        <button class="btn primary" type="submit"><i class="fa-regular fa-paper-plane"></i> Send</button>
      </form>
      <div class="actions"><button id="goLive" class="btn primary">Toggle Live</button></div>
    </div>
  </div>
</div></section>
<?php
$pageScripts = <<<'HTML'
<script src="/assets/js/live.js"></script>
HTML;
include __DIR__.'/partials/footer.php';
?>
