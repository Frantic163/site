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
			
			// ДОБАВИТЬ ОЧИСТКУ ПРОДУКТОВ!!!!!!!!!!!!!
			
			$query = "DELETE FROM `".$dbpref."catalog_categories` WHERE `catalog`=$id";
			$objDB->getQuery($query);
			$query = "DELETE FROM `".$dbpref."catalogs` WHERE `id`=$id LIMIT 1";
			$objDB->getQuery($query);
			
			echo 'gut;0';
		}
		elseif($act == 'save') {
			if(empty($_POST['id']) || empty($_POST['name'])) die('error;8');
			if($_POST['id'] != 'new') $id = $objSan->dataSanation($_POST['id'], 'clearnumber');
			else $id = 0;
			$name = $objSan->dataSanation($_POST['name'], 'plaintext');
			if($id === false || !$name) die('error;9');
			
			// проверяем, свободно ли имя
			$query_name = "SELECT * FROM `" . $dbpref . "catalogs` WHERE `name`='$name' AND `id`<>$id";
			$res = $objDB->getQuery($query_name);
			if($res) die("error;expected");
			
			// заносим данные по меню
			if($id === 0) {
				$query = "INSERT INTO `" . $dbpref . "catalogs` (`name`) VALUES ('$name')";
				$objDB->getQuery($query);
				$res = $objDB->getQuery($query_name);
				if(!$res) die("error;91");
				$id = $res[0]['id'] * 1;
			}
			else {
				$query = "UPDATE `" . $dbpref . "catalogs` SET `name`='$name' WHERE `id`=$id LIMIT 1";
				$objDB->getQuery($query);
			}
			
			// заносим данные по пунктам меню
			if(!empty($_POST['items'])) {
				// затираем старые пункты меню
				$query = "DELETE FROM `" . $dbpref . "catalog_categories` WHERE `catalog`=$id";
				$objDB->getQuery($query);
				
				// получаем строку запроса
				$items = html_entity_decode($objSan->dataSanation($_POST['items'], 'plaintext'));
				$arrItems = json_decode($items, true);
				
				foreach($arrItems as $item) {
					$currName = $objSan->dataSanation($item[0], 'plaintext');
					$currAlias = $objSan->dataSanation($item[1], 'uri');
					if(!$currName || $currAlias === false) continue;

					$pos++;
					$query = "INSERT INTO `" . $dbpref . "catalog_categories` (`name`,`alias`,`catalog`) VALUES ('$currName','$currAlias',$id)";
					$objDB->getQuery($query);
				}
			}
			
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