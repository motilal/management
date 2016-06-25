<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of event
 *
 * @author Motilal Soni
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Events extends CI_Controller {

    var $viewData = array();

    /**
     *
     */
    public function __construct() {
        parent::__construct();
        $this->site_santry->redirect = "admin";
        $this->site_santry->allow(array());
        $this->layout->set_layout("admin/layout_admin");
        $this->load->model(array("admin/event"));
    }

    public function index() {
        $condition = array();
        $result = $this->event->get_list($condition);
        $this->viewData['result'] = $result;
        $this->viewData['title'] = "Events list";
        $this->viewData['datatable_asset'] = true;
        $this->layout->view("admin/event/index", $this->viewData);
    }

    public function manage($id = null) {
        $validation = array(
            array(
                'field' => 'title',
                'label' => 'Event title',
                'rules' => "trim|required|max_length[255]"
            ),
            array(
                'field' => 'description',
                'label' => 'Description',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'start_date',
                'label' => 'Start Date',
                'rules' => "trim|required"
            ),
            array(
                'field' => 'end_date',
                'label' => 'End Date',
                'rules' => "trim|callback__validate_daterange"
            )
        );

        $this->load->library('form_validation');
        $this->form_validation->set_rules($validation);
        $this->form_validation->set_error_delimiters('<div class="text-danger v_error">', '</div>');
        if ($this->form_validation->run() === TRUE) {
            $start_date = date('Y-m-d: H:i:s', strtotime($this->input->post('start_date')));
            $end_date = date('Y-m-d: H:i:s', strtotime($this->input->post('end_date')));
            $data = array(
                "title" => $this->input->post('title'),
                "description" => $this->input->post('description', FALSE),
                "start_date" => $start_date,
                "end_date" => $end_date
            );

            if ($id > 0) {
                $data['slug'] = create_unique_slug($this->input->post('title'), 'events', 'slug', 'id', $id);
            } else {
                $data['slug'] = create_unique_slug($this->input->post('title'), 'events', 'slug');
            }


            if ($this->input->post('id') > 0) {
                $data['update'] = date("Y-m-d H:i:s");
                $this->db->update("events", $data, array("id" => $this->input->post('id')));
                $this->session->set_flashdata("success", getLangText('EventUpdateSuccess'));
            } else {
                $data['created'] = date("Y-m-d H:i:s");
                $this->db->insert("events", $data);
                $this->session->set_flashdata("success", getLangText('EventAddSuccess'));
            }
            redirect("admin/events");
        }
        $this->viewData['title'] = "Add Event";
        if ($id > 0) {
            $this->viewData['data'] = $data = $this->event->getById((int) $id);
            if (empty($data)) {
                $this->session->set_flashdata("error", getLangText('LinkExpired'));
                redirect('admin/events');
            }
            $this->viewData['title'] = "Edit Event";
        }
        $this->viewData['ckeditor_asset'] = true;
        $this->viewData['datetimepicker_asset'] = true;
        $this->layout->view("admin/event/manage", $this->viewData);
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
                        ->update("events", array("status" => 1));
            }
            if ($this->input->post("actions") == "inactive") {
                $this->db->where_in("id", $this->input->post("ids"))
                        ->update("events", array("status" => 0));
            }
            if ($this->input->post("actions") == "delete") {
                $this->db->where_in("id", $this->input->post("ids"))
                        ->delete("events");
            }
            $this->session->set_flashdata("success", "Selected rows {$this->input->post("actions")} successfully");
        }
        redirect("admin/events");
    }

    function _validate_daterange($str) {
        $start_date = strtotime($this->input->post('start_date'));
        $end_date = strtotime($this->input->post('end_date'));

        if ($end_date < $start_date) {
            $this->form_validation->set_message('_validate_daterange', '%s will not greater than start date.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function calendar() {
        $this->viewData['title'] = "Event Calendar";
        $this->viewData['drop_menu_css'] = true;
        $this->layout->view("admin/event/calendar", $this->viewData);
    }
    function calendarEvent() {
        if ($this->input->is_ajax_request()) {
            $start_date = $this->input->get('start');
            $end_date = $this->input->get('end');
            $condition = array("start_date BETWEEN '$start_date' AND '$end_date'" => NULL);
            $blogpressrealease = $this->db->select('id,Title,start_date,end_date', false)
                    ->get_where('events', $condition);
            $response = array();
            if ($blogpressrealease->num_rows() > 0) {
                foreach ($blogpressrealease->result() as $key => $val) {
                    $response[] = array('title' => $val->Title, 'date' => $val->start_date, 'url' => site_url("admin/events/manage/$val->id"));
                }
                echo json_encode($response);
            }
            exit;
        }
    }

}

?>
