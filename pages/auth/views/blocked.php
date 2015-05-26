<!DOCTYPE html>
<html>
<head>
    <title>StoreCMS | Авторизация</title>
    <meta charset="UTF-8">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="stylesheet" type="text/css" href="/panel/templates/default/css/style2.css">
</head>
<body>
    
    <header>
        <div class="wrapper">
            <div class="headline">
                <div class="left15" style="padding-right: 10px;">
                    <img src="/templates/panel/images/logo_cms.png" alt="logo" style="height: 80px;">
                </div>
                <div class="left50" style="margin-top: 20px;">
                    <h1>StoreCMS</h1>
                    <span class="like_h">система управления магазином</span>
                </div>
                <div class="right20 textright" style="margin-top: 20px;"></div>
                <div class="clear"></div>
                <hr class="hr_line">
            </div>
        </div>
    </header>
    
    <div id="main">
        <div class="wrapper">
            <div id="auth_form" style="width: 400px; margin: 80px auto 0; padding: 20px; border: 1px solid #67c9cf; border-radius: 6px;">
                <h2 style="text-align: center;">Авторизация</h2>
				<br>
				<?php if((isset($_POST['userlogin']))||(isset($_POST['userpwd']))) : ?>
					<div style="text-align: center;">
						<p style="color: #ff4000;">Превышено количество попыток входа.<br>Обратитесь в техподдержку.</p>
					</div>
				<?php endif; ?>
				
                <div class="clear"></div>
            </div>
        </div>
    </div>
    
	<footer>
        <div class="wrapper" style="padding-top: 20px; border-top: 1px solid #67c9cf;">
            <div class="left50">
                <p class="nomargin">&copy; 2014 ShopCMS</p>
            </div>
            <div class="right50 textright">
                <a href="http://rw-lab.ru" target="_blank">Лаборатория "RW"</a>
            </div>
            <div class="clear"></div>
        </div>
    </footer>
    
</body>
</html>