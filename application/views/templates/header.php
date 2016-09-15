<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $title; ?> | <?php echo $this->config->item('sitename');?></title>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url('assets/css/swipebox.css');?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css');?>">
	</head>
	<body>
		<div class="top-bar">
			<div class="container">
				<div class="row">
					<div id="blog-head" class="container">
						<h3><?php echo $this->config->item('slogan'); ?></h3>
						<h5><?php echo $this->config->item('description'); ?></h5>
					</div>
				</div>
			</div><!-- /container !-->
			<div class="<container-fluid">
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
								<a class="navbar-brand" title="<?php echo $this->config->item('slogan');?>" href="<?php echo base_url('home'); ?>"><?php //echo $this->config->item('sitename');?><img src="assets/images/JJ,s World.gif"/></a>
							</div>
							<div id="navbar-responsive-collapse" class="collapse navbar-collapse">
								<ul id="menu-menu-1" class="nav navbar-nav">
									<li class="<?=($this->uri->segment(1)==='home' || null === $this->uri->segment(1))?'active':''?>"><a href="<?php echo base_url('home'); ?>" ><img src="assets/images/home.gif" alt="Home"/></a></li>
									<li class="<?=($this->uri->segment(1)==='code')?'active':''?>"><a href="<?php echo base_url('code'); ?>" ><img src="assets/images/code.gif" alt="Code"/></a></li>
									<li class="<?=($this->uri->segment(1)==='tutorials')?'active':''?>"><a href="<?php echo base_url('tutorials'); ?>" ><img src="assets/images/tutorials.gif" alt="Tutorials"/></a></li>
									<li class="<?=($this->uri->segment(1)==='photos')?'active':''?>"><a href="<?php echo base_url('photos'); ?>" ><img src="assets/images/photos.gif" alt="Photos"/></a></li>
									<li class="<?=($this->uri->segment(1)==='about')?'active':''?>"><a href="<?php echo base_url('about'); ?>" ><img src="assets/images/about.gif" alt="About"/></a></li>
								</ul>
							</div>
						</div>
					</nav>
				</header>
			</div><!-- /container-fluid !-->
		</div><!-- /top-bar !-->