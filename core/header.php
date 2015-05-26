<?php
    global $mysqli;

    $resSettings = $mysqli->select('settings');
    $rowSettings = $mysqli->assoc($resSettings);
    
    if(!$rowSettings){
        define("STR_TEMPLATE_NAME", "default");
	define("STR_TEMPLATE_PATH", '/templates/default');
	define("STR_LANG", "ru");
    } else {
        do{
            define($rowSettings['name'], $rowSettings['value']);
        }while($rowSettings = $mysqli->assoc($resSettings));
    }
    
    
    // проверяем, является ли страница домашней
    $is_home = false;
    $request = $_SERVER['REQUEST_URI'];
    if($request == "/") {
            $arrReq = explode("/", $request);
            $first = $arrReq[1];
            if(strpos($first, "index.") !== false || strlen($first) < 1){ 
                $is_home = true; 
            }
    } else {
        $is_home = true;
    }
    
    define("IS_HOMEPAGE", $is_home);
    
    define("LINK_JQUERY", STR_TEMPLATE_PATH.'/js/jquery-1.11.1.min.js');
    // начинаем чтение шаблона
    define("STR_HEADER", true);

    // запускаем кэширование вывода
    ob_start();
    
    include(ROOT . STR_TEMPLATE_PATH . '/header.php');
    
    

