<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public $viewData;

    function __construct() {
        parent::__construct();
        $this->site_santry->redirect = "admin";
        $this->site_santry->allow();
        $this->layout->set_layout("admin/layout_admin"); 
    }

    public function index($flag = "") {
        $this->viewData['title'] = "Dashboard"; 
        $this->layout->view('admin/dashboard/dashboard', $this->viewData);
    }
    
     
    

}
