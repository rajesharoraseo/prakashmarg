path = r'C:\xampp\htdocs\prakashmarg\wp-content\themes\prakash-marg\functions.php'
with open(path, 'r', encoding='utf-8') as f:
    content = f.read()

content = content.replace("'1.0.0'", "time()")

with open(path, 'w', encoding='utf-8') as f:
    f.write(content)

print('Updated functions.php')
