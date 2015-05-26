<?php

    // получим список категорий
    $objSan = new CSanitize;
    $objSgl = new SiteSingles;
    $arrCategories = $objSgl->getCategories();

    // если не редактирование
    if(!empty($_GET['id'])) {
            $id = $objSan->dataSanation($_GET['id'], 'clearnumber');
            if($id) {
                    // получим данные записи
                    $currSingle = $objSgl->getCurrentSingle($id);

                    // выводим страничку
                    include('views/edit.php');
                    exit;
            }
    }

    // получим список записей
    if(!empty($_GET['cat'])) {
            $cat = $objSan->dataSanation($_GET['cat'], 'clearnumber');
            if(!$cat) $cat = 0;
            else $cat = $cat * 1;
    }
    else $cat = 0;
    if(!empty($_GET['page'])) {
            $page = $objSan->dataSanation($_GET['page'], 'clearnumber');
            if(!$page) $page = 1;
            else $page = $page * 1;
    }
    else $page = 1;
    $singleList = $objSgl->getSingles($cat, $page, $arrCategories);

    // выводим страничку
    include('./views/index.php');