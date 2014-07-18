#!/bin/bash
. /var/www/config.txt
gpio -g mode 25 out
gpio -g write 25 1
sleep $runTime
gpio -g write 25 0
echo 1
