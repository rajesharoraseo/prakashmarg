import requests
from bs4 import BeautifulSoup
import time
import json
import re

WP_IMPORT_URL = 'http://localhost/prakashmarg/pm_import.php'

TARGETS = [
    {
        'url': 'https://hindi.webdunia.com/aarti-chalisa/hanuman-chalisa-hindi-117011600061_1.html',
        'title': 'श्री हनुमान चालीसा (सम्पूर्ण) - WebDunia',
        'type': 'pm_scripture',
        'slug': 'shri-hanuman-chalisa-webdunia',
        'meta': {'scripture_type': 'chalisa', 'language': 'hindi', 'historical_period': 'Modern'}
    },
    {
        'url': 'https://www.bhaktibharat.com/aarti/shri-hanuman-ji-ki-aarti',
        'title': 'श्री हनुमान जी की आरती - BhaktiBharat',
        'type': 'pm_scripture',
        'slug': 'hanuman-aarti-bhaktibharat',
        'meta': {'scripture_type': 'aarti', 'language': 'hindi', 'historical_period': 'Ancient'}
    },
    {
        'url': 'https://krishnadas.com/lyrics/hanuman-chaleesa/',
        'title': 'Hanuman Chaleesa Lyrics - KrishnaDas',
        'type': 'pm_scripture',
        'slug': 'hanuman-chalisa-krishnadas',
        'meta': {'scripture_type': 'chalisa', 'language': 'english', 'historical_period': 'Modern'}
    }
]

def clean_text(text):
    return re.sub(r'\s+', ' ', text).strip()

def extract_content(soup, url):
    """Universal content extractor for spiritual lyrics/articles"""
    content_html = ""
    
    # 1. Try to find the main content container
    content_area = (
        soup.find('div', class_='article-content') or 
        soup.find('div', class_='entry-content') or 
        soup.find('div', class_='post-content') or 
        soup.find('article') or 
        soup.find('main') or
        soup.find('div', id='content') or
        soup.body
    )
    
    if not content_area:
        return ""

    # Strategy A: Paragraphs (WebDunia usually uses this)
    paragraphs = content_area.find_all('p')
    valid_ps = [p.get_text(strip=True) for p in paragraphs if len(p.get_text(strip=True)) > 20]
    
    # Strategy B: Divs with br tags (BhaktiBharat and KrishnaDas often use this)
    if len(valid_ps) < 5:
        # If there are very few paragraphs, the lyrics might be in divs separated by <br>
        # Let's extract all text nodes and group them
        for br in content_area.find_all('br'):
            br.replace_with('\n')
            
        raw_text = content_area.get_text(separator='\n')
        lines = [line.strip() for line in raw_text.split('\n') if line.strip()]
        
        # Filter out lines that look like navigation/ads
        valid_lines = [line for line in lines if len(line) > 10 and len(line) < 150]
        
        # Group every 2-4 lines into a stanza (paragraph)
        stanzas = []
        current_stanza = []
        for line in valid_lines:
            current_stanza.append(line)
            if len(current_stanza) >= 2: # 2 lines per stanza
                stanzas.append("<br>".join(current_stanza))
                current_stanza = []
        if current_stanza:
            stanzas.append("<br>".join(current_stanza))
            
        for stanza in stanzas:
            content_html += f"<p style='text-align:center; font-size:18px; margin-bottom:15px; color:#4a2b0f; line-height: 1.8;'>{stanza}</p>\n"
            
    else:
        # Paragraph strategy was successful
        for text in valid_ps:
            # Skip obvious ad texts or short navigation
            if len(text) > 15 and "Click here" not in text and "Read more" not in text:
                content_html += f"<p style='text-align:center; font-size:18px; margin-bottom:15px; color:#4a2b0f; line-height: 1.8;'>{text}</p>\n"

    return content_html

def scrape_url(url):
    print(f"Scraping: {url} ...")
    try:
        headers = {
            'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            'Accept-Language': 'hi-IN,hi;q=0.9,en-US;q=0.8,en;q=0.7'
        }
        response = requests.get(url, headers=headers, timeout=10)
        response.raise_for_status()
        
        response.encoding = response.apparent_encoding
        soup = BeautifulSoup(response.text, 'html.parser')
        
        return extract_content(soup, url)
        
    except Exception as e:
        print(f"Error scraping {url}: {e}")
        return ""

def publish_to_wp(title, content, post_type, meta, slug):
    payload = {
        'title': title,
        'content': content,
        'post_type': post_type,
        'slug': slug
    }
    payload.update(meta)
    
    try:
        response = requests.post(WP_IMPORT_URL, json=payload, headers={'Content-Type': 'application/json'})
        result = response.json()
        if result.get('success'):
            print(f"✅ Success: {title} (ID: {result['post_id']}) -> /prakashmarg/{post_type}/{slug}/")
        else:
            print(f"❌ Failed: {title} - {result.get('error')}")
    except Exception as e:
        print(f"❌ Connection Error: {e}")

if __name__ == "__main__":
    print("=============================================")
    print("🚀 Prakash Marg Universal Scraper Bot 🚀")
    print("=============================================\n")
    
    for target in TARGETS:
        content = scrape_url(target['url'])
        if content:
            publish_to_wp(target['title'], content, target['type'], target['meta'], target['slug'])
            print(f"Extracted {len(content)} bytes of HTML.\n")
        else:
            print(f"⚠️ No content found for {target['title']}\n")
        time.sleep(2) # Be polite to servers
    
    print("✅ All done!")
