<!DOCTYPE html>
<html>
	<head>
		<?php include("./php/info.php"); ?>
		<title><?php echo getName() ?></title>
		<meta charset="UTF-8">
		<meta name="author" content="<?php echo getName() ?>">
		<meta name="title" content="Resume for <?php echo getName() ?>">
		<meta name="description" content="Interactive Resume for <?php echo getName() ?>">
		<link rel="shortcut icon" href="img/favicon.ico" />
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Quicksand">

		<script type="text/javascript" src="js/jquery-2.1.3.min.js"></script>
		<script type="text/javascript" src="js/main.js"></script>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA9K9aOfMnzuUnwK-C5dbqs2tRIU0Cm6F4&libraries=places&callback=initialize" async defer></script>
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
				<h1><?php echo getName() ?></h1>
				<hr>
				<h3>Website and Resume</h3>
			</div>
			<a class="link arrow-down absolute-horizontal-center" href="#about">
				<p>▼</p>
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
			<?php echo getProjects(); ?>
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
						<form class="social-form" action="<?php echo getLinkedInUrl() ?>" target="_blank">
							<input class="social-button linkedin-button" type="submit" value="LinkedIn"/>
						</form>
						<br><br>
						<h4>Email me or contact me through LinkedIn</h4>
						<h4>if you need to get in touch. I look</h4>
						<h4>forward to hearing from you!</h4>
						<br><br>
						<h4>Click below for a printable version of my resume.</h4>
						<a class="button button-link" href="txt/resume.pdf">PDF</a>
					</div>
				</div>				
			</div>
			<div id="info" class="info">
			<br>
			<img src="img/logo.png" alt="logo">
				<br>
				<p><?php echo getName() ?></p>
				<br>
				<div id="nav-menu">
					<a class="link menu-link" href="#about">About</a>
					<a class="link menu-link" href="#qualifications">Qualifications</a>
					<a class="link menu-link" href="#employment">Employment</a>
					<a class="link menu-link" href="#projects">Projects</a>
					<a class="link menu-link" href="#contact">Contact</a>
				</div>
				<p>© 2019 <?php echo getName() ?>. Software Developer</p>
				<p>HTML5 | CSS3 | JS | PHP</p>
			</div>
			<br>
		</div>
	</body>
</html>