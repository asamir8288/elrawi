<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of acl
 *
 * @author Ahmed Samir
 */
class ACL {

    function is_allowed() {
        $CI = & get_instance();
        $loggedin = $CI->session->userdata('is_login');

        if ($loggedin && $CI->uri->segment(1) == 'admin' && $CI->uri->segment(2) == '') {
            redirect('admin/static_page/about_halalate');
        } else if ($CI->uri->segment(1) == 'admin' && $CI->uri->segment(2) == '') {
            redirect('admin/login');
        }else if(!$loggedin && $CI->uri->segment(1) == 'admin' && $CI->uri->segment(2) != '' && $CI->uri->segment(2) != 'login'){
            redirect('admin/login');
        }
    }

}

?>
