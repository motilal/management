<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of page model for State
 *
 * @author Motilal Soni
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class State extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_state_list($condition = array(), $limit = array(), $order = array(), $with_num_rows = false) {
        $this->db->select("states.*,countries.name as country_name");
        if (!empty($condition)) {
            $this->db->where($condition);
        }
        if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['start']);
        }
        if (!empty($order)) {
            $this->db->order_by($order[0], $order[1]);
        }
        $this->db->join("countries", "countries.id = states.country_id", "left");
        $data = $this->db->get("states");
        if ($with_num_rows == true) {
            $num_rows = $this->db->join("countries", "countries.id = states.country_id", "left")
                    ->where(!empty($condition) ? $condition : 1,TRUE)
                    ->count_all_results("states");

            return (object) array("data" => $data, "num_rows" => $num_rows);
        }
        return $data;
    }

    public function getStateById($id) {
        if (is_integer($id) && $id > 0) {
            $result = $this->db->get_where("states", array("id" => $id));
            return $result->num_rows() > 0 ? $result->row() : null;
        }
        return false;
    }

}

?>
