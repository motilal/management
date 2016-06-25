<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of staticPages
 *
 * @author Motilal Soni
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pages extends CI_Controller {

    var $viewData = array(); 
    /**
     *
     */
    public function __construct() {
        parent::__construct();
        $this->site_santry->redirect = "admin";
        $this->site_santry->allow(array());
        $this->layout->set_layout("admin/layout_admin");
        $this->load->model(array("admin/page"));
    }

    public function index() {  
        $condition = array();
        $result = $this->page->get_list($condition);
        $this->viewData['result'] = $result;
        $this->viewData['title'] = "Pages list";
        $this->viewData['datatable_asset'] = true;
        $this->layout->view("admin/page/index", $this->viewData);
    }

    public function manage($id = null) {
        $validation = array(
            array(
                'field' => 'title',
                'label' => 'Page title',
                'rules' => "trim|required|max_length[255]"
            ),
            array(
                'field' => 'description',
                'label' => 'Description',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'meta_keywords',
                'label' => 'Meta keywords',
                'rules' => "trim|max_length[1024]"
            ),
            array(
                'field' => 'meta_description',
                'label' => 'Meta description',
                'rules' => "trim|max_length[1024]"
            )
        );
        $this->load->library('form_validation');
        $this->form_validation->set_rules($validation);
        $this->form_validation->set_error_delimiters('<div class="text-danger v_error">', '</div>');
        if ($this->form_validation->run() === TRUE) {
            $data = array(
                "title" => $this->input->post('title'),
                "description" => $this->input->post('description', FALSE),
                "meta_keywords" => $this->input->post("meta_keywords"),
                "meta_description" => $this->input->post("meta_description")
            );

            if ($id > 0) {
                $data['slug'] = create_unique_slug($this->input->post('title'), 'pages', 'slug', 'id', $id);
            } else {
                $data['slug'] = create_unique_slug($this->input->post('title'), 'pages', 'slug');
            }


            if ($this->input->post('id') > 0) {
                $data['update'] = date("Y-m-d H:i:s");
                $this->db->update("pages", $data, array("id" => $this->input->post('id')));
                $this->session->set_flashdata("success", getLangText('PageUpdateSuccess'));
            } else {
                $data['created'] = date("Y-m-d H:i:s");
                $this->db->insert("pages", $data);
                $this->session->set_flashdata("success",getLangText('PageAddSuccess'));
            }
            redirect("admin/pages");
        }
        $this->viewData['title'] = "Add Static Page";
        if ($id > 0) {
            $this->viewData['data'] = $data = $this->page->getById((int) $id);
            if (empty($data)) {
                $this->session->set_flashdata("error", getLangText('LinkExpired'));
                redirect('admin/pages');
            }
            $this->viewData['title'] = "Edit Static Page";
        }
        $this->viewData['ckeditor_asset'] = true;
        $this->layout->view("admin/page/manage", $this->viewData);
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
                        ->update("pages", array("status" => 1));
            }
            if ($this->input->post("actions") == "inactive") {
                $this->db->where_in("id", $this->input->post("ids"))
                        ->update("pages", array("status" => 0));
            }
            if ($this->input->post("actions") == "delete") {
                $this->db->where_in("id", $this->input->post("ids"))
                        ->delete("pages");
            }
            $this->session->set_flashdata("success", "Selected rows {$this->input->post("actions")} successfully");
        }
        redirect("admin/pages");
    }

}

?>
