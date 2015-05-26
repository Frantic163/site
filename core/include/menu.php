<?php
    function get_menu($args = false){
        
        $default = array(
            'menu_class' => 'menu',
            'menu_id' => '',
            'list_class' => '',
        );
        
        //страницы которые точно не должны быть в меню
        $services_page = array("auth", "models", "404", "views", "description.php", "panel",); 
        
        $path_page = ROOT.'/pages/'; //Путь к папке со страницами

        $all_page = scandir($path_page); //Ищем все страницы
        array_shift($all_page); // удаляем из массива '.'
        array_shift($all_page); // удаляем из массива '..'

        $menu = array_diff($all_page, $services_page); //Удаляем ненужные
        
        $new_menu = array();

        //Пoдключаем фаил с описанием
        foreach($menu as $values){
            if($values == "index.php"){
                include $path_page.'description.php';
            } else {
                include $path_page.$values.'/description.php';
            }

            array_push($new_menu, $description); //Создаем массив меню
        }

        $confirm_menu = sotr_menu($new_menu);
        
        
        
        
        $m = '<ul '.$menu_class.' '.$menu_id.'>';
        
        for($i = 0; $i < count($confirm_menu); $i++){
            $m .= '<li><a href="'.$confirm_menu[$i]['path'].'">'.$confirm_menu[$i]['title'].'</a></li>';
        }
        $m .= '</li>';
        echo $m;
    }
        
    //Сортируем меню в соответсвии с из позициями
    function sotr_menu($menu){
        for($i = 0; $i < count($menu); $i++){
            if($menu[$i]['position'] != $i){
                $a = $menu[$menu[$i]['position']];
                $menu[$menu[$i]['position']] = $menu[$i];
                $menu[$i] = $a;
            }
        }

        return $menu;
    }

