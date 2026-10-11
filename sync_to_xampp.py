"""
sync_to_xampp.py
Dev (c:\\PrakashMarg\\wp-content) → XAMPP (c:\\xampp\\htdocs\\prakashmarg\\wp-content)
Usage: python sync_to_xampp.py
"""
import subprocess
import sys

SRC_THEME = r"C:\PrakashMarg\wp-content\themes\prakash-marg"
DST_THEME = r"C:\xampp\htdocs\prakashmarg\wp-content\themes\prakash-marg"
SRC_MUPLUGINS = r"C:\PrakashMarg\wp-content\mu-plugins"
DST_MUPLUGINS = r"C:\xampp\htdocs\prakashmarg\wp-content\mu-plugins"

def sync(src, dst, label):
    result = subprocess.run(
        ["robocopy", src, dst, "/E", "/NFL", "/NDL", "/NJH", "/NJS"],
        capture_output=True, text=True
    )
    # robocopy returns 0-7 as success codes
    if result.returncode <= 7:
        print(f"✅ {label} synced")
    else:
        print(f"❌ {label} FAILED (code {result.returncode})")
        print(result.stderr)

if __name__ == "__main__":
    print("Syncing dev → XAMPP...")
    sync(SRC_THEME, DST_THEME, "Theme")
    sync(SRC_MUPLUGINS, DST_MUPLUGINS, "mu-plugins")
    print("Done! Refresh your browser with Ctrl+F5")
