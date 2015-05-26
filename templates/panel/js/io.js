var socket = io.connect('149.154.65.130:9009');

socket.on('connect', function () {
	
	// при ошибке подключения
	socket.on('err_number', function() {
		alert('Ошибка подключения');
	});
	
	// при дисконнекте
	socket.on('hub_disconnect', function() {
		alert('хаб недоступен');
		if($("#edit_hub_addsens_btn").val() == "Закончить операцию") {
			$("#edit_hub_addsens_btn").val('Добавить датчики');
			$("#edit_hub_console").hide();
			$("#edit_hub_save_btn").show();
			$("#edit_hub_addsens_btn").attr('onclick', 'addHubSens(' + num + ');');
		}
		if($("#edit_learn_btn").val() == 'Отмена') {
			$("#edit_console_log").hide();
			$("#edit_port_name").removeAttr('disabled');
			$("#edit_save_btn").show();//removeAttr('disabled');
			$("#edit_port_learn_val").removeAttr('disabled');
			$("#edit_learn_btn").val('Обучить');
		}
	});
	
	// обновляем список датчиков
	socket.on('renew_list', function() {
		currPath = $("#curr_path").val();
		ajaxLoadPath(currPath);
	});
	
	// обновляем кол-во найденных датчиков (хаб в режиме hubmode=2)
	socket.on('new_sens_cnt', function(data) {
		addNewCnt = data * 1;
		currCnt = $("#edit_hub_sensors").html() * 1;
		newCnt = currCnt + addNewCnt;
		$("#edit_hub_sensors").html( newCnt );
	});
	
	// прием обновленных данных с датчиков
	socket.on('recv_data', function (data) {
		// принимаем данные
		arrData = data.split(";");
		if(arrData[1] == undefined || arrData[2] == undefined) return;
		sens = arrData[0] * 1;
		port = arrData[1] * 1;
		val = arrData[2] * 1;
		findID = sens + '' + port;
		switch(port) {
			// питание
			case 1:
				hexNum = parseInt(sens, 10).toString(16);
				if(hexNum.length < 8) hexNum = '0' + hexNum;
				sensType = hexNum[0] + hexNum[1];
				if(sensType != '06') {
					if(val === 1) {
						tmpPic = '<img src="/panel/templates/default/images/sens/light_on.png" alt="вкл">';
						newClick = "sendCommand(" + sens + ", 1, 0);";
					}
					else {
						tmpPic = '<img src="/panel/templates/default/images/sens/all_off.png" alt="выкл">';
						newClick = "sendCommand(" + sens + ", 1, 1);";
					}
				}
				else {
					if(val === 1) {
						tmpPic = '<img src="/panel/templates/default/images/sens/light_on.png" alt="ON" title="ON">';
						newClick = "sendPortCommand(" + sens + ", 1, 0);";
						$("#" + sens + '9').removeAttr('disabled');
					}
					else {
						tmpPic = '<img src="/panel/templates/default/images/sens/all_off.png" alt="OFF" title="OFF">';
						newClick = "sendPortCommand(" + sens + ", 1, 1);";
						$("#" + sens + '9').attr('disabled', 'disabled');
					}
				}
				$("#" + findID).html(tmpPic);
				$("#" + findID).attr('onclick', newClick);
				break;
			case 2:
			case 3:
			case 4:
			case 7:
			case 8:
				if(port === 2) portPic = 'cool';
				else if(port === 3) portPic = 'heat';
				else if(port === 4) portPic = 'dry';
				else if(port === 7) portPic = 'auto';
				else if(port === 8) portPic = 'flap';
				if(val === 1) {
					tmpPic = '<img src="/panel/templates/default/images/' + portPic + '_on.png" alt="ON" title="ON">';
					newClick = "sendPortCommand(" + sens + ", " + port + ", 0);";
				}
				else {
					tmpPic = '<img src="/panel/templates/default/images/' + portPic + '_off.png" alt="OFF" title="OFF">';
					newClick = "sendPortCommand(" + sens + ", " + port + ", 1);";
				}
				$("#" + findID).html(tmpPic);
				$("#" + findID).attr('onclick', newClick);
				break;
			case 5:
				newVal = val + 1;
				if(val > 0) tmpPic = '<img src="/panel/templates/default/images/fan_on.png" alt="x' + val + '" title="x' + val + '">';
				else tmpPic = '<img src="/panel/templates/default/images/fan_off.png" alt="OFF" title="OFF">';
				if(newVal > 4) newClick = "sendPortCommand(" + sens + ", " + port + ", 0);";
				else newClick = "sendPortCommand(" + sens + ", " + port + ", " + newVal + ");";
				$("#" + findID).html(tmpPic);
				$("#" + findID).attr('onclick', newClick);
				if(val > 0) $("#" + findID + "span").html('x' + val);
				else $("#" + findID + "span").html('OFF');
				break;
			//case 6:
			case 9:
				$("#" + findID).val(val);
				$("#" + findID + "range").html(val + '&deg;');
				break;
			// батарейка
			case 10:
				tmp = (val / 2.55);
				tmpBat = tmp.toFixed(1);
				if(tmpBat > 90) picBat = 'full';
				else if(tmpBat > 70) picBat = '80';
				else if(tmpBat > 50) picBat = '60';
				else if(tmpBat > 20) picBat = '40';
				else picBat = 'low';
				tmpPic = '/panel/templates/default/images/sens/bat_' + picBat + '.png';
				$("#" + findID).attr('src', tmpPic);
				$("#" + findID).attr('alt', tmpBat+'%');
				$("#" + findID).attr('title', tmpBat+'%');
				tmpBat = $("#" + findID + "span").html();
				if(tmpBat != undefined) $("#" + findID + "span").html(tmpBat);
				break;
			// датчик температуры
			case 11:
				tmpTemp = val / 10;
				$("#" + findID).html(tmpTemp + '&deg;');
				break;
			// влажность (ИК)
			case 12:
				tmpTemp = val / 10;
				$("#" + findID).html(tmpTemp + '%');
				break;
			// освещенность
			case 13:
				tmp = val / 2.55;
				tmpLt = tmp.toFixed(1);
				if(tmpLt < 10) picLt = '0';
				else if(tmpLt < 37.5) picLt = '25';
				else if(tmpLt < 67.5) picLt = '50';
				else if(tmpLt < 90) picLt = '75';
				else tmpLt = 'full';
				tmpPic = "/panel/templates/default/images/sens/sun_" + picLt + ".png";
				$("#" + findID).attr('src', tmpPic);
				$("#" + findID).attr('alt', tmpLt+'%');
				$("#" + findID).attr('title', tmpLt+'%');
				break;
			// движение
			case 14:
				if(val === 1) {
					tmpPic = '/panel/templates/default/images/sens/move_yes.png';
					isMove = 'движение есть';
				}
				else {
					tmpPic = '/panel/templates/default/images/sens/move_no.png';
					isMove = 'нет движения';
				}
				$("#" + findID).attr('src', tmpPic);
				$("#" + findID).attr('alt', isMove);
				$("#" + findID).attr('title', isMove);
				break;
			// протечка
			case 15:
				if(val === 1) tmpPic = '/panel/templates/default/images/sens/leak.png';
				else tmpPic = '/panel/templates/default/images/sens/safe_ok.png';
				$("#" + findID).attr('src', tmpPic);
				break;
			// состояние клапана
			case 16:
				if(val === 1) {
					tmpPic = '<img src="/panel/templates/default/images/sens/light_on.png" alt="вкл">';
					newClick = "sendCommand(" + sens + ", 17, 2);";
				}
				else {
					tmpPic = '<img src="/panel/templates/default/images/sens/all_off.png" alt="выкл">';
					newClick = "sendCommand(" + sens + ", 17, 1);";
				}
				$("#" + findID).html(tmpPic);
				$("#" + findID).attr('onclick', newClick);
				break;
			// команда клапану
			//case 17:
			// дверь
			case 18:
				if(val === 1) tmpPic = '/panel/templates/default/images/sens/door.png';
				else tmpPic = '/panel/templates/default/images/sens/safe_ok.png';
				$("#" + findID).attr('src', tmpPic);
				break;
			// RGBW
			case 19:
				hexNum = parseInt(val, 10).toString(16);
				while(hexNum.length < 8) hexNum = '0' + hexNum;
				$("#" + findID + 'Rrange').html(hexNum[0] + hexNum[1]);
				$("#" + findID + 'Grange').html(hexNum[2] + hexNum[3]);
				$("#" + findID + 'Brange').html(hexNum[4] + hexNum[5]);
				$("#" + findID + 'Wrange').html(hexNum[6] + hexNum[7]);
				$("#" + findID + 'R').val(parseInt('0x' + hexNum[0] + hexNum[1]));
				$("#" + findID + 'G').val(parseInt('0x' + hexNum[2] + hexNum[3]));
				$("#" + findID + 'B').val(parseInt('0x' + hexNum[4] + hexNum[5]));
				$("#" + findID + 'W').val(parseInt('0x' + hexNum[6] + hexNum[7]));
				$("#" + sens + 'color').val('#' + hexNum[0] + hexNum[1] + hexNum[2] + hexNum[3] + hexNum[4] + hexNum[5]);
				break;
			//case 20:
			// крутилка света для диммера
			case 21:
				$("#" + findID).val(val);
				tmp =  val / 2.55;
				viewVal = tmp.toFixed();
				$("#" + sens + port + 'range').html(viewVal + '%');
				break;
			default:
				return;
		}
	});
	
	// обрабатываем дисконнект
	socket.on('disconnect', function() {
		alert('server disconnect!');
	});
});

