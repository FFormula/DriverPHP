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

    public function load_stats ()
    {
        $this -> load_stats_drivers ();
        $this -> load_stats_users ();
    }
    
    protected function load_stats_drivers ()
    {
        $status = $this -> data -> load ("user", "status");
        if ($status < 1) return;
        if ($status >= 2)
            $where = "1";
        else
            $where = " user_id = " . $this -> data -> load ("user", "id");
        $query = 
            "SELECT status, COUNT(*) count
               FROM drivers 
              WHERE $where
              GROUP BY status";
        $stats = $this -> db -> select ($query);
        foreach ($stats as $row)
            $this -> answer ["stats"] ["driver_" . $row ["status"]] = $row ["count"];
    }

    protected function load_stats_users ()
    {
        $status = $this -> data -> load ("user", "status");
        if ($status < 3) return;
        $query = 
            "SELECT status, COUNT(*) count
               FROM users
              GROUP BY status";
        $stats = $this -> db -> select ($query);
        foreach ($stats as $row)
            $this -> answer ["stats"] ["user_" . $row ["status"]] = $row ["count"];
    }

}