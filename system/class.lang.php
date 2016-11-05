<?php

function lang_load ($module)
{
    global $lang;
    $lg = "ru";
    include ROOT . "lang/" . $module . "." . $lg . ".php";
    foreach ($lang as $name => $value)
        if ($value == "")
            $lang [$name] = $name;
}

function _ ($text)
{
    global $lang;
    if (isset ($lang [$text]))
        return $lang [$text];
    return $text;
}

/*
class Lang
{
    var $lg = "ru";

    public function Lang ()
    {
        $this -> load ("menu");
    }

    public function load ($module)
    {
        global $lang;
        $this -> module = $module;
        include ROOT . "lang/" . $module . "." . $this -> lg . ".php";
    }

}
*/

