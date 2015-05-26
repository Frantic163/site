<?php if(!isset($_POST['ajax'])) require_once(ROOT.'/templates/panel/header.php'); ?>
			
			<div id="breadcrumbs">
				<a href="/panel/cabinet/">Рабочий стол</a>
				&nbsp;/&nbsp;
				<a href="javascript: void(0);" onclick="refPage('site');">Сайт</a>
				&nbsp;/&nbsp;
				<span>Файлы и папки</span>
			</div>
			<br><br>
			
			<h3>Файлы и папки</h3>
			<br><br>
			<div id="elfinder"></div>
			<br><br>
			
			<!-- jQuery and jQuery UI (REQUIRED) -->
			<link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css">
			<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
			<!-- elFinder CSS (REQUIRED) -->
			<link rel="stylesheet" type="text/css" media="screen" href="/templates/panel/css/elfinder.min.css">
			<link rel="stylesheet" type="text/css" media="screen" href="/templates/panel/css/theme.css">
			<!-- elFinder JS (REQUIRED) -->
			<script type="text/javascript" src="/templates/panel/js/elfinder.min.js"></script>
			<!-- elFinder translation (OPTIONAL) -->
			<script type="text/javascript" src="/templates/panel/js/i18n/elfinder.ru.js"></script>
			<!-- elFinder initialization (REQUIRED) -->
			<script type="text/javascript" charset="utf-8">
				$(document).ready(function() {
					var elf = $('#elfinder').elfinder({
						url : '/panel/backend/elfinder/connector.php',  // connector URL (REQUIRED)
						lang: 'ru',             // language (OPTIONAL)
					}).elfinder('instance');
				});
			</script>
			
<?php if(!isset($_POST['ajax'])) require_once(ROOT.'/templates/panel/footer.php'); ?>