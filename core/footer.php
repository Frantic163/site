<?php
    // подключаем футер
    include(ROOT . STR_TEMPLATE_PATH . '/footer.php');
    
    // получим вывод страницы
    $tmpPage = ob_get_clean();

    // получим список установленных плагинов
    $arrPlugins = array();
    $arrTmp = scandir(ROOT . '/plugins/');
    foreach($arrTmp as $file) {
            if($file != '.' && $file != '..' && is_file($file) === false) {
                    $arrPlugins[] = $file;
            }
    }

    // парсим страничку на предмет шорт-кодов
    foreach($arrPlugins as $plugin) {
            $tmpLabel = '[' . $plugin;
            $tmpLblPos = strpos($tmpPage, $tmpLabel);
            // если нашли плагин
            if($tmpLblPos) {
                    $tmpLblPos++;
                    $tmpPluginCall = '';
                    $tmp = substr($tmpPage, $tmpLblPos);

                    // обход глюка strpos!!!
                    $aTmp = explode("]", $tmp);
                    $tmpPluginCall = $aTmp[0];
                    ////////////////////////

                    $tmpPluginCall = trim($tmpPluginCall);
                    $arrPlugin = explode(";", $tmpPluginCall);
                    $arrParams = array();
                    $arrCnt = 0;

                    for($i = 1; $i < count($arrPlugin); $i++) {
                            $tmp = trim($arrPlugin[$i]);
                            $tmpArrParam = explode("=", $tmp);
                            $arrParams[$arrCnt]['name'] = $tmpArrParam[0];
                            if(isset($tmpArrParam[1])) $arrParams[$arrCnt]['value'] = $tmpArrParam[1];
                            else $arrParams[$arrCnt]['value'] = NULL;
                            include(ROOT . '/plugins/' . $plugin . '/' . $plugin . '.php');
                            $tmpPage = str_replace('[' . $tmpPluginCall . ']', $tmpHtml, $tmpPage);
                    }
            }
    }

    // выводим отредактированную страницу пользователю
    echo $tmpPage;
