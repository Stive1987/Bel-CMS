<!DOCTYPE html>
<html lang="fr">
<head>
	<base href="https://palacewar.eu/">
	<title>{title}</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="{keywords}">
	<meta name="description" content="{description}">
	<link rel="shortcut icon" href="templates/PalaceWaR/assets/images/favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700%7cOpen+Sans:400,700" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="templates/PalaceWaR/assets/bower_components/bootstrap/dist/css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="templates/PalaceWaR/assets/bower_components/fontawesome/css/font-awesome.min.css" type="text/css">
	{css}
	<link rel="stylesheet" href="templates/PalaceWaR/assets/bower_components/flickity/dist/flickity.min.css" type="text/css">
	<link rel="stylesheet" href="templates/PalaceWaR/assets/bower_components/photoswipe/dist/photoswipe.css" type="text/css">
	<link rel="stylesheet" href="templates/PalaceWaR/assets/bower_components/photoswipe/dist/default-skin/default-skin.css" type="text/css">
	<link rel="stylesheet" href="templates/PalaceWaR/assets/bower_components/seiyria-bootstrap-slider/dist/css/bootstrap-slider.min.css" type="text/css">
	<link rel="stylesheet" href="templates/PalaceWaR/assets/bower_components/summernote/dist/summernote.css" type="text/css">
	<link rel="stylesheet" href="templates/PalaceWaR/assets/bower_components/prism/themes/prism-tomorrow.css" type="text/css">
	<link rel="stylesheet" href="templates/PalaceWaR/assets/css/goodgames.min.css" type="text/css">
	<link rel="stylesheet" href="templates/PalaceWaR/assets/css/custom.css" type="text/css">
	<script async custom-element="amp-auto-ads" src="https://cdn.ampproject.org/v0/amp-auto-ads-0.1.js"></script>
