<?php

class Lang
{
    var $lg = "ru";

    public function load ($module)
    {
        global $lang;
        $this -> module = $module;
        include ROOT . "lang/" . $module . "." . $this -> lg . ".php";
    }

    public function _ ($text)
    {
        global $lang;
        if (isset ($lang [$text]))
            return $lang [$text];
        return $text;
    }
}