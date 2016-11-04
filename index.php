<?php
    date_default_timezone_set("Europe/Moscow");
    include "config.php";
    include ROOT . "system/class.db.php";
    include ROOT . "system/class.data.php";
    include ROOT . "system/class.module.php";
    $db = new DB ();
    $data = new Data ();
    try
    {
        $data -> init ($db);
        $module  = $data -> module;
        $action = $data -> action;
        $api_action = "api_" . $action;
        if (!is_file (ROOT . "module/class." . $module . ".php"))
            throw new Exception ("Module [$module] not found");
        include ROOT . "module/class." . $module . ".php";
        $class = new $module ();
        $class -> init ($db, $data);
        if (!is_callable (array ($class, $api_action)))
            throw new Exception ("Module [$module] action [$action] not found");
        $class -> $api_action ();
        $data -> done ($class -> get_answer());

        include ROOT . "libs/Smarty.class.php";
        $smart = new Smarty;
        $smart -> caching = false;
        $smart -> debugging = false;
        $smart -> template_dir = SMARTY_TEMPLATES_DIR;
        $data -> output ($smart);
        $smart -> display ($module . "." . $action . ".tpl");
    }
    catch (Exception $e)
    {
        $data -> error ($e -> getMessage());
        $data -> done ();
        $data -> output ();
    }

