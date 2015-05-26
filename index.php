<?php
    $root_result = str_replace("\\","/",dirname(__FILE__));
    define('ROOT',$root_result);
    
    require_once ROOT.'/core/index.php';