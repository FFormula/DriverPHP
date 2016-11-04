<?php
/**
 * Model.Help
 * General info about this API
 * @author Jevgenij Volosatov
 */
class help extends Module
{
    /** Return current version of API */
    public function api_version()
    {
        if (!$this -> data -> is_login (-1)) return;
        $this -> answer = array (
                "version" => "1.0"
        );
    }

    public function api_now()
    {
        if (!$this -> data -> is_login (0)) return;
        $this -> answer = array (
            "now" => $this -> db -> scalar ("SELECT NOW()")
        );
    }

    public function api_session ()
    {
        if (!$this -> data -> is_login (1)) return;
        $this -> answer = $_SESSION;
    }
}

