path = r'c:\PrakashMarg\wp-content\themes\prakash-marg\templates\front-page.html'
with open(path, 'r', encoding='utf-8') as f:
    content = f.read()

content = content.replace(
    '<a href="/prakashmarg/quote" class="hero-pill">?? ???????</a>',
    '<a href="/prakashmarg/quote" class="hero-pill">?? ???????</a>\n        <a href="/prakashmarg/shop" class="hero-pill" style="background: var(--gd); border: none; color: #fff;">?? ?-?????</a>'
)

with open(path, 'w', encoding='utf-8') as f:
    f.write(content)
print('Added store pill')
