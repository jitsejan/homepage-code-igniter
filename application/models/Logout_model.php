<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class logout_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
    
    public function logout()
    {
        $this->session->unset_userdata('userid');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('validated');
        $this->session->sess_destroy();
        return true;
    }
    
}
?>
