<?php

session_start();

class Data
{
    private $db;
    public $action;
    public $module;
    protected $error;
    protected $result;
//  private $post; common array for both GET and POST data
    private $get;
    private $data_parts;

    function __construct ()
    {
        $this -> get = array ();
    }

    public function get ($param)
    {
        if (isset ($this -> get [$param]))
            return $this -> get [$param];
        return "";
    }

    public function hide_menu ()
    {
        $this -> get ["hide_menu"] = true;
    }

    /** Parse route, post and get arguments */
    public function init ($db)
    {
        $this -> db = $db;
        $this -> error = "";
        $this -> parse_route();
        $this -> parse_post();
        $this -> parse_get();
    }

    public function redirect ($url, $time = 0)
    {
        if ($time == "0")
        {
            @header ("Location: $url");
            echo "<script> document.location = '$url'; </script>";
            die ();
        } else {
            @header ("Refresh: $time; $url");
            echo "<head><meta http-equiv='refresh' content='$time; $url'></head>";
        }
    }

    private function parse_route ()
    {
        if (!isset ($_GET ["data"]))
        {
            $this -> module = DATA_DEFAULT_MODULE;
            $this -> action = DATA_DEFAULT_ACTION;
            return;
        }
        $route = trim ($_GET ["data"], '\\/');
        $this -> data_parts = explode ('/', $route);
        $this -> module = array_shift ($this -> data_parts);
        $this -> action = array_shift ($this -> data_parts);
    }

    public function is_post ()
    {
        return count ($_POST) > 0;
    }

    private function parse_post()
    {
        if (!is_array($_POST))
            return;
        foreach ($_POST as $key => $value)
            $this -> get [$key] = addslashes(trim($value));
    }

    private function parse_get()
    {
        if (!is_array ($this -> data_parts))
            return;
        foreach ($this -> data_parts as $part)
        {
            list ($param, $value) = explode ('=', $part);
            $this -> get [$param] = addslashes (trim($value));
        }
    }

    public function is_param ($param, $error = "")
    {
        if (isset ($this -> get [$param]))
            return true;
        if ($error == "")
            $error = "Param [$param] not set";
        $this -> error ($error);
        return false;
    }

    public function is_login ($status = 0)
    {
        if ($status == -1) return true;
        $user = $this -> load ("user");
        if (!isset ($user ["id"]))
        {
            $this->error("Not authorized");
            return false;
        }
        if ($user ["status"] >= $status)
            return true;
        $this -> error (
                    "Access denied. " .
                    "Need level " . $status .
                    ", your level is " . $user ["status"]);
        return false;
    }

    public function save ($param, $value)
    {
        $_SESSION [$param] = $value;
    }

    public function load ($param, $key = "")
    {
        if ($key == "")
            if (isset ($_SESSION [$param]))
                return $_SESSION [$param];

        if ($key != "")
            if (isset ($_SESSION [$param] [$key]))
                return $_SESSION [$param] [$key];

        return "";
    }

    public function error ($text)
    {
        $this -> error = $text;
    }

    public function done ($answer = "")
    {
        $this -> result ["module"] = $this -> module;
        $this -> result ["action"] = $this -> action;
        if ($this -> error)
            $this -> result ["error"] = $this -> error;
        $this -> result ["answer"] = $answer;
    }

    /** Print all data by default/specified format */
    public function output ($smart = null)
    {
        if ($smart == null)
        {
            echo "<pre>";
            print_r ($this -> result);
            return;
        }
        $smart -> assign ("php", $this -> result ["answer"]);
        $smart -> assign ("user",
            array ( "id" => @$_SESSION ["user"] ["id"],
                    "email" => @$_SESSION ["user"] ["email"],
                    "park" => @$_SESSION ["user"] ["park"],
                    "phone" => @$_SESSION ["user"] ["phone"],
                    "status" => @$_SESSION ["user"] ["status"],
                    "name" => @$_SESSION ["user"] ["name"]));
    }

    public function in_symbols ($text, $symbols)
    {
        for ($j = 0; $j < strlen ($text); $j ++) {
            if (strpos($symbols, substr($text, $j, 1)) === false)
                return false;
        }
        return true;
    }

    public function is_phone ($text)
    {
        if (!$this -> in_symbols ($text, DIGITS))
            return false;
        if (strlen ($text) < 11)
            return false;
        if (substr ($text, 0, 2) != "+7")
            return false;
        return true;
    }
}