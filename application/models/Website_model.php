<?php
class Website_model extends CI_Model {

  public function __construct()
  {
    $this->load->database();
    $this->load->helper('date');
  }

  public function get_websites()
  {
      $this->db->select();
      $this->db->order_by("index", "desc");
      $query = $this->db->get('websites');
      $websites = $query->result_array();
      if(sizeof($websites,1) > 1):
        return $websites;
      else:
        return false;
      endif;
  } /* get_websites */
}
