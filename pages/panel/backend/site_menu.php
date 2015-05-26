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
			
			$query = "DELETE FROM `".$dbpref."menu_items` WHERE `menu`=$id";
			$objDB->getQuery($query);
			$query = "DELETE FROM `".$dbpref."menu` WHERE `id`=$id LIMIT 1";
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
			$query_name = "SELECT * FROM `" . $dbpref . "menu` WHERE `name`='$name' AND `id`<>$id";
			$res = $objDB->getQuery($query_name);
			if($res) die("error;expected");
			
			// заносим данные по меню
			if($id === 0) {
				$query = "INSERT INTO `" . $dbpref . "menu` (`name`) VALUES ('$name')";
				$objDB->getQuery($query);
				$res = $objDB->getQuery($query_name);
				if(!$res) die("error;91");
				$id = $res[0]['id'] * 1;
			}
			else {
				$query = "UPDATE `" . $dbpref . "menu` SET `name`='$name' WHERE `id`=$id LIMIT 1";
				$objDB->getQuery($query);
			}
			
			// заносим данные по пунктам меню
			if(!empty($_POST['items'])) {
				// затираем старые пункты меню
				$query = "DELETE FROM `" . $dbpref . "menu_items` WHERE `menu`=$id";
				$objDB->getQuery($query);
				
				// получаем строку запроса
				$items = html_entity_decode($objSan->dataSanation($_POST['items'], 'plaintext'));
				$arrItems = json_decode($items, true);
				
				foreach($arrItems as $item) {
					$currName = $objSan->dataSanation($item[0], 'plaintext');
					$currUrl = $objSan->dataSanation($item[1], 'uri');
					if(!$currName || $currUrl === false) continue;

					$pos++;
					$query = "INSERT INTO `" . $dbpref . "menu_items` (`name`,`url`,`position`,`menu`) VALUES ('$currName','$currUrl',$pos,$id)";
					$objDB->getQuery($query);
				}
			}
			
			echo 'gut;0';
		}
		elseif($act == 'get') {
			if(empty($_POST['id'])) die("error;5");
			$id = $objSan->dataSanation($_POST['id'], 'clearnumber');
			if(!$id) die("error;6");
			
			$query = "SELECT * FROM `" . $dbpref . "menu` WHERE `id`=$id";
			$res = $objDB->getQuery($query);
			$menu = $res[0];
			$query = "SELECT * FROM `" . $dbpref . "menu_items` WHERE `menu`=$id AND `activity`=1";
			$items = $objDB->getQuery($query);
			
			$result = 'gut!;<div id="menu_box_'.$id.'" style="width: 100%;">
						<h5>'.$menu['name'].'</h5>
						<br>
						<div class="left25">
							<input id="menu_name_'.$id.'" type="text" value="'.$menu['name'].'" placeholder="Название меню">
						</div>
						<div class="left75">
							<input type="button" value="Сохранить" onclick="newMenu('.$id.');">
							&nbsp;&nbsp;
							<input type="button" value="Добавить пункт" onclick="showAddForm(this,'.$id.');">
						</div>
						<div class="clear"></div>
						<br><br>
						
						<div id="menu_item_'.$id.'" style="width: 100%; display: none;">
							<div class="left25">
								<input type="text" id="'.$id.'_item_name" value="" placeholder="Название пункта меню" style="width: 200px;">
							</div>
							<div class="left25">
								<input type="text" id="'.$id.'_item_url" value="" placeholder="Ссылка (url)" style="width: 200px;">
							</div>
							<div class="left25">&nbsp;</div>
							<div class="left25">
								<input type="button" value="Добавить" onclick="addNewItem('.$id.');">
							</div>
							<div class="clear"></div>
						</div>
						<br><br>
						
						<div id="menu_current_'.$id.'" class="menu_current" style="width: 100%;">';
						
			foreach($items as $item) :
				$result .= '<div id="item_line_'.$id.'_'.$item['position'].'" class="item_line_'.$id.' item_line">
					<div class="left25">
						<span id="item_menu_name_'.$id.'_'.$item['position'].'" class="item_menu_name_'.$id.'">'.$item['name'].'</span>
					</div>
					<div class="left25">
						<span id="item_menu_url_'.$id.'_'.$item['position'].'" class="item_menu_url_'.$id.'">'.$item['url'].'</span>
					</div>
					<div class="left25 textcenter">
						<span id="item_menu_pos_'.$id.'_'.$item['position'].'" class="item_menu_pos_'.$id.'">'.$item['position'].'</span>
					</div>
					<div class="left25">
						<table style="width: 100%;">
							<tr>
								<td style="width: 25%;">
									<a href="javascript: void(0);" id="item_menu_edit_'.$id.'_'.$item['position'].'" class="item_menu_edit_'.$id.'" onclick="editItemMenu('.$id.','.$item['position'].');">E</a>
								</td>
								<td style="width: 25%;">
									<a href="javascript: void(0);" id="item_menu_down_'.$id.'_'.$item['position'].'" class="item_menu_down_'.$id.'" onclick="downItemMenu('.$id.','.$item['position'].');">v</a>
								</td>
								<td style="width: 25%;">
									<a href="javascript: void(0);" id="item_menu_up_'.$id.'_'.$item['position'].'" class="item_menu_up_'.$id.'" onclick="upItemMenu('.$id.','.$item['position'].');">^</a>
								</td>
								<td>
									<a href="javascript: void(0);" id="item_menu_del_'.$id.'_'.$item['position'].'" class="item_menu_del_'.$id.'" onclick="delItemMenu('.$id.','.$item['position'].');">x</a>
								</td>
							</tr>
						</table>
					</div>
					<div class="clear"></div>
				</div>';
			endforeach;
			$result .= '</div>
					</div>';
			echo $result;
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