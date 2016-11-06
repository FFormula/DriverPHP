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
        foreach ($this -> driver as $name => $value) {
            if (!$this->data->is_param($name)) return false;
            $this->driver [$name] = $this->data->get($name);
        }
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
            $this -> answer ["error"] = na("User not set");
        foreach ($this -> driver as $name => $value)
            $this->answer ["warn"] [$name] = 0;
    }

    public function api_insert_post ()
    {
        if (!$this -> data -> is_login (1)) return;
        if (!$this -> is_all_params ()) return;
        $this -> answer ["saved"] = "";

        if ($this -> check_insert_errors()) return;
        if ($this -> check_equals_driver()) return;
        $this -> insert_driver ();

        $this -> answer ["saved"] = true;
    }

    protected function check_insert_errors ()
    {
        $this -> answer ["error"] = "";
        $this -> answer ["driver"] = $this -> driver;
        $errors = 0;
        foreach ($this -> driver as $name => $value)
        {
            $this -> answer ["driver"] [$name] = $this -> data -> get($name);
            if ($this -> data -> get($name) == "") {
                $errors ++;
                $this->answer ["warn"] [$name] = 1;
            } else
                $this->answer ["warn"] [$name] = 0;
        }
        if ($errors == 0)
            return false;
        $this->answer ["error"] = na("Fill all fields");
        return true;
    }

    protected function check_equals_driver()
    {
        $query =
            "SELECT COUNT(*) FROM drivers
              WHERE last_name = UPPER('" . $this -> data -> get ("last_name") . "')
                AND first_name = UPPER('" . $this -> data -> get ("first_name") . "')
                AND father_name = UPPER('" . $this -> data -> get ("father_name") . "')
                AND passport_serial = UPPER('" . $this -> data -> get ("passport_serial") . "') 
                AND passport_number = UPPER('" . $this -> data -> get ("passport_number") . "')";
        $count = $this -> db -> scalar ($query) * 1;
        if ($count == 0)
            return false;
        $this->answer ["error"] = na("The same driver already exists");
        return true;
    }

    protected function insert_driver ()
    {
        $user_id = $this -> data -> load ("user") ["id"];
        if ($this->data->load("user") ["status"] == "2") // admin
            $driver_status = 2; // admin adds already approved drivers
        else
            $driver_status = 1;
        $query =
            "INSERT INTO drivers
                SET user_id = '" . $user_id . "',
                    last_name = UPPER('" . $this -> data -> get ("last_name") . "'), 
                    first_name = UPPER('" . $this -> data -> get ("first_name") . "'), 
                    father_name = UPPER('" . $this -> data -> get ("father_name") . "'),
                    passport_serial = UPPER('" . $this -> data -> get ("passport_serial") . "'), 
                    passport_number = UPPER('" . $this -> data -> get ("passport_number") . "'),
                    info = '" . $this -> data -> get ("info") . "',
                    status = " . $driver_status . ",
                    insert_date = NOW()";
        $this -> db -> query ($query);
        $this -> answer ["driver_id"] = $this -> db -> insert_id ();
    }

    /*
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
    }*/

    public function api_confirm ()
    {
        $this->answer ["message"] = "";
        if (!$this -> data -> is_login (1)) return;
        if (!$this->data->is_param("driver_id")) return;
        if (!$this->data->is_param("status")) {
            $this->answer ["message"] = na("status not specified");
            return;
        }
        if ($this->data->get("status") == "drop") // drop
            $this->delete($this->data->get("driver_id"));
        else
            $this->update_status($this->data->get("driver_id"), $this->data->get("status"));
    }

    protected function delete ($driver_id)
    {
        if ($this -> has_docs ($driver_id)) {
            $this -> answer ["message"] = na ("Cannot delete this driver, because he has documents");
            return;
        }
        if ($this->data->load("user") ["status"] == "2") // admin
            $this -> admin_delete ($driver_id);
        else
            $this -> oper_delete ($driver_id);
        $this -> answer ["message"] = na("Driver deleted");
    }

    protected function has_docs ($driver_id)
    {
        $count = $this -> db -> scalar (
            "SELECT COUNT(*) 
               FROM docs 
              WHERE driver_id = '" . $driver_id . "'");
        return ($count > 0);
    }

    protected function admin_delete ($driver_id)
    {
        if (!$this -> data -> is_login (2)) return;
        $query =
            "DELETE FROM drivers
              WHERE id = '" . $driver_id . "' 
              LIMIT 1";
        $this -> db -> query ($query);
    }

    protected function oper_delete ($driver_id)
    {
        $query =
            "DELETE FROM drivers
              WHERE id = '" . $driver_id . "'
                AND user_id = '" . $this->data->load("user") ["id"] . "'
              LIMIT 1";
        $this -> db -> query ($query);
    }

    protected function update_status ($driver_id, $status)
    {
        if ($this->data->load("user") ["status"] == "2") // admin
            $this->admin_update_status($driver_id, $status);
        else
            $this->oper_update_status($driver_id, $status);
        $this -> answer ["message"] = na("Driver status changed");
    }

    protected function admin_update_status ($driver_id, $status)
    {
        if (!$this -> data -> is_login (2)) return;
        $query =
            "UPDATE drivers
                SET status = '" . $status . "',
                    update_date = NOW()
              WHERE id = '" . $driver_id . "' 
              LIMIT 1";
        $this -> db -> query ($query);
    }

    protected function oper_update_status ($driver_id, $status)
    {
        $query =
            "UPDATE drivers
                SET status = '" . $status . "',
                    update_date = NOW()
              WHERE id = '" . $driver_id . "' 
                AND user_id = '" . $this->data->load("user") ["id"] . "'
              LIMIT 1";
        $this -> db -> query ($query);
    }

    public function api_list ()
    {
        if (!$this -> data -> is_login (1)) return;
        if ($this -> data -> load ("user") ["status"] == "2")
            $user_cond = "1";
        else
            $user_cond = " user_id = '" . $this -> data -> load ("user") ["id"] . "'";
        $query =
            "SELECT drivers.id, insert_date, update_date, 
                    last_name, first_name, father_name,
                    passport_serial, passport_number,
                    drivers.status, drivers.info,
                    users.name user_name,
                    COUNT(docs.id) docs
               FROM drivers 
               JOIN users 
                 ON drivers.user_id = users.id 
          LEFT JOIN docs 
                 ON drivers.id = docs.driver_id  
              WHERE $user_cond
           GROUP BY drivers.id
           ORDER BY id DESC";
        $this -> answer ["list"] = $this -> db -> select ($query);
    }

    public function api_info ()
    {
        $this -> answer ["error"] = "";
        if (!$this -> data -> is_param ("driver_id")) return;
        if (!$this -> exists ()) {
            $this -> answer ["error"] = na("Driver does not exists");
            return;
        }
        if ($this->data->load("user") ["status"] == "2") // admin
            $info = $this->info_admin();
        else
            $info = $this->info_oper();
        if (count ($info) == 0)
        {
            $this->answer ["error"] = na("This driver is not yours");
        } else {
            $this->answer ["info"] = $info[0];
            $this->answer ["info"] ["status_text"] = na("status" . $this->answer ["info"] ["status"]);
        }
    }

    protected function info_oper ()
    {
        if (!$this -> data -> is_login (1)) return;
        if (!$this -> exists ()) {
            $this -> answer ["error"] = na("Driver does not exists");
            return;
        }
        $query =
            "SELECT drivers.id, 
                    drivers.insert_date, drivers.update_date, 
                    last_name, first_name, father_name,
                    passport_serial, passport_number,
                    drivers.status, drivers.info,
                    users.name user_name
               FROM drivers 
               JOIN users 
                 ON drivers.user_id = users.id
              WHERE drivers.id = '" . $this -> data -> get ("driver_id") . "'
                AND user_id = '" . $this -> data -> load ("user") ["id"] . "'";
        return $this -> db -> select ($query);
    }

    protected function info_admin ()
    {
        if (!$this -> data -> is_login (2)) return;
        $query =
            "SELECT drivers.id, 
                    drivers.insert_date, drivers.update_date, 
                    last_name, first_name, father_name,
                    passport_serial, passport_number,
                    drivers.status, drivers.info,
                    users.name user_name
               FROM drivers 
               JOIN users 
                 ON drivers.user_id = users.id
              WHERE drivers.id = '" . $this -> data -> get ("driver_id") . "'";
        return $this -> db -> select ($query);
    }

    public function api_find ()
    {
        $this -> answer ["by"] = "";
        $this -> answer ["count"] = "";
        $this -> answer ["driver_name"] = "";
    }

    public function api_find_post ()
    {
        if (!$this -> data -> is_login (-1)) return;
        if (!$this -> data -> is_param ("by", na("Search criteria not specified"))) return;
        $this -> answer ["by"] = $this -> data -> get ("by");

        $arr = explode(" ", $this -> data -> get ("by"));

        $in_ids = "";
        $count = 0;
        foreach ($arr as $word1)
        {
            $word = trim($word1);
            if ($word == "")
                continue;
            $query =
                "SELECT id 
                   FROM drivers 
                  WHERE status = 2
                    AND $in_ids
                        (last_name = '" . $word . "' OR 
                         passport_serial = '" . $word . "' OR 
                         passport_number = '" . $word . "')";
//            first_name = '" . $word . "' OR
//            father_name = '" . $word . "' OR
            $list = $this -> db -> select ($query);
            $ids = "";
            $count = count ($list);
            foreach ($list as $row)
                $ids .= "," . $row ["id"];
            $in_ids = " id IN (0" . $ids . ") AND ";
        }

        $this -> answer ["count"] = $count;
        $this -> answer ["driver_name"] = "";
        if ($count == 1)
        {
            $query =
                "SELECT last_name, first_name, father_name 
                   FROM drivers
                  WHERE id IN (0" . $ids . ")";
            $res = $this -> db -> select ($query);
            $this -> answer ["driver_name"] =
                $res [0] ["last_name"] . " " .
                $res [0] ["first_name"] . " " .
                $res [0] ["father_name"] ;
        }
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