<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Layout
 *
 * @author Bansal
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Layout {

    //put your code here
    var $obj;
    var $layout;
    /**
     * 
     * @param type $layout
     */
    function Layout($layout = "layout_main") {
        $this->obj = & get_instance();
        $this->layout = $layout;
    }
    /**
     * 
     * @param type $layout
     */
    function set_layout($layout) {
        $this->layout = $layout;
    }
    /**
     * 
     * @param type $view
     * @param type $data
     * @param type $return
     * @return type
     */
    function view($view, $data=null, $return=false) {
        $loadedData = array();
        $loadedData['content_for_layout'] = $this->obj->load->view($view, $data, true);

        if ($return) {
            $output = $this->obj->load->view($this->layout, $loadedData, true);
            return $output;
        } else {
            $this->obj->load->view($this->layout, $loadedData, false);
        }
    }
    /**
     * 
     * @param type $view
     * @param type $data
     * @param type $ret
     * @return type
     */
    function element($view, $data = array(), $ret = false){
        if(!empty($data) && $ret !== false)
            return $this->obj->load->view($view, $data, $ret);
        else
            $this->obj->load->view($view);
    }

}

?>
