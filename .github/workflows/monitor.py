import os
import datetime
import requests

RENDER_URL = os.environ["RENDER_URL"].strip()
SUPABASE_URL = os.environ["SUPABASE_URL"].strip()
SUPABASE_KEY = os.environ["SUPABASE_KEY"].strip()
TG_BOT_TOKEN = os.environ.get("TG_BOT_TOKEN", "").strip()
TG_ADMIN_ID = os.environ.get("TG_ADMIN_ID", "").strip()

def send_tg_alert(msg):
    if not TG_BOT_TOKEN or not TG_ADMIN_ID:
        return
    requests.post(
        f"https://api.telegram.org/bot{TG_BOT_TOKEN}/sendMessage",
        json={"chat_id": TG_ADMIN_ID, "text": msg, "parse_mode": "HTML"}
    )

# 1. Keep Render Server Awake (Every 10 mins)
try:
    r = requests.get(RENDER_URL, timeout=15)
    print(f"✅ Render Ping Status: {r.status_code}")
except Exception as e:
    print(f"⚠️ Render Ping Failed: {e}")

# 2. Daily Dead Link Check (Around 5:30 PM IST / 12:00 UTC)
now = datetime.datetime.now(datetime.timezone.utc)
if now.hour == 12 and now.minute < 15:
    print("🔍 Running Daily Dead Link Check...")
    headers = {
        "apikey": SUPABASE_KEY,
        "Authorization": f"Bearer {SUPABASE_KEY}"
    }
    res = requests.get(f"{SUPABASE_URL}/rest/v1/movies?select=id,title,download_links", headers=headers)
    movies = res.json() if res.status_code == 200 else []

    dead_reports = []
    for m in movies:
        links = m.get("download_links") or []
        for item in links:
            url = item.get("url")
            if not url or "gplinks" in url:
                continue
            try:
                head = requests.head(url, allow_redirects=True, timeout=10)
                if head.status_code >= 400:
                    dead_reports.append(f"• <b>{m['title']}</b> ({item.get('label', 'Link')}) → HTTP {head.status_code}")
            except Exception:
                dead_reports.append(f"• <b>{m['title']}</b> ({item.get('label', 'Link')}) → Unreachable")

    if dead_reports:
        alert_text = "🚨 <b>Dead Links Detected on Site:</b>\n\n" + "\n".join(dead_reports[:25])
        send_tg_alert(alert_text)
        print("Alert sent to Telegram.")
    else:
        print("✅ All direct links are healthy!")
