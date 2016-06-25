<?php

/**
 * Description of gallery
 *
 * @author Motilal Soni
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Galleries extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->site_santry->redirect = "admin";
        $this->site_santry->allow(array());
        $this->layout->set_layout("admin/layout_admin");
        $this->load->model(array("admin/gallery"));
    }

    public function index() {
        $this->viewData['title'] = "Gallery";
        $this->layout->view("admin/gallery/index", $this->viewData);
    }

    public function upload() {
        error_reporting(E_ALL | E_STRICT);
        header('Pragma: no-cache');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Content-Disposition: inline; filename="files.json"');
        header('X-Content-Type-Options: nosniff');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');
        $filename = $this->input->get('file'); 
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'OPTIONS':
                break;
            case 'HEAD':
            case 'GET':
                $this->gallery->get();
                break;
            case 'POST':
                if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
                    $this->gallery->delete();
                } else {
                    $this->gallery->post();
                }
                break;
            case 'DELETE':
                $this->gallery->delete($filename);
                break;
            default:
                header('HTTP/1.1 405 Method Not Allowed');
        }
    } 
}

//end of class
