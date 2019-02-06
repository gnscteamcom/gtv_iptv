#!/bin/bash

IPADDRESS=$(hostname -I | sed "s/ //g");
SSHPORT=$(sshd -T | head -n 1 | awk '{print $2}');

UPTIME="$(uptime)";
BANDWIDTH="$(sh get_bandwidth.sh eth0)";