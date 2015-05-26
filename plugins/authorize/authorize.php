<?php

if(file_exists(dirname(__FILE__) . '/lang/' . STR_LANG . '/phrases.php')) include(dirname(__FILE__) . '/lang/' . STR_LANG . '/phrases.php');

if(!isset($arrParams[0]['name'])) $tmpHtml = '<span color="red">' . $plugin_error . '</span>';
else {
	$outType = 0;
	foreach($arrParams as $param) {
		if($param['name'] == 'loginform') {
			$outType = 1;
			break;
		}
		if($param['name'] == 'register') {
			$outType = 2;
			break;
		}
		if($param['name'] == 'recovery') {
			$outType = 3;
			break;
		}
	}
	
	switch($outType) {
		case 1:
			$tmpHtml = '<h3 style="color: #c11;">' . $login_title . '</h3>
                    <form style="margin-top: 10px;" method="post" action="/auth/">
                        <input type="text" name="userlogin" value="" placeholder="' . $placeholder_login . '" style="width: 160px;"><br>
                        <input type="password" name="userpwd" value="" placeholder="' . $placeholder_pwd . '" style="width: 160px; margin-top: 6px;">
                        <br><br>
                        <input type="submit" value="' . $login_btn . '" style="float: right; margin-right: 20px;">
                        <div class="clear"></div>
                    </form>
                    <br>
                    <div class="left50">
                        <a href="javascript: void(0);" style="text-decoration: none;"><small>' . $ref_register . '</small></a>
                    </div>
                    <div class="right50 textright">
                        <a href="javascript: void(0);" style="text-decoration: none;"><small>' . $ref_recovery . '</small></a>
                    </div>';
			break;
		case 2:
			$tmpHtml = '';
			break;
		case 3:
			$tmpHtml = '';
			break;
		default:
			$tmpHtml = '<span color="red">' . $plugin_error . '</span>';
	}
}

?>