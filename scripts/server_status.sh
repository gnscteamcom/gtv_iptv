#!/bin/bash

# uuid
UUID="$(dmidecode -s system-uuid)"

# uptime
UPTIME="$(awk '{print $1}' /proc/uptime)";

# ssh port
SSHPORT="$(sshd -T | head -n 1 | awk '{print $2}')";

# cpu
CPU="$(grep 'cpu ' /proc/stat | awk '{usage=($2+$4)*100/($2+$4+$5)} END {print usage "%"}')";

# memory
RAM="$(free -m | awk 'NR==2{printf "%.2f%%\t\t", $3*100/$2 }')";

# hard drive
DISK="$(df -h | awk '$NF=="/"{printf "%s\t\t", $5}')";

# network / bandwidth stats
IPADDRESS="$(hostname -I | sed "s/ //g")";

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

JSON='{ "uuid": "'$UUID'","uptime": "'$UPTIME'", "cpu": "'$CPU'", "ram": "'$RAM'", "disk": "'$DISK'", "ip": "'$IPADDRESS'", "bandwidth_down": "'$RBPS'", "bandwidth_up": "'$TBPS'" }'

curl -i -H "Accept: application/json" -H "Content-Type:application/json" -X POST --data '{ "uuid": "'$UUID'","uptime": "'$UPTIME'", "cpu": "'$CPU'", "ram": "'$RAM'", "disk": "'$DISK'", "ip": "'$IPADDRESS'", "bandwidth_down": "'$RBPS'", "bandwidth_up": "'$TBPS'" }' "https://genexnetworks.net/gtv_portal/api/?server_update"