</head>
<body>
	<header class="nk-header nk-header-opaque">

		<div class="nk-contacts-top">
			<div class="container">
				<div class="nk-contacts-left">
					<ul class="nk-social-links">
						<li>
							<a class="nk-social-facebook" href="https://www.facebook.com/PalaceWaR/">
								<span class="fa fa-facebook"></span>
							</a>
						</li>
						<li>
							<a class="nk-social-google-plus" href="https://plus.google.com/+PalacewarEu">
								<span class="fa fa-google-plus"></span>
							</a>
						</li>
						<li>
							<a class="nk-social-paypal" href="https://www.paypal.me/PalaceWaR">
								<span class="fa fa-paypal"></span>
							</a>
						</li>
					</ul>
				</div>
				<div class="nk-contacts-right">
					<ul class="nk-contacts-icons">
						<li>
							<a href="User" title="User">
								<span class="fa fa-user"></span>
							</a>
						</li>
						<li>
							<a href="Dashboard?management" title="Management">
								<span class="fa fa-cog"></span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<nav class="nk-navbar nk-navbar-top nk-navbar-sticky">
			<div class="container">
				<div class="nk-nav-table">

					<a href="Home" class="nk-nav-logo">
						<img src="templates/PalaceWaR/assets/images/logo.png" alt="PalaceWaR" width="199">
					</a>

					<ul class="nk-nav nk-nav-right hidden-md-down" data-nav-mobile="#nk-nav-mobile">
						<li><a href="Home">Accueil</a></li>
						<li><a href="Forum">Forum</a></li>
						<li><a href="Team">Team</a></li>
						<li><a href="Members">Membres</a></li>
					</ul>
					<ul class="nk-nav nk-nav-right nk-nav-icons">

						<li class="single-icon hidden-lg-up">
							<a href="#" class="no-link-effect" data-nav-toggle="#nk-nav-mobile">
								<span class="nk-icon-burger">
									<span class="nk-t-1"></span>
									<span class="nk-t-2"></span>
									<span class="nk-t-3"></span>
								</span>
							</a>
						</li>

					</ul>
				</div>
			</div>
		</nav>

	</header>

	<div id="nk-nav-mobile" class="nk-navbar nk-navbar-side nk-navbar-right-side nk-navbar-overlay-content hidden-lg-up">
		<div class="nano">
			<div class="nano-content">
				<a href="Home" class="nk-nav-logo">
					<img src="{dir_html}assets/images/logo.png" alt="" width="120">
				</a>
				<div class="nk-navbar-mobile-content">
					<ul class="nk-nav">
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="nk-main">

		<div class="nk-gap-1"></div>
		<div class="container">
			{breadcrumb}
		</div>
		<div class="nk-gap-1"></div>
		<?php
		if (constant('GET_PAGE') == 'page') { ?>
			<?php echo $this->_page; ?>
			<?php } else if ($this->full_page) { ?>
			<div class="container">
			<div class="row vertical-gap">
				<div class="col-lg-12">
					<div class="nk-box-2 bel_cms_bg">
						<?php echo $this->_page; ?>
					</div>
				</div>
			</div>
			<?php } else if ($this->full_page !== true) {?>
			<div class="container">
			<div class="row vertical-gap">
				<div class="col-lg-8">
					<?php $this->LoadWidgets('top') ?>
					<blockquote class="nk-blockquote blockquotecms">
                        <div class="nk-blockquote-icon">
                            <span>Google AdSense‎</span>
                        </div>
                        <amp-auto-ads type="adsense" data-ad-client="ca-pub-5176882397524933"></amp-auto-ads>
                        <div class="nk-blockquote-content">
							<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<ins class="adsbygoogle"
								style="display:block"
								data-ad-client="ca-pub-5176882397524933"
								data-ad-slot="4068823417"
								data-ad-format="auto"></ins>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script>
                        </div>
                        <div class="nk-blockquote-author">
                            <span>Google AdSense‎</span>
                        </div>
                    </blockquote>


					<iframe src="https://discordapp.com/widget?id=459367055762784266&theme=dark" width="100%" height="500" allowtransparency="true" frameborder="0"></iframe>

					<?php echo $this->_page; ?>
				</div>
				<div class="col-lg-4">

					<aside class="nk-sidebar nk-sidebar-right nk-sidebar-sticky">

						<?php $this->LoadWidgets('right') ?>

						<div class="nk-widget nk-widget-highlighted">
							<h4 class="nk-widget-title"><span>Facebook</span></h4>
							<div class="nk-widget-content">
								<div class="fb-page" data-href="https://www.facebook.com/PalaceWaR" data-width="700" data-height="350" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"></div>
							</div>
						</div>

						<div class="nk-widget nk-widget-highlighted">
							<h4 class="nk-widget-title">
								<span>
									<span class="text-main-1">We</span> Are Social</span>
							</h4>
							<div class="nk-widget-content">
								<ul class="nk-social-links-3 nk-social-links-cols-4">
									<li>
										<a class="nk-social-facebook" href="https://www.facebook.com/PalaceWaR/">
											<span class="fa fa-facebook"></span>
										</a>
									</li>
									<li>
										<a class="nk-social-google-plus" href="https://plus.google.com/+PalacewarEu">
											<span class="fa fa-google-plus"></span>
										</a>
									</li>
									<li>
										<a class="nk-social-paypal" href="https://www.paypal.me/PalaceWaR">
											<span class="fa fa-paypal"></span>
										</a>
									</li>
								</ul>
							</div>
						</div>

					</aside>

				</div>
			</div>
			<?php } ?>
		</div>

		<div class="nk-gap-2"></div>

		<footer class="nk-footer">

			<div class="container">
				<div class="nk-gap-3"></div>
				<div class="row vertical-gap">
					<div class="col-md-6">
						<div class="nk-widget">
							<h4 class="nk-widget-title">
								<span class="text-main-1">Contact</span> With Us</h4>
							<div class="nk-widget-content">
								<form action="php/contact.php" class="nk-form nk-form-ajax">
									<div class="row vertical-gap sm-gap">
										<div class="col-md-6">
											<input type="email" class="form-control required" name="email" placeholder="Email *">
										</div>
										<div class="col-md-6">
											<input type="text" class="form-control required" name="name" placeholder="Name *">
										</div>
									</div>
									<div class="nk-gap"></div>
									<textarea class="form-control required" name="message" rows="5" placeholder="Message *"></textarea>
									<div class="nk-gap-1"></div>
									<button class="nk-btn nk-btn-rounded nk-btn-color-white">
										<span>Send</span>
										<span class="icon"><i class="ion-paper-airplane"></i></span>
									</button>
									<div class="nk-form-response-success"></div>
									<div class="nk-form-response-error"></div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-md-6">

					</div>
				</div>
				<div class="nk-gap-3"></div>
			</div>

			<div class="nk-copyright">
				<div class="container">
					<div class="nk-copyright-left">
						Copyright &copy; 2001 @ <?=date('Y')?> <?=COPYLEFT?>
					</div>
					<div class="nk-copyright-right">
						<ul class="nk-social-links-2">
							<li><a class="nk-social-facebook" href="https://www.facebook.com/PalaceWaR/"><span class="fa fa-facebook"></span></a></li>
							<li><a class="nk-social-google-plus" href="https://plus.google.com/+PalacewarEu"><span class="fa fa-google-plus"></span></a></li>
							<li><a class="nk-social-paypal" href="https://www.paypal.me/PalaceWaR"><span class="fa fa-paypal"></span></a></li>
						</ul>
					</div>
				</div>
			</div>
		</footer>

	</div>
	<?php
	$bg = array('1', '2', '3', '4', '5', '6');
	$bg = array_rand($bg, 1);
	if (constant('GET_PAGE') == 'page') { ?>
	<img class="nk-page-background-top" src="templates/PalaceWaR/assets/images/bg-palacewar.png" alt="Background PalaceWaR">
	<img class="nk-page-background-bottom" src="templates/PalaceWaR/assets/images/bg-bottom.png" alt="">
	<?php } else { ?>
	<img class="nk-page-background-top" src="templates/PalaceWaR/assets/images/bg-palacewar_7.png" alt="Background PalaceWaR : 7">
	<img class="nk-page-background-bottom" src="templates/PalaceWaR/assets/images/bg-bottom.png" alt="">
	<?php } ?>
	{js}
	<script src="templates/PalaceWaR/assets/bower_components/gsap/src/minified/TweenMax.min.js"></script>
	<script src="templates/PalaceWaR/assets/bower_components/gsap/src/minified/plugins/ScrollToPlugin.min.js"></script>
	<script src="templates/PalaceWaR/assets/bower_components/tether/dist/js/tether.min.js"></script>
	<script src="templates/PalaceWaR/assets/bower_components/jquery-form/jquery.form.js"></script>
	<script src="templates/PalaceWaR/assets/bower_components/jquery-validation/dist/jquery.validate.min.js"></script>
	<script src="templates/PalaceWaR/assets/bower_components/seiyria-bootstrap-slider/dist/bootstrap-slider.min.js"></script>
	<script src="templates/PalaceWaR/assets/bower_components/summernote/dist/summernote.min.js"></script>
	<script src="templates/PalaceWaR/assets/plugins/nk-share/nk-share.js"></script>
	<script src="templates/PalaceWaR/assets/js/goodgames.min.js"></script>
	<script src="templates/PalaceWaR/assets/js/goodgames-init.js"></script>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-25332959-1', 'auto');
		ga('send', 'pageview');
	</script>
</body>

</html>