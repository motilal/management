<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Settings extends CI_Controller {

    public $viewData;

    function __construct() {
        parent::__construct();
        $this->site_santry->redirect = "admin";
        $this->site_santry->allow();
        $this->layout->set_layout("admin/layout_admin");
    }

    public function index() {
        $validation = array();
        $config_items = $this->setting->get_config_items();
        foreach ($config_items as $k => $v) {
            array_push($validation, array(
                'field' => "settings_{$v->id}",
                'label' => $v->title,
                'rules' => $v->is_required == 0 ? 'trim' : $v->validation_rules
                    )
            );
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules($validation);
        $this->form_validation->set_error_delimiters('<div class="text-danger v_error">', '</div>');
        if ($this->form_validation->run() === TRUE) {
            foreach ($config_items as $k => $v) {
                $data = array(
                    "value" => $this->input->post("settings_{$v->id}", true)
                );
                $this->db->update("settings", $data, array("id" => $v->id));
            }
            $this->session->set_flashdata("success", "Site settings updated successfully");
            redirect("admin/settings");
        }
        $this->viewData['settings_data'] = $config_items;

        $this->viewData['title'] = "Profile Setting";
        $this->layout->view('admin/setting/index', $this->viewData);
    }

    public function profile() {
        if ($this->input->post()) {
            $post = $this->input->post();
            if ($post['action'] == 'change-password') {
                $this->_changePassword();
            }
        }
        $this->viewData['title'] = "Profile Setting";
        $this->layout->view('admin/setting/profile', $this->viewData);
    }

    protected function _changePassword() {
        $valudation = array(
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required|xss_clean|callback__validate_password'
            ),
            array(
                'field' => 'new_password',
                'label' => 'New Password',
                'rules' => 'trim|required|min_length[6]|max_length[40]|xss_clean'
            ),
            array(
                'field' => 'confirm_password',
                'label' => 'Confirm Password',
                'rules' => 'trim|required|min_length[6]|max_length[40]|xss_clean|matches[new_password]'
            )
        );
        $this->load->library('form_validation');
        $this->form_validation->set_rules($valudation);
        $this->form_validation->set_error_delimiters('<div class="text-danger v_error">', '</div>');

        if ($this->form_validation->run() == TRUE) {
            $salt = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
            $update_data['password'] = password_hash(
                    $this->input->post("new_password"), PASSWORD_BCRYPT, array('cost' => 11, 'salt' => $salt)
            );
            $update_data['salt'] = base64_encode($salt);
            $update_data['updated'] = date('Y-m-d H:i:s');

            if ($this->db->update("users", $update_data, array("id" => $this->site_santry->get_auth_data()->id))) {
                $this->session->set_flashdata("success", "Profile updated successfully");
                redirect("admin/dashboard");
            }
        }
    }

    public function _validate_password() {
        $password = $this->input->post("password");
        $username = $this->input->post("username");
        $result = $this->db->select("users.*")
                ->where("id", $this->site_santry->get_auth_data()->id)
                ->get("users");
        if ($result->num_rows() > 0) {
            if (password_verify($password, $result->row()->password) === TRUE) {
                return TRUE;
            }
        }
        $this->form_validation->set_message('_validate_password', 'You enter wrong %s');
        return FALSE;
    }

}
