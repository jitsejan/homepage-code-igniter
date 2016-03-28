<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Code extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('code_model');
    $this->load->helper('url_helper');
  }

  public function index()
  {
    $data['title'] = 'Code';

    $this->load->view('templates/header', $data);
    $this->load->view('code/index', $data);
    $this->load->view('templates/footer');
  }

}
