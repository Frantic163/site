<?php if(!isset($_POST['ajax'])) require_once(CURR_PANEL_PATH . 'templates/default/header.php'); ?>
			
			<div id="breadcrumbs">
				<a href="/panel/cabinet/">Рабочий стол</a>
				&nbsp;/&nbsp;
				<a href="javascript: void(0);" onclick="refPage('catalog/list');">Каталоги</a>
				&nbsp;/&nbsp;
				<a href="javascript: void(0);">Категория</a>
				&nbsp;/&nbsp;
				<span>Добавление товара</span>
			</div>
			<br><br>
			
			<style>
				#save_btn {
					position: absolute;
					top: 48px;
					left: 360px;
				}
				.field_line {margin-bottom: 20px;}
			</style>
			
			<script type="text/javascript" src="/panel/js/tiny_mce/plugins/filemanager/js/mcfilemanager.js"></script>
			
			<script>
				function addNewPic(num) {
					newPicUrl = $("#new_pic").val();
					nextNum = $(".pic_" + num).length;
					if(nextNum == 0) $("#prod_pics_" + num).html('');
					else setNewPicNum(num, 2);
					nextNum++;
					newItem = '<div class="left33" id="pic_box_' + num + '_1" style="text-align: center;"><img src="' + newPicUrl + '" class="pic_' + num + '" style="height: 96px;"><br><br><input class="pic_rm" type="button" value="Удалить" onclick="removePic(\'' + num + '\', 1);"></div>';
					$("#prod_pics_" + num).prepend(newItem);
				}
				
				function setNewPicNum(num, d) {
					$("#prod_pics_" + num).find(".left33").each(function(id, el) {
						curr = id + d;
						$(el).attr("id", "pic_box_" + num + "_" + curr);
						$(el).find('.pic_rm:first').attr("onclick","removePic('" + num + "', " + curr + ")");
					});
				}
				
				function removePic(num, pid) {
					$("#pic_box_" + num + "_" + pid).remove();
					if($(".pic_" + num).length == 0) $("#prod_pics_" + num).html('<center><p style="color: #c11;">Нет ни одной картинки товара</p></center>');
					else setNewPicNum(num, 1);
				}
				
				function addNewField(num) {
					name = $("#field_name_" + num).val();
					ftype = $("#field_type_" + num).val();
					opts = $("#field_options_" + num).val();
					
					if(name.length < 2) {
						alert("Введите название свойства");
						return false;
					}
					
					if(opts.length < 2) {
						alert("Введите параметры свойства");
						return false;
					}
					
					var nextNum = $(".field_line_" + num).length;
					if(nextNum < 1) $("#field_box_" + num).html('');
					nextNum++;
					
					arSel = new Array('', '', '', '', '');
					nType = ftype * 1;
					nType--;
					arSel[nType] = 'selected';
					
					newHtml = '<div class="field_line_' + num + ' field_line" id="field_line_' + num + '_' + nextNum + '" style="width: 100%;"><table style="width: 100%;"><tr><td style="width: 40%;"><input type="text" class="field_name_' + num + '" id="field_name_' + num + '_' + nextNum + '" value="' + name + '" placeholder="название свойства" style="width: 100%;"></td><td><select class="field_type_' + num + '" id="field_type_' + num + '_' + nextNum + '" style="margin-left: 20px;"><option value="1" ' + arSel[0] + '>характеристика (текст)</option><option value="2" ' + arSel[1] + '>опции (чекбокс)</option><option value="3" ' + arSel[2] + '>опции (мультиселект)</option><option value="4" ' + arSel[3] + '>опция (радиокнопка)</option><option value="5" ' + arSel[4] + '>опция (выпадающий список)</option></select></td><td><input type="text" class="field_options_' + num + '" id="field_options_' + num + '_' + nextNum + '" placeholder="параметры свойства" value="' + opts + '"></td><td><input type="button" class="field_rm_' + num + '" id="field_rm_' + num + '_' + nextNum + '" value="Удалить" onclick="rmField(\'' + num + '\', ' + nextNum + ');"></td></tr></table></div>';
					
					$("#field_box_" + num).append(newHtml);
				}
				
				function setNewFieldNum(num, d) {
					$(".field_line_" + num).each(function(id, el) {
						curr = id + d;
						$(el).attr("id", "field_line_" + num + "_" + curr);
					});
					$(".field_name_" + num).each(function(id, el) {
						curr = id + d;
						$(el).attr("id", "field_name_" + num + "_" + curr);
					});
					$(".field_type_" + num).each(function(id, el) {
						curr = id + d;
						$(el).attr("id", "field_type_" + num + "_" + curr);
					});
					$(".field_options_" + num).each(function(id, el) {
						curr = id + d;
						$(el).attr("id", "field_options_" + num + "_" + curr);
					});
					$(".field_rm_" + num).each(function(id, el) {
						curr = id + d;
						$(el).attr("id", "field_rm_" + num + "_" + curr);
						$(el).attr("onclick","rmField(\'" + num + "\', " + curr + ");");
					});
				}
				
				function rmField(num, p) {
					$("#field_line_" + num + '_' + p).remove();
					if($(".field_line_" + num).length < 1) $("#field_box_" + num).html('<p style="color: #c11;">Не найдено ни одного свойства</p>');
					else setNewFieldNum(num, 1);
				}
			</script>
			
			<h3>Новый товар</h3>
			<br><br>
			
			<div id="save_btn">
				<input type="button" value="Сохранить новый товар" onclick="saveProduct('new');">
			</div>
			
			<div id="prod_box_new" style="width: 100%;">
				<div class="left40">
					<input type="text" id="prod_name_new" value="" placeholder="Наименование товара" style="width: 100%;">
					<br><br>
					
					<textarea id="prod_desc_new" style="width: 100%; height: 48%;" placeholder="Описание товара"></textarea>
					<br><br>
				</div>
				<div class="right50">
					<form name="example1">
						<input type="text" id="new_pic" name="url" value="Select file" size="80" onchange="addNewPic('new');" style="display: none;">
						<a href="javascript:mcFileManager.open('example1','url');">Загрузить картинку</a>
					</form>
					<br>
					<div id="prod_pics_new" style="width: 100%;">
						<?php if(empty($arrPics)) : ?>
							<center>
								<p style="color: #c11;">Нет ни одной картинки товара</p>
							</center>
						<?php else : ?>
							<?php foreach($arrPics as $key=>$pic) : ?>
								<div class="left33" id="pic_box_new_<?php echo $key;?>" style="text-align: center;">
									<img src="<?php echo $pic;?>" class="pic_new" style="height: 96px;">
									<br><br>
									<input class="pic_rm" type="button" value="Удалить" onclick="removePic('new', <?php echo $key;?>);">
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
				<div class="clear"></div>
				<br><br>
				
				<h4>Свойства товара</h4>
				<br>
				
				<div id="field_box_new" style="width: 100%;">
					<?php if(empty($fieldList)) : ?>
						<p style="color: #c11;">Не найдено ни одного свойства</p>
					<?php else : ?>
						<?php foreach($fieldList as $field) : ?>
							<div id="field_line_<?php echo $field['id'];?>" style="width: 100%;">
								<div class="left40">
									<input type="text" id="field_name_<?php echo $field['id'];?>" value="<?php echo $field['name'];?>" placeholder="название свойства" style="width: 100%;">
								</div>
								<div class="left15">&nbsp;</div>
								<div class="left25">
									<select id="field_type_new">
										<option value="1">характеристика (текст)</option>
										<option value="2">опции (чекбокс)</option>
										<option value="3">опции (мультиселект)</option>
										<option value="4">опция (радиокнопка)</option>
										<option value="5">опция (выпадающий список)</option>
									</select>
								</div>
								<div class="right20">
									<!--input type="button" value="Изменить" onclick=""-->
								</div>
								<div class="clear"></div>
								<br>
								<textarea id="field_options_new" placeholder="параметры свойства (для списков - через точку с запятой)" style="width: 85%; height: 60px;"><?php echo $field['value'];?></textarea>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
				<br><br>
				
				<h4>Новое свойство</h4>
				<br><br>
				<div id="field_line_new" style="width: 100%;">
					<div class="left40">
						<input type="text" id="field_name_new" value="" placeholder="название свойства" style="width: 100%;">
					</div>
					<div class="left30">
						<select id="field_type_new" style="margin-left: 20px;">
							<option value="1">характеристика (текст)</option>
							<option value="2">опции (чекбокс)</option>
							<option value="3">опции (мультиселект)</option>
							<option value="4">опция (радиокнопка)</option>
							<option value="5">опция (выпадающий список)</option>
						</select>
					</div>
					<div class="right25 textright">
						<input type="button" value="Добавить" onclick="addNewField('new');">
					</div>
					<div class="clear"></div>
					<br>
					<textarea id="field_options_new" placeholder="параметры свойства (для списков - через точку с запятой)" style="width: 100%; height: 60px;"></textarea>
				</div>
			</div>
			
			<br><br><br>
            
			
<?php if(!isset($_POST['ajax'])) require_once(CURR_PANEL_PATH . 'templates/default/footer.php');?>