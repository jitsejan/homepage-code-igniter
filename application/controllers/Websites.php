<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Websites extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('website_model');
    $this->load->helper('url_helper');
  }

  public function index()
  {
    $data['title'] = 'Website overview';

    $this->load->view('templates/header', $data);
    $this->load->view('websites/index', $data);
    $this->load->view('templates/footer');
  }

  
}
