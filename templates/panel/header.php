<!DOCTYPE html>
<html>
<head>
    <title>StoreCMS - панель управления</title>
    <meta charset="UTF-8">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="stylesheet" type="text/css" href="/templates/panel/css/style2.css">
	<script type="text/javascript" src="/templates/panel/js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="/templates/panel/js/script.js"></script>
	<script type="text/javascript" src="/templates/panel/js/site.js"></script>
</head>
<body>
	<div id="popup-field"></div>
	<div id="popup-window" class="popup-menu"></div>
    
    <header>
        <div class="wrapper">
            <div class="headline">
                <div class="left15" style="padding-right: 10px;">
					<a href="/panel/cabinet/" title="Панель управления">
						<img src="/templates/panel/images/logo_cms.png" alt="logo" style="height: 80px;">
					</a>
                </div>
                <div class="left50" style="margin-top: 20px;">
                    <h1>StoreCMS</h1>
                    <span class="like_h">система управления магазином</span>
                </div>
                <div class="right20 textright" style="margin-top: 20px;">
                    <div id="userbtn">
                        <div class="userpic_box">
                            <img src="/templates/panel/images/userpic.png" alt="^_^">
                        </div>
                        <div class="divider">
                            <img src="/templates/panel/images/dot.png" alt=".">
                        </div>
                        <div class="username_box">
                            <a href="javascript: void(0);" onclick="showPopupMenu();">
                                <?php echo $isSession['uname']; ?>
                                <img src="/templates/panel/images/arr_dn_menu.png" alt="v" style="height: 12px; padding-left: 2px;">
                            </a>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
				
				<div id="usermenu_popup" class="popup-menu" style="display: none;">
					<ul>
						<li><a href="javascriptL void(0);">Настройки</a></li>
						<li><a href="javascript: void(0);">Техподдержка</a></li>
						<li>&nbsp;</li>
						<li><a href="/auth/?action=logout">Выход</a></li>
					</ul>
				</div>
				
                <div class="clear"></div>
                <hr class="hr_line">
            </div>
            <div class="taskline">
				<?php if(!isset($arrBreadcrums[0])) : ?>
					<div class="task_item">
						<table>
							<tr>
								<td>
									Новых заказов
								</td>
								<td>
									<p class="task_warn task_clear">0</p>
								</td>
							</tr>
						</table>
					</div>
					<div class="task_item">
						<table>
							<tr>
								<td>
									<a href="javascript: void(0);" class="task_ref">Новых сообщений</a>
								</td>
								<td>
									<p class="task_warn task_clear">0</p>
								</td>
							</tr>
						</table>
					</div>
					<div class="task_item">
						<table>
							<tr>
								<td>
									Новых пользователей
								</td>
								<td>
									<p class="task_warn task_clear">0</p>
								</td>
							</tr>
						</table>
					</div>
				<?php else :
					$cnt = 0;
					foreach($arrBreadcrums as $bread) :
						$cnt++;
						if($cnt < count($arrBreadcrums)) : ?>
							<span><?php echo $bread['name']; ?></span>
						<?php else : ?>
							<a href="<?php echo $bread['path']; ?>"><?php echo $bread['name']; ?></a>
							&nbsp;&nbsp;&raquo;&nbsp;&nbsp;
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
                <div class="clear"></div>
            </div>
        </div>
    </header>
    
    <div id="main">
        <div class="wrapper">