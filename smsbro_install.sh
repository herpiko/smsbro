#!/bin/bash
if [ "$(id -u)" != "0" ]; then
   echo "Skrip ini mesti dijalankan oleh root. Anda bisa juga menggunakan sudo." 1>&2
   exit 1
fi
set -e
echo ""
echo "SMSBro-installer v.0.1.4 (kompatibel untuk gammu 1.30 atau di atasnya)"
echo ""
echo "Halo,"
echo "Skrip ini dirancang untuk Debian dan turunannya dan akan memasang SMSBro pada sistem anda."
echo "Sebelum melanjutkan, anda perlu :"
echo ""
echo "- internet."
echo "- lingkungan apache2-mysql-php siap pakai di sistem anda."
echo "- memastikan bahwa gammu dan gammu-smsd sudah terpasang di sistem anda."
echo "- mengkonfigurasi agar http server (apache) anda mengizinkan penggunaan .htaccess."
echo ""
echo "Tekan tombol enter untuk melanjutkan..."
read continue

pwd=${pwd}
clear
cd /tmp/
rm -rf master*

echo " "
echo "Tuliskan lokasi root directory dari web server di sistem anda."
echo -n "(Jika dikosongkan, maka akan diset ke /var/www/html) : "
read rootpath
if [[ -z "$rootpath" ]]; then
	rootpath="/var/www/html"
fi
echo ""
echo "Tuliskan lokasi di bawah $rootpath, dimana SMSBro ingin dipasang."
echo -n "(Jika dikosongkan, maka SMSBro akan terpasang di root directory) : "
read path
if [[ -z "$path" ]]; then
	fullpath="$rootpath"
fi
fullpath="$rootpath/$path"

echo ""
echo "Anda perlu mengisi informasi di bawah ini untuk database SMSBro"
echo -n "MySQL host : "
read host
echo -n "MySQL user : "
read user
echo -n "MySQL password : "
read passwd
# echo ""
# echo "Anda perlu mengisi informasi di bawah ini untuk database gammu-smsd (smsd)."
# echo "Anda boleh tidak mengisinya (kosong) jika smsd terletak pada MySQL server yang sama dengan database SMSBro"
# echo -n "SMSD's MySQL host : "
# read smsdhost
# if [[ -z "$smsdhost" ]]; then
# 	smsdhost="$host"
# fi
# echo -n "SMSD's MySQL user : "
# read smsduser
# if [[ -z "$smsduser" ]]; then
# 	smsduser="$user"
# fi
# echo -n "SMSD's MySQL password : "
# read smsdpasswd
# if [[ -z "$smsdpasswd" ]]; then
# 	smsdpasswd="$passwd"
# fi

echo ""
echo "SMSBro akan dipasang di $fullpath"
echo ""
echo "Tekan tombol enter untuk melanjutkan..."
read continue

url='https://github.com/herpiko/smsbro/archive/master.tar.gz'
#url='http://localhost/download/master.tar.gz'
echo -n "Sedang mengunduh. Mohon menunggu...    "
echo -n "    "
    wget --progress=dot $url 2>&1 | grep --line-buffered "%" | sed -u -e "s,\.,,g" | awk '{printf("\b\b\b\b%4s", $2)}'
    echo -ne "\b\b\b\b"
    echo " Selesai."
echo ""
tar -xvf master.tar.gz
clear

mkdir  -p $fullpath
cp -vR /tmp/smsbro-master/* $fullpath
rm -rf /tmp/smsbro-master/

cd $fullpath
sed -i -e 's/php\/smsbro/'$path'/g' application/config/config.php
sed -i -e 's/localhost/'$host'/g' application/config/database.php
sed -i -e 's/root/'$user'/g' application/config/database.php
sed -i -e 's/passwd/'$passwd'/g' application/config/database.php
mv htaccess .htaccess
sed -i -e 's/php\/smsbro/'$path'/g' .htaccess
mkdir -p /opt/smsbro
cp -vR $fullpath/opt/* /opt/smsbro/
mv /opt/smsbro/gammu-smsdrc /etc/gammu-smsdrc
sed -i -e 's/root/'$user'/g' /etc/gammu-smsdrc
sed -i -e 's/passwd/'$passwd'/g' /etc/gammu-smsdrc
sed -i -e 's/localhost/'$host'/g' /etc/gammu-smsdrc
chmod a+x /opt/smsbro/*

result=`mysql -u $user -p$passwd --skip-column-names -e "SHOW DATABASES LIKE 'smsbro'"`
if [ -z "$result" ]; then
    echo "Database does not exist"
mysql -u "$user" --password="$passwd" -h "$host" -e "CREATE DATABASE smsbro"
mysql -u "$user" --password="$passwd" -h "$host" smsbro < "$fullpath"/db/smsbro.sql
else
    echo "Database exist"
mysql -u "$user" --password="$passwd" -h "$host" -e "DROP DATABASE smsbro"
mysql -u "$user" --password="$passwd" -h "$host" -e "CREATE DATABASE smsbro"
mysql -u "$user" --password="$passwd" -h "$host" smsbro < "$fullpath"/db/smsbro.sql
fi

result=`mysql -u $user -p$passwd --skip-column-names -e "SHOW DATABASES LIKE 'smsd'"`
if [ -z "$result" ]; then
    echo "Database does not exist"
mysql -u "$user" --password="$passwd" -h "$host" -e "CREATE DATABASE smsd"
mysql -u "$user" --password="$passwd" -h "$host" smsd < "$fullpath"/db/smsd.sql
else
    echo "Database exist"
fi

clear
echo "SMSBro telah berhasil dipasang."
echo "Selanjutnya anda perlu mengkonfigurasi /etc/gammu-smsdrc untuk perangkat GSM anda dan memastikan gammu-smsd bekerja dengan baik."
echo "Setelah menjalankan service gammu-smsd, anda bisa mencobanya langsung di http://localhost/$path"
echo "Gunakan :"
echo "   user : admin"
echo "   passwd : admin"
echo "untuk masuk."
echo ""
echo "Tekan tombol enter untuk keluar..."
read continue
cd $pwd
clear
