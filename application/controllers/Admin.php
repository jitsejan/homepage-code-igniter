<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('slide_model');
    $this->load->model('photoset_model');
    $this->load->model('photo_model');
    $this->load->model('admin_model');
  }

  public function index($page = NULL)
  {
    // if(isset($this->session->userdata['userid']) && ($this->session->userdata['level'] >= 5)){
    $data['page'] = 'Dash';
    $data['title'] = $data['page'] .' | Admin';
    
    $this->load->view('templates/header', $data);
    $this->load->view('admin/index', $data);
    $this->load->view('templates/footer');
    // }else{
        // redirect('login');
    // }
  }
  


}
