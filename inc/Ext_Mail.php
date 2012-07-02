<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ext_Mail
 *
 * @author studio
 */


abstract class Ext_Mail {

    private $content_type = 'text/html', $sender_email, $sender_name;

    public function get_content_type() {
        return $this->content_type;
    }

    public function set_content_type($content_type) {
        $this->content_type = $content_type;
        return $this;
    }

    public function get_sender_email() {
        return $this->sender_email;
    }

    public function set_sender_email($sender_email) {
        $this->sender_email = $sender_email;
        return $this;
    }

    public function get_sender_name() {
        return $this->sender_name;
    }

    public function set_sender_name($sender_name) {
        $this->sender_name = $sender_name;
        return $this;
    }


    public function publish_post(){

    }

    public function new_user_activation(){

    }

    public function retrieve_password(){

    }
}

?>
