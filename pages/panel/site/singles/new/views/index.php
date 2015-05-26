<?php if(!isset($_POST['ajax'])) require_once(CURR_PANEL_PATH . 'templates/default/header.php'); ?>
			
			<div id="breadcrumbs">
				<a href="/panel/cabinet/">Рабочий стол</a>
				&nbsp;/&nbsp;
				<a href="javascript: void(0);" onclick="refPage('site');">Сайт</a>
				&nbsp;/&nbsp;
				<a href="javascript: void(0);" onclick="refPage('site/singles');">Записи</a>
				&nbsp;/&nbsp;
				<span>Новая запись</span>
			</div>
			<br><br>
			
<script type="text/javascript" src="/panel/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "imagemanager,filemanager,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "/panel/templates/<?php echo STR_TEMPLATE_NAME;?>/css/style.css",
		
		language: "ru",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "/panel/js/tiny_mce/lists/template_list.js",
		external_link_list_url : "/panel/js/tiny_mce/lists/link_list.js",
		external_image_list_url : "/panel/js/tiny_mce/lists/image_list.js",
		media_external_list_url : "/panel/js/tiny_mce/lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "<?php echo $isSession['uname'];?>",
			staffid : "<?php echo $isSession['uname'];?>"
		}
	});
</script>
<!-- /TinyMCE -->
			
			<h3>Новая запись</h3>
            <br><br>
			
			<div style="">
				
				<input type="text" id="ns_name" style="width: 100%;" value="" placeholder="Название записи">
				<br><br>
				
				<div class="left48">
					<input type="text" id="ns_url" style="width: 100%" value="" placeholder="ссылка на запись (необязательно)">
				</div>
				<div class="right48" style="margin-left: 1%;">
					<input type="text" id="ns_meta" style="width: 100%;" value="" placeholder="Мета теги">
				</div>
				<br><br>
				
				<div class="left48">
					<select id="ns_cat" style="min-width: 240px;">
						<option value="0">Без категории</option>
						<?php if(!empty($arrCategories)) : ?>
							<?php foreach($arrCategories as $cat) : ?>
								<option value="<?php echo $cat['id'];?>"><?php echo $cat['name'];?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>
				<div class="right48" style="margin-left: 1%;">
					<input type="checkbox" id="ns_show" value="1" checked>
					&nbsp;&nbsp;
					<label for="ns_show">показывать запись</label>
				</div>
				<br><br><br>
				
				<div class="clear"></div>
				
				<!-- Gets replaced with TinyMCE, remember HTML in a textarea should be encoded -->
				<div>
					<textarea id="elm1" name="elm1" rows="25" cols="160" style="width: 100%;"></textarea>
				</div>
				
				<br><br><br>
				<input type="button" name="save" value="Сохранить" onclick="singleSave();" />&nbsp;&nbsp;&nbsp;
				<input type="button" name="reset" value="Назад" onclick="singleReset();" />
				
				<br><br><br>
				
				<script>
					function singleSave() {
						if($("#ns_show").is(":checked")) isShow = 1;
						else isShow = 0;
						strData = 'act=new&name=' + $("#ns_name").val() + '&code=' + tinyMCE.get('elm1').getContent() + '&meta=' + $("#ns_meta").val() + '&url=' + $("#ns_url").val() + '&show=' + isShow + '&cat=' + $("#ns_cat").val();
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
									alert('Запись сохранена');
									window.location.href = '/panel/site/singles';
								}
						});
					}
					
					function singleReset() {
						window.location.href = '/panel/site/singles';
					}
				</script>
				
			</div>
			
<?php if(!isset($_POST['ajax'])) require_once(CURR_PANEL_PATH . 'templates/default/footer.php');?>