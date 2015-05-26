<?php if(!isset($_POST['ajax'])) require_once(ROOT.'/templates/panel/header.php'); ?>
			
			<div id="breadcrumbs">
				<a href="/panel/cabinet/">Рабочий стол</a>
				&nbsp;/&nbsp;
				<a href="javascript: void(0);" onclick="refPage('site');">Сайт</a>
				&nbsp;/&nbsp;
				<span>Меню</span>
			</div>
			<br><br>
			
			<style>
				.menu_current a {text-decoration: none;}
				.item_line {width: 100%;}
			</style>
			
			<script>
				function newMenu(num) {
					// проверяем название меню
					mName = $("#menu_name_" + num).val();
					if(mName.length < 2) {
						alert("Введите название меню");
						return false;
					}
					
					// проверяем пункты меню
					items = '';
					if($("#menu_current_" + num).find(".item_line").length < 1) {
						if(!confirm("Сохранить пустое меню?")) return false;
					}
					else {
						var arrItem = new Array();
						$("#menu_current_" + num).find(".item_line").each(function(id, el) {
							curr = id + 1;
							itemName = $(el).find(".item_menu_name_" + num + ":first").html();
							itemUrl = $(el).find(".item_menu_url_" + num + ":first").html();
							arrItem[id] = new Array(itemName, itemUrl);
						});
						items = JSON.stringify(arrItem);
					}
					
					strData = 'act=save&id=' + num + '&name=' + mName;
					if(items.length > 0) strData = strData + '&items=' + items;
					
					strUrl = '/panel/backend/site_menu.php';
					$.ajax({
						type: "POST",
						url: strUrl,
						data: strData
						}).done(function(data) {
							//alert(data);
							arrData = data.split(';');
							if(arrData[0] == 'error') {
								if(arrData[1] == 'expected') alert("Меню с таким именем уже существует");
								else alert("Ошибка: " + arrData[1]);
							}
							else {
								alert('Меню сохранено');
								window.location.href = '/panel/site/menu';
							}
					});
				}
				
				function setNewNumber(p, d) {
					// увеличим номера у пунктов меню
					$("#menu_current_" + p).find(".item_line_" + p).each(function(id, el) {
						currNum = id + d;
						$(el).attr("id", "item_line_" + p + "_" + currNum);
					});
					$("#menu_current_" + p).find(".item_menu_name_" + p).each(function(id, el) {
						currNum = id + d;
						$(el).attr("id", "item_menu_name_" + p + "_" + currNum);
					});
					$("#menu_current_" + p).find(".item_menu_url_" + p).each(function(id, el) {
						currNum = id + d;
						$(el).attr("id", "item_menu_url_" + p + "_" + currNum);
					});
					$("#menu_current_" + p).find(".item_menu_pos_" + p).each(function(id, el) {
						currNum = id + d;
						$(el).html(currNum);
						$(el).attr("id", "item_menu_pos_" + p + "_" + currNum);
					});
					$("#menu_current_" + p).find(".item_menu_down_" + p).each(function(id, el) {
						currNum = id + d;
						$(el).attr("id", "item_menu_down_" + p + "_" + currNum);
						$(el).attr("onclick", "downItemMenu('" + p + "'," + currNum + ");");
					});
					$("#menu_current_" + p).find(".item_menu_up_" + p).each(function(id, el) {
						currNum = id + d;
						$(el).attr("id", "item_menu_up_" + p + "_" + currNum);
						$(el).attr("onclick", "upItemMenu('" + p + "'," + currNum + ");");
					});
					$("#menu_current_" + p).find(".item_menu_del_" + p).each(function(id, el) {
						currNum = id + d;
						$(el).attr("id", "item_menu_del_" + p + "_" + currNum);
						$(el).attr("onclick", "delItemMenu('" + p + "'," + currNum + ");");
					});
					$("#menu_current_" + p).find(".item_menu_edit_" + p).each(function(id, el) {
						currNum = id + d;
						$(el).attr("id", "item_menu_edit_" + p + "_" + currNum);
						$(el).attr("onclick", "editItemMenu('" + p + "'," + currNum + ");");
					});
					///////////////////////////////////
				}
				
				function showButtons(pid) {
					// показываем кнопки у всех
					$(".item_menu_up_" + pid).show();
					$(".item_menu_down_" + pid).show();
					// убираем ненужные кнопки
					lastNum = $(".item_line_" + pid).length;
					$("#item_menu_up_" + pid + "_1").hide();//css("display", "none");
					$("#item_menu_down_" + pid + "_" + lastNum).hide();
				}
				
				function addNewItem(pid) {
					iName = $("#" + pid + "_item_name").val();
					iUrl = $("#" + pid + "_item_url").val();
					
					if(iName.length < 2) {
						alert("Введите название меню");
						return false;
					}
					
					setNewNumber(pid,2);
					
					$("#menu_current_" + pid).prepend('<div id="item_line_' + pid + '_1" class="item_line_' + pid + ' item_line"><div class="left25"><span id="item_menu_name_' + pid + '_1" class="item_menu_name_' + pid + '">' + iName + '</span></div><div class="left25"><span id="item_menu_url_' + pid + '_1" class="item_menu_url_' + pid + '">' + iUrl + '</span></div><div class="left25 textcenter"><span id="item_menu_pos_' + pid + '_1" class="item_menu_pos_' + pid + '">1</span></div><div class="left25"><table style="width: 100%;"><tr><td style="width: 25%;"><a href="javascript: void(0);" id="item_menu_edit_' + pid + '_1" class="item_menu_edit_' + pid + '" onclick="editItemMenu(' + pid + ',1);">E</a></td><td style="width: 25%;"><a href="javascript: void(0);" id="item_menu_down_' + pid + '_1" class="item_menu_down_' + pid + '" onclick="downItemMenu(' + pid + ',1);">v</a></td><td style="width: 25%;"><a href="javascript: void(0);" id="item_menu_up_' + pid + '_1" class="item_menu_up_' + pid + '" onclick="upItemMenu(' + pid + ',1);">^</a></td><td><a href="javascript: void(0);" id="item_menu_del_' + pid + '_1" class="item_menu_del_' + pid + '" onclick="delItemMenu(' + pid + ',1);">x</a></td></tr></table></div><div class="clear"></div></div>');
					
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
					if($(el).val() == 'Новое меню') $("#menu_list").val('new');
					else {
						var fVal = '';
						$("#menu_list").find("option").each(function(id, el) {
							if(id == 1) fVal = $(el).attr("value");
						});
						$("#menu_list").val(fVal);
					}
					onChangeMenuList();
					/*if($("#menu_box_" + p).css("display") != "none") {
						$("#menu_box_" + p).hide();
						if(p == 'new') $(el).val("Новое меню");
					}
					else {
						$("#menu_box_" + p).show();
						if(p == 'new') $(el).val("Отмена");
					}*/
				}
				
				function showAddForm(el, num) {
					if($("#menu_item_" + num).css("display") != "none") {
						$("#menu_item_" + num).hide();
						$(el).val("Добавить пункт");
					}
					else {
						$("#menu_item_" + num).show();
						$(el).val("Отмена");
					}
				}
				
				function onChangeMenuList() {
					selectVal = $("#menu_list").val();
					$("#selected_menu_box").html('');
					$("#menu_box_new").hide();
					if(selectVal == 'new') {
						$("#menu_box_new").show();
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
									$("#selected_menu_box").html(newHtml);
									showButtons(selectVal);
								}
						});
					}
				}
				
				$(document).ready(function() {
					showButtons(<?php echo $listMenu[0]['id'];?>);
				});
			</script>
			
			<h3>Настройки меню</h3>
            <br><br>
			
			<div class="left25">
				<?php if(empty($listMenu)) : ?>
					<span style="color: #c11;">нет ни одного меню</span>
				<?php else : ?>
				
					<select id="menu_list" onchange="onChangeMenuList(this);">
						<option value="new">Новое меню</option>
						<?php $cnt = 0;
						foreach($listMenu as $menu) :
							if($cnt === 0) $isSel = "selected";
							else $isSel = ""; ?>
							<option value="<?php echo $menu['id'];?>" <?php echo $isSel;?>><?php echo $menu['name'];?></option>
						<?php $cnt++;
						endforeach; ?>
					</select>
					
				<?php endif; ?>
			</div>
			<div class="left50">
				<input id="new_btn" type="button" value="Новое меню" onclick="showNewForm(this,'new');">
			</div>
			<div class="clear"></div>
			
			<br>
			<div id="menu_box_new" style="width: 100%; display: none;">
				<h5>Создать новое меню</h5>
				<br>
				<div class="left25">
					<input id="menu_name_new" type="text" value="" placeholder="Название меню">
				</div>
				<div class="left25">
					<input type="button" value="Сохранить" onclick="newMenu('new');">
				</div>
				<div class="clear"></div>
				<br><br>
				
				<div id="menu_item_new" style="width: 100%;">
					<div class="left25">
						<input type="text" id="new_item_name" value="" placeholder="Название пункта меню" style="width: 200px;">
					</div>
					<div class="left25">
						<input type="text" id="new_item_url" value="" placeholder="Ссылка (url)" style="width: 200px;">
					</div>
					<div class="left25">&nbsp;</div>
					<div class="left25">
						<input type="button" value="Добавить" onclick="addNewItem('new');">
					</div>
					<div class="clear"></div>
				</div>
				<br><br>
				
				<div id="menu_current_new" class="menu_current" style="width: 100%;"></div>
			</div>
			
			<?php if(!empty($listMenu)) : ?>
				<br><br>
				<div id="selected_menu_box" style="width: 100%;">
					<div id="menu_box_<?php echo $listMenu[0]['id'];?>" style="width: 100%;">
						<h5><?php echo $listMenu[0]['name'];?></h5>
						<br>
						<div class="left25">
							<input id="menu_name_<?php echo $listMenu[0]['id'];?>" type="text" value="<?php echo $listMenu[0]['name'];?>" placeholder="Название меню">
						</div>
						<div class="left75">
							<input type="button" value="Сохранить" onclick="newMenu(<?php echo $listMenu[0]['id'];?>);">
							&nbsp;&nbsp;
							<input type="button" value="Добавить пункт" onclick="showAddForm(this,<?php echo $listMenu[0]['id'];?>);">
						</div>
						<div class="clear"></div>
						<br><br>
						
						<div id="menu_item_<?php echo $listMenu[0]['id'];?>" style="width: 100%; display: none;">
							<div class="left25">
								<input type="text" id="<?php echo $listMenu[0]['id'];?>_item_name" value="" placeholder="Название пункта меню" style="width: 200px;">
							</div>
							<div class="left25">
								<input type="text" id="<?php echo $listMenu[0]['id'];?>_item_url" value="" placeholder="Ссылка (url)" style="width: 200px;">
							</div>
							<div class="left25">&nbsp;</div>
							<div class="left25">
								<input type="button" value="Добавить" onclick="addNewItem(<?php echo $listMenu[0]['id'];?>);">
							</div>
							<div class="clear"></div>
						</div>
						<br><br>
						
						<div id="menu_current_<?php echo $listMenu[0]['id'];?>" class="menu_current" style="width: 100%;">
							<?php for($i = 0; $i < count($listMenu); $i++): ?>
								<div id="item_line_<?php echo $listMenu[0]['id'];?>_<?php echo $listMenu['position'];?>" class="item_line_<?php echo $listMenu[0]['id'];?> item_line">
									<div class="left25">
										<span id="item_menu_name_<?php echo $listMenu[$i]['id'];?>_<?php echo $listMenu[$i]['position'];?>" class="item_menu_name_<?php //echo $listMenu[$i]['id'];?>"><?php echo $listMenu[$i]['title']?></span>
									</div>
									<div class="left25">
										<span id="item_menu_url_<?php echo $listMenu[$i]['id'];?>_<?php echo $listMenu[$i]['position'];?>" class="item_menu_url_<?php //echo $listMenu[$i]['id'];?>"><?php echo $listMenu[$i]['path']?></span>
									</div>
									<div class="left25 textcenter">
										<span id="item_menu_pos_<?php echo $listMenu[$i]['id'];?>_<?php echo $listMenu[$i]['position'];?>" class="item_menu_pos_<?php //echo $listMenu[$i]['id'];?>"><?php echo $listMenu[$i]['name']?></span>
									</div>
									<div class="left25">
										<table style="width: 100%;">
											<tr>
												<td style="width: 25%;">
													<a href="javascript: void(0);" id="item_menu_edit_<?php echo $listMenu[0]['id'];?>_<?php echo $listMenu[$i]['position'];?>" class="item_menu_edit_<?php echo $listMenu[$i]['id'];?>" onclick="editItemMenu(<?php echo $listMenu[$i]['id'];?>,<?php echo $listMenu[$i]['position'];?>);">E</a>
												</td>
												<td style="width: 25%;">
													<a href="javascript: void(0);" id="item_menu_down_<?php echo $listMenu[0]['id'];?>_<?php echo $listMenu[$i]['position'];?>" class="item_menu_down_<?php echo $listMenu[$i]['id'];?>" onclick="downItemMenu(<?php echo $listMenu[$i]['id'];?>,<?php echo $listMenu[$i]['position'];?>);">v</a>
												</td>
												<td style="width: 25%;">
													<a href="javascript: void(0);" id="item_menu_up_<?php echo $listMenu[0]['id'];?>_<?php echo $listMenu[$i]['position'];?>" class="item_menu_up_<?php echo $listMenu[$i]['id'];?>" onclick="upItemMenu(<?php echo $listMenu[$i]['id'];?>,<?php echo $listMenu[$i]['position'];?>);">^</a>
												</td>
												<td>
													<a href="javascript: void(0);" id="item_menu_del_<?php echo $listMenu[0]['id'];?>_<?php echo $listMenu[$i]['position'];?>" class="item_menu_del_<?php echo $listMenu[$i]['id'];?>" onclick="delItemMenu(<?php echo $listMenu[$i]['id'];?>,<?php echo $listMenu[$i]['position'];?>);">x</a>
												</td>
											</tr>
										</table>
									</div>
									<div class="clear"></div>
								</div>
							<?php endfor; ?>
						</div>
					</div>
				</div>
			<?php endif; ?>
			
			<br><br><br>
			
<?php if(!isset($_POST['ajax'])) require_once(ROOT.'/templates/panel/footer.php'); ?>