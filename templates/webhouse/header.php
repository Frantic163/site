<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo SITE_NAME;?></title>
    <!--SEO Meta Tags-->
    <meta name="description" content="<?php echo SITE_DESCRIPT;?>" />
		<meta name="keywords" content="" />
		<meta name="author" content="RWLab" />
    <!--Mobile Specific Meta Tag-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!--Favicon-->
    <link rel="shortcut icon" href="<?php echo STR_TEMPLATE_PATH; ?>/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo STR_TEMPLATE_PATH; ?>/favicon.ico" type="image/x-icon">
    <!--Master Slider Styles-->
    <link href="<?php echo STR_TEMPLATE_PATH; ?>/masterslider/style/masterslider.css" rel="stylesheet" media="screen">
    <!--Styles-->
    <link href="<?php echo STR_TEMPLATE_PATH; ?>/css/styles.css" rel="stylesheet" media="screen">
    
    <!--Modernizr-->
		<script src="<?php echo STR_TEMPLATE_PATH; ?>/js/libs/modernizr.custom.js"></script>
    <!--Adding Media Queries Support for IE8-->
    <!--[if lt IE 9]>
      <script src="js/plugins/respond.js"></script>
    <![endif]-->
    <!--Javascript (jQuery) Libraries and Plugins-->
    <script src="<?php echo LINK_JQUERY; ?>"></script>
    <script src="<?php echo STR_TEMPLATE_PATH; ?>/js/libs/jquery-ui-1.10.4.custom.min.js"></script>
    <script src="<?php echo STR_TEMPLATE_PATH; ?>/js/libs/jquery.easing.min.js"></script>
    <script src="<?php echo STR_TEMPLATE_PATH; ?>/js/plugins/bootstrap.min.js"></script>
    <script src="<?php echo STR_TEMPLATE_PATH; ?>/js/plugins/smoothscroll.js"></script>
    <script src="<?php echo STR_TEMPLATE_PATH; ?>/js/plugins/jquery.validate.min.js"></script>
    <script src="<?php echo STR_TEMPLATE_PATH; ?>/js/plugins/icheck.min.js"></script>
    <script src="<?php echo STR_TEMPLATE_PATH; ?>/js/plugins/jquery.placeholder.js"></script>
    <script src="<?php echo STR_TEMPLATE_PATH; ?>/js/plugins/jquery.stellar.min.js"></script>
    <script src="<?php echo STR_TEMPLATE_PATH; ?>/js/plugins/jquery.touchSwipe.min.js"></script>
    <script src="<?php echo STR_TEMPLATE_PATH; ?>/js/plugins/jquery.shuffle.min.js"></script>
    <script src="<?php echo STR_TEMPLATE_PATH; ?>/js/plugins/lightGallery.min.js"></script>
    <script src="<?php echo STR_TEMPLATE_PATH; ?>/js/plugins/owl.carousel.min.js"></script>
    <script src="<?php echo STR_TEMPLATE_PATH; ?>/js/plugins/masterslider.min.js"></script>
    <script src="<?php echo STR_TEMPLATE_PATH; ?>/js/plugins/jquery.nouislider.min.js"></script>
    <script src="<?php echo STR_TEMPLATE_PATH; ?>/mailer/mailer.js"></script>
    <script src="<?php echo STR_TEMPLATE_PATH; ?>/js/scripts.js"></script>
  </head>

  <!--Body-->
  <body>

  	<!--Login Modal-->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
		
        <div class="modal-body">
			
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            <h2>Авторизуйтесь или <a href="javascript: void(0);">зарегистрируйтесь</a></h2>
			
            [authorize; loginform]
			
          <!--form class="login-form">
            <div class="form-group group">
            	<label for="log-email">Email</label>
                <input type="email" class="form-control" name="log-email" id="log-email" placeholder="Введите свой email" required>
            </div>
            <div class="form-group group">
            	<label for="log-password">Пароль</label>
                <input type="text" class="form-control" name="log-password" id="log-password" placeholder="Enter your password" required>
              <a class="help-link" href="javascript: void(0);">Забыли пароль?</a>
            </div>
            <div class="checkbox">
                <label><input type="checkbox" name="remember"> запомнить меня</label>
            </div>
            <input class="btn btn-black" type="submit" value="Войти" onclick="false">
          </form -->
        </div>
		  
        <div class="modal-header">
            <!--button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            <h2>Авторизуйтесь или <a href="javascript: void(0);">зарегистрируйтесь</a></h2-->
            <p class="large">Войти через социальные сети</p>
            <div class="social-login">
            	<a class="facebook" href="javascript: void(0);"><i class="fa fa-facebook-square"></i></a>
            	<a class="google" href="javascript: void(0);"><i class="fa fa-google-plus-square"></i></a>
            	<a class="twitter" href="javascript: void(0);"><i class="fa fa-twitter-square"></i></a>
            </div>
        </div>
		  
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!--Header-->
    <header data-offset-top="500" data-stuck="600"><!--data-offset-top is when header converts to small variant and data-stuck when it becomes visible. Values in px represent position of scroll from top. Make sure there is at least 100px between those two values for smooth animation-->
    
      <!--Search Form-->
      <form class="search-form closed" method="get" role="form" autocomplete="off">
      	<div class="container">
          <div class="close-search"><i class="icon-delete"></i></div>
            <div class="form-group">
              <label class="sr-only" for="search-hd">Search for product</label>
              <input type="text" class="form-control" name="search-hd" id="search-hd" placeholder="Search for product">
              <button type="submit"><i class="icon-magnifier"></i></button>
          </div>
        </div>
      </form>
    
    	<!--Mobile Menu Toggle-->
      <div class="menu-toggle"><i class="fa fa-list"></i></div>

      <div class="container">
        <a class="logo" href="/"><img src="<?php echo STR_TEMPLATE_PATH; ?>/img/logo.png" alt="WebHouse"/></a>
      </div>
      
      <!--Main Menu-->
      <nav class="menu">
        <div class="container">
            <div class="main">
                  <h1>WebHouse - первый оконный дискаунтер</h1>
            </div>
        </div>

        <div class="catalog-block">
          <div class="container">
            <!-- <ul class="catalog">   
                   
            </ul> -->
            <?php  get_menu(); ?>	
            <div class="searchform" style="position: absolute; top: 9px; right: 0; display: block !important; width: 180px;">
                <form class="" method="get" role="form" autocomplete="off">
                    <div class="form-group">
                      <!--label class="sr-only" for="search-hd">Search for product</label-->
                    <input type="text" class="form-control-sr" name="search-hd" id="search-hd" placeholder="Поиск...">
                    <button id="submit-sr" type="submit"><i class="icon-magnifier"></i></button>
                    </div>
                </form>
            </div>
			
          </div>
        </div>
      </nav>
      
      <div class="toolbar-container">
        <div class="container">  
          <!--Toolbar-->
          <div class="toolbar group">
            <a class="login-btn btn-outlined-invert" href="#" data-toggle="modal" data-target="#loginModal"><i class="icon-profile" style="color: #156193;"></i> <span><b>В</b>ойти</span></a>

            <a class="btn-outlined-invert" href="<!--wishlist.html-->"><i class="icon-heart" style="color: #156193;"></i> <span><b>И</b>збранное</span></a>   

            <div class="cart-btn">
              <a class="btn btn-outlined-invert" href="javascript: void(0);<!--shopping-cart.html-->"><i class="icon-shopping-cart-content" style="color: #fff;"></i><span style="background: #fe9015;">0</span><b>пусто</b></a>
              
              <!--Cart Dropdown-->
              <div class="cart-dropdown">
                <span></span><!--Small rectangle to overlap Cart button-->
                <div class="body">
					<p>Ваша корзина пуста</p>
                  <!--table>
                    <tr>
                      <th>Наименование</th>
                      <th>Кол-во</th>
                      <th>Цена</th>
                    </tr>
                    <tr class="item">
                      <td><div class="delete"></div><a href="#">Окно "Винни Пух"</a></td>
                      <td><input type="text" value="1"></td>
                      <td class="price">89 005 руб.</td>
                    </tr>
                    <tr class="item">
                      <td><div class="delete"></div><a href="#">Окно "Винни Пух"</a></td>
                      <td><input type="text" value="2"></td>
                      <td class="price">4 300 руб.</td>
                    </tr>
                    <tr class="item">
                      <td><div class="delete"></div><a href="#">Окно "Винни Пух"</a></td>
                      <td><input type="text" value="5"></td>
                      <td class="price">84 руб.</td>
                    </tr>
                  </table-->
                </div>
                <div class="footer group">
                  <div class="buttons" style="display: none;">
                    <a class="btn btn-outlined-invert" href="<!--checkout.html-->"><i class="icon-download"></i>Оплатить</a>
                    <a class="btn btn-outlined-invert" href="<!--shopping-cart.html-->"><i class="icon-shopping-cart-content"></i>В корзину</a>
                  </div>
                  <div class="total"><span>0</span> руб.</div>
                </div>
              </div><!--Cart Dropdown Close-->
            </div>

            <!--button class="search-btn btn-outlined-invert"><i class="icon-magnifier"></i></button-->
          </div><!--Toolbar Close-->
        </div>
      </div>
    </header><!--Header Close-->
    
    <!--Page Content-->
    <div class="page-content">
		
<?php 
    if(IS_HOMEPAGE){
        if(file_exists(dirname(__FILE__) . '/slider.php')){ include(dirname(__FILE__) . '/slider.php'); }
        if(file_exists(dirname(__FILE__) . '/categories.php')){ include(dirname(__FILE__) . '/categories.php'); }
    } 
?>