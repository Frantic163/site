<?php

// Подключаем файлы ядра
require('../protected/index.php');

// 1. Если сессия создана:
if(is_array($isSession)) {
	// 1.1. Если пользователь авторизован
	if(isset($isSession['uname'])) {
	
		if(!isset($_POST['old']) || !isset($_POST['login']) || !isset($_POST['email'])) die('error;1');
		
		$objSan = new CSanitize;
		$old = $objSan->dataSanation($_POST['old'], 'plaintext');
		$login = $objSan->dataSanation($_POST['login'], 'plaintext');
		$email = $objSan->dataSanation($_POST['email'], 'email');
		if(!$old || !$login || !$email) die('error;2');
		
		$objDB = new DBQuery;
		
		$query = "SELECT * FROM `inh_users` WHERE `username`='" . $login . "' OR `email`='" . $email . "'";
		$res = $objDB->getQuery($query);
		foreach($res as $usr) {
			if($old != $usr['username']) die('isfind;0');
		}
		$query = "UPDATE `inh_users` SET `username`='" . $login . "', `email`='" . $email . "'";
		if(isset($_POST['pwd'])) {
			$pwd = $objSan->dataSanation($_POST['pwd'], 'password');
			if(!$pwd) die('error;3');
			$query .= ", `pwd`=MD5('" . $pwd . "')";
		}
		if(isset($_POST['fname'])) {
			$fname = $objSan->dataSanation($_POST['fname'], 'plaintext');
			if(!$fname) die('error;4');
			$query .= ", `fname`='" . $fname . "'";
		}
		if(isset($_POST['lname'])) {
			$lname = $objSan->dataSanation($_POST['lname'], 'plaintext');
			if(!$lname) die('error;4');
			$query .= ", `lname`='" . $lname . "'";
		}
		$query .= " WHERE `username`='" . $old . "'";
		$objDB->getQuery($query);
		echo 'gut;0';
	}
	// 1.2. Если не авторизован - отправляем на авторизацию
	else {
		echo "error;unautorized";
	}
}
// 2. Если сессия не найдена - отправляем на авторизацию
else {
	echo "error;unautorized";
}

?>