<?php if(!isset($_POST['ajax'])) require_once(ROOT.'/templates/panel/header.php'); ?>
			
			<div id="breadcrumbs">
				<a href="/panel/cabinet/">Рабочий стол</a>
				&nbsp;/&nbsp;
				<span>Магазин</span>
			</div>
			<br><br>
			
			<div class="cab_item" onclick="refPage('store/orders');">
                <h3>Заказы</h3>
                <br>
            </div>
            <div class="cab_item" onclick="refPage('store/warehouse');">
                <h3>Склад</h3>
                <br>
            </div>
            <div class="cab_item" onclick="refPage('store/payment');">
                <h3>Платежные системы</h3>
                <br>
            </div>
            
			
<?php if(!isset($_POST['ajax'])) require_once(ROOT.'/templates/panel/footer.php'); ?>