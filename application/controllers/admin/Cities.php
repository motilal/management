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

class Cities extends CI_Controller {

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
        $this->load->model(array("admin/city"));
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
            $condition["cities.name like '%{$keyword}%' OR states.short_name like '%{$keyword}%' OR countries.name like '%{$keyword}%'"] = null;
        }

        $limit = array(
            'start' => (int) $start > 1 ? $start - 1 : $start,
            'limit' => $perpage
        );
        $order = array('cities.name', 'ASC');
        if (!empty($this->input->get('order_by')) && !empty($this->input->get('sort'))) {
            $order = array($this->input->get('order_by'), $this->input->get('sort'));
        }
        $result = $this->city->get_city_list($condition, $limit, $order, true);
        $this->viewData['result'] = $result->data;
        $this->viewData['pagination'] = create_pagination("admin/cities/index", $result->num_rows, $perpage, $this->segment);
        $this->viewData['title'] = "Cities";
        $this->layout->view("admin/city/index", $this->viewData);
    }

    public function manage($id = null) {
        $validation = array(
            array(
                'field' => 'name',
                'label' => 'City Name',
                'rules' => "trim|required|max_length[200]|callback__validate_city_name"
            ),
            array(
                'field' => 'country_id',
                'label' => 'Country',
                'rules' => "trim|required"
            ),
            array(
                'field' => 'state_id',
                'label' => 'State',
                'rules' => 'trim|required'
            )
        );
        $this->load->library('form_validation');
        $this->form_validation->set_rules($validation);
        $this->form_validation->set_error_delimiters('<div class="text-danger v_error">', '</div>');
        if ($this->form_validation->run() === TRUE) {
            $data = array(
                "name" => $this->input->post('name'),
                "country_id" => $this->input->post('country_id'),
                'state_id' => $this->input->post('state_id')
            );
            if ($this->input->post('id') > 0) {
                $this->db->update("cities", $data, array("id" => $this->input->post('id')));
                $this->session->set_flashdata("success", getLangText('CityUpdateSuccess'));
            } else {
                $data['status'] = 1;
                $this->db->insert("cities", $data);
                $this->session->set_flashdata("success", getLangText('CityAddSuccess'));
            }
            redirect("admin/cities");
        }
        $this->viewData['title'] = "Add City";
        if ($id > 0) {
            $this->viewData['data'] = $cityDate = $this->city->getCityById((int) $id);
            if (empty($cityDate)) {
                $this->session->set_flashdata("error", getLangText('LinkExpired'));
                redirect('admin/cities');
            }
            $this->viewData['title'] = "Edit State";
            $country_id = $cityDate->country_id;
        }
        if ($this->input->post()) {
            $country_id = $this->input->post('country_id');
        }
        //Country List Drop down
        $this->load->model('admin/country');
        $condition = array('countries.status' => '1');
        $order = array('countries.name', 'ASC');
        $this->viewData['country_dropdown'] = $this->country->get_country_list($condition, $order);

        if (isset($country_id) && $country_id > 0) {
            //State List Drop down
            $this->load->model('admin/state');
            $condition = array('states.status' => '1', 'states.country_id' => $country_id);
            $order = array('states.name', 'ASC');
            $this->viewData['state_dropdown'] = $this->state->get_state_list($condition, null, $order);
        }

        $this->layout->view("admin/city/manage", $this->viewData);
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
                        ->update("cities", array("status" => 1));
                $redirect_str = "?" . base64_decode($this->input->post("redirect"));
            }
            if ($this->input->post("actions") == "inactive") {
                $this->db->where_in("id", $this->input->post("ids"))
                        ->update("cities", array("status" => 0));
                $redirect_str = "?" . base64_decode($this->input->post("redirect"));
            }
            if ($this->input->post("actions") == "delete") {
                $this->db->where_in("id", $this->input->post("ids"))
                        ->delete("cities");
            }
            $this->session->set_flashdata("success", "Selected rows {$this->input->post("actions")} successfully");
        }
        redirect("admin/cities" . $redirect_str);
    }

    function _validate_city_name($str) {
        $id = $this->uri->segment(4);
        $condition = array('name' => $str, 'country_id' => $this->input->post('country_id'));
        if (!empty($id) && is_numeric($id)) {
            $condition['id !='] = $id;
        }
        $num_row = $this->db->where($condition)->count_all_results('cities');
        if ($num_row >= 1) {
            $this->form_validation->set_message('_validate_city_name', getLangText('CityAlreadyExist'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function state_dropdown() {
        if ($this->input->post('id') > 0) {
            //State List Drop down
            $this->load->model('admin/state');
            $condition = array('states.status' => '1', 'states.country_id' => $this->input->post('id'));
            $order = array('states.name', 'ASC');
            $state_dropdown = $this->state->get_state_list($condition, null, $order);
            $response = array("<option value=''>Select State</option>");
            if ($state_dropdown->num_rows() > 0):
                foreach ($state_dropdown->result() as $key => $value) :
                    $response[] = "<option value='{$value->id}'>{$value->name}</option>";
                endforeach;
            endif;
        }else {
            $response = array("<option value=''>Select State</option>");
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
        return;
    }

}

?>
