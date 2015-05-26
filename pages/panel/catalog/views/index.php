<?php if(!isset($_POST['ajax'])) require_once(ROOT.'/templates/panel/header.php'); ?>
			
			<div id="breadcrumbs">
				<a href="/panel/cabinet/">Рабочий стол</a>
				&nbsp;/&nbsp;
				<span>Каталог</span>
			</div>
			<br><br>
			
			<div class="cab_item" onclick="refPage('catalog/list');">
                <h3>Список каталогов</h3>
                <br>
            </div>
            <div class="cab_item" onclick="refPage('catalog/new');">
                <h3>Создать каталог</h3>
                <br>
            </div>
            <div class="cab_item" onclick="refPage('catalog/import');">
                <h3>Импорт / Экспорт</h3>
                <br>
            </div>
            
			
<?php if(!isset($_POST['ajax'])) require_once(ROOT.'/templates/panel/footer.php'); ?>