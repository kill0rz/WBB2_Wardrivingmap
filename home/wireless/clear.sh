#!/bin/sh
cd /var/www/wbb2/wardrivingmap
rm -R ./tmp
mkdir tmp
cp ./template/.htaccess ./tmp/.htaccess
chmod 0777 tmp