// обрабатываем старт speed button
function startSpeedScript(num) {
	socket.emit('speed_btn', num);
}

// открытие/закрытие управления цветом
function openColor(sid) {
	if($("#light_panel_" + sid).css('display') != 'none') $("#light_panel_" + sid).hide();
	else $("#light_panel_" + sid).show();
}

// команды от ползунков RGBW
function setColorRange(sid, cnl) {
	switch(cnl) {
		case 1:
			tmpR = $("#" + sid + "19R").val() * 1;
			tmpHexR = parseInt(tmpR, 10).toString(16);
			$("#" + sid + "19Rrange").html( tmpHexR );
			tmpHexG = $("#" + sid + "19Grange").html();
			tmpHexB = $("#" + sid + "19Brange").html();
			tmpHexW = $("#" + sid + "19Wrange").html();
			$("#" + sid + 'color').val('#' + tmpHexR + tmpHexG + tmpHexB);
			newVal = parseInt('0x' + tmpHexR + tmpHexG + tmpHexB + tmpHexW);
			break;
		case 2:
			tmpG = $("#" + sid + "19G").val() * 1;
			tmpHexG = parseInt(tmpG, 10).toString(16);
			$("#" + sid + "19Grange").html( tmpHexG );
			tmpHexR = $("#" + sid + "19Rrange").html();
			tmpHexB = $("#" + sid + "19Brange").html();
			tmpHexW = $("#" + sid + "19Wrange").html();
			$("#" + sid + 'color').val('#' + tmpHexR + tmpHexG + tmpHexB);
			newVal = parseInt('0x' + tmpHexR + tmpHexG + tmpHexB + tmpHexW);
			break;
		case 3:
			tmpB = $("#" + sid + "19B").val() * 1;
			tmpHexB = parseInt(tmpB, 10).toString(16);
			$("#" + sid + "19Brange").html( tmpHexB );
			tmpHexR = $("#" + sid + "19Rrange").html();
			tmpHexG = $("#" + sid + "19Grange").html();
			tmpHexW = $("#" + sid + "19Wrange").html();
			$("#" + sid + 'color').val('#' + tmpHexR + tmpHexG + tmpHexB);
			newVal = parseInt('0x' + tmpHexR + tmpHexG + tmpHexB + tmpHexW);
			break;
		default:
			tmpW = $("#" + sid + "19W").val() * 1;
			tmpHexW = parseInt(tmpW, 10).toString(16);
			$("#" + sid + "19Wrange").html( tmpHexW );
			tmpHexR = $("#" + sid + "19Rrange").html();
			tmpHexG = $("#" + sid + "19Grange").html();
			tmpHexB = $("#" + sid + "19Brange").html();
			newVal = parseInt('0x' + tmpHexR + tmpHexG + tmpHexB + tmpHexW);
	}
	if($("#" + sid + "1").find('img:first').attr('src').indexOf('light_on') > 0) {
		strSend = sid + ';19;' + newVal;
		socket.emit('send_command', strSend);
	}
}

