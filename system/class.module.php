<?php

abstract class Module
{
    protected $db;
    protected $data;
    protected $answer;

    function __construct ()
    {
    }

    public function init ($db, $data)
    {
        $this -> db = $db;
        $this -> data = $data;
    }

    public function get_answer ()
    {
        return $this -> answer;
    }

}