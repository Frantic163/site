<?php if(!isset($_POST['ajax'])) require_once(ROOT.'/templates/panel/header.php'); ?>
			
			<div id="breadcrumbs">
				<a href="/panel/cabinet/">Рабочий стол</a>
				&nbsp;/&nbsp;
				<span>Пользователи</span>
			</div>
			<br><br>
			
			<div class="cab_item" onclick="refPage('users/userlist');">
                <h3>Список пользователей</h3>
                <br>
            </div>
            <div class="cab_item" onclick="refPage('users/roles');">
                <h3>Роли пользователей</h3>
                <br>
            </div>
            <div class="cab_item" onclick="refPage('users/blocks');">
                <h3>Блокировки</h3>
                <br>
            </div>
            
			
<?php if(!isset($_POST['ajax'])) require_once(ROOT.'/templates/panel/footer.php'); ?>