#!/bin/sh
cd "$(dirname "$0")"

rsync -aP --delete ssh-w0193cf6@steirer.info:/www/htdocs/w0193cf6/glc.steirer.info/docroot/ remote/
rsync -a --delete remote/wp-content/debug.log docroot/wp-content/debug.log

rsync -a --delete theme/ docroot/wp-content/themes/theme
rsync -a --delete theme/ remote/wp-content/themes/theme

unison docroot remote -batch -perms 0 -ui text -ignore "Name wp-config.php" -ignore "Name .DS_Store"

rsync -aP --delete --copy-dirlinks remote/ ssh-w0193cf6@steirer.info:/www/htdocs/w0193cf6/glc.steirer.info/docroot/