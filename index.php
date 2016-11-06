<?php
    // $_GET ["data"] = "/docs/drop/doc_id=4";
    date_default_timezone_set("Europe/Moscow");
    include "config.php";
    include ROOT . "system/class.db.php";
    include ROOT . "system/class.data.php";
    include ROOT . "system/class.lang.php";
    include ROOT . "system/class.module.php";
    $db = new DB ();
    $data = new Data ();
    try
    {
        $data -> init ($db);
        $module  = $data -> module;
        $action = $data -> action;
        $api_action = API_PREFIX . $action . ($data -> is_post() ? POST_SUFFIX : "");
        if (!is_file (ROOT . "module/class." . $module . ".php"))
            throw new Exception ("Module [$module] not found");
        include ROOT . "module/class." . $module . ".php";
        lang_load ("menu");
        lang_load ($module);
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
        $smart -> assign ("lang", $lang);
        $smart -> assign ("menu", $module . "/" . $action);
        $data -> output ($smart);
        $smart -> display ($module . "." . $action . ".tpl");
    }
    catch (Exception $e)
    {
        $data -> error ($e -> getMessage());
        $data -> done ();
        $data -> output ();
    }

