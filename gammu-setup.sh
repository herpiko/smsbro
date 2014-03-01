#!/bin/bash
set -e
whoami=$(whoami)
pwd=${pwd}
devicelist=$(lsusb)
echo $devicelist
lsusb
echo $whoami