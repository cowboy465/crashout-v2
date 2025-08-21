
async function loadTopics(){
  const res = await fetch('/api/forum_topics.php'); const topics = await res.json();
  const tbody = document.getElementById('topicsBody'); tbody.innerHTML='';
  topics.forEach(t=>{
    const tr = document.createElement('tr');
    const replies = (t.replies||[]).length;
    tr.innerHTML = `<td><a href="/thread.php?id=${t.id}">${escapeHtml(t.title)}</a></td><td>${escapeHtml(t.author||'anon')}</td><td>${replies}</td><td>${new Date(t.created_at).toLocaleString()}</td>`;
    tbody.appendChild(tr);
  });
}
function escapeHtml(s){ return s? s.replace(/</g,'&lt;') : ''; }
document.getElementById('topicForm').addEventListener('submit', async (e)=>{
  e.preventDefault(); const fd = new FormData(e.target);
  const res = await fetch(e.target.action, {method:'POST', body:fd}); const data = await res.json();
  if(data.status==='ok'){ e.target.reset(); loadTopics(); } else alert(data.message||'Error');
});
document.addEventListener('DOMContentLoaded', loadTopics);
