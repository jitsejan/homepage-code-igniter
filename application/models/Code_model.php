<?php
class Code_model extends CI_Model {

  public function __construct()
  {
    $this->load->database();
    $this->load->helper('date');
  }

  public function get_snippets()
  {
      $this->db->select();
      $this->db->order_by("createtime", "desc");
      $query = $this->db->get('snippets');
      $snippets = $query->result_array();
      if(sizeof($snippets,1) > 1):
        return $snippets;
      else:
        return false;
      endif;
  } /* get_snippets */

}
