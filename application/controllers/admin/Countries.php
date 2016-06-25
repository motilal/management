<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Countries
 *
 * @author Motilal Soni
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Countries extends CI_Controller {

    var $viewData = array();  
    
    public function __construct() {
        parent::__construct();
        $this->site_santry->redirect = "admin";
        $this->site_santry->allow(array());
        $this->layout->set_layout("admin/layout_admin");
        $this->load->model(array("admin/country"));
    }

    public function index() {
        $condition = array();
        $start = (int)$this->input->get('start');
        $result = $this->country->get_country_list($condition);
        $this->viewData['result'] = $result; 
        $this->viewData['title'] = "Countries";
        $this->viewData['datatable_asset'] = true;
        $this->layout->view("admin/country/index", $this->viewData);
    }

    public function manage($id = null) {
        $validation = array(
            array(
                'field' => 'name',
                'label' => 'Country Name',
                'rules' => "trim|required|max_length[200]"
            ),
            array(
                'field' => 'short_name',
                'label' => 'Short Name',
                'rules' => 'trim|max_length[200]'
            )
        );
        $this->load->library('form_validation');
        $this->form_validation->set_rules($validation);
        $this->form_validation->set_error_delimiters('<div class="text-danger v_error">', '</div>');
        if ($this->form_validation->run() === TRUE) {
            $data = array(
                "name" => $this->input->post('name'),
                "short_name" => $this->input->post('short_name') 
            );
 
            if ($this->input->post('id') > 0) { 
                $this->db->update("countries", $data, array("id" => $this->input->post('id')));
                $this->session->set_flashdata("success", getLangText('CountryUpdateSuccess'));
            } else { 
                $data['status'] = 1;
                $this->db->insert("countries", $data);
                $this->session->set_flashdata("success", getLangText('CountryAddSuccess'));
            }
            redirect("admin/countries");
        }
        $this->viewData['title'] = "Add Country";
        if ($id > 0) {
            $this->viewData['data'] = $data = $this->country->getCountryById((int) $id);
            if (empty($data)) {
                $this->session->set_flashdata("error", getLangText('LinkExpired'));
                redirect('admin/countries');
            }
            $this->viewData['title'] = "Edit Country";
        } 
        $this->layout->view("admin/country/manage", $this->viewData);
    }

    public function actions() {
        $validation = array(
            array(
                'field' => 'ids[]',
                'label' => 'Select checkbox',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'actions',
                'label' => 'Actions',
                'rules' => 'trim|required'
            )
        );
        $this->form_validation->set_rules($validation);
        if ($this->form_validation->run() === TRUE) {
            if ($this->input->post("actions") == "active") {
                $this->db->where_in("id", $this->input->post("ids"))
                        ->update("countries", array("status" => 1));
            }
            if ($this->input->post("actions") == "inactive") {
                $this->db->where_in("id", $this->input->post("ids"))
                        ->update("countries", array("status" => 0));
            }
            if ($this->input->post("actions") == "delete") {
                $this->db->where_in("id", $this->input->post("ids"))
                        ->delete("countries");
            }
            $this->session->set_flashdata("success", "Selected rows {$this->input->post("actions")} successfully");
        }
        redirect("admin/countries");
    }

}

?>
