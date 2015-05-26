<?php

class SessionInfo {
	
	// Стартуем сессию
	public function __construct() {
		session_start();
	}
	
	// Функция возвращает массив данных о сессии пользователя
	public function getUserSession() {
                if((!isset($_SESSION['uname']))&&(!isset($_SESSION['try_cnt']))){
                    return false;  
                } else {
			$arrSession = array();
                        if(isset($_SESSION['uname'])){
                            $arrSession = $_SESSION;
                        } else {
				// Устанавливаем счетчик попыток подключения
				if(isset($_SESSION['try_cnt'])) {
					$tmpCnt = $_SESSION['try_cnt'];
					$tmpCnt++;
                                } else {
                                    $tmpCnt = 1;    
                                } 
				$_SESSION['try_cnt'] = $tmpCnt;
				$arrSession['try_cnt'] = $tmpCnt;
				// Записываем IP пользователя (зарезервировано)
				$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
				$arrSession['ip'] = $_SESSION['ip'];
			}
			return $arrSession;
		}
	}
	
	// Функция задает данные сессии пользователя
	public function setSessionParams($way, $arrData) {
                global $mysqli;
            
		// Попытка входа без параметров или с неверными параметрами
		if($way === 1) {
			if(!isset($_SESSION['try_cnt'])) {
				$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
				$tmpCnt = 1;
			}
			else {
				$tmpCnt = $_SESSION['try_cnt'];
				$tmpCnt++;
			}
			$_SESSION['try_cnt'] = $tmpCnt;
		}
		// Добавление данных об авторизованном пользователе
		else {
			$_SESSION['try_cnt'] = 0;
			$arrQuery = Array(
				'username'=>$arrData['login'],
				'pwd'=>MD5($arrData['pwd']),
			);
			$res = $mysqli->select('users', false, $arrQuery, "and");
                        $row = $mysqli->assoc($res);
			if(!is_array($row)) die("Error: session can't start");
                            $_SESSION['uname'] = $row['username'];
                            $_SESSION['email'] = $row['email'];
                            $_SESSION['access'] = $row['role'] * 1;
		}
	}
	
	// Закрываем сессию пользователя
	public function destroySession() {
		unset($_SESSION['uname']);
		unset($_SESSION['email']);
		unset($_SESSION['access']);
		unset($_SESSION['try_cnt']);
		unset($_SESSION['ip']);
		session_destroy();
	}
}
