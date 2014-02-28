killall -9 gammu-smsd
rm -rf /var/log/gammu/smsdlog
touch /var/log/gammu/smsdlog
gammu-smsd -d
