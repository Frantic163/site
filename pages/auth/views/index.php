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
						<p style="color: #ff4000;">Неверный логин или пароль</p>
					</div>
					<br>
				<?php endif; ?>
				
				<center>
                                    <form method="post" action="/auth/" enctype="multipart/form-data">
                                        <input name="userlogin" type="text" value="" placeholder="логин" style="width: 200px;"><br>
                                        <input name="userpwd" type="password" value="" placeholder="пароль" style="width: 200px; margin-top: 10px;"><br>
                                        <br>
                                        <input type="submit" value="Войти">
                                    </form>
				</center>
				<br>
                <div class="left30 textright">
                    <a href="javascript: void(0);" title="начать регистрацию">Регистрация</a>
                </div>
                <div class="right30">
                    <a href="javascript: void(0);" title="восстановить пароль">Забыли пароль?</a>
                </div>
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