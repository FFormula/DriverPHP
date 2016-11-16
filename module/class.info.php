<?php

class info extends Module
{
    public function api_index ()
    {
        $this -> answer ["date"] = date ("Y-m-d");
    }
}