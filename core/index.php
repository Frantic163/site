<?php
    /* Подключение фаилов ядра */
    $include_path = ROOT."/core/include/";
    
    $include_files = scandir($include_path);
    array_shift($include_files);
    array_shift($include_files);
    
    foreach($include_files as $include_file) {
        include_once $include_path.$include_file; //подключаем все фаилы моделей
    }

    $mysqli = db::getObject(); 
    
    // проверка сессии
    $sess = new SessionInfo;
    $isSession = $sess->getUserSession();

    $uri = $_SERVER['REQUEST_URI'];
    
    // Санация uri
    $modelSanObj = new CSanitize;
    $isUri = $modelSanObj->dataSanation($uri,'uri');
    
    // Если URL не прошел санацию - страница 404
    if(!$isUri) {
        require_once ROOT.'/pages/404/index.php';
    } else {
       
        //получаем массив путь и get запрос если он есть
        preg_match('/^([^?]+)(\?.*?)?(#.*)?$/',$isUri, $matches); 
        $path = (isset($matches[1])) ? $matches[1] : '';
        //$get = (isset($matches[2])) ? $matches[2] : '';
        
        $path = ROOT.'/pages'.$path; //полный путь к подключаемой странице   
           
        if(is_dir($path)){ //проверяем есть ли данная дериктория

            $req_file = $path.'index.php';

            if(file_exists($req_file)){ //проверяем есть ли index 
                
                $models_path = $path.'models/'; //путь к моделям
                 
                if(is_dir($models_path)){ //проверяем есть ли дериктория моделей
                    $models = scandir($models_path);
                    array_shift($models); // удаляем из массива '.'
                    array_shift($models); // удаляем из массива '..'
                    foreach($models as $model) {
                        require_once $models_path.$model; //подключаем все фаилы моделей
                    }
                }
                
                if(strpos($path, ADMINCATALOG) != false){ //проверяем является ли путь админкой
                    
                    $objVerification = new Verification();
                    $verification = $objVerification->getRole($isSession); //проверяем верификацию пользователя       
                    
                    if($verification){ //если пользовател вошел
                        require_once $req_file; //подключаем нашу страницу
                    } else {
                        require_once ROOT.'/pages/auth/index.php';
                    } 
                } else {
                    require_once $req_file; 
                }

            } else {
                require_once ROOT.'/pages/404/index.php';
            } 
        } else {
            require_once ROOT.'/pages/404/index.php';   
        }
    }
