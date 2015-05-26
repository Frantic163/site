<?php

// Подключаем файлы ядра
$arrPath = explode("/", dirname(__FILE__));
$path = '';
foreach($arrPath as $item) {
	$path .= $item . '/';
	if($item == 'panel') break;
}
define("CURR_PANEL_PATH", $path);
require(CURR_PANEL_PATH . 'protected/index.php');

// 1. Если сессия создана:
if(is_array($isSession)) {
	// 1.1. Если пользователь авторизован - грузим рабочий стол
	if(isset($isSession['uname'])) {
		if($isSession['access'] < 1) {
			echo "<meta http-equiv='refresh' content='0;URL=/'>";
			exit;
		}
		
		// получим список каталогов
		$objCatalog = new CatalogListModel;
		$listCatalogue = $objCatalog->getCatalogList();
		
		// массив категорий для найденных каталогов
		$arrCats = Array();
		foreach($listCatalogue as $cat) {
			$arrCats[$cat['id']] = $objCatalog->getCategories($cat['id']);
		}
		
		// выводим страничку
		include('./views/index.php');
	}
	// 1.2. Если не авторизован - отправляем на авторизацию
	else {
		echo "<meta http-equiv='refresh' content='0;URL=/panel/auth/'>";
	}
}
// 2. Если сессия не найдена - отправляем на авторизацию
else {
	echo "<meta http-equiv='refresh' content='0;URL=/panel/auth/'>";
}

?>