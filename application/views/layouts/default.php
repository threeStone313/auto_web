<!DOCTYPE html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Dashboard | XO Auto-Test System</title>
		<meta name="description" content="">
		<meta name="author" content="Walking Pixels | www.walkingpixels.com">
		<meta name="robots" content="index, follow">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- Styles -->
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/sangoma-blue.css">
		<link rel="stylesheet" href="<?php echo base_url();?>public/js/plugins/autocomplete/jquery.autocomplete.css">
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/mystyle.css">

		<!-- JS Libs -->
		
		<script src="<?php echo base_url();?>public/js/libs/jquery.js"></script>
		<script src="<?php echo base_url();?>public/js/libs/modernizr.js"></script>
		<script src="<?php echo base_url();?>public/js/plugins/autocomplete/jquery.bowser.js"></script>
		<script src="<?php echo base_url();?>public/js/plugins/autocomplete/jquery.autocomplete.js"></script>


		<!-- IE8 support of media queries and CSS 2/3 selectors -->
		<!--[if lt IE 9]>
			<script src="<?php echo base_url();?>public/js/libs/respond.min.js"></script>
			<script src="<?php echo base_url();?>public/js/libs/selectivizr.js"></script>
		<![endif]-->
		
	</head>
	<body>
		
		<!-- Full height wrapper -->
		<div id="wrapper">

			<!-- Main page header -->
			<header id="header" class="container">

				<h1>
					<!-- Main page logo -->
					<a href="login.html">Sangoma</a>
					
					<!-- Main page headline -->
					<span>XO Auto-Test System</span>
				</h1>
				
				<!-- User profile -->
				<div class="user-profile">
					<figure>
						<!-- User profile info -->
						<figcaption>
							<strong><a href="user-profile.html"><?php echo $_SESSION['admin']['nickname']?></a></strong>
							<ul>
								<li><a href="/setting/index" title="Account settings">Settings</a></li>
								<li><a href="/welcome/logout" title="Logout">Logout</a></li>
							</ul>
						</figcaption>
						<!-- /User profile info -->

					</figure>
				</div>
				<!-- /User profile -->

			</header>
			<!-- /Main page header -->

			<!-- Main page container -->
			<section class="container" role="main">

				<!-- Grid row -->
				<div class="row">
					
					<!-- Navigation block -->
					<div class="col-sm-2">					
						<?php echo $nav;?>
					</div>
					<!-- /Navigation block -->
					
					<!-- Content block -->
					<div class="col-sm-10">
						
						<?php echo $contents;?>

					</div>
					<!-- /Content block -->
					
				</div>
				<!-- /Grid row -->

			</section>
			<!-- /Main page container -->
			
		</div>
		<!-- /Full height wrapper -->

		<!-- Main page footer -->
		<footer id="footer">
			<div class="container">

				<!-- Footer info -->
				<p>Built with love on <a href="http://getbootstrap.com/">Twitter Bootstrap</a> by <a href="http://www.walkingpixels.com">Walking Pixels</a></p>

				<!-- Footer nav -->
				<ul>
					<li><a href="http://support.walkingpixels.com/">Support</a></li>
					<li><a href="http://getbootstrap.com/getting-started/">Documentation</a></li>
					<li><a href="http://parallaq.com/">API</a></li>
				</ul>
				<!-- /Footer nav -->

				<!-- Footer back to top -->
				<a href="#top" class="btn btn-back-to-top" title="Back to top"><span class="elusive icon-arrow-up"></span></a>

			</div>
		</footer>
		<!-- /Main page footer -->

		<!-- Bootstrap scripts -->
		<script src="<?php echo base_url();?>public/js/bootstrap/bootstrap.min.js"></script>
	</body>
</html>
