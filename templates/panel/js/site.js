// сохраняем настройки дефолтного шаблона
function saveTemplate() {
	strData = 'act=edit&tmpl=' + $("#main_tmpl_select").val();
	strUrl = '/panel/backend/site_templates.php';
	$.ajax({
		type: "POST",
		url: strUrl,
		data: strData
		}).done(function(data) {
			//alert(data);
			arrData = data.split(';');
			if(arrData[0] == 'error') alert("Ошибка: " + arrData[1]);
			else alert('Настройки сохранены');
	});
}