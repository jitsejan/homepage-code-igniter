<div class="row">
  <div class="col-md-4"></div>
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-body">
        <h3><small>Add a new item</small></h3><hr/>
        <font color="red"><?php echo $this->session->flashdata('msg'); ?></font>
        <form action='<?php echo base_url('index.php/items/add');?>' method='post' name='additem'>
          <div class="form-group">
            <label for="link">Link</label>
            <input type="text" class="form-control" id="link" name="link" placeholder="Enter link to item">
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-4"></div>
</div>
