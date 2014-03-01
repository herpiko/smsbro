#/bin/bash
CHECK=$0
SERVICE=$1
DATE=`date`
OUTPUT=$(ps cax | grep -v grep | grep -v $CHECK |grep $1)
#echo $OUTPUT
if [ "${#OUTPUT}" -gt 0 ] ;
then echo "1"
else echo "0"
fi
