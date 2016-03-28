<nav class="navbar navbar-default no-margin">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header fixed-brand">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"  id="menu-toggle">
          <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>
        </button>
        <a class="navbar-brand" href="<?php echo base_url('admin');?>"> Admin Panel</a>
    </div><!-- navbar-header-->

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active" ><button class="navbar-toggle collapse in" data-toggle="collapse" id="menu-toggle-2"> <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span></button></li>
                </ul>
    </div><!-- bs-example-navbar-collapse-1 -->
</nav>
<div id="wrapper">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav nav-pills nav-stacked" id="menu">

            <li class="<?php if($page == 'Dash'): echo 'active'; endif;?>">
                <a href="<?php echo base_url('admin'); ?>"><span class="fa-stack fa-lg pull-left"><i class="fa fa-dashboard fa-stack-1x "></i></span> Dashboard</a>
            <!--       <ul class="nav-pills nav-stacked" style="list-style-type:none;">-->
            <!--        <li><a href="#">link1</a></li>-->
            <!--        <li><a href="#">link2</a></li>-->
            <!--    </ul>-->
            <!--</li>-->
            <li class="<?php if($page == 'Brands'): echo 'active'; endif;?>">
                <a href="<?php echo base_url('admin/brands'); ?>"><span class="fa-stack fa-lg pull-left"><i class="fa fa-cloud-download fa-stack-1x "></i></span>Brands</a>
            </li>
            <li>
                <a href="<?php echo base_url('admin/categories'); ?>"><span class="fa-stack fa-lg pull-left"><i class="fa fa-cloud-download fa-stack-1x "></i></span>Categories</a>
            </li>
            <li>
                <a href="<?php echo base_url('admin/colors'); ?>"><span class="fa-stack fa-lg pull-left"><i class="fa fa-cloud-download fa-stack-1x "></i></span>Colors</a>
            </li>
        </ul>
    </div><!-- /#sidebar-wrapper -->
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid xyz">
            <div class="row">
                <div class="col-lg-12">