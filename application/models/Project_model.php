<?php
class Project_model extends CI_Model {

  public function __construct()
  {
    $this->load->database();
    $this->load->helper('date');
  }

  public function get_projects()
  {
      $this->db->select();
      $this->db->order_by("createtime", "desc");
      $query = $this->db->get('projects');
      $projects = $query->result_array();
      if(sizeof($projects,1) > 1):
        return $projects;
      else:
        return false;
      endif;
  }

  public function get_item($itemid = FALSE, $uuid = FALSE){
    if ($uuid !== FALSE)
    {
      $this->db->select('p.id, p.brand, p.link, p.color, p.title, p.category, p.uuid, s.id as storeid, s.name as store');
      $this->db->join('stores as s', 's.id = p.storeid', 'RIGHT');
      $query = $this->db->get_where('products as p', array('uuid' => $uuid));
      $item = $query->row_array();
      $item['images'] = $this->item_model->get_images($item['id']);
      $item['prices'] = $this->item_model->get_prices($item['id']);
      return $item;
    }
    elseif($itemid !== FALSE)
    {
      $this->db->select('p.id, p.brand, p.link, p.color, p.title, p.category, p.uuid, s.id as storeid, s.name as store');
      $this->db->join('stores as s', 's.id = p.storeid', 'RIGHT');
      $query = $this->db->get_where('products as p', array('p.id' => $itemid));
      $item = $query->row_array();
      $item['images'] = $this->item_model->get_images($itemid);
      $item['prices'] = $this->item_model->get_prices($itemid);
      return $item;
    }
    else
    {
      return false;
    }
  }


  function get_images($productid = FALSE)
  {
    if ($productid === FALSE)
    {   // TODO Do nothing. How to handle this?
        return false;
    }
    else
    {
    	$this->db->select('imageurl, localurl');
      $this->db->order_by("id", "asc");
  		$query = $this->db->get_where('productimages', array('productid' => $productid));
      return $query->result_array();
    }
  }

  function get_prices($productid = FALSE)
  {
    if ($productid === FALSE)
    {  // TODO Do nothing. How to handle this?
      return false;
    }
    else
    {
      $this->db->select('price, checkdate');
      $this->db->order_by('checkdate desc');
      $query = $this->db->get_where('productprices', array('productid' => $productid));
      return $query->result_array();
    }
  }

  public function get_productid($uuid = FALSE){
    $this->db->select('id');
    $query = $this->db->get_where('products', array('uuid' => $uuid));
    $result = $query->row_array();
    return $result['id'];
  }
  
  public function delete_item($userid = NULL, $uuid = NULL){
    if($userid !== FALSE && $uuid !== FALSE){
      $productid = $this->item_model->get_productid($uuid);
      /* Delete from userproducts */
      $darray = array('userid' => $userid, 'productid' => $productid);
      $this->db->where($darray); 
      $this->db->delete('userproducts'); 
      /* Delete from outfitproducts */
      $this->outfit_model->delete_outfits_for_item($userid, $productid);
    }
  }

  public function find_changed_items($userid, $date, $type){
    $query = "
    SELECT `cur`.`productid`, `prevdate`, `prevprice`, `curdate`, `curprice`, `numprices`
    FROM (
      SELECT `p`.`productid`, `price` as `prevprice`, `checkdate` as `prevdate`, `numprices`
      FROM `productprices` as `p` 
      RIGHT JOIN (
        SELECT MAX(`checkdate`) as `date` 
        FROM `productprices` as `date` 
        WHERE `checkdate` < '".$date."' 
        GROUP BY `productid`) as `d` 
      ON  `d`.`date` = `p`.`checkdate` 
      LEFT JOIN (SELECT `productid`, COUNT(*) as `numprices` FROM `productprices` WHERE `checkdate` < '".$date."' GROUP BY `productid`) AS `counter`
      ON `counter`.`productid` = `p`.`productid`
      GROUP BY `productid`) as `prev`
      RIGHT JOIN (
        SELECT `productprices`.`productid`, `checkdate` as `curdate`, `price` as `curprice`
        FROM `productprices` 
        LEFT JOIN `userproducts`
        ON `userproducts`.`productid` = `productprices`.`productid` 
        LEFT JOIN (SELECT `productid`, COUNT(*) as `numprices` FROM `productprices` WHERE `checkdate` < '".$date."' GROUP BY `productid`) AS `counter`
        ON `counter`.`productid` = `productprices`.`productid`
        WHERE `userproducts`.`userid` = ".$userid."
        AND `checkdate` = '".$date."' 
        GROUP BY `productid`) AS `cur` 
      ON `cur`.`productid` = `prev`.`productid`";
      
    
    switch ($type):
      case 'increased':
        $query .= " WHERE `prevprice` < `curprice` AND `prevprice` IS NOT NULL AND `prevprice` <> 0.00";
        break;
      case 'descreased':
        $query .= " WHERE `prevprice` > `curprice` AND `curprice` IS NOT NULL AND `curprice` <> ''";
        break;
      case 'notavailable':
        $query .= " WHERE `curprice` = '' AND `prevprice` IS NOT NULL AND `prevprice` <> ''";
        break;
      case 'availableagain':
        $query .= " WHERE `prevprice` = '' AND `curprice` IS NOT NULL AND `curprice` <> '' AND `numprices` > 1" ;
        break;
      case 'new':
        $query .= " WHERE `prevprice` IS NULL AND `curprice` IS NOT NULL AND `numprices` IS NULL";
        break;
      default:
        break;
    endswitch;
    
    
    $items =$this->db->query($query)->result_array();
    if(sizeof($items,1) > 1)
    {
      foreach($items as $index => $item)
      {
        $items[$index] = $this->item_model->get_item($itemid = $item['productid'], $uuid = FALSE);
        $items[$index]['prevprice'] = $item['prevprice'];
        $items[$index]['curprice'] = $item['curprice'];
      }
      return $items;
    }
    return false;
  }

