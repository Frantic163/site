<?php
// Если пользователь производит действие:
if(isset($_GET['action'])) {
	// Если пользователь закончил работу - убиваем сессию (далее юзер автоматом попадет на страницу авторизации)
	if($_GET['action'] == 'logout') {
		$sess->destroySession();
		$isSession = false;
		echo "<meta http-equiv='refresh' content='0;URL=/'>";
		exit;
	}
}

// 1. Если сессия создана:
if(is_array($isSession)) {
	
	// 1.1. Если пользователь авторизован - отправляем его на страницу рабочего стола
	if(isset($isSession['uname'])) {
		if($isSession['access'] > 0) echo "<meta http-equiv='refresh' content='0;URL=/panel/cabinet/'>";
		else echo "<meta http-equiv='refresh' content='0;URL=/'>";
	}
	// 1.2. Если неавторизован - проверяем, сколько было попыток подключения
	else {
		
		// 1.2.1. Если больше установленного - выводим окошко ЖОПЫ
		if($isSession['try_cnt'] > $tryCnt) {
                    include('views/blocked.php');
		}
		// 1.2.2. Если меньше - проверяем параметры авторизации
		else {
			// 1.2.2.1. Параметры присутствуют - проверяем данные авторизации
			if((isset($_POST['userlogin']))&&(isset($_POST['userpwd']))) {
			
				$modelAuth = new AuthModel;
				$userData = $modelAuth->sanitizeAuth($_POST['userlogin'],$_POST['userpwd']);
				// Если данные некорректны - обновляем сессию и возвращаем на страницу авторизации
				if(!is_array($userData)) {
					$sess->setSessionParams(1, null);
					include('views/index.php');
					exit;
				}
				$isGranded = $modelAuth->getUserAccess($userData);
				// 1.2.2.1.1. Если есть - обновляем сессию и перенаправляем его на страницу рабочего стола
				if($isGranded == true) {
					$sess->setSessionParams(2,$userData);
					$currSession = $sess->getUserSession();
					if($currSession['access'] > 0) echo "<meta http-equiv='refresh' content='0;URL=/panel/cabinet/'>";
					else echo "<meta http-equiv='refresh' content='0;URL=/'>";
				}
				// 1.2.2.1.2. Если нет - обновляем параметры сессии и выводим страницу авторизации
				else {
					$sess->setSessionParams(1, null);
					include('views/index.php');
				}
			}
			// 1.2.2.2. Параметры отсутствуют - обновляем параметры сессии и выводим страницу авторизации
			else {
				$sess->setSessionParams(1, null);
				include('views/index.php');
			}
		}
	}
}
// 2. Если сессия не создана:
else {

	// 	  проверяем параметры для авторизации
	// 2.1. Параметры присутствуют - проверяем, есть ли пользователь в базе
	if((isset($_POST['userlogin']))&&(isset($_POST['userpwd']))) {
		
		$modelAuth = new AuthModel;
		$userData = $modelAuth->sanitizeAuth($_POST['userlogin'],$_POST['userpwd']);
		// Если данные некорректны - обновляем сессию и возвращаем на страницу авторизации
		if(!is_array($userData)) {
			$sess->setSessionParams(1, null);
			include('views/index.php');
			exit;
		}
		$isGranded = $modelAuth->getUserAccess($userData);
		// 2.1.1. Если есть - стартуем сессию и перенаправляем его на страницу рабочего стола
		if($isGranded == true) {
			$sess->setSessionParams(2, $userData);
			$currSession = $sess->getUserSession();
			if($currSession['access'] > 0) echo "<meta http-equiv='refresh' content='0;URL=/panel/cabinet/'>";
			else echo "<meta http-equiv='refresh' content='0;URL=/'>";
		}
		// 2.1.2. Если нет - создаем сессию для неавторизованного (для учета количества подключений) и выводим страницу авторизации
		else {
			$sess->setSessionParams(1, null);
			include('views/index.php');
		}
		
	}
	// 2.2. Параметры отсутствуют - создаем сессию для неавторизованного (для учета количества подключений) и выводим страницу авторизации
	else {
		$sess->setSessionParams(1, null);
		include('views/index.php');
	}
}
