
// Intersection reveal
const observer = new IntersectionObserver(entries=>{
  entries.forEach(e=>{ if(e.isIntersecting){ e.target.classList.add('reveal'); observer.unobserve(e.target);} })
},{threshold:.12});
document.addEventListener('DOMContentLoaded', ()=>{
  document.querySelectorAll('.card').forEach(el=>observer.observe(el));
  // Presence ping every 60s
  setInterval(()=>{ fetch('/api/status_ping.php',{method:'POST'}); }, 60000);
  // Initial ping
  fetch('/api/status_ping.php',{method:'POST'});
});
function esc(s){return s? String(s).replace(/</g,'&lt;') : ''}
async function likePost(id, btn){
  const data = await (await fetch('/api/like.php',{method:'POST',body:new URLSearchParams({post_id:id})})).json();
  if(data.status==='ok'){ btn.querySelector('span').textContent=data.likes; }
}
