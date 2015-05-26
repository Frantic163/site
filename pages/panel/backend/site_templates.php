<?php

// Подключаем файлы ядра
require('../protected/index.php');

// 1. Если сессия создана:
if(is_array($isSession)) {
	// 1.1. Если пользователь авторизован
	if(isset($isSession['uname'])) {
	
		if(!isset($_POST['act'])) die('error;2');
		
		$objSan = new CSanitize;
		$act = $objSan->dataSanation($_POST['act'], 'cleartext');
		if(!$act) die('error;3');
		$objDB = new DBQuery;
		
		if($act == 'add') {
			/*if(!isset($_POST['code'])) die('error;5');
			$code = $objSan->dataSanation($_POST['code'], 'clearnumber');
			if(!$code) die('error;6');
			
			if(isset($_POST['name'])) {
				$name = $objSan->dataSanation($_POST['name'], 'plaintext');
				if(!$name) die('error;7');
			}
			else $name = false;
			
			$res = $objDB->getQuery("SELECT COUNT(*) FROM `inh_hubs` WHERE `hub_number`=" . $hub . " AND `activation`=" . $code . " AND `active`=0");
			$currCnt = $res[0][0] * 1;
			if($currCnt == 0) die('notfnd;0');
			
			$query = "UPDATE `inh_hubs` SET `username`='" . $isSession['uname'] . "', `active`=1";
			if($name) $query .= ", `name`='" . $name . "'";
			$query .= " WHERE `hub_number`=" . $hub;
			$res = $objDB->getQuery($query);
			if(!$name) {
				$query = "SELECT * FROM `inh_hubs` WHERE `hub_number`=$hub";
				$res = $objDB->getQuery($query);
				$name = $res[0]['name'];
			}*/
			echo 'gut;' . $name;
		}
		elseif($act == 'del') {
			/*$query = "UPDATE `inh_hubs` SET `active`=0 WHERE `hub_number`=" . $hub;
			$objDB->getQuery($query);*/
			echo 'gut;0';
		}
		elseif($act == 'edit') {
			if(!isset($_POST['tmpl'])) die('error;8');
			$tmpl = $objSan->dataSanation($_POST['tmpl'], 'plaintext');
			if(!$tmpl) die('error;9');
			
			$query = "UPDATE `" . $dbpref . "settings` SET `value`='" . $tmpl . "' WHERE `name`='STR_TEMPLATE_NAME' LIMIT 1";
			$objDB->getQuery($query);
			$query = "UPDATE `" . $dbpref . "settings` SET `value`='/templates/" . $tmpl . "' WHERE `name`='STR_TEMPLATE_PATH' LIMIT 1";
			$objDB->getQuery($query);
			echo 'gut;0';
		}
		else echo 'error;4';
	
	}
	// 1.2. Если не авторизован - отправляем на авторизацию
	else {
		echo "error;744";
	}
}
// 2. Если сессия не найдена - отправляем на авторизацию
else {
	echo "error;744";
}

?>