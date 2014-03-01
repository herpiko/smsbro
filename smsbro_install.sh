#!/bin/bash
clear
set -e
whoami=${whoami}
echo "Halo,"
echo "Skrip ini akan memasang SMSBro pada sistem anda."
echo "Sebelum melanjutkan, anda perlu :"
echo ""
echo "- internet."
echo "- memastikan bahwa gammu dan gammu-smsd telah berjalan dengan baik di sistem anda."
echo "- mengkonfigurasi gammu-smsd ke database MySQL dengan nama database smsd"
echo "- mengkonfigurasi agar http server (apache) anda mengizinkan penggunaan .htaccess."
echo ""
echo "Tekan tombol enter untuk melanjutkan..."
read continue

pwd=${pwd}
clear
cd /tmp/
rm -rf master*
url='http://localhost/download/master.tar.gz'
echo -n "Sedang mengunduh. Mohon menunggu...    "
echo -n "    "
    wget --progress=dot $url 2>&1 | grep --line-buffered "%" | sed -u -e "s,\.,,g" | awk '{printf("\b\b\b\b%4s", $2)}'
    echo -ne "\b\b\b\b"
    echo " Selesai."
echo ""
tar -xvf master.tar.gz
clear
echo " "
echo "Tuliskan lokasi root directory dari web server di sistem anda."
echo -n "(Jika dikosongkan, maka akan diset ke /var/www/htdocs) : "
read rootpath
if [[ -z "$rootpath" ]]; then
	rootpath="/var/www/htdocs"
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
echo ""
echo "SMSBro akan dipasang di $fullpath"
echo "Tekan tombol enter untuk melanjutkan..."
read continue
clear
echo ""
echo "Anda perlu mengisi informasi di bawah ini untuk database SMSBro"
echo -n "MySQL host : "
read host
echo -n "MySQL user : "
read user
echo -n "MySQL password : "
read passwd
echo ""
echo "Anda perlu mengisi informasi di bawah ini untuk database gammu-smsd (smsd)."
echo "Anda boleh tidak mengisinya (kosong) jika smsd terletak pada MySQL server yang sama dengan database SMSBro"
echo -n "SMSD's MySQL host : "
read smsdhost
if [[ -z "$smsdhost" ]]; then
	smsdhost="$host"
fi
echo -n "SMSD's MySQL user : "
read smsduser
if [[ -z "$smsduser" ]]; then
	smsduser="$user"
fi
echo -n "SMSD's MySQL password : "
read smsdpasswd
if [[ -z "$smsdpasswd" ]]; then
	smsdpasswd="$passwd"
fi

echo ""
echo "Tekan tombol enter untuk melanjutkan..."
read continue

mkdir  -p $fullpath
cp -vR /tmp/smsbro-master/* $fullpath
rm -rf /tmp/smsbro-master/

cd $fullpath
sed -i -e 's/php\/smsbro/'$path'/g' application/config/config.php
mv htaccess .htaccess
sed -i -e 's/php\/smsbro/'$path'/g' .htaccess
mkdir -p /opt/smsbro
cp -vR $fullpath/opt-bin /opt/smsbro/

mysql -u root --password="$pass" -h $host smsbro < $fullpath/db/smsbro.sql

clear
echo "SMSBro telah berhasil dipasang. Silakan dicoba di http://localhost/$path"
echo "Tekan tombol enter untuk keluar..."
read continue
cd $pwd
clear
