<?php

// Подключаем файлы ядра
require('../protected/index.php');

// 1. Если сессия создана:
if(is_array($isSession) || $_POST['name'] == 'tickets') {
	// 1.1. Если пользователь авторизован
	if(isset($isSession['uname']) || $_POST['name'] == 'tickets') {
		
		// Проверяем наличие необходимых данных
		if((!isset($_POST['name']))||(!isset($_POST['act']))) {
			echo 'error: data failed;null';
			exit;
		}
		// Санация входных данных
		$objSan = new CSanitize;
		$name = $objSan->dataSanation($_POST['name'], 'cleartext');
		$act = $objSan->dataSanation($_POST['act'], 'cleartext');
		if(($name == false)||($act == false)) {
			echo 'error: data failed;null';
			exit;
		}
		
		// Выбираем нужную таблицу
		switch($name) {
			case 'ticket':
				if($act == 'new') $tblName = 'ticket_thread';
				else {
					$tblName = 'ticket_message';
				}
				break;
			default:
				$tblName = $name;
		}
		
		// Если действие - удаление
		if($act == 'del') {
			// проверяем и форматируем данные
			if(!isset($_POST['rid'])) {
				echo 'error1';
				exit;
			}
			$rid = $objSan->dataSanation($_POST['rid'],'clearnumber');
			if(!$rid) {
				echo 'error2';
				exit;
			}
			
			// Подключаем БД и сносим нах данные
			$objDB = new DBQuery;
			if(!$objDB->delData($tblName, $rid)) echo 'error3';
			else echo 'gut!';
		}
		// Если действие - обновление параметров
		elseif($act == 'edit_setts') {
			// Подключаемся к БД
			$objDB = new DBQuery;
			$errFlag = 0;
			foreach($_POST as $key=>$val) {
				// формируем данные
				if(strpos($key, "lp_") !== false) {
					$tmpArr = str_replace("lp_", "", $key);
					$tmpKey = strtoupper($tmpArr);
					$sanKey = 'plaintext';
					if(($tmpKey == 'PAGE')||($tmpKey == 'DRAFT_PAGE')) $sanKey = 'fullhtml';
					if($val === 'null') $tmpVal = NULL;
					else {
						$tmpVal = $objSan->dataSanation($val, $sanKey);
						if($tmpVal === false) {
							echo 'error: incorrect data;null';
							exit;
						}
					}
					
					// и обновляем данные
					$arrData = array($tmpKey => $tmpVal);
					$res = $objDB->changeData($tblName,NULL,$arrData);
					if(!$res) {
						$errFlag = 1;
						break;
					}
				}
			}
			// Отправляем сообщение о результате обновления БД
			if($errFlag === 1) echo 'error: data save failed;null';
			else {
				if(isset($_POST['react'])) echo 'gut!;/lasta/'.$_POST['react'].'/';
				else echo "gut!;/lasta/workspace/";
			}
		}
		// Если действие - запись или обновление
		elseif(($act == 'new')||($act == 'add')||($act == 'edit')) {
			// подготавливаем данные для записи
    			$arrData = array();
			foreach($_POST as $key=>$val) {
				if((strpos($key, "msg-") !== false)&&(strpos($key, "-lbl") === false)) {
					$tmpArr = explode("-", $key);
					$tmpKey = $tmpArr[1];
					// проверяем входные данные
					$sanKey = 'plaintext';
					if(($tmpKey == 'login')||($tmpKey == 'user')) $sanKey = 'login';
					elseif($tmpKey == 'passwd') $sanKey = 'password';
					elseif($tmpKey == 'email') $sanKey = 'email';
					elseif($tmpKey == 'ref') $sanKey = 'uri';
					$tmpVal = $objSan->dataSanation($val, $sanKey);
					if($tmpVal === false) {
						echo 'error: incorrect data;null';
						exit;
					}
					if($tmpKey != 'passwd')	$arrData[$tmpKey] = $tmpVal;
					else $arrData[$tmpKey] = MD5($tmpVal);
				}
			}
			
			if(!is_array($arrData)) {
				echo 'error: data formatted failed;null';
				exit;
			}
			
			// Подключаемся к БД
			$objDB = new DBQuery;
			
			// и или обновляем данные
			if($act == 'edit') {
				if(!isset($_POST['rid'])) {
					echo 'error: incorrect data1;null';
					exit;
				}
				$rid = $objSan->dataSanation($_POST['rid'],'clearnumber');
				if(!$rid) {
					echo 'error: incorrect data;null';
					exit;
				}
				
				$res = $objDB->changeData($tblName,$rid,$arrData);
				if($res === false) echo 'error: data save failed;null';
				else echo 'gut!;/lasta/users/';
			}
			// или записываем новые
			elseif(($act == 'new')||($act == 'add')) {
				// Если есть поле пароля - проверяем существование юзеров с одинаковым логином и мылом
				if(array_key_exists('passwd',$arrData)) {
					$arrQuery1['user'] = $arrData['user'];
					$arrQuery2['email'] = $arrData['email'];
					$res1 = $objDB->getData('users',$arrQuery1);
					$res2 = $objDB->getData('users',$arrQuery2);
					if((is_array($res1))||(is_array($res2))) {
						echo 'error: login and/or email is used;null';
						exit;
					}
				}
			
				// и записываем данные в таблицу
				if($tblName == 'ticket_thread') {
					// Код для таблиц тикетов
					$tmpArrData = array(
						'uid'=>$isSession['uid'],
						'head'=>$arrData['head'],
					);
					if(!$objDB->insertData($tblName, $tmpArrData)) {
						echo 'error: data save failed;null';
						exit;
					}
					$resSave = $objDB->getData($tblName, $tmpArrData);
					if(!is_array($resSave)) {
						echo 'error: data save failed;null';
						exit;
					}
					$tId = $resSave[0]['id'];
					$tmpArrData = array(
						'thread_id'=>$tId,
						'msg'=>$arrData['msg'],
						'last_user'=>$isSession['uname'],
					);
					if(!$objDB->insertData('ticket_message', $tmpArrData)) {
						echo 'error: data save failed;null';
						exit;
					}
					echo "Сообщение успешно отправлено;/lasta/support/index.php?act=ticket";
				}
				elseif($tblName == 'ticket_message') {
					// отдельно - код добавления мессаджа тикета в тред
					$tId = $objSan->dataSanation($_POST['tid'], 'clearnumber');
					// $tId = $tId_ * 1;
					$tmpArrData = array(
						'thread_id'=>$tId,
						'msg'=>$arrData['msg'],
						'last_user'=>$isSession['uname'],
					);
					if(!$objDB->insertData('ticket_message', $tmpArrData)) {
				    		echo 'error: data save failed;null';
						exit;
					}
					echo "Сообщение успешно отправлено;/lasta/support/index.php?act=ticket";
				}
				else {
					// Общий случай записи данных
					if(!$objDB->insertData($tblName, $arrData)) {
						echo 'error: data save failed;null';
						exit;
					}
					echo "Данные успешно отправлены;/lasta/".$tblName."/";
				}
			}
		}
	}
	// 1.2. Если не авторизован - отправляем на авторизацию
	else {
		echo "error: unautorized;null";
	}
}
// 2. Если сессия не найдена - отправляем на авторизацию
else {
	echo "error: unautorized;null";
}

?>