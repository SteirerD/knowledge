#!/bin/bash

wget https://de.wordpress.org/latest-de_DE.zip
rm -rf docroot/*
unzip latest-de_DE.zip
mv wordpress/* docroot
rm latest-de_DE.zip
rm -rf wordpress

rm -rf docroot/wp-content/plugins
mkdir docroot/wp-content/plugins
echo "<?php //Silence is golden." > docroot/wp-content/plugins/index.php

rm -rf docroot/wp-content/themes
mkdir docroot/wp-content/themes
echo "<?php //Silence is golden." > docroot/wp-content/themes/index.php
ln -s ../../../theme docroot/wp-content/themes/theme

rm -rf docroot/wp-content/languages/plugins/*
rm -rf docroot/wp-content/languages/themes/*