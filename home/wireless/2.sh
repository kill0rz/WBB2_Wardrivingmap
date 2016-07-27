#!/bin/sh
#test if all variables are set

if [ -z $1 ]; then
 exit
fi

#timestamp
current_time=$(date "+%s")

#$1 = uploaded file.netxml

cd /var/www/forum/wbb2/wardrivingmap/
#Backup
chmod 0777 ./todo/$1
cp wireless.dbl ./backups/db/wireless.dbl.$current_time
cp ./todo/$1 ./backups/netxml/$1.$current_time
mv output.kml ./backups/kml/output.kml.$current_time

#Launch Kismet for global
giskismet -x ./todo/$1 > giskismet_output.txt
giskismet -q "select * from wireless" -o output.kml
rm giskismet_output.txt
php wardrivingmap_notify.php 1

#Launch Kismet for local
var_date=`php parse_date.php ./todo/$1`
cd ./kml/$var_date/
giskismet -x ../../todo/$1
giskismet -q "select * from wireless" -o output.kml

#delete
cd ../../
rm ./todo/$1
cd ../
