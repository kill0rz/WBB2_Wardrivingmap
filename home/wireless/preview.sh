#!/bin/sh
#test if all variables are set

if [ -z $1 ]; then
 exit
fi

#timestamp
current_time=$(date "+%s")

#$1 = uploaded file.netxml

cd /var/www/wbb2/wardrivingmap/

#Backup
chmod 0777 ./todo/$1
mkdir ./tmp/$current_time/
cp ./todo/$1 ./tmp/$current_time/$1
cp ./template/index.php ./tmp/$current_time/index.php
cd ./tmp/$current_time/
#Launch Kismet
giskismet -x ../../todo/$1
giskismet -q "select * from wireless" -o output.kml
echo "https://forum/wbb2/wardrivingmap/tmp/"$current_time"/index.php?timestamp="$current_time
