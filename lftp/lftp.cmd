set ssl:verify-certificate no
open ftp://w0193cf6.kasserver.com
user w0193cf6 EwtWwoEF4LF2
set ftp:list-options -a

lcd theme
cd glc.steirer.info/theme

mirror -R --delete-first -P 24 -v --exclude-glob .DS_Store --exclude usage

!echo SYNCED!
