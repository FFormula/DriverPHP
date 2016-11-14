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
        if ($info == "") {
            $this -> answer ["error"] = na("File description missed");
            return;
        }
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
            $this -> answer ["error"] = na("Driver not found");
            return false;
        }
        if ($this -> data -> load ("user", "status") == "2")
            return true;
        if ($user_id == $this -> data -> load ("user", "id"))
            return true;
        $this -> answer ["error"] = na("This driver is not yours");
        return false;
    }

    protected function save_file ($driver_id)
    {
        if (empty($_FILES['docfile']['name'])) {
            $this->answer ["error"] = na("You need to select a file to upload.");
            return "";
        }
        $ext = strtolower(pathinfo(basename($_FILES['docfile']['name']), PATHINFO_EXTENSION));
        if (!$this->allow_ext($ext)) {
            $this->answer ["error"] = na("This file type not allowed.");
            return "";
        }
        $filename = $driver_id . "_" . date("YmdHis") . "_" . $this->rand_line(12) . "." . $ext;
        if (!move_uploaded_file($_FILES['docfile']['tmp_name'], DOCS_DIR . $filename))
        {
            $this -> answer ["error"] = na("Error uploading document");
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
        $this -> answer ["count"] = "";
        if (!$this -> data -> is_login(1)) return;
        if (!$this -> data -> is_param("driver_id")) return;
        $driver_id = $this -> data -> get ("driver_id");
        $this -> answer ["driver_id"] = $driver_id;
        $this -> get_driver_name ($driver_id);
        if (!$this -> is_my_driver ($driver_id))
            return;
        $query =
            "SELECT id, filename, info
               FROM docs
              WHERE driver_id = '" . $driver_id .
        "' ORDER BY id DESC";

        $list = $this -> db -> select ($query);
        $this -> answer ["docs_web"] = DOCS_WEB;
        $this -> answer ["list"] = $list;
        $this -> answer ["count"] = count($list);
    }

    protected function get_driver_name ($driver_id)
    {
        $this -> answer ["driver_name"] = $this -> db -> scalar (
            "SELECT CONCAT(last_name, ' ', first_name, ' ', father_name) 
               FROM drivers WHERE id = '" . $driver_id . "'");
    }

    public function api_drop ()
    {
        $this -> answer ["error"] = "";
        $this -> answer ["driver_id"] = "";
        if (!$this -> data -> is_login(1)) return;
        if (!$this -> data -> is_param("doc_id")) return;
        $doc_id = $this -> data -> get ("doc_id");
        if (!$this -> check_docs ($doc_id)) return;

        $driver_id = $this -> get_driver_by_doc ($doc_id);
        $this -> answer ["driver_id"] = $driver_id;
        if (!$this -> is_my_driver ($driver_id))
            return;

        if (!$this -> delete_file ($doc_id)) {
            $this -> answer ["error"] = na ("Error deleting file");
            return;
        }
        $this -> delete_base ($doc_id);
    }

    protected function check_docs ($doc_id)
    {
        $count = $this -> db -> scalar (
            "SELECT COUNT(*)
               FROM docs
              WHERE id = '" . $doc_id . "'");
        if ($count > 0)
            return true;
        $this -> answer ["error"] = na ("File already deleted.");
        return false;
    }

    protected function get_driver_by_doc ($doc_id)
    {
        return $this -> db -> scalar (
            "SELECT driver_id
               FROM docs
              WHERE id = '" . $doc_id . "'");
    }

    protected function delete_file ($doc_id)
    {
        $filename = $this -> db -> scalar (
            "SELECT filename
               FROM docs
              WHERE id = '" . $doc_id . "'");
        if (!$filename)
            return true;
        if (!file_exists(DOCS_DIR . $filename))
            return true;
        if (!is_file(DOCS_DIR . $filename))
            return false;
        unlink (DOCS_DIR . $filename);
        return !file_exists(DOCS_DIR . $filename);
    }

    protected function delete_base ($doc_id)
    {
        $this -> db -> query (
            "DELETE FROM docs
              WHERE id = '" . $doc_id .
           "' LIMIT 1");
    }
}