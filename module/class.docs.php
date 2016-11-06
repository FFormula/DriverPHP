<?php

class docs extends Module
{
    public function api_upload_post ()
    {
        $this -> answer ["error"] = "";
        if (!$this -> data -> is_login(1)) return;
        if (!$this -> data -> is_param("driver_id")) return;
        if (!$this -> data -> is_param("info")) return;
        $driver_id = $this -> data -> get ("driver_id");
        $this -> answer ["driver_id"] = $driver_id;
        if (!$this -> is_my_driver ($driver_id)) return;
        $info = $this -> data -> get ("info");
        $filename = $this -> save_file ($driver_id);
        if ($filename == "") return;
        $this -> insert ($driver_id, $filename, $info);
    }

    protected function is_my_driver ($driver_id)
    {
        $user_id = $this -> db -> scalar (
            "SELECT user_id 
               FROM drivers
              WHERE id = '" . $driver_id . "'");
        if (!$user_id) {
            $this -> answer ["error"] = "Driver not found";
            return false;
        }
        if ($this -> data -> load ("user") ["status"] == "2")
            return true;
        if ($user_id == $this -> data -> load ("user") ["id"])
            return true;
        $this -> answer ["error"] = "This driver is not yours";
        return false;
    }

    protected function save_file ($driver_id)
    {
        if (empty($_FILES['docfile']['name'])) {
            $this->answer ["error"] = "You need to select a file to upload.";
            return "";
        }
        $ext = strtolower(pathinfo(basename($_FILES['docfile']['name']), PATHINFO_EXTENSION));
        if (!$this->allow_ext($ext)) {
            $this->answer ["error"] = "This file type not allowed.";
            return "";
        }
        $filename = $driver_id . "_" . date("YmdHis") . "_" . $this->rand_line(12) . "." . $ext;
        if (!move_uploaded_file($_FILES['docfile']['tmp_name'], DOCS_DIR . $filename))
        {
            $this -> answer ["error"] = "Error uploading document";
            return "";
        }
        return $filename;
    }

    protected function allow_ext ($ext)
    {
        $ext_arr = explode(",", DOCS_EXTS);
        return in_array ($ext, $ext_arr);
    }

    protected function rand_line ($length)
    {
        $abc = "abcdefghijklmnopqrstuvwxyz0123456789";
        $line = "";
        for ($j = 0; $j < $length; $j ++)
            $line .= $abc [mt_rand(0, strlen($abc) - 1)];
        return $line;
    }

    protected function insert ($driver_id, $filename, $info)
    {
        $query =
            "INSERT INTO docs
                SET driver_id = '" . $driver_id . "',
                    filename = '" . $filename . "',
                    info = '" . $info . "'";
        $this -> db -> query ($query);
    }

    public function api_list ()
    {
        $this -> answer ["error"] = "";
        if (!$this -> data -> is_login(1)) return;
        if (!$this -> data -> is_param("driver_id")) return;
        $driver_id = $this -> data -> get ("driver_id");
        if (!$this -> is_my_driver ($driver_id))
            return;
        $query =
            "SELECT id, filename, info
               FROM docs
              WHERE driver_id = '" . $driver_id .
        "' ORDER BY id DESC";

        $list = $this -> db -> select ($query);
        $this -> answer ["list"] = $list;
        $this -> answer ["count"] = count($list);
    }
}