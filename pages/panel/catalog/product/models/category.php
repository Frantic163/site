<?php

class CategoryModel {
	
	public function getNames($cid, $type) {
		require(CURR_PANEL_PATH . 'protected/settings.php');
		$objDB = new DBQuery;
		$query = "SELECT * FROM `" . $dbpref . "catalog_categories` WHERE `id`=$cid";
		$res = $objDB->getQuery($query);
		if($type == 1) {
			$cat = $res[0]['catalog'];
			$query = "SELECT * FROM `" . $dbpref . "catalogs` WHERE `id`=$cat";
			$res = $objDB->getQuery($query);
		}
		return $res[0]['name'];
	}
	
	public function getProducts($cid) {
		require(CURR_PANEL_PATH . 'protected/settings.php');
		$objDB = new DBQuery;
		$query = "SELECT * FROM `" . $dbpref . "products` WHERE `id`=$cid";
		return $res = $objDB->getQuery($query);
	}
	
}

?>