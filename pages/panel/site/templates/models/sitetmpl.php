<?php

class SiteTemplates {
	
	// получим текущий шаблон сайта
	public function getCurrTemplate() {
		global $mysqli; 
		$query = "SELECT * FROM `" . DBPREF . "settings` WHERE `name`='STR_TEMPLATE_NAME' LIMIT 1";
		$res = $mysqli->query($query);
                $row = $mysqli->row($res);
		return $row;
	}
	
}
