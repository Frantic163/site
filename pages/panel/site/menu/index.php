<?php
    
    $objMenu = new Menu;
    $listMenu = $objMenu->getMenu($services_page);

    include('views/index.php');