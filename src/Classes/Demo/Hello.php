<?php

namespace Classes\Demo;

class Hello {

    public function __construct() {

        echo __METHOD__ . " \r\n";

        echo __DIR__;
        
    }

}