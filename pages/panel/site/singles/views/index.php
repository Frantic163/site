<?php if(!isset($_POST['ajax'])) require_once(CURR_PANEL_PATH . 'templates/default/header.php'); ?>
			
			<div id="breadcrumbs">
				<a href="/panel/cabinet/">Рабочий стол</a>
				&nbsp;/&nbsp;
				<a href="javascript: void(0);" onclick="refPage('site');">Сайт</a>
				&nbsp;/&nbsp;
				<span>Записи</span>
			</div>
			<br><br>
			
			<h3>Записи</h3>
			<br>
			<div>
				<label>Выберите категорию:</label>&nbsp; &nbsp;
				<select id="single_cat_list" style="min-width: 180px;" onselect="">
					<option value="0">Все записи</option>
					<?php if(!empty($arrCategories)) : ?>
						<?php foreach($arrCategories as $cat) : ?>
							<option value="<?php echo $cat['id'];?>"><?php echo $cat['name'];?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
				&nbsp;&nbsp;&nbsp;
				<!--input type="button" value="добавить категорию" onclick=""-->
				<a href="/panel/site/singles/categories/">редактировать категории</a>
				&nbsp;&nbsp;&nbsp;
				<a href="/panel/site/singles/new/" style="text-decoration: none !important;">
					<input type="button" value="новая запись" onclick="">
				</a>
			</div>
			<div class="clear"></div>
			<br><br>
			
			<div id="single_list">
				<?php //print_r($singleList);
				if(empty($singleList)) : ?>
					<p style="color: #c11;">Нет ни одной записи в выбранной категории</p>
				<?php else : ?>
					<table style="width: 100%;">
						<tr>
							<th style="text-align: left;">#</th>
							<th style="text-align: left;">Название</th>
							<th style="text-align: left;">Видимость</th>
							<th style="text-align: left;">Категория</th>
							<th></th>
						</tr>
						<?php foreach($singleList as $single) : ?>
							<tr id="single_<?php echo $single['id'];?>">
								<td><?php echo $single['id'];?></td>
								<td>
									<a href="/panel/site/singles/?id=<?php echo $single['id'];?>" id="sn_<?php echo $single['id'];?>"><?php echo $single['name'];?></a>
								</td>
								<td>
									<?php $tmpShow = $single['show'] * 1;
									if($tmpShow > 0) $isShow = 'checked';
									else $isShow = '';?>
									<!--input type="checkbox" id="show_sgl_<?php echo $single['id'];?>" <?php echo $isShow;?>>
									&nbsp;-->
									<label><!--for="show_sgl_<?php echo $single['id'];?>"-->показывать</label>
								</td>
								<td><?php echo $single['cat'];?></td>
								<td>
									<input type="button" value="Удалить" onclick="delSingle(<?php echo $single['id'];?>);">
								</td>
							</tr>
						<?php endforeach; ?>
					</table>
				<?php endif; ?>
			</div>
			
			<script>
				function delSingle(sid) {
					sName = $("#sn_" + sid).html();
					if(!confirm("Удалить запись \"" + sName + "\"?")) return false;
					
					strData = 'act=del&id=' + sid;
					strUrl = '/panel/backend/single.php';
					$.ajax({
						type: "POST",
						url: strUrl,
						data: strData
						}).done(function(data) {
							//alert(data);
							arrData = data.split(';');
							if(arrData[0] == 'error') alert("Ошибка: " + arrData[1]);
							else {
								alert('Запись "' + sName + '" удалена');
								window.location.href = '/panel/site/singles';
							}
					});
				}
			</script>
			
<?php if(!isset($_POST['ajax'])) require_once(CURR_PANEL_PATH . 'templates/default/footer.php');?>