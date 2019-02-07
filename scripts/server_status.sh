#!/bin/bash

# check and install curl
command -v curl >/dev/null 2>&1 || { sudo apt install curl -y; }

# uuid
UUID="$(cat /sys/class/dmi/id/product_uuid)"

# hostname
HOSTNAME=$(hostname);

# uptime
UPTIME="$(awk '{print $1}' /proc/uptime)";

# ssh port
SSHPORT="$(sshd -T | head -n 1 | awk '{print $2}')";

# cpu
CPU=$(lscpu | grep "Model name:" | sed -r 's/Model name:\s{1,}//g');
CPU_USAGE="$(grep 'cpu ' /proc/stat | awk '{usage=($2+$4)*100/($2+$4+$5)} END {print usage "%"}')";

# memory
RAM_USAGE="$(free -m | awk 'NR==2{printf "%.2f%%", $3*100/$2 }' | sed 's/ //g')";

# hard drive
DISK_USAGE="$(df -h | awk '$NF=="/"{printf "%s", $5}')";

# network / bandwidth stats
IPADDRESS="$(ip addr | grep 'state UP' -A2 | tail -n1 | awk '{print $2}' | cut -f1  -d'/')";
# IPADDRESS="$(hostname -i)";

NIC="$(ip route get 8.8.8.8 | sed -nr 's/.*dev ([^\ ]+).*/\1/p')";
NIC="${NIC##*( )}"
IF=$NIC
R1=`cat /sys/class/net/$NIC/statistics/rx_bytes`
T1=`cat /sys/class/net/$NIC/statistics/tx_bytes`
sleep 1
R2=`cat /sys/class/net/$NIC/statistics/rx_bytes`
T2=`cat /sys/class/net/$NIC/statistics/tx_bytes`
TBPS=`expr $T2 - $T1`
RBPS=`expr $R2 - $R1`
TKBPS=`expr $TBPS / 1024`
RKBPS=`expr $RBPS / 1024`
TMBPS=`expr $TKBPS / 1024`
RMBPS=`expr $RKBPS / 1024`

curl -d '{ "uuid": "'$UUID'","hostname": "'$HOSTNAME'","uptime": "'$UPTIME'", "cpu": "n_a", "cpu_usage": "'$CPU_USAGE'", "ram_usage": "'$RAM_USAGE'", "disk_usage": "'$DISK_USAGE'", "ip_address": "'$IPADDRESS'", "bandwidth_down": "'$RKBPS'", "bandwidth_up": "'$TKBPS'" }' -H "Content-Type: application/json" -X POST https://genexnetworks.net/gtv_portal/api/server_status.php

echo "Make sure you claim your server by using the following access code."
echo "Access Code: $UUID"
