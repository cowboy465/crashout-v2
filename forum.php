<?php $active='forum'; include __DIR__.'/partials/header.php'; ?>
<section class="section"><div class="container">
  <h2>Forum</h2>
  <form class="form" id="topicForm" action="/api/forum_create.php" method="post" style="margin-bottom:14px">
    <input class="input" type="text" name="topic" placeholder="Topic title" required>
    <textarea class="textarea" name="message" placeholder="Kick off with your opening message..." required></textarea>
    <button class="btn primary" type="submit"><i class="fa-solid fa-paper-plane"></i> Start Topic</button>
  </form>
  <table class="table"><thead><tr><th>Topic</th><th>Started by</th><th>Replies</th><th>When</th></tr></thead><tbody id="topicsBody"></tbody></table>
</div></section>
<?php
$pageScripts = <<<'HTML'
<script src="/assets/js/forum.js"></script>
HTML;
include __DIR__.'/partials/footer.php';
?>
