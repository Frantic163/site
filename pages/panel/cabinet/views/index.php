<?php if(!isset($_POST['ajax'])) require_once(ROOT.'/templates/panel/header.php'); ?>
			
            <div class="cab_item" onclick="refPage('site');">
                <h3>Сайт</h3>
                <br>
                <hr class="cab_item_hr">
                <a href="/panel/site/pages/">Файлы и папки</a>
                <a href="/panel/site/singles/">Записи</a>
                <!--a href="/panel/site/menu/">Меню</a-->
            </div>

            <div class="cab_item" onclick="refPage('catalog');">
                <h3>Каталог</h3>
                <br>
                <hr class="cab_item_hr">
                <a href="/panel/catalog/list/">Список каталогов</a>
                <a href="/panel/catalog/import/">Импорт</a>
            </div>

            <div class="cab_item" onclick="refPage('store');">
                <h3>Магазин</h3>
                <br>
                <hr class="cab_item_hr">
                <a href="/panel/store/orders/">Заказы</a>
                <a href="/panel/store/warehouse/">Склад</a>
            </div>
            
            <div class="cab_item" onclick="refPage('users');">
                <h3>Пользователи</h3>
                <br>
                <hr class="cab_item_hr">
                <a href="/panel/users/userlist/">Список пользователей</a>
                <a href="/panel/users/blocks/">Блокировки</a>
            </div>
            
            <div class="cab_item" onclick="refPage('modules');">
                <h3>Плагины (модули)</h3>
                <br>
                <hr class="cab_item_hr">
                <a href="/panel/modules/">Список плагинов</a>
                <a href="/panel/modules/new/">Редактирование</a>
            </div>
            
            <div class="cab_item" onclick="refPage('settings');">
                <h3>Настройки</h3>
                <br>
                <hr class="cab_item_hr">
                <a href="/panel/settings/">Сайт</a>
                <a href="/panel/settings/backup/">Резервное копирование</a>
            </div>
			
<?php if(!isset($_POST['ajax'])) require_once(ROOT.'/templates/panel/footer.php'); ?>