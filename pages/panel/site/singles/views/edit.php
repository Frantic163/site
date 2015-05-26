<?php if(!isset($_POST['ajax'])) require_once(CURR_PANEL_PATH . 'templates/default/header.php'); ?>
			
			<div id="breadcrumbs">
				<a href="/panel/cabinet/">Рабочий стол</a>
				&nbsp;/&nbsp;
				<a href="javascript: void(0);" onclick="refPage('site');">Сайт</a>
				&nbsp;/&nbsp;
				<a href="javascript: void(0);" onclick="refPage('site/singles');">Записи</a>
				&nbsp;/&nbsp;
				<span>Редактирование записи</span>
			</div>
			<br><br>
			
<!-- TinyMCE -->
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
			
			<script>
				function changeSingleLine(n) {
					if(n == 1) {
						$("#single_name_change").hide();
						$("#single_name_box").show();
					}
					else {
						$("#single_change_url").hide();
						$("#single_url_span").hide();
						$("#single_url_btn").show();
						$("#single_url").attr("type", "text");
					}
				}
				
				function saveSingleLine(n) {
					if(n == 1) {
						$("#single_name_span").html($("#single_name").val());
						$("#single_name_box").hide();
						$("#single_name_change").show();
					}
					else {
						tmpUrl = $("#single_url").val();
						if(tmpUrl.length < 1) tmpUrl = '/index.php?id=' + $("#single_id").val();
						$("#single_url_span").html(tmpUrl);
						$("#single_url").attr("type", "hidden");
						$("#single_change_url").show();
						$("#single_url_btn").hide();
						$("#single_url_span").show();
					}
				}
			</script>
			
			<h3>
				Редактирование записи "<span id="single_name_span"><?php echo $currSingle['name'];?></span>"
				&nbsp;&nbsp;&nbsp;
				<a href="javascript: void(0);" id="single_name_change" onclick="changeSingleLine(1);">изменить</a>
			</h3>
			<br><br>
			
			<form method="post" action=""><!--http://tinymce.moxiecode.com/dump.php?example=true"-->
				<input type="hidden" id="single_act" name="act" value="edit">
				<input type="hidden" id="single_id" name="id" value="<?php echo $currSingle['id'];?>">
				
				<!-- Редактируем название -->
				<div id="single_name_box" style="width: 100%; display: none;">
					<div class="left15">
						<b>название:</b>
					</div>
					<div class="left85">
						<input type="text" id="single_name" name="name" value="<?php echo $currSingle['name'];?>">
						&nbsp;&nbsp;&nbsp;
						<input type="button" value="Ok" id="single_name_btn" onclick="saveSingleLine(1)">
					</div>
					<div class="clear"></div>
					<br><br>
				</div>
				<!------>
				
				<!-- Редактируем условный путь к записи -->
				<?php if(empty($currSingle['url'])) $url = '/index.php?id=' . $currSingle['id'];
				else $url = $currSingle['url'];?>
				<div class="left15">
					<b>ссылка:</b>
				</div>
				<div class="left33">
					<span id="single_url_span"><?php echo $url;?></span>
					<input type="hidden" id="single_url" name="url" value="<?php echo $currSingle['url'];?>">
					&nbsp;&nbsp;&nbsp;
					<a href="javascript: void(0);" id="single_change_url" onclick="changeSingleLine(2);">изменить</a>
					<input type="button" value="Ok" id="single_url_btn" onclick="saveSingleLine(2)" style="display: none;">
				</div>
				<div class="clear"></div>
				<!------>
				
				<br><br>
				
				<!-- Редактируем метатеги записи -->
				<div class="left15">
					<b>метатеги:</b>
				</div>
				<div class="left85">
					<input type="text" id="single_meta" name="meta" value="<?php echo $currSingle['meta'];?>" style="width: 100%">
				</div>
				<div class="clear"></div>
				<!------>
				
				<br><br>
				
				<!-- Gets replaced with TinyMCE, remember HTML in a textarea should be encoded -->
				<div>
					<textarea id="elm1" name="elm1" rows="25" cols="160" style="width: 100%;">
						<?php echo $currSingle['code'];?>
					</textarea>
				</div>
				
				<br>
				
				<!-- Редактируем категорию записи -->
				<div class="left15">
					<b>категория:</b>
				</div>
				<div class="left33">
					<select id="single_cat" name="cat">
						<option value="0">без категории</option>
						<?php if(!empty($arrCategories)) : ?>
							<?php $tmpCat = $currSingle['cat'];
							foreach($arrCategories as $cat) :
								if($cat['id'] == $tmpCat) $isSel = 'selected';
								else $isSel = '';?>
								<option value="<?php echo $cat['id'];?>" <?php echo $isSel;?>><?php echo $cat['name'];?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>
				<div class="clear"></div>
				<!------>
				
				<br><br>
				
				<!-- Включаем / отключаем показ -->
				<?php $tmpShow = $currSingle['show'] * 1;
				if($tmpShow > 0) $isChk = 'checked';
				else $isChk = '';?>
				<div class="left15">&nbsp;</div>
				<div class="left33">
					<input type="checkbox" id="single_show" name="show" value="1" <?php echo $isChk;?>>&nbsp;
					<label for="single_show">показывать запись</label>
				</div>
				<!------>
				
				<br><br><br>
				<input type="button" name="save" value="Сохранить" onclick="singleSave();" />&nbsp;&nbsp;&nbsp;
				<input type="button" name="reset" value="Назад" onclick="singleReset();" />
				
			</form>
			
			<br><br>
			
			<script>
				function singleSave() {
					if($("#single_show").is(":checked")) isShow = 1;
					else isShow = 0;
					strData = 'act=edit&id=' + $("#single_id").val() + '&name=' + $("#single_name_span").html() + '&code=' + tinyMCE.get('elm1').getContent() + '&meta=' + $("#single_meta").val() + '&url=' + $("#single_url").val() + '&show=' + isShow + '&cat=' + $("#single_cat").val();
					strUrl = '/panel/backend/single.php';
					$.ajax({
						type: "POST",
						url: strUrl,
						data: strData
						}).done(function(data) {
							//alert(data);
							arrData = data.split(';');
							if(arrData[0] == 'error') alert("Ошибка: " + arrData[1]);
							else alert('Запись сохранена');
					});
				}
				
				function singleReset() {
					window.location.href = '/panel/site/singles';
				}
			</script>
			
<?php if(!isset($_POST['ajax'])) require_once(CURR_PANEL_PATH . 'templates/default/footer.php');?>