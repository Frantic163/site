<?php

class AuthModel {
	
	// Проверяем по базе юзера
	public function getUserAccess($arrUsr) {
		$arrQuery = Array(
			'username'=>$arrUsr['login'],
			'pwd'=>MD5($arrUsr['pwd'])
		);
                
                global $mysqli;
                
		$res = $mysqli->select('users', false, $arrQuery, "and");
                $row = $mysqli->assoc($res);
		if($res != false) {
			return true;
		}
		else {
			return false;
		}
	}
	
	// Санация входных данных
	public function sanitizeAuth($uLogin,$uPwd) {
		$arrData = Array();
		$sanObj = new CSanitize;
		$arrData['login'] = $sanObj->dataSanation($uLogin, 'login');
		$arrData['pwd'] = $sanObj->dataSanation($uPwd, 'password');
		// если данные некорректны - возвращаем false
		if(($arrData['login'] == false)||($arrData['pwd'] == false)) return false;
		return $arrData;
	}
}
