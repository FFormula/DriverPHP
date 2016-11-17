<?php

class driver extends Module
{
    var $driver = array (
        "first_name" => "",
        "last_name" => "",
        "father_name" => "",
        "passport_serial" => "",
        "passport_number" => "",
        "license_serial" => "",
        "license_number" => "",
        "phone" => "",
        "info" => ""
    );

    function is_all_params ()
    {
        foreach ($this -> driver as $name => $value) {
            echo $name . ",";
            if (!$this->data->is_param($name)) return false;
            $this->driver [$name] = $this->data->get($name);
        }
        return true;
    }

    protected function read_driver_id ()
    {
        if ($this->data->is_param("driver_id")) {
            $driver_id = $this->data->get("driver_id");
            if (!$this->is_my_driver($driver_id))
                $driver_id = 0;
        } else {
            $driver_id = 0;
        }
        return $driver_id;
    }

    protected function select ($driver_id)
    {
        $info = $this -> db -> select (
            "SELECT * 
               FROM drivers 
              WHERE id = '" . $driver_id .
           "' LIMIT 1");
        if (isset ($info [0] ["id"]))
            $this -> driver = $info [0];
    }

    public function api_insert ()
    {
        if (!$this -> data -> is_login (1)) return;
        $user_id = $this -> data -> load ("user", "id");
        $this -> answer ["saved"] = "";
        $this -> answer ["error"] = "";
        $driver_id = $this -> read_driver_id();
        $this -> answer ["driver_id"] = $driver_id ? $driver_id : na("New");
        $this -> answer ["new_driver"] = $driver_id ? "0" : "1";
        $this -> select ($driver_id);
        $this -> answer ["driver"] = $this -> driver;
        if (!$user_id)
            $this -> answer ["error"] = na("User not set");
        foreach ($this -> driver as $name => $value)
            $this->answer ["warn"] [$name] = 0;
    }

