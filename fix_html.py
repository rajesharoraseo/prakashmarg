path1 = r'c:\PrakashMarg\wp-content\themes\prakash-marg\templates\front-page.html'
with open(path1, 'r', encoding='utf-8') as f:
    content = f.read()

urls = [
    'panchang', 'chalisa-library', 'bhajan', 'mantra', 
    'puja-vidhi', 'vrat-tyohar', 'tirth-yatra', 
    'rashifal', 'quote', 'shop'
]

for url in urls:
    content = content.replace(f'href="/prakashmarg/{url}"', f'href="/prakashmarg/index.php/{url}"')

with open(path1, 'w', encoding='utf-8') as f:
    f.write(content)

path2 = r'c:\PrakashMarg\wp-content\themes\prakash-marg\templates\single.html'
with open(path2, 'r', encoding='utf-8') as f:
    content = f.read()

for url in urls:
    content = content.replace(f'href="/prakashmarg/{url}"', f'href="/prakashmarg/index.php/{url}"')

with open(path2, 'w', encoding='utf-8') as f:
    f.write(content)

path3 = r'c:\PrakashMarg\wp-content\themes\prakash-marg\parts\header.html'
with open(path3, 'r', encoding='utf-8') as f:
    content = f.read()

for url in urls:
    content = content.replace(f'href="/prakashmarg/{url}"', f'href="/prakashmarg/index.php/{url}"')

with open(path3, 'w', encoding='utf-8') as f:
    f.write(content)

print('Updated links in HTML files')
