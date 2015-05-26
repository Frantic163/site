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
		
		if($act == 'del') {
			if(empty($_POST['id'])) die("error;10");
			$id = $objSan->dataSanation($_POST['id'], 'clearnumber');
			if(!$id) die("error;11");
			
			$query = "DELETE FROM `".$dbpref."categories` WHERE `id`=$id LIMIT 1";
			$objDB->getQuery($query);
			
			echo 'gut;0';
		}
		elseif($act == 'save') {
			if(empty($_POST['id']) || empty($_POST['name']) || !isset($_POST['desc']) || !isset($_POST['parent']) || !isset($_POST['access']) || !isset($_POST['meta'])) die('error;8');
			if($_POST['id'] != 'new') $id = $objSan->dataSanation($_POST['id'], 'clearnumber');
			else $id = 0;
			$name = $objSan->dataSanation($_POST['name'], 'plaintext');
			$desc = $objSan->dataSanation($_POST['desc'], 'plaintext');
			$parent = $objSan->dataSanation($_POST['parent'], 'clearnumber');
			$access = $objSan->dataSanation($_POST['access'], 'clearnumber');
			$meta = $objSan->dataSanation($_POST['meta'], 'plaintext');
			if($id === false || !$name || $desc === false || $parent === false || $access === false || $meta === false) die('error;9');
			
			if($id === 0) {
				$values = "('$name',";
				if(!empty($desc)) $values .= "'$desc',";
				else $values .= "NULL,";
				if($parent == 0) $values .= "NULL,";
				else $values .= "$parent,";
				$values .= "$access,";
				if(!empty($meta)) $values .= "'$meta')";
				else $values .= "NULL)";
				$query = "INSERT INTO `" . $dbpref . "categories` (`name`,`descript`,`parent`,`access`,`meta`) VALUES $values";
			}
			else {
				$setline = "`name`='$name',";
				if(!empty($desc)) $setline .= "`descript`='$desc',";
				else $setline .= "`descript`=NULL,";
				if($parent == 0) $setline .= "`parent`=NULL,";
				else $setline .= "`parent`=$parent,";
				$setline .= "`access`=$access,";
				if(!empty($meta)) $setline .= "`meta`='$meta'";
				else $setline .= "`meta`=NULL";
				$query = "UPDATE `" . $dbpref . "categories` SET $setline WHERE `id`=$id LIMIT 1";
			}
			
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