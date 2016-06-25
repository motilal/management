<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Used for email templates 
 *
 * @author Motilal Soni
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_templates extends CI_Controller {

    var $viewData = array();

    /**
     *
     */
    public function __construct() {
        parent::__construct();
        $this->site_santry->redirect = "admin";
        $this->site_santry->allow(array());
        $this->layout->set_layout("admin/layout_admin");
        $this->load->model(array("admin/email_template"));
    }

    public function index() {
        $result = $this->email_template->get_list();
        $this->viewData['result'] = $result;
        $this->viewData['title'] = "Email Templates list";
        $this->viewData['datatable_asset'] = true;
        $this->layout->view("admin/email_template/index", $this->viewData);
    }

    public function view($id = null) {
        $this->viewData['data'] = $data = $this->email_template->getById((int) $id);
        if (empty($data)) {
            show_404();
        }
        $this->viewData['title'] = "Email Templates View";
        $this->layout->view("admin/email_template/view", $this->viewData);
    }

    public function manage($id = null) {
        $validation = array(
            array(
                'field' => 'title',
                'label' => 'Title',
                'rules' => "trim|required|max_length[255]"
            ),
            array(
                'field' => 'subject',
                'label' => 'Subject',
                'rules' => "trim|required|max_length[255]"
            ),
            array(
                'field' => 'variable',
                'label' => 'Variable',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'body',
                'label' => 'Body',
                'rules' => 'trim|required'
            )
        );
        $this->load->library('form_validation');
        $this->form_validation->set_rules($validation);
        $this->form_validation->set_error_delimiters('<div class="text-danger v_error">', '</div>');
        if ($this->form_validation->run() === TRUE) {
            $data = array(
                "title" => $this->input->post('title'),
                "subject" => $this->input->post('subject'),
                "variable" => $this->input->post('variable'),
                "body" => $this->input->post('body', FALSE)
            );

            if ($id > 0) {
                $data['slug'] = create_unique_slug($this->input->post('title'), 'email_templates', 'slug', 'id', $id);
            } else {
                $data['slug'] = create_unique_slug($this->input->post('title'), 'email_templates', 'slug');
            }


            if ($this->input->post('id') > 0) {
                $data['updated'] = date("Y-m-d H:i:s");
                $this->db->update("email_templates", $data, array("id" => $this->input->post('id')));
                $this->session->set_flashdata("success", getLangText('EmailUpdateSuccess'));
            } else {
                $data['created'] = date("Y-m-d H:i:s");
                $this->db->insert("email_templates", $data);
                $this->session->set_flashdata("success", getLangText('EmailAddSuccess'));
            }
            redirect("admin/email_templates");
        }
        $this->viewData['title'] = "Add Email Template";
        if ($id > 0) {
            $this->viewData['data'] = $data = $this->email_template->getById((int) $id);
            if (empty($data)) {
                $this->session->set_flashdata("error", getLangText('LinkExpired'));
                redirect('admin/email_templates');
            }
            $this->viewData['title'] = "Edit Email Template";
        }
        $this->viewData['ckeditor_asset'] = true;
        $this->layout->view("admin/email_template/manage", $this->viewData);
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
                        ->update("email_templates", array("status" => 1));
            }
            if ($this->input->post("actions") == "inactive") {
                $this->db->where_in("id", $this->input->post("ids"))
                        ->update("email_templates", array("status" => 0));
            }
            $this->session->set_flashdata("success", "Selected rows {$this->input->post("actions")} successfully");
        }
        redirect("admin/email_templates");
    }

}

?>
