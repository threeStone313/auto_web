<!DOCTYPE html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Login | XO Auto-Test System</title>
		<meta name="description" content="">
		<meta name="author" content="Walking Pixels | www.walkingpixels.com">
		<meta name="robots" content="index, follow">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- Styles -->
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/sangoma-blue.css">

		<!-- JS Libs -->
		
		<script src="<?php echo base_url();?>public/js/libs/jquery.js"></script>
		<script src="<?php echo base_url();?>public/js/libs/modernizr.js"></script>

		<!-- IE8 support of media queries and CSS 2/3 selectors -->
		<!--[if lt IE 9]>
			<script src="public/js/libs/respond.min.js"></script>
			<script src="public/js/libs/selectivizr.js"></script>
		<![endif]-->
		
	</head>
	<body class="login">
		
		<!-- Main page container -->
		<section class="container" role="main">

			<!-- Login header -->
			<div class="login-logo">
				<a href="#">Sangoma</a>
				<h1>Welcome to Auto-web</h1>
			</div>
			<!-- /Login header -->

			<!-- Login form -->
			<?php echo form_open('welcome/login'); ?>
				<?php echo $notice;?>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><span class="elusive icon-user"></span></span>
						<input class="form-control" type="text" placeholder="Enter your email" name="email">
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><span class="elusive icon-key"></span></span>
						<input class="form-control" type="password" placeholder="Password" name="password">
					</div>
				</div>
				<div class="form-group pull-right">
					Remember Me <input style="margin-top:10px;" type="checkbox" name="remember">
				</div>
				<button class="btn btn-primary btn-lg btn-block" type="submit">Log in</button>
				<div class="lost-password"><a href="#">Lost your password?</a> or <a href="/admin/sign_in">Sign in</a></div>
			</form>
			<!-- /Login form -->
			
		</section>
		<!-- /Main page container -->

		<!-- Bootstrap scripts -->
		<script src="<?php echo base_url();?>public/js/bootstrap/bootstrap.min.js"></script>
		
	</body>
</html>