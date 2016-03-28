<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('logout_model');
	}
    
    function index()
    {
        $this->logout_model->logout();
        redirect('home','refresh');
    }
    
}
?>
