<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (!function_exists("sanitize_output")) {

    /**
     *
     * @param type $buffer
     * @return type 
     */
    function sanitize_output($buffer) {

        $search = array(
            '/\>[^\S ]+/s', // strip whitespaces after tags, except space
            '/[^\S ]+\</s', // strip whitespaces before tags, except space
            '/(\s)+/s'       // shorten multiple whitespace sequences
        );

        $replace = array(
            '>',
            '<',
            '\\1'
        );

        //$buffer = preg_replace($search, $replace, $buffer);

        return $buffer;
    }

}
if(!function_exists('str_date_format')){
    /**
     * 
     * @param type $input_date
     * @param type $output_date_format
     * @param type $input_date_format
     * @return string
     */
    function str_date_format($input_date, $output_date_format, $input_date_format = "Y-m-d H:i:s"){
        $dt = DateTime::createFromFormat($input_date_format, $input_date);
        if($dt !== false && !array_sum($dt->getLastErrors())){
            return $dt->format($output_date_format);
        }
        //$this->set_message('valid_date_formats', 'The %s is not valid date format.');
        return FALSE;
    }
}

if(!function_exists('reduce_content')){
    /**
     * 
     * @param type $string
     * @param type $length
     * @param type $html_strip
     * @return type
     */
    function reduce_content($string, $length=100, $html_strip = false){
        if($html_strip === TRUE)
            $string = strip_tags($string);
        return strlen($string) > $length ? substr($string, 0, $length - 3).'...' : $string;
    }
}