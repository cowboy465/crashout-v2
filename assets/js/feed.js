
let offset=0, limit=12, loading=false, q='', trending=false;
const feed = document.getElementById('feed');
const btnMore = document.getElementById('loadMore');
const search = document.getElementById('search');
const toggle = document.getElementById('toggleTrending');

async function load(reset=false){
  if(loading) return; loading=true;
  const url = `/api/posts.php?offset=${offset}&limit=${limit}&q=${encodeURIComponent(q)}&sort=${trending?'trending':'latest'}`;
  const res = await fetch(url);
  const posts = await res.json();
  if(reset){ feed.innerHTML=''; offset=0; }
  posts.forEach(p=>feed.appendChild(cardFor(p)));
  offset += posts.length;
  btnMore.style.display = posts.length < limit ? 'none' : 'inline-flex';
  revealNewCards();
  loading=false;
}
function cardFor(p){
  const el = document.createElement('article');
  el.className='card';
  const title = esc(p.title);
  const body = esc(p.content);
  el.innerHTML = `
    <h3 style="margin:0 0 4px"><a href="/post_view.php?id=${encodeURIComponent(p.id)}">${title}</a></h3>
    <div class="meta"><span class="tag">${esc(p.author||'anon')}</span><span>·</span><span>${new Date(p.created_at).toLocaleString()}</span></div>
    <p style="margin:10px 0">${body}</p>
    <div class="actions">
      <button class="btn" onclick="likePost('${p.id}', this)"><i class="fa-regular fa-heart"></i> <span>${p.likes||0}</span></button>
      <a class="btn" href="/post_view.php?id=${encodeURIComponent(p.id)}"><i class="fa-regular fa-comment"></i> Comments</a>
      <a class="btn" href="/user/${encodeURIComponent(p.author||'anon')}"><i class="fa-solid fa-user"></i> Profile</a>
    </div>`;
  return el;
}
function revealNewCards(){
  document.querySelectorAll('.card').forEach(el=>{
    if(!el.classList.contains('reveal')){ el.getBoundingClientRect(); el.classList.add('reveal'); }
  });
}
search.addEventListener('input', ()=>{ q=search.value.trim(); offset=0; load(true); });
toggle.addEventListener('change', ()=>{ trending=toggle.checked; offset=0; load(true); });
document.getElementById('loadMore').addEventListener('click', ()=>load());
document.addEventListener('DOMContentLoaded', ()=>load());