// команды от задатчика цвета
function setColor(sid) {
	currColor = $("#" + sid + "color").val();
	tmp = currColor.replace('#', '');
	newRed = tmp[0] + tmp[1];
	newGreen = tmp[2] + tmp[3];
	newBlue = tmp[4] + tmp[5];
	newValHex = tmp + $("#" + sid + "19Wrange").html();
	newVal = parseInt('0x' + newValHex);
	$("#" + sid + "19Rrange").html(newRed);
	$("#" + sid + "19Grange").html(newGreen);
	$("#" + sid + "19Brange").html(newBlue);
	$("#" + sid + "19R").val(parseInt('0x' + newRed));
	$("#" + sid + "19G").val(parseInt('0x' + newGreen));
	$("#" + sid + "19B").val(parseInt('0x' + newBlue));
	if($("#" + sid + "1").find('img:first').attr('src').indexOf('light_on') > 0) {
		strSend = sid + ';19;' + newVal;
		socket.emit('send_command', strSend);
	}
}

// команды с задатчика температуры
function sendPortRange(sens, port) {
	power = $("#" + sens + '1').attr('alt');
	// если устройство выключено
	if(power == 'OFF') return;
	val = $("#" + sens + port).val();
	// задаем температуру
	if(port === 9) $("#" + sens + port + 'range').html(val + '&deg;');
	// или значение в %
	else {
		tmp = val / 2.55;
		tmpVal = tmp.toFixed();
		$("#" + sens + port + 'range').html( tmpVal );
	}
	strSend = sens + ';' + port + ';' + val;
	socket.emit('send_command', strSend);
}

