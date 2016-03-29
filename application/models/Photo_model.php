<?php
class Photo_model extends CI_Model {

  public function __construct()
  {
    $this->load->database();
    $this->load->helper('date');
    $this->load->helper('directory');
  }
}
