<?php

class SiteSingles {

	// получаем категории
	public function getCategories() {
		$objDB = new DBQuery;
		$query = "SELECT * FROM `" . $dbpref . "categories`";
		return $res = $objDB->getQuery($query);
	}
	
	// получаем записи
	public function getSingles($cat, $page, $catList) {
		require(CURR_PANEL_PATH . 'protected/settings.php');
		$startLimit = $page * 10 - 10;
		$endLimit = $startLimit + 9;
		$objDB = new DBQuery;
		if($cat > 0) {
			$query = "SELECT `" . $dbpref . "singles`.`id`, `" . $dbpref . "singles`.`name`, `" . $dbpref . "singles`.`show`, `" . $dbpref . "categories`.`name` AS `cat` FROM `" . $dbpref . "singles` JOIN `" . $dbpref . "categories` ON `" . $dbpref . "singles`.`cat`=`" . $dbpref . "categories`.`id` WHERE `" . $dbpref . "categories`.`id`=$cat ORDER BY `" . $dbpref . "singles`.`id` LIMIT $startLimit, $endLimit";
			$res = $objDB->getQuery($query);
		}
		else {
			$query = "SELECT `id`,`name`,`show`,`cat` FROM `" . $dbpref . "singles` ORDER BY `id` LIMIT $startLimit, $endLimit";
			$res = $objDB->getQuery($query);
			if($res) {
				for($i = 0; $i < count($res); $i++) {
					$currCat = $res[$i]['cat'] * 1;
					if($currCat > 0) {
						foreach($catList as $tmpCat) {
							$tmpCatId = $tmpCat['id'] * 1;
							if($tmpCatId == $currCat) {
								$res[$i]['cat'] = $tmpCat['name'];
								break;
							}
						}
					}
					else $res[$i]['cat'] = 'без категории';
				}
			}
		}
		return $res;
	}
	
	// получаем текущую запись
	public function getCurrentSingle($id) {
		require(CURR_PANEL_PATH . 'protected/settings.php');
		$objDB = new DBQuery;
		$query = "SELECT * FROM `" . $dbpref . "singles` WHERE `id`=$id LIMIT 1";
		$res = $objDB->getQuery($query);
		return $res[0];
	}

}

?>