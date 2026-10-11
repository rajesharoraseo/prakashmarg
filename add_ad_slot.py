path = r'c:\PrakashMarg\wp-content\themes\prakash-marg\templates\single.html'
with open(path, 'r', encoding='utf-8') as f:
    content = f.read()

affiliate_html = '''
      <div class="pm-sidebar-widget" style="background: #fff8e1; border: 2px dashed var(--go);">
        <h4 class="pm-sidebar-title" style="color: var(--gd);">?? ?-????? ?? ??????</h4>
        <p style="font-size:13px; margin-bottom:10px; color:var(--txm)">?? ????? ?? ????????? ?? ???? ??????? ????? ????? ?? ??????? ?????</p>
        <a href="/prakashmarg/shop" class="btn-outline-green" style="display:block; text-align:center; background:var(--gd); color:#fff; border:none; padding:10px;">????? ?????</a>
        <p style="text-align:center; margin-top:8px; font-size:11px;"><a href="#" style="color:var(--gm);">Amazon ?? ?????? (Affiliate)</a></p>
      </div>

      <div class="pm-sidebar-widget pm-ad-slot" style="background: #f1f1f1; text-align:center; padding: 20px 10px;">
        <p style="font-size:11px; color:#888; margin-bottom:8px;">ADVERTISEMENT</p>
        <div style="width:100%; height:250px; background:#e0e0e0; display:flex; align-items:center; justify-content:center; color:#999; font-weight:bold;">
          Google AdSense / Banner
        </div>
      </div>
'''

content = content.replace(
    '<div class="pm-sidebar-widget" style="background:linear-gradient',
    affiliate_html + '\n      <div class="pm-sidebar-widget" style="background:linear-gradient'
)

with open(path, 'w', encoding='utf-8') as f:
    f.write(content)
print('Added ad slot and affiliate')
