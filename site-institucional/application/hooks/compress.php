<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function compress()
{
    ini_set("pcre.recursion_limit", "16777");
    $CI = & get_instance();
    $buffer = $CI->output->get_output();
    $re = '%(?>[^\S ]\s*| \s{2,})(?=[^<]*+(?:<(?!/?(?:textarea|pre|script)\b)[^<]*+)*+(?:<(?>textarea|pre|script)\b| \z))%Six';
    $new_buffer = preg_replace($re, " ", $buffer);
    if ($new_buffer === null) {
        $new_buffer = $buffer;
    }
    $CI->output->set_output($new_buffer);
    $CI->output->_display();
}