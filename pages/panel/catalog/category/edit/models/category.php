<?php

class CatalogListModel {
	
	public function getCatalogList() {
		require(CURR_PANEL_PATH . 'protected/settings.php');
		$objDB = new DBQuery;
		$query = "SELECT * FROM `" . $dbpref . "catalogs`";
		return $res = $objDB->getQuery($query);
	}
	
	public function getCategories($cid) {
		require(CURR_PANEL_PATH . 'protected/settings.php');
		$objDB = new DBQuery;
		$query = "SELECT * FROM `" . $dbpref . "catalog_categories` WHERE `catalog`=$cid";
		return $res = $objDB->getQuery($query);
	}
	
}

?>