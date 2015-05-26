<?php if(!isset($_POST['ajax'])) require_once(ROOT.'/templates/panel/header.php'); ?>
			
			<div id="breadcrumbs">
				<a href="/panel/cabinet/">Рабочий стол</a>
				&nbsp;/&nbsp;
				<a href="javascript: void(0);" onclick="refPage('site');">Сайт</a>
				&nbsp;/&nbsp;
				<span>Шаблоны</span>
			</div>
			<br><br>
			
			<h3>Шаблоны сайта</h3>
			<br>
			<div class="left25">
				<label>Основной шаблон сайта:</label>
			</div>
			<div class="left25">
				<select id="main_tmpl_select" style="min-width: 180px;">
					<?php foreach($arrTemplates as $tmpl) : ?>
						<?php if($tmpl == $defTmpl) $issel = 'selected';
						else $issel = ''; ?>
						<option value="<?php echo $tmpl;?>" <?php echo $issel;?>><?php echo $tmpl; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="left33">
				<input type="button" value="Сохранить" onclick="saveTemplate();">
			</div>
			<div class="clear"></div>
			
<?php if(!isset($_POST['ajax'])) require_once(ROOT.'/templates/panel/footer.php'); ?>