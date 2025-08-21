CrashOut — Animated FTP Package (Accounts, Profiles, Twitch, Presence)
====================================================================

Upload this entire folder to your web root (e.g., `htdocs` or `public_html`) with FileZilla.
If saving fails, set `/data` and `/uploads` to permissions 755 (or 775 temporarily).

Key Features
------------
- Accounts: register/login/logout, password change & demo reset link
- Profiles: /user/[username] with avatar, bio, theme, Twitch embed, status badge
- Presence: online/offline/live via status pings + manual live toggle
- Feed: posts, likes (cookie), comments, search, trending
- Forum: topics, threads, replies
- Live: chat (polling) + Twitch embed using saved channel
- Autoplay featured content on home (Twitch if someone live, else YouTube rage reel)

Routing
-------
- Pretty URL for profiles via `.htaccess`: `/user/USERNAME` → `user.php?u=USERNAME`

Security Notes
--------------
- Demo-grade JSON storage in `/data` (protected by `.htaccess`). Switch to MySQL for production.
- Avatar uploads limited to 2MB JPG/PNG/WebP and stored in `/uploads/avatars`.
- Twitch requires `parent={your-domain}` param in the embed. The code sets it from `location.hostname`.

Files
-----
- index.php, post.php, post_view.php, forum.php, thread.php, live.php, login.php, logout.php, reset.php, settings.php, user.php
- /api/* (auth, presence, posts, comments, forum, live chat, profile updates)
- /assets/css/styles.css (theme + animations)
- /assets/js/*.js (feed, forum, live, core helpers)
- /data/* (JSON data; do not delete .htaccess)
- /.htaccess (routing + DirectoryIndex)
