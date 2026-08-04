#!/usr/bin/python3

import os
import qrcode # INSTALL python3-qrcode package
import qrcode.image.svg

# command used to figure out ip address
parameter_ip_command_part1 = "ip a | grep " # command part 1 (prefix)
parameter_interface = "wlo1" # interface used by players (command part 2)
parameter_ip_command_part3 = " | grep inet" # command part 3 (suffix)

# command executed by OS
ip_address_raw = os.popen(parameter_ip_command_part1 + parameter_interface + parameter_ip_command_part3).read()
# output syntax: inet [DEVICEIP]/[SUBNET] brd [BROADCASTIP] ... other

# parsing output to get RAW IP
ip_address = "http://"+(ip_address_raw.split()[1]).split("/")[0]+"/taboo"

# QR code generation
ip_qr_code = qrcode.make(ip_address, box_size=32, image_factory=qrcode.image.svg.SvgImage) # generate svg qr code
svg_qr = ip_qr_code.to_string() # raw svg file

# HTTP page generation
print("Content-type: text/html; charset=utf-8\r\nCache-Control: no-cache\r\n")
print("<!DOCTYPE html>\n<html>\n<head><title>openTaboo QR</title></head>\n<body>")
print("<div style='text-align:center;'>")
print("<h1 style='color:green;'>openTaboo QR 🔗</h2>")
print(svg_qr.decode())
print("<h2>"+ip_address+"</h2>")
print("</div>")
print("</body>\n</html>")
