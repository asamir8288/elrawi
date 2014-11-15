<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of my_controller
 *
 * @author Ahmed
 */
class My_Controller extends CI_Controller {
    
    var $data = array();
    
    public function __construct() {
        parent::__construct();        
        
        $lang_code = $this->session->userdata('lang_code');
        
        if($lang_code == 'en-us'){
            $this->data['lang_id'] = 1;
        }else{
            $this->data['lang_id'] = 2;
        }
        
        $this->template->set_template('admin');
    }
}

?>
