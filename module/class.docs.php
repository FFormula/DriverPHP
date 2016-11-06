<?php

class docs extends Module
{
    public function api_upload_post ()
    {
        $this -> save_file ();
        $this -> insert ();
    }

    public function api_show ()
    {

    }
}