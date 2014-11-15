<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of localization
 *
 * @author Ahmed Samir
 */
Class Localization {

    function pick_language() {        
        $CI =& get_instance();
        
        $langs = $CI->config->item('lang_list');
        $lang = '';
        
        // Lang set in URL via ?lang=something
        if (!empty($_GET['lang'])) {
            $lang = substr($_GET['lang'], 0, 5);            
        }
        // Lang has already been set and is stored in a session
        elseif ($CI->session->userdata('lang_code')) {
            $lang = $CI->session->userdata('lang_code');
        }

        // If no language has been worked out - or it is not supported - use the default
        if (empty($lang) or !in_array($lang, array_keys($CI->config->item('lang_list')))) {
            $lang = $CI->config->item('language');            
        }
        $CI->config->set_item('language', $lang);
        
        if (is_file(APPPATH . "language/$lang/" . "{$CI->router->class}_lang.php")){
           $CI->lang->load($CI->router->class, $lang);
        }else{
            // load global language file
            $CI->lang->load('global', $lang);
        }
        
        $CI->session->set_userdata('lang_name',  $langs[$lang]);
        $CI->session->set_userdata('lang_code',  $lang);
    }
    

}

?>
