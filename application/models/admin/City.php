<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of city model for City
 *
 * @author Motilal Soni
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class City extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_city_list($condition = array(), $limit = array(), $order = array(), $with_num_rows = false) {
        $this->db->select("cities.*,states.name as state_name,countries.name as country_name");
        if (!empty($condition)) {
            $this->db->where($condition);
        }
        if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['start']);
        }
        if (!empty($order)) {
            $this->db->order_by($order[0], $order[1]);
        }
        $this->db->join("states", "states.id = cities.state_id", "left");
        $this->db->join("countries", "countries.id = cities.country_id", "left");
        $data = $this->db->get("cities");
        if ($with_num_rows == true) {
            $num_rows = $this->db->join("states", "states.id = cities.state_id", "left")
                    ->join("countries", "countries.id = states.country_id", "left")
                    ->where(!empty($condition) ? $condition : 1,TRUE)
                    ->count_all_results("cities");

            return (object) array("data" => $data, "num_rows" => $num_rows);
        }
        return $data;
    }

    public function getCityById($id) {
        if (is_integer($id) && $id > 0) {
            $result = $this->db->get_where("cities", array("id" => $id));
            return $result->num_rows() > 0 ? $result->row() : null;
        }
        return false;
    }

}

?>
