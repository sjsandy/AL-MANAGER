<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mod_Emails
 *
 * @author studio
 */


abstract class Mail_BASE {



    abstract function content_type();
    abstract function sender_email();
    abstract function sender();
    abstract function new_user_notification();
    abstract function password_retrival();
    abstract function new_post();

    private $send_to_email, $send_to_name, $filter,$filter_function;

    public function set_send_to_email($send_to_email) {
        $this->send_to_email = $send_to_email;
    }

    public function set_send_to_name($send_to_name) {
        $this->send_to_name = $send_to_name;
    }



    public function filters(){
        add_filter('wp_mail_content_type', array($this,'content_type'));
        add_filter('wp_mail_from', array($this,'sender_email'));
        add_filter('wp_mail_from_name', array($this,'sender'));
        //add_filter($this->filter, array($this,$this->filter_function));
    }

    public function actions(){
        add_action('publish_post', array($this,'new_post'));
    }



}

class Mod_Emails extends Mail_BASE {



    public function __construct() {

    }

    public function content_type() {

    }

    public function sender() {

    }

    public function sender_email() {

    }

    public function new_post() {

    }

    public function new_user_notification() {

    }

    public function password_retrival() {

    }


}
