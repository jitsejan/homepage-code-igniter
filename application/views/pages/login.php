<div class="row">
  <div class="col-md-4"></div>
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-body">
        <h3><small>Please log in</small></h3><hr/>
        <?php if(isset($msg) && !is_null($msg)) echo $msg;?>

        <form action='<?php echo base_url('index.php/login/process');?>' method='post' name='process'>
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-4"></div>
</div>
