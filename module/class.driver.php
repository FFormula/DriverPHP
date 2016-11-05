<?php

class driver extends Module
{
    var $driver = array (
        "first_name" => "",
        "last_name" => "",
        "father_name" => "",
        "passport_serial" => "",
        "passport_number" => "",
        "info" => ""
    );

    function is_all_params ()
    {
        if (!$this -> data -> is_param ("last_name")) return false;
        if (!$this -> data -> is_param ("first_name")) return false;
        if (!$this -> data -> is_param ("father_name")) return false;
        if (!$this -> data -> is_param ("passport_serial")) return false;
        if (!$this -> data -> is_param ("passport_number")) return false;
        if (!$this -> data -> is_param ("info")) return false;
        return true;
    }

    public function api_insert ()
    {
        if (!$this -> data -> is_login (1)) return;
        $this -> answer ["saved"] = "";
        $this -> answer ["error"] = "";
        $this -> answer ["driver"] = $this -> driver;
        $user_id = $this -> data -> load ("user") ["id"];
        if (!$user_id)
            $this -> answer ["error"] = "User not set";
    }

    public function api_insert_post ()
    {
        if (!$this -> data -> is_login (1)) return;
        if (!$this -> is_all_params ()) return;
        $this -> answer ["saved"] = "";
        $this -> answer ["error"] = "";
        $this -> answer ["driver"] = $this -> driver;
        $user_id = $this -> data -> load ("user") ["id"];

        $error = "";
        foreach ($this -> driver as $name => $value)
        {
            $this -> answer ["driver"] [$name] = $this -> data -> get($name);
            if ($this -> data -> get($name) == "")
                $error .= " " . $name . " not set";
        }
        if ($error != "")
        {
            $this->answer ["error"] = $error;
            return;
        }
        $query =
            "INSERT INTO drivers
                SET user_id = '" . $user_id . "',
                    last_name = '" . $this -> data -> get ("last_name") . "', 
                    first_name = '" . $this -> data -> get ("first_name") . "', 
                    father_name = '" . $this -> data -> get ("father_name") . "',
                    passport_serial = '" . $this -> data -> get ("passport_serial") . "', 
                    passport_number = '" . $this -> data -> get ("passport_number") . "',
                    status = 1,
                    insert_date = NOW()";
        $this -> db -> query ($query);
        $this -> answer ["saved"] = true;
    }

    public function api_update ()
    {
        if (!$this -> data -> is_login (2)) return;
        if (!$this -> data -> is_param ("driver_id")) return;
        if (!$this -> exists ()) return;
        if (!$this -> is_all_params ()) return;
        $query =
            "UPDATE drivers
                SET last_name = '" . $this -> data -> get ("last_name") . "', 
                    first_name = '" . $this -> data -> get ("first_name") . "', 
                    father_name = '" . $this -> data -> get ("father_name") . "',
                    passport_serial = '" . $this -> data -> get ("passport_serial") . "', 
                    passport_number = '" . $this -> data -> get ("passport_number") . "',
                    update_date = NOW()
              WHERE id = '" . $this -> data -> get ("driver_id") . "' 
              LIMIT 1";
        $this -> db -> query ($query);
        $this -> answer = "Driver info changed";
    }

    public function api_confirm ()
    {
        if (!$this -> data -> is_login (2)) return;
        if (!$this -> data -> is_param ("driver_id")) return;
        if (!$this -> data -> is_param ("status")) return;
        if (!$this -> exists ()) return;
        $query =
            "UPDATE drivers
                SET status = '" . $this -> data -> get ("status") . "',
                    update_date = NOW()
              WHERE id = '" . $this -> data -> get ("driver_id") . "' 
              LIMIT 1";
        $this -> db -> query ($query);
        $this -> answer = "Driver status changed";
    }

    public function api_list ()
    {
        if (!$this -> data -> is_login (2)) return;
        $query =
            "SELECT insert_date, update_date, 
                    last_name, first_name, father_name,
                    passport_serial, passport_number,
                    status, info
               FROM drivers 
           ORDER BY id DESC";
        $this -> answer = $this -> db -> select ($query);
    }

    public function api_info ()
    {
        if (!$this -> data -> is_login (2)) return;
        if (!$this -> data -> is_param ("driver_id")) return;
        if (!$this -> exists ()) return;
        $query =
            "SELECT insert_date, update_date, 
                    last_name, first_name, father_name,
                    passport_serial, passport_number,
                    status, info
               FROM drivers 
              WHERE id = '" . $this -> data -> get ("driver_id") . "'";
        $this -> answer = $this -> db -> select ($query);
    }

    public function api_find ()
    {
        if (!$this -> data -> is_login (-1)) return;
        if (!$this -> data -> is_param ("by", "Search criteria not specified")) return;

        $this -> answer = "No records";
    }

    protected function exists ()
    {
        $driver_id = $this -> data -> get ("driver_id");
        $query =
            "SELECT COUNT(*)
               FROM drivers
              WHERE id = '" . $driver_id . "'";
        if ($this -> db -> scalar ($query) == "0")
        {
            $this -> data -> error (
                "Driver #" .
                $driver_id .
                " not found");
            return false;
        }
        return true;
    }
}