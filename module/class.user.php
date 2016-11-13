<?php
class user extends Module
{
    var $user = array (
        "park" => "",
        "phone" => "",
        "name" => "",
        "email" => "",
        "password" => ""
    );

    function is_all_params()
    {
        foreach ($this -> user as $name => $value) {
            if (!$this->data->is_param($name)) return false;
            $this->user [$name] = $this->data->get($name);
        }
        return true;
    }

    protected function check_param_errors ()
    {
        $this -> answer ["error"] = "";
        $this -> answer ["user"] = $this -> user;
        $errors = 0;
        foreach ($this -> user as $name => $value)
        {
            $this -> answer ["user"] [$name] = $this -> data -> get($name);
            if ($this -> data -> get($name) == "") {
                $errors ++;
                $this->answer ["warn"] [$name] = 1;
            } else
                $this->answer ["warn"] [$name] = 0;
        }
        if (!$this -> is_valid_email($this -> answer ["user"] ["email"])) {
            $this->answer ["warn"] ["email"] = 1;
            $this->answer ["error"] = na("Invalid email address");
            return true;
        }
        if ($errors == 0)
            return false;
        $this->answer ["error"] = na("Fill all fields");
        return true;
    }

    public function api_insert()
    {
        $this->answer ["saved"] = "";
        $this->answer ["error"] = "";
        $this->answer ["user"] = $this -> user;
    }

    public function api_insert_post ()
    {
        $this->answer ["saved"] = "";
        $this->answer ["error"] = "";
        if (!$this->is_all_params()) return;
        if ($this->check_param_errors()) return;

        $exists = $this -> db -> scalar (
            "SELECT COUNT(*) 
               FROM users 
              WHERE email = '" . $this->data->get("email") . "'");
        if ($exists)
        {
            $this -> answer ["error"] = na("This email already registered");
            return;
        }
        $query =
            "INSERT INTO users
                SET name = '" . $this->data->get("name") . "', 
                    email = '" . $this->data->get("email") . "', 
                    password = '" . $this->data->get("password") . "',
                    park = '" . $this->data->get("park") . "',
                    phone = '" . $this->data->get("phone") . "',
                    status = 0";
        $this->db->query($query);
        $this -> answer ["saved"] = true;
    }

    public function api_login ()
    {
        $this -> answer ["logged"] = "";
        $this -> answer ["error"] = "";
        $this -> answer ["user"] = $this -> user;
        if (isset ($this -> data -> load ("user") ["id"]))
            $this -> answer ["logged"] = true;
    }

    public function api_login_post ()
    {
        $this -> answer ["logged"] = "";
        $this -> answer ["error"] = "";
        if (!$this -> data -> is_param ("email")) return;
        if (!$this -> data -> is_param ("password")) return;
        $this -> answer ["user"] ["email"] = $this -> data -> get ("email");
        $query =
            "SELECT id, name, email, status 
               FROM users 
              WHERE email = '" . $this->data->get("email") . "' 
                AND password = '" . $this->data->get("password") . "'";
        $user = $this -> db -> select ($query);
        if (!isset ($user [0] ["id"])) {
            $message = na("Email or password incorrect");
            $this -> data -> error ($message);
            $this -> answer ["error"] = $message;
            return;
        }
        if ($user [0] ["status"] == 0) {
            $message = na("Your account on moderation");
            $this -> data -> error ($message);
            $this -> answer ["error"] = $message;
            return;
        }
        $this -> data -> save ("user", $user [0]);
        $this -> answer ["logged"] = true;
    }

    public function api_logout ()
    {
        $this -> data -> save ("user", array ());
        $this -> answer = "You logged out";
    }

    public function api_select_all ()
    {
        $query =
            "SELECT id, name, email, password, status
               FROM users 
           ORDER BY id DESC";
        $this -> answer = $this -> db -> select ($query);
    }

    public function api_check ()
    {
        if (!$this -> data -> is_login (2)) return;
        $query =
            "SELECT id, name, email, park, phone, status
               FROM users 
              WHERE status >= 0
           ORDER BY status, id DESC";
        $this -> answer ["check"] = $this -> db -> select ($query);
    }

    public function api_confirm ()
    {
        $this->answer ["message"] = "";
        if (!$this->data->is_login(2)) return;
        if (!$this->data->is_param("for_user_id")) return;
        if (!$this->data->is_param("status")) {
            $this->answer ["message"] = na("Status not specified");
            return;
        }
        $for_user_id = $this->data->get("for_user_id");
        if (!$this->exists($for_user_id)) return;
        $status = $this->data->get("status");
        if ($status == "drop")
            $this->delete($for_user_id);
        else
            $this->update_status($for_user_id, $status);
        $this -> answer ["message"] = na("User status changed");
    }

    protected function delete ($for_user_id)
    {
        $query =
            "UPDATE users
                SET status = '-1'
              WHERE id = '" . $for_user_id . "' 
              LIMIT 1";
        $this -> db -> query ($query);
    }

    protected function update_status ($for_user_id, $status)
    {
        if (!in_array ($status, array (0, 1, 2)))
            $status = 0;
        $query =
            "UPDATE users
                SET status = '" . $status . "'
              WHERE id = '" . $for_user_id . "' 
              LIMIT 1";
        $this -> db -> query ($query);
    }

    protected function exists ($user_id)
    {
        $query =
            "SELECT COUNT(*)
               FROM users
              WHERE id = '" . $user_id . "'";
        if ($this -> db -> scalar ($query) == "0")
        {
            $this -> data -> error (
                "User #" .
                $user_id .
                " not found");
            return false;
        }
        return true;
    }

    function is_valid_email($email)
    {
        $pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$";
        return eregi($pattern, $email);
    }
}