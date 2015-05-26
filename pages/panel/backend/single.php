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
		
		if($act == 'new') {
			if(empty($_POST['name']) || !isset($_POST['show']) || !isset($_POST['cat'])) die('error;8');
			$name = $objSan->dataSanation($_POST['name'], 'plaintext');
			$show = $objSan->dataSanation($_POST['show'], 'clearnumber');
			$cat = $objSan->dataSanation($_POST['cat'], 'clearnumber');
			if(!$name || $show === false || $cat === false) die('error;9');
			
			$values = "('$name',";
			// записываем код
			if(!empty($_POST['code'])) {
				$code = $objSan->dataSanation($_POST['code'], 'fullhtml');
				if($code) {
					$code = str_replace("\r\n", "", $code);
					$code = str_replace("\r", "", $code);
					$code = str_replace("\n", "", $code);
					$values .= "'$code',";
				}
			}
			else $values .= "NULL,";
			
			// записываем метатеги
			if(!empty($_POST['meta'])) {
				$meta = $objSan->dataSanation($_POST['meta'], 'plaintext');
				if($meta) $values .= "'$meta',";
			}
			else $values .= "NULL,";
			
			// сохраняем урл
			if(!empty($_POST['url'])) {
				$url = $objSan->dataSanation($_POST['url'], 'plaintext');
				if($url) $values .= "'$url',";
			}
			else $values .= "NULL,";
			
			$values .= "$show,$cat,'" . $isSession['uname'] . "')";
			
			$query = "INSERT INTO `" . $dbpref . "singles` (`name`,`code`,`meta`,`url`,`show`,`cat`,`author`) VALUES $values";
			
			//echo $query;
			//exit;
			
			$objDB->getQuery($query);
			
			echo 'gut;0';
		}
		elseif($act == 'del') {
			if(empty($_POST['id'])) die("error;10");
			$id = $objSan->dataSanation($_POST['id'], 'clearnumber');
			if(!$id) die("error;11");
			
			$query = "DELETE FROM `".$dbpref."singles` WHERE `id`=$id LIMIT 1";
			$objDB->getQuery($query);
			
			echo 'gut;0';
		}
		elseif($act == 'edit') {
			if(empty($_POST['id']) || empty($_POST['name']) || !isset($_POST['show']) || !isset($_POST['cat'])) die('error;8');
			$id = $objSan->dataSanation($_POST['id'], 'clearnumber');
			$name = $objSan->dataSanation($_POST['name'], 'plaintext');
			$show = $objSan->dataSanation($_POST['show'], 'clearnumber');
			$cat = $objSan->dataSanation($_POST['cat'], 'clearnumber');
			if(!$id || !$name || $show === false || $cat === false) die('error;9');
			
			$setline = "`name`='$name',";
			// записываем код
			if(!empty($_POST['code'])) {
				$code = $objSan->dataSanation($_POST['code'], 'fullhtml');
				if($code) {
					$code = str_replace("\r\n", "", $code);
					$code = str_replace("\r", "", $code);
					$code = str_replace("\n", "", $code);
					$setline .= "`code`='$code',";
				}
			}
			else $setline .= "`code`=NULL,";
			
			// записываем метатеги
			if(!empty($_POST['meta'])) {
				$meta = $objSan->dataSanation($_POST['meta'], 'plaintext');
				if($meta) $setline .= "`meta`='$meta',";
			}
			else $setline .= "`meta`=NULL,";
			
			// сохраняем урл
			if(!empty($_POST['url'])) {
				$url = $objSan->dataSanation($_POST['url'], 'plaintext');
				if($url) $setline .= "`url`='$url',";
			}
			else $setline .= "`url`=NULL,";
			
			$setline .= "`show`=$show,`cat`=$cat";
			
			$query = "UPDATE `" . $dbpref . "singles` SET $setline WHERE `id`=$id LIMIT 1";
			//echo $query;
			//exit;
			
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