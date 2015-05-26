<?php if(!isset($_POST['ajax'])) require_once(CURR_PANEL_PATH . 'templates/default/header.php'); ?>
			
			<div id="breadcrumbs">
				<a href="/panel/cabinet/">Рабочий стол</a>
				&nbsp;/&nbsp;
				<a href="javascript: void(0);" onclick="refPage('site');">Сайт</a>
				&nbsp;/&nbsp;
				<a href="javascript: void(0);" onclick="refPage('site/singles');">Записи</a>
				&nbsp;/&nbsp;
				<span>Категории</span>
			</div>
			<br><br>
			
			<script>
				function showHideCatProp(num) {
					if($("#catbox_" + num).css("display") != "none") isShow = true;
					else isShow = false;
					$(".cat_boxes").hide();
					if(isShow) $("#catbox_" + num).hide();
					else $("#catbox_" + num).show();
				}
				
				function saveCategory(id) {
					cName = $("#cat_name_" + id).val();
					if(cName.length < 2) {
						alert("Введите название категории");
						return false;
					}
					strData = 'act=save&id=' + id + '&name=' + cName + '&desc=' + $("#cat_descript_" + id).val() + '&parent=' + $("#cat_parent_" + id).val() + '&access=' + $("#cat_access_" + id).val() + '&meta=' + $("#cat_meta_" + id).val();
					strUrl = '/panel/backend/category.php';
					$.ajax({
						type: "POST",
						url: strUrl,
						data: strData
						}).done(function(data) {
							//alert(data);
							arrData = data.split(';');
							if(arrData[0] == 'error') alert("Ошибка: " + arrData[1]);
							else {
								alert('Категория сохранена');
								window.location.href = '/panel/site/singles/categories';
							}
					});
				}
				
				function delCategory(id) {
					cName = $("#cat_name_" + id).val();
					if(!confirm("Удалить категорию \"" + cName + "\"?")) return false;
					
					strData = 'act=del&id=' + id;
					strUrl = '/panel/backend/category.php';
					$.ajax({
						type: "POST",
						url: strUrl,
						data: strData
						}).done(function(data) {
							//alert(data);
							arrData = data.split(';');
							if(arrData[0] == 'error') alert("Ошибка: " + arrData[1]);
							else {
								alert('Категория "' + cName + '" удалена');
								window.location.href = '/panel/site/singles/categories';
							}
					});
				}
			</script>
			
			<h3>
				Категории
				&nbsp;&nbsp;&nbsp;
				<input type="button" value="Создать" onclick="showHideCatProp('new');">
			</h3>
			<br><br>
			
			<!-- Форма добавления категории -->
			<div id="catbox_new" class="cat_boxes" style="width: 100%; display: none;">
				<h4>Создать новую категорию</h4><br>
				<div class="left48">
					<input type="text" id="cat_name_new" value="" placeholder="Введите название категории" style="width: 100%;">
					<br><br>
					<input type="text" id="cat_meta_new" value="" placeholder="Введите метатеги" style="width: 100%;">
					<br><br>
					
					<div class="left48">
						<select id="cat_parent_new" style="width: 100%;">
							<option value="0">без категории</option>
							<?php foreach($arrCategories as $cat) : ?>
								<option value="<?php echo $cat['id'];?>"><?php echo $cat['name'];?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="right48">
						<select id="cat_access_new" style="width: 100%;">
							<option value="0">доступ для всех</option>
						</select>
					</div>
					<div class="clear"></div>
				</div>
				
				<div class="right48">
					<textarea id="cat_descript_new" style="width: 100%; height: 64px;" placeholder="Описание"></textarea>
					<br>
					<input type="button" value="Сохранить" onclick="saveCategory('new');">
					&nbsp;&nbsp;
					<input type="button" value="Отмена" onclick="$('.cat_boxes').hide();">
				</div>
				
				<div class="clear"></div>
				<br><br>
			</div>
			<!-- -- -->
			
			<div id="cat_list">
				<?php //print_r($singleList);
				if(empty($arrCategories)) : ?>
					<p style="color: #c11;">Не задано ни одной категории</p>
				<?php else : ?>
					<?php foreach($arrCategories as $itemCat) : ?>
						<div class="left75">
							<a href="javascript: void(0);" id="cat_<?php echo $itemCat['id'];?>" style="text-decoration: none; border-bottom: 1px dashed blue;" onclick="showHideCatProp(<?php echo $itemCat['id'];?>);"><?php echo $itemCat['name'];?></a>
						</div>
						<div class="right25 textright">
							<input type="button" value="Удалить" onclick="delCategory(<?php echo $itemCat['id'];?>)">
						</div>
						<div class="clear"></div>
						
						<div id="catbox_<?php echo $itemCat['id'];?>" class="cat_boxes" style="width: 100%; display: none;">
							<br>
							<div class="left48">
								<input type="text" id="cat_name_<?php echo $itemCat['id'];?>" value="<?php echo $itemCat['name'];?>" placeholder="Введите название категории" style="width: 100%;">
								<br><br>
								<input type="text" id="cat_meta_<?php echo $itemCat['id'];?>" value="<?php echo $itemCat['meta'];?>" placeholder="Введите метатеги" style="width: 100%;">
								<br><br>
								
								<div class="left48">
									<select id="cat_parent_<?php echo $itemCat['id'];?>" style="width: 100%;">
										<option value="0">без категории</option>
										<?php $parent = $itemCat['parent'];
											foreach($arrCategories as $cat) :
												if ($cat['id'] == $parent) $isParent = 'selected';
												else $isParent = ''; ?>
												<option value="<?php echo $cat['id'];?>" <?php echo $isParent;?>><?php echo $cat['name'];?></option>
											<?php endforeach; ?>
									</select>
								</div>
								<div class="right48">
									<select id="cat_access_<?php echo $itemCat['id'];?>" style="width: 100%;">
										<option value="0">доступ для всех</option>
									</select>
								</div>
								<div class="clear"></div>
							</div>
							
							<div class="right48">
								<textarea id="cat_descript_<?php echo $itemCat['id'];?>" style="width: 100%; height: 64px;" placeholder="Описание"><?php echo $itemCat['descript'];?></textarea>
								<br>
								<input type="button" value="Сохранить" onclick="saveCategory(<?php echo $itemCat['id'];?>);">
							</div>
							
							<div class="clear"></div>
						</div>
						<br><br>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
			
<?php if(!isset($_POST['ajax'])) require_once(CURR_PANEL_PATH . 'templates/default/footer.php');?>