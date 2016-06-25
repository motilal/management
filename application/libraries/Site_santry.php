<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Site_santry
 *
 * @author Administrator
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Site_santry{
    var $ci_obj = null;
    var $redirect = "/";
    //put your code here
    /**
     *
     * @param type $params 
     */
    public function __construct($params = array()) {
        $this->ci_obj = & get_instance();
    }
    /**
     * 
     * @return type
     */
    public function is_admin_login(){
        $auth_data = $this->ci_obj->session->userdata('_auth_data');
        return is_object($auth_data) && ($auth_data->role == 2 || $auth_data->role == 3) ? true : false;
    }
    /**
     * 
     * @return type
     */
    public function is_login(){
        $auth_data = $this->ci_obj->session->userdata('_auth_data');
        return is_object($auth_data) ? true : false;
    }

    /**
     *
     * @param type $params 
     */
    public function do_login($params = array()){
        $this->ci_obj->session->set_userdata(array("_auth_data" => $params));
    }
    /**
     *
     * @param type $params 
     */
    public function do_log_out($params = array()){
        return $this->ci_obj->session->unset_userdata('_auth_data');
    }
    /**
     * 
     * @return type
     */
    public function get_auth_data(){
        return $this->ci_obj->session->userdata('_auth_data');
    }
    /**
     * 
     * @param type $actions
     * @return boolean
     */
    public function allow($actions = array()){
        //pr($this->ci_obj->uri->rsegments[2]);
        if(!in_array($this->ci_obj->uri->rsegments[2], $actions) && $this->get_auth_data() == FALSE){
            redirect($this->redirect."?request=".base64_encode(uri_string()."?".$_SERVER['QUERY_STRING']));
        }
        if(isset($this->ci_obj->uri->segments[1]) && $this->ci_obj->uri->segments[1] == "admin"){
            if($this->is_admin_login() === FALSE && !in_array($this->ci_obj->uri->rsegments[2], $actions)){
                redirect($this->redirect."?request=".base64_encode(uri_string()."?".$_SERVER['QUERY_STRING']));
            }
        }
        return TRUE;
    }
}

?>
