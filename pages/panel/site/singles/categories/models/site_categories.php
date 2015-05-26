<?php

class SiteSingles {

	// получаем категории
	public function getCategories() {
		require(CURR_PANEL_PATH . 'protected/settings.php');
		$objDB = new DBQuery;
		$query = "SELECT * FROM `" . $dbpref . "categories`";
		return $res = $objDB->getQuery($query);
	}
	
}

?>