<?php if(!isset($_POST['ajax'])) require_once(CURR_PANEL_PATH . 'templates/default/header.php'); ?>
			
			<div id="breadcrumbs">
				<a href="/panel/cabinet/">Рабочий стол</a>
				&nbsp;/&nbsp;
				<a href="javascript: void(0);" onclick="refPage('catalog');">Каталог</a>
				&nbsp;/&nbsp;
				<span>Новый каталог</span>
			</div>
			<br><br>
			
			<style>
				.catalog_current a {text-decoration: none;}
				.item_line {width: 100%;}
			</style>
			
			<script>
				function newCat(num) {
					// проверяем название меню
					mName = $("#catalog_name_" + num).val();
					if(mName.length < 2) {
						alert("Введите название меню");
						return false;
					}
					
					// проверяем пункты меню
					items = '';
					if($("#catalog_current_" + num).find(".item_line").length < 1) {
						if(!confirm("Сохранить пустой каталог?")) return false;
					}
					else {
						var arrItem = new Array();
						$("#catalog_current_" + num).find(".item_line").each(function(id, el) {
							curr = id + 1;
							itemName = $(el).find(".item_catalog_name_" + num + ":first").html();
							itemUrl = $(el).find(".item_catalog_url_" + num + ":first").html();
							arrItem[id] = new Array(itemName, itemUrl);
						});
						items = JSON.stringify(arrItem);
					}
					
					strData = 'act=save&id=' + num + '&name=' + mName;
					if(items.length > 0) strData = strData + '&items=' + items;
					
					strUrl = '/panel/backend/catalog.php';
					$.ajax({
						type: "POST",
						url: strUrl,
						data: strData
						}).done(function(data) {
							//alert(data);
							arrData = data.split(';');
							if(arrData[0] == 'error') {
								if(arrData[1] == 'expected') alert("Каталог с таким именем уже существует");
								else alert("Ошибка: " + arrData[1]);
							}
							else {
								alert('Каталог сохранен');
								window.location.href = '/panel/catalog/list';
							}
					});
				}
				
				function setNewNumber(p, d) {
					// увеличим номера у пунктов меню
					$("#catalog_current_" + p).find(".item_line_" + p).each(function(id, el) {
						currNum = id + d;
						$(el).attr("id", "item_line_" + p + "_" + currNum);
					});
					$("#catalog_current_" + p).find(".item_catalog_name_" + p).each(function(id, el) {
						currNum = id + d;
						$(el).attr("id", "item_catalog_name_" + p + "_" + currNum);
					});
					$("#catalog_current_" + p).find(".item_catalog_url_" + p).each(function(id, el) {
						currNum = id + d;
						$(el).attr("id", "item_catalog_url_" + p + "_" + currNum);
					});
					$("#catalog_current_" + p).find(".item_catalog_pos_" + p).each(function(id, el) {
						currNum = id + d;
						$(el).html(currNum);
						$(el).attr("id", "item_catalog_pos_" + p + "_" + currNum);
					});
					$("#catalog_current_" + p).find(".item_catalog_down_" + p).each(function(id, el) {
						currNum = id + d;
						$(el).attr("id", "item_catalog_down_" + p + "_" + currNum);
						$(el).attr("onclick", "downItemMenu('" + p + "'," + currNum + ");");
					});
					$("#catalog_current_" + p).find(".item_catalog_up_" + p).each(function(id, el) {
						currNum = id + d;
						$(el).attr("id", "item_catalog_up_" + p + "_" + currNum);
						$(el).attr("onclick", "upItemMenu('" + p + "'," + currNum + ");");
					});
					$("#catalog_current_" + p).find(".item_catalog_del_" + p).each(function(id, el) {
						currNum = id + d;
						$(el).attr("id", "item_catalog_del_" + p + "_" + currNum);
						$(el).attr("onclick", "delItemMenu('" + p + "'," + currNum + ");");
					});
					$("#catalog_current_" + p).find(".item_catalog_edit_" + p).each(function(id, el) {
						currNum = id + d;
						$(el).attr("id", "item_catalog_edit_" + p + "_" + currNum);
						$(el).attr("onclick", "editItemMenu('" + p + "'," + currNum + ");");
					});
					///////////////////////////////////
				}
				
				function showButtons(pid) {
					// показываем кнопки у всех
					$(".item_catalog_up_" + pid).show();
					$(".item_catalog_down_" + pid).show();
					// убираем ненужные кнопки
					lastNum = $(".item_line_" + pid).length;
					$("#item_catalog_up_" + pid + "_1").hide();//css("display", "none");
					$("#item_catalog_down_" + pid + "_" + lastNum).hide();
				}
				
				function addNewItem(pid) {
					iName = $("#" + pid + "_item_name").val();
					iUrl = $("#" + pid + "_item_url").val();
					
					if(iName.length < 2) {
						alert("Введите название меню");
						return false;
					}
					
					setNewNumber(pid,2);
					
					$("#catalog_current_" + pid).prepend('<div id="item_line_' + pid + '_1" class="item_line_' + pid + ' item_line"><div class="left25"><span id="item_catalog_name_' + pid + '_1" class="item_catalog_name_' + pid + '">' + iName + '</span></div><div class="left25"><span id="item_catalog_url_' + pid + '_1" class="item_catalog_url_' + pid + '">' + iUrl + '</span></div><div class="left25 textcenter"><span id="item_catalog_pos_' + pid + '_1" class="item_catalog_pos_' + pid + '">1</span></div><div class="left25"><table style="width: 100%;"><tr><td style="width: 25%;"><a href="javascript: void(0);" id="item_catalog_edit_' + pid + '_1" class="item_catalog_edit_' + pid + '" onclick="editItemMenu(' + pid + ',1);">E</a></td><td style="width: 25%;"><a href="javascript: void(0);" id="item_catalog_down_' + pid + '_1" class="item_catalog_down_' + pid + '" onclick="downItemMenu(' + pid + ',1);">v</a></td><td style="width: 25%;"><a href="javascript: void(0);" id="item_catalog_up_' + pid + '_1" class="item_catalog_up_' + pid + '" onclick="upItemMenu(' + pid + ',1);">^</a></td><td><a href="javascript: void(0);" id="item_catalog_del_' + pid + '_1" class="item_catalog_del_' + pid + '" onclick="delItemMenu(' + pid + ',1);">x</a></td></tr></table></div><div class="clear"></div></div>');
					
					showButtons(pid);
				}
				
				function delItemMenu(pid, num) {
					if(!confirm("Удалить пункт меню #" + num +"?")) return false;
					$("#item_line_" + pid + "_" + num).remove();
					setNewNumber(pid, 1);
					showButtons(pid);
				}
				
				function upItemMenu(pid, num) {
					if(num < 2) return false;
					currLineHtml = $("#item_line_" + pid + "_" + num).html();
					prev = num - 1;
					prevLineHtml = $("#item_line_" + pid + "_" + prev).html();
					$("#item_line_" + pid + "_" + prev).html(currLineHtml);
					$("#item_line_" + pid + "_" + num).html(prevLineHtml);
					setNewNumber(pid, 1);
					showButtons(pid);
				}
				
				function downItemMenu(pid, num) {
					lastNum = $(".item_line_" + pid).length;
					if(num >= lastNum) return false;
					currLineHtml = $("#item_line_" + pid + "_" + num).html();
					next = num + 1;
					nextLineHtml = $("#item_line_" + pid + "_" + next).html();
					$("#item_line_" + pid + "_" + next).html(currLineHtml);
					$("#item_line_" + pid + "_" + num).html(nextLineHtml);
					setNewNumber(pid, 1);
					showButtons(pid);
				}
				
				function showNewForm(el, p) {
					if($(el).val() == 'Новое меню') $("#catalog_list").val('new');
					else {
						var fVal = '';
						$("#catalog_list").find("option").each(function(id, el) {
							if(id == 1) fVal = $(el).attr("value");
						});
						$("#catalog_list").val(fVal);
					}
					onChangeMenuList();
					/*if($("#catalog_box_" + p).css("display") != "none") {
						$("#catalog_box_" + p).hide();
						if(p == 'new') $(el).val("Новое меню");
					}
					else {
						$("#catalog_box_" + p).show();
						if(p == 'new') $(el).val("Отмена");
					}*/
				}
				
				function showAddForm(el, num) {
					if($("#catalog_item_" + num).css("display") != "none") {
						$("#catalog_item_" + num).hide();
						$(el).val("Добавить пункт");
					}
					else {
						$("#catalog_item_" + num).show();
						$(el).val("Отмена");
					}
				}
				
				function onChangeMenuList() {
					selectVal = $("#catalog_list").val();
					$("#selected_catalog_box").html('');
					$("#catalog_box_new").hide();
					if(selectVal == 'new') {
						$("#catalog_box_new").show();
						$("#new_btn").val("Отмена");
					}
					else {
						$("#new_btn").val("Новое меню");
						strData = 'act=get&id=' + selectVal;
						strUrl = '/panel/backend/site_menu.php';
						//alert(strData);
						$.ajax({
							type: "POST",
							url: strUrl,
							data: strData
							}).done(function(data) {
								//alert(data);
								arrData = data.split(';');
								if(arrData[0] == 'error') alert("Ошибка загрузки меню: " + arrData[1]);
								else {
									newHtml = '';
									for(i = 1; i < arrData.length; i++) {
										if(newHtml.length > 0) newHtml = newHtml + ";";
										newHtml = newHtml + arrData[i];
									}
									$("#selected_catalog_box").html(newHtml);
									showButtons(selectVal);
								}
						});
					}
				}
				
				$(document).ready(function() {
					showButtons(<?php echo $listMenu[0]['id'];?>);
				});
			</script>
			
			<h3>Создание нового каталога</h3>
            <br><br>
			
			<div id="catalog_box_new" style="width: 100%;">
				<div class="left50">
					<input id="catalog_name_new" type="text" value="" placeholder="Название каталога" style="width: 340px;">
				</div>
				<div class="left25">&nbsp;</div>
				<div class="left25">
					<input type="button" value="Сохранить" onclick="newCat('new');">
				</div>
				<div class="clear"></div>
				<br><br><br>
				
				<div id="catalog_item_new" style="width: 100%;">
					<div class="left50">
						<input type="text" id="new_item_name" value="" placeholder="Название новой категории" style="width: 340px;">
					</div>
					<div class="left25">
						<input type="text" id="new_item_url" value="" placeholder="алиас" style="width: 200px;">
					</div>
					<!--div class="left25">&nbsp;</div-->
					<div class="left25">
						<input type="button" value="Добавить" onclick="addNewItem('new');">
					</div>
					<div class="clear"></div>
				</div>
				<br><br>
				
				<div id="catalog_current_new" class="catalog_current" style="width: 100%;"></div>
			</div>
			
			<br><br><br>
			
<?php if(!isset($_POST['ajax'])) require_once(CURR_PANEL_PATH . 'templates/default/footer.php');?>