    public function api_insert_post ()
    {
        if (!$this -> data -> is_login (1)) return;

        $driver_id = $this -> read_driver_id();
        $this -> answer ["driver_id"] = $driver_id ? $driver_id : na("New");
        $this -> answer ["new_driver"] = $driver_id ? "0" : "1";
        echo "here";
        if (!$this -> is_all_params ()) return;
        echo "here2";
        $this -> answer ["saved"] = "";

        if ($this -> check_insert_errors()) return;
        if ($this -> check_equals_driver($driver_id)) return;
        if ($driver_id) {
            $this->update($driver_id);
            $this->data->redirect("/driver/info/driver_id=" . $driver_id, 5);
        } else {
            $new_driver_id = $this->insert();
            $this->data->redirect("/docs/list/driver_id=" . $new_driver_id);
        }

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

    protected function check_equals_driver($driver_id = 0)
    {
        $query =
            "SELECT COUNT(*) 
               FROM drivers
              WHERE last_name = UPPER('" . $this -> data -> get ("last_name") . "')
                AND first_name = UPPER('" . $this -> data -> get ("first_name") . "')
                AND father_name = UPPER('" . $this -> data -> get ("father_name") . "')
                AND passport_serial = UPPER('" . $this -> data -> get ("passport_serial") . "') 
                AND passport_number = UPPER('" . $this -> data -> get ("passport_number") . "' 
                AND id <> '" . $driver_id . "')";
        $count = $this -> db -> scalar ($query) * 1;
        if ($count == 0)
            return false;
        $this->answer ["error"] = na("The same driver already exists");
        return true;
    }

    protected function insert ()
    {
        $user_id = $this -> data -> load ("user", "id");
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
        $new_driver_id = $this -> db -> insert_id ();
        $this -> answer ["driver_id"] = $new_driver_id;
        return $new_driver_id;
    }

    public function update ($driver_id)
    {
        if ($this->data->load("user", "status") == "1") // admin
            $reset_status = true; // $driver_status = 1; // admin adds already approved drivers
        else
            $reset_status = false;
        $query =
            "UPDATE drivers
                SET last_name = UPPER('" . $this -> data -> get ("last_name") . "'), 
                    first_name = UPPER('" . $this -> data -> get ("first_name") . "'), 
                    father_name = UPPER('" . $this -> data -> get ("father_name") . "'),
                    passport_serial = UPPER('" . $this -> data -> get ("passport_serial") . "'), 
                    passport_number = UPPER('" . $this -> data -> get ("passport_number") . "'),
                    info = '" . $this -> data -> get ("info") . "', " .
 ($reset_status ? " status = 1, " : "") . "
                    update_date = NOW()
              WHERE id = '" . $driver_id . "' 
              LIMIT 1";
        $this -> db -> query ($query);
    }

    public function api_confirm ()
    {
        $this->answer ["message"] = "";
        if (!$this -> data -> is_login (1)) return;
        if (!$this->data->is_param("driver_id")) return;
        if (!$this->data->is_param("status")) {
            $this->answer ["message"] = na("Status not specified");
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
        if ($this->data->load("user", "status") == "2" ||
            $this->data->load("user", "status") == "3") // admin
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
                AND user_id = '" . $this->data->load("user", "id") . "'
              LIMIT 1";
        $this -> db -> query ($query);
    }

    protected function update_status ($driver_id, $status)
    {
        if ($this->data->load("user", "status") == "2" ||
            $this->data->load("user", "status") == "3") // admin
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
                AND user_id = '" . $this->data->load("user", "id") . "'
              LIMIT 1";
        $this -> db -> query ($query);
    }

    public function api_list ()
    {
        if (!$this -> data -> is_login (1)) return;
        if ($this -> data -> load ("user", "status") == "2" || 
            $this -> data -> load ("user", "status") == "3")
            $user_cond = "1";
        else
            $user_cond = " user_id = '" . $this -> data -> load ("user", "id") . "'";
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
                AND drivers.status = 2
           GROUP BY drivers.id
           ORDER BY id DESC";
        $this -> answer ["list"] = $this -> db -> select ($query);
    }

    public function api_wait ()
    {
        if (!$this -> data -> is_login (1)) return;
        if ($this -> data -> load ("user", "status") == "2" || 
            $this -> data -> load ("user", "status") == "3")
            $user_cond = "1";
        else
            $user_cond = " user_id = '" . $this -> data -> load ("user", "id") . "'";
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
                AND drivers.status = 1
           GROUP BY drivers.id
           ORDER BY id DESC";
        $this -> answer ["wait"] = $this -> db -> select ($query);
    }

    public function api_info ()
    {
        $this -> answer ["error"] = "";
        if (!$this -> data -> is_param ("driver_id")) return;
        $this -> answer ["info"] ["status"] = 0; // do not show notice errors
        $driver_id = $this -> data -> get ("driver_id");
        if (!$this -> exists ($driver_id)) {
            $this -> answer ["error"] = na("Driver does not exists");
            return;
        }
        if ($this->data->load("user", "status") == "2" ||
            $this->data->load("user", "status") == "3") // admin
            $info = $this->info_admin($driver_id);
        else
            $info = $this->info_oper($driver_id);
        if (count ($info) == 0)
        {
            $this->answer ["error"] = na("This driver is not yours");
        } else {
            $this->load_docs ($driver_id);
            $this->answer ["info"] = $info[0];
            $this->answer ["info"] ["status_text"] = na("status" . $this->answer ["info"] ["status"]);
        }
    }

    protected function load_docs ($driver_id)
    {
        $query =
            "SELECT id, filename, info
               FROM docs
              WHERE driver_id = '" . $driver_id .
            "' ORDER BY id DESC";

        $list = $this -> db -> select ($query);
        $this -> answer ["docs_web"] = DOCS_WEB;
        $this -> answer ["docs"] = $list;
        $this -> answer ["docs_count"] = count($list);
    }

    protected function info_oper ($driver_id)
    {
        if (!$this -> data -> is_login (1)) return;
        if (!$this -> exists ($driver_id)) {
            $this -> answer ["error"] = na("Driver does not exists");
            return;
        }
        $code_opened = false;
        if ($this -> data -> get ("code"))
        {
            $right_code = md5($driver_id . "/" . $this -> data -> load ("user", "id") . "/saldo");
            if ($right_code == $this -> data -> get ("code")) {
                $code_opened = true;
                $this -> data -> hide_menu ();
            }
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
              WHERE drivers.id = '" . $driver_id . "'";
        if (!$code_opened) $query .= "
                AND user_id = '" . $this -> data -> load ("user", "id") . "'";
        return $this -> db -> select ($query);
    }

    protected function info_admin ($driver_id)
    {
        if (!$this -> data -> is_login (2)) return;
        if ($this -> data -> get ("code"))
            $this -> data -> hide_menu ();
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
              WHERE drivers.id = '" . $driver_id . "'";
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
        if ($count <= 10)
        {
            $query =
                "SELECT id, last_name, first_name, father_name, info
                   FROM drivers
                  WHERE id IN (0" . $ids . ")";
            $list = $this -> db -> select ($query);
            $user_id = $this->data->load("user", "id");
            foreach ($list as $key => $value)
                $list [$key] ["code"] = md5 ($list [$key] ["id"] . "/" . $user_id . "/saldo");
            $this -> answer ["list"] = $list;
        }
    }

    protected function exists ($driver_id)
    {
        $query =
            "SELECT COUNT(*)
               FROM drivers
              WHERE id = '" . $driver_id . "'";
        if ($this -> db -> scalar ($query) == "0")
        {
            $this -> answer ["error"] =
                "Driver #" .
                $driver_id .
                " not found";
            return false;
        }
        return true;
    }

    protected function is_my_driver ($driver_id)
    {
        $user_id = $this -> db -> scalar (
            "SELECT user_id 
               FROM drivers
              WHERE id = '" . $driver_id . "'");
        if (!$user_id) {
            $this -> answer ["error"] = na("Driver does not exists");
            return false;
        }
        if ($this -> data -> load ("user", "status") == "2" ||
            $this -> data -> load ("user", "status") == "3")
            return true;
        if ($user_id == $this -> data -> load ("user", "id"))
            return true;
        $this -> answer ["error"] = na("This driver is not yours");
        return false;
    }
}