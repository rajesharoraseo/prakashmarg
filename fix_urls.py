import os, glob

files = glob.glob('c:/PrakashMarg/wp-content/themes/prakash-marg/**/*.html', recursive=True)
for f in files:
    with open(f, 'r', encoding='utf-8') as file:
        content = file.read()
    
    content = content.replace('href="/', 'href="/prakashmarg/')
    content = content.replace('action="/', 'action="/prakashmarg/')
    content = content.replace('href="/prakashmarg/prakashmarg/', 'href="/prakashmarg/')
    content = content.replace('action="/prakashmarg/prakashmarg/', 'action="/prakashmarg/')
    
    with open(f, 'w', encoding='utf-8') as file:
        file.write(content)
print('Fixed URLs!')
