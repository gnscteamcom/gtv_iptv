<?php

$raw = file_get_contents("http://iptv.genexnetworks.net:10810/player_api.php?username=jamie&password=M!mi1372&action=get_live_streams");

echo $raw;

