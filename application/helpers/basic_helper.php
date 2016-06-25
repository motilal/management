<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if (!function_exists('pr')) {

    function pr($data = null, $exit = false) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        if ($exit === TRUE)
            die();
    }

    if (!function_exists('sort_attribute')) {

        function sort_attribute($fieldname = null) {
            $CI = & get_instance();
            if (!empty($fieldname)) {
                $sort = 'asc';
                $sort_class = 'sorting';
                if ($CI->input->get('sort') == 'asc' && $CI->input->get('order_by') == $fieldname) {
                    $sort = 'desc';
                    $sort_class = 'sorting_asc';
                } else if ($CI->input->get('sort') == 'desc' && $CI->input->get('order_by') == $fieldname) {
                    $sort = 'asc';
                    $sort_class = 'sorting_desc';
                }   
                return (object) array('sort' => $sort, 'sort_class' => $sort_class);
               
            }
        }

    }

    if (!function_exists('sorting_url')) {

        function sorting_url($fieldname = null) {
            $CI = & get_instance();
            if (!empty($fieldname)) {
                $sort_attr = sort_attribute($fieldname);
                $getdata = $CI->input->get();
                unset($getdata['sort']);
                unset($getdata['order_by']);
                $query_string = http_build_query($getdata);
                $ext_url = "";
                if (!empty($query_string)) {
                    $ext_url = '&' . $query_string;
                } 
                $url = current_url()."?sort={$sort_attr->sort}&order_by={$fieldname}{$ext_url}";

                return (object) array('url' => $url, 'class' => $sort_attr->sort_class);
            }
        }

    }
}   