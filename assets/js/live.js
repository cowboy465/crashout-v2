
function esc(s){return s? s.replace(/</g,'&lt;'):''}
async function refreshChat(){
  try{ const res = await fetch('/api/live_chat_get.php'); const data = await res.json();
    const list = document.getElementById('chat'); list.innerHTML='';
    data.forEach(m=>{ const li=document.createElement('li'); li.className='card reveal';
      li.innerHTML = `<div class="meta"><span class="tag">${esc(m.author||'anon')}</span><span>·</span><span>${new Date(m.created_at).toLocaleTimeString()}</span></div><div style="margin-top:6px">${esc(m.message)}</div>`; list.appendChild(li); });
  }catch(e){ console.error(e); }
}
document.getElementById('chatForm').addEventListener('submit', async (e)=>{
  e.preventDefault(); const fd=new FormData(e.target);
  await fetch(e.target.action, {method:'POST', body:fd}); e.target.message.value=''; refreshChat();
});
setInterval(refreshChat, 3000); document.addEventListener('DOMContentLoaded', refreshChat);

// Load player's Twitch channel from profile via /data/users.json (if blocked, replace with API)
(async ()=>{
  try{
    const meRes = await fetch('/api/get_users_online.php'); const pres = await meRes.json();
    const me = pres.currentUser;
    const users = await (await fetch('/data/users.json',{cache:'no-store'})).json();
    const rec = me && users[me] ? users[me] : null;
    if(rec && rec.twitch_channel){
      document.getElementById('livePlayer').innerHTML = `<iframe src="https://player.twitch.tv/?channel=${rec.twitch_channel}&parent=${location.hostname}" allowfullscreen style="width:100%;height:100%;border:0"></iframe>`;
    }
  }catch(e){};
})();

document.getElementById('goLive').addEventListener('click', async ()=>{
  const res = await fetch('/api/set_live.php', {method:'POST', body:new URLSearchParams({live:'1'})});
  const j = await res.json(); alert(j.live?'You are LIVE':'Toggled');
});
