<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of States
 *
 * @author Motilal Soni
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class States extends CI_Controller {

    var $viewData = array();
    var $segment = 4;
    var $per_page = ADMIN_PAGEING_LIMIT;

    /**
     *
     */
    public function __construct() {
        parent::__construct();
        $this->site_santry->redirect = "admin";
        $this->site_santry->allow(array());
        $this->layout->set_layout("admin/layout_admin");
        $this->load->model(array("admin/state"));
    }

    public function index() {
        $condition = array();
        $start = (int) $this->input->get('start');

        $perpage = $this->per_page;
        if (!empty($this->input->get('perpage')) && $this->input->get('perpage') > 0) {
            $perpage = (int) $this->input->get('perpage');
        }
        $this->viewData['perpage'] = $perpage;

        if (!empty($this->input->get('keyword'))) {
            $keyword = $this->db->escape_str($this->input->get('keyword'));
            $condition["states.name like '%{$keyword}%' OR states.short_name like '%{$keyword}%' OR countries.name like '%{$keyword}%'"] = null;
        }

        $limit = array(
            'start' => (int) $start > 1 ? $start - 1 : $start,
            'limit' => $perpage
        );
        $order = array('states.name', 'ASC');
        if (!empty($this->input->get('order_by')) && !empty($this->input->get('sort'))) {
            $order = array($this->input->get('order_by'), $this->input->get('sort'));
        }
        $result = $this->state->get_state_list($condition, $limit, $order, true);
        $this->viewData['result'] = $result->data;
        $this->viewData['pagination'] = create_pagination("admin/states/index", $result->num_rows, $perpage, $this->segment);
        $this->viewData['title'] = "States";
        $this->layout->view("admin/state/index", $this->viewData);
    }

    public function manage($id = null) {
        $validation = array(
            array(
                'field' => 'name',
                'label' => 'State Name',
                'rules' => "trim|required|max_length[200]|callback__validate_state_name"
            ),
            array(
                'field' => 'country_id',
                'label' => 'Country',
                'rules' => "trim|required"
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
                "short_name" => $this->input->post('short_name'),
                'country_id' => $this->input->post('country_id')
            );

            if ($this->input->post('id') > 0) {
                $this->db->update("states", $data, array("id" => $this->input->post('id')));
                $this->session->set_flashdata("success", getLangText('StateUpdateSuccess'));
            } else {
                $data['status'] = 1;
                $this->db->insert("states", $data);
                $this->session->set_flashdata("success", getLangText('StateAddSuccess'));
            }
            redirect("admin/states");
        }
        $this->viewData['title'] = "Add State";
        if ($id > 0) {
            $this->viewData['data'] = $stateDate = $this->state->getStateById((int) $id);
            if (empty($stateDate)) {
                $this->session->set_flashdata("error", getLangText('LinkExpired'));
                redirect('admin/states');
            }
            $this->viewData['title'] = "Edit State";
        }
        $this->load->model('admin/country');
        $condition = array('countries.status' => '1');
        $order = array('countries.name', 'ASC');
        $this->viewData['country_dropdown'] = $this->country->get_country_list($condition, $order);
        $this->layout->view("admin/state/manage", $this->viewData);
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
        $redirect_str = '';
        if ($this->form_validation->run() === TRUE) {
            if ($this->input->post("actions") == "active") {
                $this->db->where_in("id", $this->input->post("ids"))
                        ->update("states", array("status" => 1));
                 $redirect_str = "?".base64_decode($this->input->post("redirect"));
            }
            if ($this->input->post("actions") == "inactive") {
                $this->db->where_in("id", $this->input->post("ids"))
                        ->update("states", array("status" => 0));
                 $redirect_str = "?".base64_decode($this->input->post("redirect"));
            }
            if ($this->input->post("actions") == "delete") {
                $this->db->where_in("id", $this->input->post("ids"))
                        ->delete("states");
            }
            $this->session->set_flashdata("success", "Selected rows {$this->input->post("actions")} successfully");
        }
        redirect("admin/states".$redirect_str);
    }

    function _validate_state_name($str) {
        $id = $this->uri->segment(4); 
        $condition = array('name'=>$str,'country_id'=>$this->input->post('country_id'));
        if (!empty($id) && is_numeric($id)) {
            $condition['id !='] = $id;
        } 
        $num_row = $this->db->where($condition)->count_all_results('states');
        if ($num_row >= 1) {
            $this->form_validation->set_message('_validate_state_name', getLangText('StateAlreadyExist'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

?>
