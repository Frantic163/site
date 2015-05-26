// открываем раздел меню
function refPage(url) {
	window.location.assign( '/panel/' + url + '/');
}

// Функция открытия закрытия всплывающих меню (div class='popup-menu')
function showPopup(elName) {
	elTarget = $('#'+elName);
	if($(elTarget).css('display') == 'none') {
		$(elTarget).show();
		$('#popup-field').css({'width':'100%','height':'100%'});
		$('#popup-field').show();
	}
	else {
		$('#popup-field').click();
	}
	return false;
}

function showPopupMenu() {
	showPopup('usermenu_popup');
	fTop = $(document).scrollTop();
	$('#popup-field').css('top',fTop+'px');
}

// Функция "прибития" футера к низу
function moveFooter() {
	headH = $('header:first').height();
	pageH = $('.content:first').height();
	fooH = $('footer:first').height();
	winH = $(window).height();
	htmlH = headH + pageH + fooH;
	if(winH > htmlH) {
		deltaH = winH - htmlH + 40;
		$('#rasporka').css('height',deltaH+'px');
	}
}

// инициализация функций
$(document).ready(function() {
	// Функция закрытия всех всплывающих окон и меню
	$('#popup-field').click(function() {
		$('.popup-menu').each(function(id, el) {
			$(el).hide();
			$('#popup-field').css('width','0');
			$('#popup-field').css('height','0');
			$('#popup-field').css('background','transparent');
			$('#popup-field').hide();
			$('body').css('overflow','visible');
		});
	});
	
	// прибиваем футер к полу
	moveFooter();
});