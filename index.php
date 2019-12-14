<!DOCTYPE html>
<html>
	<head>
		<?php include("./php/info.php"); ?>
		<title>Chandler Lucius</title>
		<meta charset="UTF-8">
		<meta name="author" content="Chandler Lucius">
		<meta name="title" content="Resume for Chandler Lucius">
		<meta name="description" content="Interactive Resume for Chandler Lucius">
		<link rel="manifest" href="manifest.webmanifest">
		<link rel="shortcut icon" href="img/favicon.ico" />
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<link rel="stylesheet" type="text/css" href="font/font-awesome-4.3.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Quicksand">

		<script src="js/jquery-2.1.3.min.js" type="text/javascript"></script>
		<script src="js/main.js" type="text/javascript"></script>
		<script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initialize&key=AIzaSyCXKEzorYAvStnbrGtHq_rwjYaRXozf7To" async defer></script>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-88933858-1', 'auto');
		  ga('send', 'pageview');
		
		</script>
		<?php echo getGoogleMapScript() ?>
	</head>
	<body>
		<input id="blue" type="radio" class="color" name="scheme-color">
		<input id="red" type="radio" class="color" name="scheme-color">
		<input id="green" type="radio" class="color" name="scheme-color">
		<input id="gold" type="radio" class="color" name="scheme-color">
		<input id="business" type="radio" class="style" name="scheme-style" checked>
		<input id="casual" type="radio" class="style" name="scheme-style">
		<div class="menu flex">
			<div id="nav-menu">
				<a class="link menu-link" href="#about">About</a>
				<a class="link menu-link" href="#qualifications">Qualifications</a>
				<a class="link menu-link" href="#employment">Employment</a>
				<a class="link menu-link" href="#projects">Projects</a>
				<a class="link menu-link" href="#contact">Contact</a>
			</div>
			<div class="menu-right">
				<label id="casual-label" for="casual" class="style-link float-right">Casual</label>
				<label id="business-label" for="business" class="style-link float-right">Business</label>
				<p class="style-link float-right scheme">|</p>
				<label id="gold-label" for="gold" class="color-link float-right">Gold</label>
				<label id="green-label" for="green" class="color-link float-right">Green</label>
				<label id="red-label" for="red" class="color-link float-right">Red</label>
				<label id="blue-label" for="blue" class="color-link float-right">Blue</label>
				<p class="color-link float-right scheme">Scheme:</p>
			</div>
		</div>
		<div id="title-page" class="title-page">
			<div class="title absolute-center">
				<h1>Chandler Lucius</h1>
				<hr>
				<h3>Software Developer</h3>
			</div>
			<a class="link arrow-down absolute-horizontal-center" href="#about">
				<p class="fa fa-chevron-down"></p>
			</a>
			<div class="overlay"></div>
		</div>
		<div class="resume">
			<div id="about" class="resume-child-even">
				<?php echo getAbout(); ?>
				<hr class="split">
				<?php echo getCareerFocus(); ?>
				<hr class="split-further">
				<?php echo getEducation(); ?>
				<hr class="split-further-again">
				<?php echo getAwards(); ?>
			</div>
			<?php echo getQualifications(); ?>
			<?php echo getEmployment(); ?>
			<div id="projects" class="resume-child-odd">
				<h1>Projects</h1>
				<hr class="split">
		        <div class="flex">
	                <div class="figure fade">
						<img src="img/logo-white-archer-circle.png" alt="odysi-logo"/>
						<div class="description">
							<h2>Odysi</h2>
							<p>Plan, track, and journal your favorite adventures</p>
							<a href="https://www.myodysi.com/" class="info" target="_blank">View Site</a>
						</div>
	                </div>
	                <div class="figure fade">
						<img src="img/logo-light.svg" alt="odysi-logo"/>
						<div class="description">
							<h2>Linux Dashboard</h2>
							<p>Simple, fast, server analytics.</p>
							<a href="https://www.linuxdashboard.com:8443" class="info" target="_blank">View Site</a>
						</div>
	                </div>
		        </div>
			</div>
			<div id="contact" class="resume-child-even">
				<h1>Contact</h1>
				<hr class="split">
				<div class="flex">
					<div class="email flex-child">
						<h2>Email Me</h2>
						<form id="email" action="./php/email.php" method="post">
							<table class="email-table">
								<tr>
									<td>
										<h4 class="email-label">Your Email</h4>
										<input id="email-address" class="email-input" name="email" maxlength="50" required/>
									</td>
								</tr><tr>
									<td>
										<h4 class="email-label">Your Name</h4>
										<input id="name" class="email-input" name="name" maxlength="50" required/>
									</td>
								</tr><tr>
									<td>
										<h4 class="email-label">Message (HTML formatted message requires JS)</h4>
									</td>
								</tr><tr>
									<td>
										<div class="non-javascript">
											<textarea name="email-body" class="email-input" rows="10" cols="100"></textarea>
										</div>
										<div class="javascript">
											<div id="email-body" class="email-input email-body" contenteditable="true"></div>
										</div>
									</td>
								</tr><tr>
									<td>
										<br>
										<input id="email-input" type="submit" name="send"/>
										<label class="button" for="email-input">Send</label>
									</td>
								</tr>
							</table>
						</form>
					</div>
					<div class="flex-child">
						<h2>Connect With Me</h2>
						<br>
						<form class="social-form" action="http://www.linkedin.com/in/chandlerlucius" target="_blank">
							<input class="social-button linkedin-button" type="submit" value="LinkedIn"/>
						</form>
						<br><br>
						<h4>Email me or contact me through LinkedIn</h4>
						<h4>if you need to get in touch. I look</h4>
						<h4>forward to hearing from you!</h4>
						<br><br>
						<h4>Click below for a printable version of my resume.</h4>
						<a class="button button-link" href="txt/resume.pdf" target="_blank">PDF</a>
						<!--<br>-->
						<!--<form class="pdf-form" action="./php/Chandler-Lucius_Java-Developer.php" method="post" target="_blank">-->
						<!--	<label class="button" for="pdf-resume">PDF (Experimental)</label>-->
						<!--	<input id="pdf-resume" type="submit"/>-->
						<!--</form>-->
					</div>
				</div>				
			</div>
			<div id="info" class="info">
			<br>
			<img src="img/CL-Logo.png" alt="chandler-lucius-logo">
				<br>
				<p>Chandler Lucius</p>
				<br>
				<div id="nav-menu">
					<a class="link menu-link" href="#about">About</a>
					<a class="link menu-link" href="#qualifications">Qualifications</a>
					<a class="link menu-link" href="#employment">Employment</a>
					<a class="link menu-link" href="#projects">Projects</a>
					<a class="link menu-link" href="#contact">Contact</a>
				</div>
				<p>© 2019 Chandler Lucius. Software Developer</p>
				<p>Java | HTML | CSS | JS | PHP | SQL</p>
			</div>
			<br>
			<!-- <a class="link arrow-down" href="#title-page"> -->
				<!-- <p class="fa fa-chevron-up"></p> -->
			<!-- </a> -->
		</div>
	</body>
</html>