  public function set_item()
  {
    $url = $this->input->post('link');
    $userid = $this->session->userdata['userid'];
    // Check if product is already in database
    $query = $this->db->select('id')->get_where('products', array('link' => $url));
    $productid = $query->row_array()['id'];
    if(isset($productid))
    { // Product already in database. Check if an entry exists for the user-product
      $query = $this->db->select('id')->get_where('userproducts', array('productid' => $productid, 'userid' => $userid));
      if ($query->num_rows() > 0)
      { // Product already added for current user
        $msg = "This product has already been added to your items!";
        $this->session->set_flashdata('msg', $msg);
        redirect('items/add');
      }
      else
      { // Product should be added for current user
        $this->item_model->set_userproduct($userid, $productid);
      }
    }
    else
    { // Product not in database yet
      $command = escapeshellcmd("python /home/jitsejan/code/outfitter/__main__.py '$url'");
    	$output = shell_exec($command);
    	if($output != "")
      { // Parse script succeeded
        $output_array = explode('; ',$output);
        $data = array();
        $images = array();
        // Split output to data and images
        foreach($output_array as $index => $value){
          $pair = explode('=>', $value);
          if(sizeof($pair, 1) == 1)
          {
            $images[] = $pair[0];
          }
          else
          {
            $data[$pair[0]] = $pair[1];
          }
        }
        $ppdata['price'] = $data['price'];
        $ppdata['currency'] = $data['currency'];
        unset($data['price']);
        unset($data['currency']);
        $this->db->insert('products', $data);
        if($this->db->affected_rows() > 0){
          $productid = $this->db->insert_id();
          // Insert product images
          $this->item_model->set_productimages($productid, $images);
          // Insert product price
          $this->item_model->set_productprice($productid , $ppdata);
          // Insert user product
          $this->item_model->set_userproduct($userid, $productid);
        }
        else
        { // Inserting product went wrong
          $msg = "There was an error adding the item to the database";
          $this->session->set_flashdata('msg', $msg);
          redirect('items/add');
        }
      }
      else
      { // Parse script failed
        $msg = "Something is wrong with the provided link!";
        $this->session->set_flashdata('msg', $msg);
        redirect('items/add', $data);
      }
    }
  } /* set_item */

  function set_productimages($productid, $images){
    foreach($images as $index => $image){
      // Insert images for item
      $imagedata['productid'] = $productid;
      $imagedata['imageurl'] = $image;
      $this->db->insert('productimages', $imagedata);
    }
  } /* set_productimages */

  function set_productprice($productid, $data)
  { // Insert product price
    $pricedata['productid'] = $productid;
    $pricedata['price'] = $data['price'];
    $pricedata['currency'] = $data['currency'];
    $pricedata['checkdate'] = date('Y-m-d', NOW());
    $result = $this->db->insert('productprices', $pricedata);
    if($result):
      // Added product-price link.
      return true;
    else:
      // Adding product-price went wrong
      return false;
    endif;
  } /* set_productprice */

  function set_userproduct($userid, $productid)
  { // Insert user product
    $updata['userid'] =  $userid;
    $updata['productid'] = $productid;
    $result = $this->db->insert('userproducts', $updata);
    if($result):
      // Added user-product link. Redirect to item overview
      redirect('items');
    else:
       // Adding user-product went wrong
      return false;
    endif;
  } /* set_userproduct */
}
