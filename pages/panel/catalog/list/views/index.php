<?php if(!isset($_POST['ajax'])) require_once(CURR_PANEL_PATH . 'templates/default/header.php'); ?>
			
			<div id="breadcrumbs">
				<a href="/panel/cabinet/">Рабочий стол</a>
				&nbsp;/&nbsp;
				<a href="javascript: void(0);" onclick="refPage('catalog');">Каталог</a>
				&nbsp;/&nbsp;
				<span>Список каталогов</span>
			</div>
			<br><br>
			
			<style>
				.catalog_box > .left50 > a {text-decoration: none; border-bottom: 1px dashed blue;}
			</style>
			
			<script>
				function showHideCategories(num) {
					isShow = false;
					if($("#catalog_cat_box_" + num).css("display") != "none") isShow = true;
					if(isShow) $("#catalog_cat_box_" + num).hide();
					else {
						hideAllCats();
						$("#catalog_cat_box_" + num).show();
					}
				}
				
				function hideAllCats() {
					$(".catalog_cat_box").hide();
				}
			</script>
			
			<h3>Список каталогов</h3>
			<br><br>
			
			<?php if(empty($listCatalogue)) : ?>
				<p style="color: #c11;">Не найдено ни одного каталога</p>
			<?php else : ?>
				<?php $cnt = 0;
				foreach($listCatalogue as $item) : ?>
					<div class="catalog_box" id="catalog_box_<?php echo $item['id'];?>" style="width: 100%;">
						
						<div class="left50">
							<a href="javascript: void(0);" onclick="showHideCategories(<?php echo $item['id'];?>);"><?php echo $item['name'];?></a>
						</div>
						<div class="left25">&nbsp;</div>
						<div class="left25"></div>
						<div class="clear"></div>
						
						<br><br>
						
						<div id="catalog_cat_box_<?php echo $item['id'];?>" class="catalog_cat_box" style="margin-left: 20px; display: none;">
							<!-- Здесь вывод категорий и форма добавления -->
							<?php foreach($arrCats[$item['id']] as $category) : ?>
								<div class="catalog_cat_line_<?php echo $item['id'];?>" style="margin-bottom: 10px;">
									<div class="left33">
										<a href="/panel/catalog/category/?id=<?php echo $category['id'];?>"><?php echo $category['name'];?></a>
									</div>
									<div class="left25">
										<span><?php echo $category['alias'];?></span>
									</div>
									<div class="left20">&nbsp;</div>
									<div class="left20">
										<a href="/panel/catalog/category/edit/?id=<?php echo $category['id'];?>" style="text-decoration: none;">
											<input type="button" value="Редактировать">
										</a>
									</div>
									<div class="clear"></div>
								</div>
							<?php endforeach; ?>
						</div>
						
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
			
			<br><br><br>
            
			
<?php if(!isset($_POST['ajax'])) require_once(CURR_PANEL_PATH . 'templates/default/footer.php');?>