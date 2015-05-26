<?php

		
    // получим текущий шаблон
    $objTmpl = new SiteTemplates;
    $defTmpl = $objTmpl->getCurrTemplate();

    // получим список шаблонов
    //$tmp = scandir($home . 'templates');
    $arrTemplates = array();
    /*foreach($tmp as $file) {
            if(is_dir($home . 'templates/' . $file) && $file != '.' && $file != '..') array_push($arrTemplates, $file);
    }*/
    
    print_r($arrTemplates);
    
    
    // выводим страничку
    include('views/index.php');
