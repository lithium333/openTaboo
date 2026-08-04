# openTaboo
LAN server to play the popular Taboo game, all you need is a GNU Linux PC with a few components installed listed below:
- Apache webserver
- Apache PHP8 module
- Apache CGI module
- Python 3.x
- Python qrcode module
- g++ toolchain to compile the cgi modules
- boost/interprocess c++ library

# The admin panel
![Preview](https://github.com/lithium333/openTaboo/blob/main/preview1.png?raw=true)

# Game running trough mobile browser
![Preview 2](https://github.com/lithium333/openTaboo/blob/main/preview2.png?raw=true)

# configuration essentials
- setup apache: enable CGI, add rules for (.bin .cgi .py) files : enable execution, disable compression or any caching method
- setup /cards subdir and 
- compile each c++ using the indicated output name by the comment and make it excutable by www-data
- edit .py file to match the exact network interface for which display local IP
- make the .py file executable by www-data
