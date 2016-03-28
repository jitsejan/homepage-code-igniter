<?php
class Admin_model extends CI_Model {

  public function __construct()
  {
    $this->load->database();
    $this->load->helper('date');
  }
  
  public function set_colormapping($post) 
  {
    unset($post['btn_search']);
    foreach($post as $index => $value):
        $cmdata['colorid'] =  substr($index, strrpos($index, "_")+1);
        $cmdata['colorname'] = str_replace('_', ' ', substr($index, 3, strrpos($index, "_")-3));
        $result = $this->db->insert('colormappings', $cmdata);
    endforeach;
    redirect('admin/colors');
    
  } /* set_colormapping */
 
}
