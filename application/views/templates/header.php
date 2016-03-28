<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $title; ?> | <?php echo $this->config->item('sitename');?></title>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css');?>">
		
		<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/js/jquery-2.2.0.min.js');?>"></script>
		<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/js/jquery-ui.js');?>"></script>
		<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/js/jquery.mobile.custom.min.js');?>"></script>
		<script type="text/javascript" language="javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div id="blog-head" class="container">
					<h3><?php echo $this->config->item('slogan'); ?></h3>
					<h5><?php echo $this->config->item('description'); ?></h5>
				</div>
			</div>
		</div><!-- /container !-->
		<div class="<container-fluid></container-fluid>">
			<header role="banner" data-spy="affix" data-offset-top="140">
				<nav class="navbar navbar-default">
					<div class="container">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-responsive-collapse">
			    				<span class="sr-only">Navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand" title="<?php echo $this->config->item('slogan');?>" href="<?php echo base_url('home'); ?>"><?php echo $this->config->item('sitename');?></a>
						</div>
						<div id="navbar-responsive-collapse" class="collapse navbar-collapse">
							<ul id="menu-menu-1" class="nav navbar-nav">
								<li class="<?=($this->uri->segment(1)==='home')?'active':''?>"><a href="<?php echo base_url('home'); ?>" >Home</a></li>
								<li class="<?=($this->uri->segment(1)==='code')?'active':''?>"><a href="<?php echo base_url('code'); ?>" >Code</a></li>
								<li class="<?=($this->uri->segment(1)==='photos')?'active':''?>"><a href="<?php echo base_url('photos'); ?>" >Photos</a></li>
								<li class="<?=($this->uri->segment(1)==='about')?'active':''?>"><a href="<?php echo base_url('about'); ?>" >About</a></li>
							</ul>
						</div>
					</div>
				</nav>
			</header>
		</div><!-- /container !-->
		<div class="container">
			