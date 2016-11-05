<?php
class user extends Module
{
    var $user = array (
        "name" => "",
        "email" => "",
        "password" => ""
    );

    function is_all_params()
    {
        if (!$this->data->is_param("name")) return false;
        if (!$this->data->is_param("email")) return false;
        if (!$this->data->is_param("password")) return false;
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
        $this->answer ["user"] = $this -> user;

        $exists = $this -> db -> scalar (
            "SELECT COUNT(*) 
               FROM users 
              WHERE email = '" . $this->data->get("email") . "'");
        if ($exists)
        {
            $this -> answer ["error"] = "This email already registered";
            return;
        }
        $query =
            "INSERT INTO users
                SET name = '" . $this->data->get("name") . "', 
                    email = '" . $this->data->get("email") . "', 
                    password = '" . $this->data->get("password") . "',
                    status = 1";
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
            $message = "Email or password incorrect";
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

    public function api_set_status ()
    {
        if (!$this -> data -> is_login (2)) return;
        if (!$this -> data -> is_param ("status")) return;
        if (!$this -> data -> is_param ("for_user_id")) return;
        $for_user_id = $this -> data -> get ("for_user_id");
        if (!$this -> exists ($for_user_id)) return;
        $query =
            "UPDATE users
                SET status = '" . $this -> data -> get ("status") . "'
              WHERE id = '" . $for_user_id . "' 
              LIMIT 1";
        $this -> db -> query ($query);
        $this -> answer = "User #" . $for_user_id . " status changed";
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

}