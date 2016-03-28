<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('project_model');
    $this->load->model('website_model');
  }

  public function index()
  {
    $data['title'] = 'Home';
    
    $data['projects'] = $this->project_model->get_projects();
    $data['websites'] = $this->website_model->get_websites();
    
    $this->load->view('templates/header', $data);
    $this->load->view('home/landing', $data);
    $this->load->view('templates/footer');
  }

}
