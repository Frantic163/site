<?php if(!isset($_POST['ajax'])) require_once(ROOT.'/templates/panel/header.php'); ?>
			
			<div id="breadcrumbs">
				<a href="/panel/cabinet/">Рабочий стол</a>
				&nbsp;/&nbsp;
				<span>Сайт</span>
			</div>
			<br><br>
			
			<div class="cab_item" onclick="refPage('site/pages');">
                <h3>Файлы и папки</h3>
                <br>
            </div>
            <div class="cab_item" onclick="refPage('site/singles');">
                <h3>Записи</h3>
                <br>
            </div>
            <div class="cab_item" onclick="refPage('site/templates');">
                <h3>Шаблоны</h3>
                <br>
            </div>
            <div class="cab_item" onclick="refPage('site/menu');">
                <h3>Меню</h3>
                <br>
            </div>
            
			
<?php if(!isset($_POST['ajax'])) require_once(ROOT.'/templates/panel/footer.php'); ?>