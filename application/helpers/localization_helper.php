<?php

function getdir() {
    $CI = & get_instance();
    if ($CI->session->userdata('lang_code') == 'en-us') {
        return 'ltr';        
    } else {
        return 'rtl';
    }        
}

?>
