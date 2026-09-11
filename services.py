import asyncio, os, tempfile, re
import yt_dlp

async def search_music(query, limit=10):
    def work():
        opts = {"quiet": True, "skip_download": True, "noplaylist": True}
        with yt_dlp.YoutubeDL(opts) as y:
            info = y.extract_info(f"ytsearch{limit}:{query}", download=False)
            return [(e.get("title","بدون عنوان"), e.get("webpage_url"))
                    for e in info.get("entries", []) if e and e.get("webpage_url")]
    return await asyncio.to_thread(work)

async def download_audio(url):
    folder = tempfile.mkdtemp(prefix="tg_music_")
    out = os.path.join(folder, "%(title)s.%(ext)s")
    def work():
        opts = {
            "format": "bestaudio/best", "outtmpl": out, "noplaylist": True,
            "postprocessors": [{"key":"FFmpegExtractAudio","preferredcodec":"mp3","preferredquality":"128"}],
            "quiet": True
        }
        with yt_dlp.YoutubeDL(opts) as y:
            info = y.extract_info(url, download=True)
            path = y.prepare_filename(info)
            base = os.path.splitext(path)[0] + ".mp3"
            return base, info.get("title","Audio")
    return await asyncio.to_thread(work)
