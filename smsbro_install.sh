set -e
echo -n "You should configure the httpd server to allow .htaccess. You can do it later after installation. (N = abort, Y = continue) :"
read continue
if $continue=="N" then
	exit
fi

pwd=${pwd}
clear
cd /tmp/
#url='https://github.com/herpiko/smsbro/archive/master.tar.gz'
#echo -n "Downloading...    "
#wget --progress=dot $url 2>&1 | grep --line-buffered "%" | sed -u -e "s,\.,,g" | awk '{printf("\b\b\b\b%4s", $2)}'
#echo -ne "\b\b\b\b"
#echo " Done."
#tar -xvf master.tar.gz
#clear
echo "Type the DocumentRoot path in your system."
echo -n "(Leave it blank then the path will set to /var/www/htdocs) : "
read rootpath
echo "Type the path where smsbro will be installed."
echo -n " (Leave it blank then smsbro will installed in the http's root directory) : "
read path
fullpath="$rootpath/$path"
echo "$fullpath"
echo -n "MySQL host : "
read host
echo -n "MySQL user : "
read user
echo -n "MySQL password : "
read passwd

mkdir  -p $path
cp -vR /tmp/smsbro-master/* $fullpath
rm -rf /tmp/smsbro-master/

cd $fullpath


clear
echo "smsbro successfully installed. Please test it at http://localhost/$path"
cd $pwd
