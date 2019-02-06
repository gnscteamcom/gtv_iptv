<?php

# Name: Roku NowTV Setup Script
# Author: GTV
# Created: 04 Feb 2019
# Version 1.0


// vars
$ip_address 		= $argv[1];
$username 			= str_split('jamie.whittingham@gmail.com');
$password 			= str_split('admin1372');


// functions
function nowtv_login_keyboard($ip_address, $key){
	// row 1
	if($key == '1'){
		keypress($ip_address, 'Select', '0');
	}
	if($key == '2'){
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Select', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == '3'){
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == '4'){
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == '5'){
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == '6'){
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == '7'){
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == '8'){
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == '9'){
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		
	}
	if($key == '0'){
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}

	// row 2
	if($key == 'q'){
		keypress($ip_address, 'Down', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
	}
	if($key == 'w'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == 'e'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == 'r'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == 't'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == 'y'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == 'u'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == 'i'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == 'o'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == 'p'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}

	// row 3
	if($key == 'a'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
	}
	if($key == 's'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == 'd'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == 'f'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == 'g'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == 'h'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == 'j'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == 'k'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == 'l'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == '@'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}

	// row 4
	if($key == 'z'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == 'x'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == 'c'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == 'v'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == 'b'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == 'n'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == 'm'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == '-'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}
	if($key == '_'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
	}

	// row 5
	if($key == '.'){
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Down', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');
		keypress($ip_address, 'Right', '0');

		keypress($ip_address, 'Select', '0');

		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Left', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
		keypress($ip_address, 'Up', '0');
	}

	// select item
	// keypress($ip_address, 'Select', '1');

	// reset keyboard for next key
	// keypress($ip_address, 'Back', '2');
	// keypress($ip_address, 'Select', '0');
}

function keypress($ip_address, $key, $sleep = '1'){
	exec("curl --silent --output /dev/null -d '' http://".$ip_address.":8060/keypress/".$key);
	sleep($sleep);
}

function load_channel($ip_address, $channel_id, $content_id = '', $sleep = '1'){
	exec("curl --silent --output /dev/null -d '' http://".$ip_address.":8060/launch/".$channel_id."?contentID=".$content_id);
	sleep($sleep);
}


// load NowTV ready for initial login
echo "Loading NowTV login screen. \n";
load_channel($ip_address, '20242', 1402, 20);


// enter username text box
keypress($ip_address, 'Select', 2);


// enter the username
echo "Entering username: ".$username."\n";
foreach($username as $key => $value){
	nowtv_login_keyboard($ip_address, $value);
}


// enter password text box
keypress($ip_address, 'Play', 0);


// enter the password
echo "Entering password: ".$password."\n";
foreach($password as $key => $value){
	nowtv_login_keyboard($ip_address, $value);
}


// submit login details
keypress($ip_address, 'Play', 0);
keypress($ip_address, 'Select', 0);


echo "Complete. \n";