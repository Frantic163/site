<?php if(!defined("STR_HEADER") || STR_HEADER !== true) die(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Untitled Document</title>
    <meta charset="UTF-8">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="stylesheet" type="text/css" href="<?php echo STR_TEMPLATE_PATH; ?>/css/style.css">
</head>
<body>
    
    <header>
        <div class="wrapper">
            <div class="headline">
                <div class="left15" style="padding-right: 10px;">
                    <img src="<?php echo STR_TEMPLATE_PATH; ?>/images/logo.png" alt="logo" style="height: 128px;">
                </div>
                <div class="left50" style="margin-top: 26px;">
                    <h1>Ваш магазин</h1>
                    <span class="like_h">установлен и готов к настройке</span>
                </div>
                <div class="right20 textright" style="margin-top: 36px;">
                    <p class="nomargin">8 (800) 123-45-67</p>
                    <input type="button" value="Заказать звонок">
                </div>
                <div class="clear"></div>
                <hr class="hr_line">
            </div>
            <div class="topmenu">
                <ul id="mainmenu">
                    <li><a href="javascript: void(0);">Новости</a></li>
                    <li><a href="javascript: void(0);">Каталог</a></li>
                    <li><a href="javascript: void(0);">Доставка</a></li>
                    <li><a href="javascript: void(0);">О компании</a></li>
                    <li><a href="javascript: void(0);">Контакты</a></li>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
    </header>
    
    <div id="main">
        <div class="wrapper">
		
			<?php if(file_exists(dirname(__FILE__) . '/left_sidebar.php')) include(dirname(__FILE__) . '/left_sidebar.php'); ?>
			
			<div class="content left60">