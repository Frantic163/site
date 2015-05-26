<?php if(!isset($_POST['ajax'])) require_once(CURR_PANEL_PATH . 'templates/default/header.php'); ?>
			
			<div id="breadcrumbs">
				<a href="/panel/cabinet/">Рабочий стол</a>
				&nbsp;/&nbsp;
				<a href="javascript: void(0);" onclick="refPage('catalog/list');">Каталоги</a>
				&nbsp;/&nbsp;
				<span><?php echo $catalogName . " -> " . $categoryName;?></span>
			</div>
			<br><br>
			
			<style>
				#add_box {
					position: absolute;
					top: 48px;
					left: 360px;
				}
			</style>
			
			<h3><?php echo $categoryName;?></h3>
			<br><br>
			
			<div id="add_box">
				<a href="/panel/catalog/product/new/?cid=<?php echo $cid;?>" style="text-decoration: none;">
					<input type="button" value="Новый товар">
				</a>
			</div>
			
			<?php if(empty($productList)) : ?>
				<p style="color: #c11;">Не найдено ни одного товара</p>
			<?php else : ?>
				<?php foreach($productList as $product) : ?>
					<div id="product_<?php echo $product['id'];?>">
						<div class="left50">
							<a href="/panel/catalog/product/?id=<?php echo $product['id'];?>"><?php echo $product['name'];?></a>
						</div>
						<div class="left25">&nbsp;</div>
						<div class="left25">
							<a href="javascript:void(0);" style="text-decoration: none;" onclick="delProduct(<?php echo $product['id'];?>)">x</a>
						</div>
						<div class="clear"></div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
			
			<br><br><br>
            
			
<?php if(!isset($_POST['ajax'])) require_once(CURR_PANEL_PATH . 'templates/default/footer.php');?>