// отправляем команды для ИК-датчика
function sendPortCommand(sens, port, val) {
	power = $("#" + sens + '1').find('img:first').attr('alt');
	// если устройство выключено
	if(port !== 1 && power == 'OFF') return;
	// если порт зависимый
	if(val === 0 && port !== 1 && port !== 5 && port !== 8) return;
	// распортовка
	switch(port) {
		case 1:
			if(val === 0) $("#" + sens + '9').attr('disabled', 'disabled');
			else $("#" + sens + '9').removeAttr('disabled');
			break;
			
		case 2:
		case 3:
		case 4:
		case 7:
			/*socket.emit('send_command', sens + ';2;0');
			socket.emit('send_command', sens + ';3;0');
			socket.emit('send_command', sens + ';4;0');
			socket.emit('send_command', sens + ';7;0');*/
			break;
		
		default:
			break;
	}
	// отправка основной команды
	strData = sens + ";" +  port + ";" + val;
	socket.emit('send_command', strData);
}

// отправляем команды с ползунка
function sendRange(sens, port) {
	val = $("#" + sens + port).val();
	tmp = val / 2.55;
	viewVal = tmp.toFixed();
	$("#" + sens + port + 'range').html(viewVal + '%');
	strSend = sens + ';' + port + ';' + val;
	socket.emit('send_command', strSend);
}

// отправляем команду на хаб
function sendCommand(sens, port, val) {
	strSend = sens + ';' + port + ';' + val;
	socket.emit('send_command', strSend);
}

// устанавливаем хаб
function setHub(hub) {
	pathName = $("#curr_path").val();
	strUrl = '/panel/' + pathName + '/index.php';
	strData = "ajax=1&hub=" + hub;
	$.ajax({
		type: "POST",
		url: strUrl,
		data: strData
		}).done(function(data) {
			if(data == 'access denied') alert('ошибка загрузки контента');
			else {
				$("#main>.wrapper").html('');
				$("#main>.wrapper").html(data);
			}
	});
}