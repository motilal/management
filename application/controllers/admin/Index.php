<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Index extends CI_Controller {

    public $viewData;

    function __construct() {
        parent::__construct();
        $this->site_santry->redirect = "admin";
        $this->site_santry->allow(array("login","logout"));
        $this->layout->set_layout("admin/layout_admin");
    }

    public function login() {
        $this->layout->set_layout("admin/layout_login");
        if ($this->site_santry->is_admin_login()) {
            redirect('admin/dashboard');
        }
        if ($this->input->post()) {

            $valudation = array(
                array(
                    'field' => 'username',
                    'label' => 'Username',
                    'rules' => 'trim|required|xss_clean|callback__validate_user'
                ),
                array(
                    'field' => 'password',
                    'label' => 'Password',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                'field' => 'request',
                'label' => 'Request',
                'rules' => 'trim'
            ));
            $this->load->library('form_validation');
            $this->form_validation->set_rules($valudation);
            $this->form_validation->set_error_delimiters('<div class="text-danger v_error">', '</div>');

            if ($this->form_validation->run() == TRUE) {
                $result = $this->db->select("username,email,role")
                        ->where_in("role", array(2))
                        ->group_start()
                        ->where("username", $this->input->post("username")) 
                        ->or_where("email", $this->input->post("username"))
                        ->group_end()
                        ->get("users");
                $this->site_santry->do_login($result->row());
                if ($this->db->update("users", array("last_login" => date('Y-m-d H:i:s')), array("id" => $result->row()->id))) {
                    redirect($this->input->post('request') ? $this->input->post('request') : "/admin/dashboard/?auth=verify");
                }
            }
        }
        $this->viewData['request'] = $this->input->get("request") ? base64_decode($this->input->get('request')) : "";
        $this->viewData['title'] = "Admin Login"; 
        $this->layout->view("admin/admin_login", $this->viewData);
    }

    public function logout() { 
        if ($this->site_santry->is_admin_login()) {
            $this->site_santry->do_log_out();
            redirect("admin");
        }
    }

    public function _validate_user() {
        $password = $this->input->post("password");
        $username = $this->input->post("username");
        $result = $this->db->select("users.*")
                ->where_in("role", array(2))
                ->group_start()
                ->where("username", $username)
                ->or_where("email", $username)
                ->group_end()
                ->get("users");
        if ($result->num_rows() > 0) {
            if (password_verify($password, $result->row()->password) === TRUE) {
                return TRUE;
            }
        }
        $this->form_validation->set_message('_validate_user', 'Invalid Username / %s');
        return FALSE;
    }

}
