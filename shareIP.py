#!/usr/bin/python3

import os
import qrcode # INSTALL python3-qrcode package
import qrcode.image.svg

#TMP IP MANUAL
ip_address="http://192.168.1.123/taboo"

###IP MANUAL

# QR code generation
ip_qr_code = qrcode.make(ip_address, box_size=32, image_factory=qrcode.image.svg.SvgPathImage) # generate svg qr code
svg_qr = ip_qr_code.to_string() # raw svg file
svg_html=svg_qr.decode()
svg_html = svg_html.replace("<svg ", "<svg class='svgstyle' ")

# HTTP page generation
print("Content-type: text/html; charset=utf-8\r\nCache-Control: no-cache\r\n")
print("<!DOCTYPE html>\n<html>\n<head><title>openTaboo QR</title>")
print("<style>.svgstyle{")
print("fill:#0000ff;border:4px groove #5fff5f;border-radius:16px;background-image:linear-gradient(45deg,#7fff7f,#ffff3f);}")
print("</style>\n</head>\n<body>")
print("<div style='text-align:center;'>")
print("<h1 style='color:green;'>openTaboo QR 🔗</h2>")
print(svg_html)
print("<h2>"+ip_address+"</h2>")
print("</div>")
print("</body>\n</html>")
