<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- Set the viewport so this responsive site displays correctly on mobile devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 3 Responsive Design Tutorial | RevillWeb.com</title>
    <!-- Include bootstrap CSS -->
    <link href="<?=URL;?>public/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=URL;?>public/css/layout.css" rel="stylesheet">
	<link href="<?=URL;?>public/css/media.css" rel="stylesheet">
	<link rel="stylesheet" href="http://localhost/mvc/public/css/datepicker.css" />
	<?php if (!empty($this->styles)):?>
	<?php foreach($this->styles as $style) : ?>
	<link href="<?=URL; ?>public/css/<?php echo $style; ?>.css" rel="stylesheet" type="text/css" media="screen" />
	<?php endforeach; ?>
	<?php endif; ?>
	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Anton|Oswald' rel='stylesheet' type='text/css' />
	<link href='http://fonts.googleapis.com/css?family=Shadows+Into+Light+Two' rel='stylesheet' type='text/css' />
</head>
<body>
<div id="fb-root"></div>
<script type="text/javascript">
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "http://connect.facebook.net/en_GB/all.js#xfbml=1&amp;appId=151487781542911";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>
	<div class="box2 outer">
		<!-- Site header and navigation -->
		<header class="top" role="header">
		<img class="img-responsive" src="<?=URL;?>public/images/layout/banner.jpg">
			<div class="container">
				<nav class="navbar navbar-default" role="navigation">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
							<li><a href="<?=URL;?>"><span class="glyphicon glyphicon-home"></span></a></li>
							<li><a href="<?=URL;?>about">About</a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">News <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="<?=URL;?>news">Latest News</a></li>
									<li><a href="<?=URL;?>articles">Articles</a></li>
								</ul>
							</li>
							<li><a href="<?=URL;?>blogs">Blog</a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Fundraising <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="<?=URL;?>events">Fundraising Events</a></li>
									<li><a href="<?=URL;?>donate">Donate with PayPal</a></li>
									<li><a href="<?=URL;?>lottery">100 Club Lottery</a></li>
									<li><a href="<?=URL;?>sponsors">Sponsors</a></li>
								</ul>
							</li>
							<li><a href="<?=URL;?>gallery">Gallery</a></li>
							<li><a href="<?=URL;?>forum">Forum</a></li>
							<li><a href="<?=URL;?>contact">Contact</a></li>
							<li><a href="<?=URL;?>shop">Shop</a></li>
						</ul>
						<form class="navbar-form navbar-right" role="search">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Search">
							</div>
							<button type="submit" class="btn btn-default">Submit</button>
						</form>
					</div><!-- /.navbar-collapse -->
				</nav>
			</div>
		</header>
		<!-- Site banner -->
		<div class="banner">
			<div class="container">
				<div class="box contentimg">
					<img class="img-responsive" src="<?=URL; ?>public/images/<?=(isset($this->largeimg)) ? 'layout/'.$this->largeimg : ((isset($this->adminlrgimg)) ? 'admin/'.$this->adminlrgimg : false);?>" alt="<?=(isset($this->alt)) ? $this->alt : false; ?>" title="<?=(isset($this->alt)) ? $this->alt : false; ?>" />
				</div>
			</div>
		</div>
		<!-- Middle content section -->
		<div class="middle">
			<div class="container">
				<!-- Main Content section -->
				<div class="col-md-8 content">	
					<div id="breadcrumb"><?=(isset($this->crumbs)) ? $this->crumbs : false; ?></div>
					<div id="pagetitle"><h1><?=(isset($this->heading)) ? $this->heading : false; ?></h1></div>