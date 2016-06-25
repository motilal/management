<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if (!function_exists('create_pagination')) {

    /**
     *
     * @param type $url
     * @param type $total_rows
     * @param type $per_page
     * @param type $segment
     * @param type $query_string
     * @return type pagination
     */
    function create_pagination($url, $total_rows, $per_page, $segment, $query_gegments = array(), $config = array()) {
        $CI = & get_instance();
        if (empty($query_gegments)) {
            $query_gegments = $CI->input->get();
            if (isset($query_gegments['start'])) {
                unset($query_gegments['start']);
            }
        }
        $query_string = http_build_query($query_gegments);

        $config['base_url'] = site_url($url);
        $config['num_links'] = 2;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['uri_segment'] = $segment;
        $config['suffix'] = $query_string ? "&" . $query_string : "";
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = "start";
        $config['first_url'] = $query_string ? "?" . $query_string : "";
        /* design */
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
        $config['cur_tag_close'] = '</a></li>';
        $CI->load->library("pagination");
        $CI->pagination->initialize($config);
        return $CI->pagination->create_links();
    }

}

if (!function_exists('db_input')) {

    /**
     *
     * @param type $param
     * @param type $quote
     * @return type 
     */
    function db_input($param, $quote = true) {

        //is_numeric doesn't work all the time...9e8 is considered numeric..which is correct...but not expected.
        if ($param && preg_match("/^\d+(\.\d+)?$/", $param))
            return $param;

        if ($param && is_array($param)) {
            reset($param);
            while (list($key, $value) = each($s)) {
                $param[$key] = db_input($value, $quote);
            }
            return $param;
        }
        return db_real_escape($param, $quote);
    }

}
if (!function_exists('db_real_escape')) {

    /**
     *
     * @param type $val
     * @param type $quote
     * @return type 
     */
    function db_real_escape($val, $quote = false) {
        //Magic quotes crap is taken care of in main.inc.php
        $val = addslashes($val);
        return ($quote) ? "'$val'" : $val;
    }

}
if (!function_exists('db_htmlchars')) {

    /**
     *
     * @param type $var
     * @return type 
     */
    function db_htmlchars($var) {
        return is_array($var) ? array_map(array('Format', 'htmlchars'), $var) : htmlspecialchars($var, ENT_QUOTES);
    }

}
if (!function_exists("send_mail")) {

    /**
     * 
     * @param type $mail_key
     * @param type $replace_from
     * @param type $replace_to
     * @param type $to
     * @param type $from
     * @param type $from_name
     * @param type $debug
     * @return boolean
     */
    function send_mail($mail_key = "", $replace_from = array(), $replace_to = array(), $to = "", $from = "", $from_name = "", $debug = false) {
        $CI = & get_instance();
        $CI->load->model(array("email_template"));
        $mail_data = $CI->email_template
                ->get_email_template_by_slug($mail_key);
        $subject = str_replace($replace_from, $replace_to, $mail_data->subject);
        $view_data['mail_body'] = str_replace($replace_from, $replace_to, $mail_data->message);
        $view_data['title'] = $mail_data->title;
        $message = sanitize_output($CI->load->view("emails/email_layout", $view_data, true));
        $CI->load->library('email');
        $mail_smtp = $CI->config->item("mail_smtp");
        $CI->email->initialize($mail_smtp);
        $CI->email->clear();

        if ($from == "" || $from_name == "") {
            $CI->email->reply_to($CI->setting->item("site_email"), $this->setting->item("site_title"));
            $CI->email->from($mail_smtp['smtp_user'], $this->setting->item("site_title"));
        } else {
            $CI->email->reply_to($from, $from_name);
            $CI->email->from($mail_smtp['smtp_user'], $from_name);
        }
        $CI->email->to($to);
        $CI->email->subject($subject);
        $CI->email->message($message);
        $CI->email->send();
        if ($debug == true) {
            echo $CI->email->print_debugger();
            die;
        }
    }

}

if (!function_exists('is_json')) {

    /**
     * 
     * @param type $string
     * @return type
     */
    function is_json($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

}

if (!function_exists('create_unique_slug')) { 
    function create_unique_slug($string, $table = 'pages', $field = 'slug', $key = NULL, $value = NULL) {
        $CI = & get_instance();
        $slug = url_title($string);
        $slug = strtolower($slug);
        $i = 0;
        $params = array();
        $params[$field] = $slug;
        if ($key)
            $params["$key !="] = $value;

        while ($CI->db->where($params)->get($table)->num_rows()) {
            if (!preg_match('/-{1}[0-9]+$/', $slug))
                $slug .= '-' . ++$i;
            else
                $slug = preg_replace('/[0-9]+$/', ++$i, $slug);

            $params [$field] = $slug;
        }
        return $slug;
    }

}
if (!function_exists('getLangText')) {

    /**
     * 
     * @param type $string
     * @return type
     */
    function getLangText($langKey) {         
        $CI = & get_instance(); 
        return $CI->lang->line("$langKey");
    }

}

?>
