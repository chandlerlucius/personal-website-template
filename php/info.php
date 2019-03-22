<?php
$list = glob("txt/info.txt");

$file = $list[0];
$lines = file($file);
define('SEMICOLON', ';');
define('COLON', ':');
define('SPACE', ' ');
define('COMMA', ',');
define('HEADERS', 'Headers', false);
define('END', 'End', false);
define('LINES', 'Lines');
date_default_timezone_set(timezone_name_from_abbr("CST"));

/*
  This function will pull lines from info.txt.
  Info.txt contains easily editbale info like qualification and job history.
  It traverses through each line of the file and puts each line in a multidimensional array.

  Placing End on a line will ensure where the search for a specific set of values stops.
  Placing Break on a line will ensure where a break should happen on the HTML page.
  Placing a New Line (Carriage Return, PHP_EOL, whatever) on a line will ensure where the new set of array data begins.
*/
$outerIndex = 0;
$innerIndex = 0;
$txtLines = [];
foreach($lines as $key => $line) {
	if(strpos($line, 'PHP_EOL') !== false || bin2hex($line) == '0a') {
		if($outerIndex == 0) {
			$txtLines = call_user_func_array('array_merge', $txtLines);

			if($txtLines[0] == HEADERS) {
				$headerLines = $txtLines;
			}
			$searchArray = $txtLines[0];
		}
		else {
			$searchArray = $txtLines[0][0];
		}
		foreach ($headerLines as $key => $value) {
			if(strpos($value, $searchArray) !== false) {
				$array = explode(SEMICOLON, trim($value));
				$firstWord = explode(SPACE, trim($array[0]));
				${strtolower($firstWord[0]) . LINES} = $txtLines;
			}
		}

		$outerIndex = 0;
		$innerIndex = 0;
		$txtLines = [];
	} else if(strpos($line, '--') !== false) {
		$innerIndex = 0;
		$outerIndex++;
	} else {
		$txtLines[$outerIndex][$innerIndex++] = trim($line);
	} 
}

function getGoogleMapScript() {
	global $employmentLines;
	$dom = new DOMDocument('1.0', 'utf-8');

	$tempLines = $employmentLines;

	unset($tempLines[0]);
	$tempLines = array_values($tempLines);
	$employCount = 1;

	$mapScript = "function initialize() {" . PHP_EOL;

	foreach($tempLines as $key => $line) {
		if(strpos($line, 'Break') === false) {
			$array = explode(SEMICOLON, $line);
			$employmentPlaceId1 = trim($array[0]);
			$employmentPlaceId2 = trim($array[1]);

			$employCompanyMapId = 'map-' . $employCount++;
	
			$mapScript .= 
			"	var mapCanvas" . $employCount . " = document.getElementById('" . $employCompanyMapId . "');" . PHP_EOL .
			"	var mapOptions" . $employCount . " = {" . PHP_EOL .
			"		zoom: 13," . PHP_EOL .
			"		mapTypeId: google.maps.MapTypeId.HYBRID," . PHP_EOL .
			"		zoomControl: true," . PHP_EOL .
			"		disableDefaultUI: true" . PHP_EOL .
			"	}" . PHP_EOL .
			"	var map" . $employCount . " = new google.maps.Map(mapCanvas" . $employCount . ", mapOptions" . $employCount . ")" . PHP_EOL .
			"	var infowindow" . $employCount . " = new google.maps.InfoWindow();" . PHP_EOL .
			"	var service" . $employCount . " = new google.maps.places.PlacesService(map" . $employCount . ");" . PHP_EOL .
			"	service" . $employCount . ".getDetails({" . PHP_EOL .
			"		placeId: '" . $employmentPlaceId1 . "'" . PHP_EOL .
			"	}, function(place, status) {" . PHP_EOL .
			"		if (status === google.maps.places.PlacesServiceStatus.OK) {" . PHP_EOL .
			"			var companyName = place.name;" . PHP_EOL .
			"			var i = companyName.indexOf(',');" . PHP_EOL .
			"			if(i > 0) {" . PHP_EOL .
			"				companyName = companyName.slice(0, i);" . PHP_EOL .
			"			}" . PHP_EOL .
			"			var addressComponents = place.address_components;" . PHP_EOL .
			"			addressComponents.forEach(function (address_component) {" . PHP_EOL .
			"				if (address_component.types[0] == 'country') {" . PHP_EOL .
			"					hqLocation = address_component.long_name;" . PHP_EOL .
			"				}" . PHP_EOL .
			"			});" . PHP_EOL .
			"			document.getElementById('employ-company-title-" . $employCount . "').innerHTML = companyName;" . PHP_EOL .
			"			document.getElementById('employ-company-HQ-" . $employCount . "').innerHTML = 'HQ - ' + hqLocation;" . PHP_EOL .
			"			document.getElementById('employ-company-website-" . $employCount . "').href = place.website;" . PHP_EOL .
			"			document.getElementById('employ-company-map-url-" . $employCount . "').href = place.url;" . PHP_EOL .
			"			var marker = new google.maps.Marker({" . PHP_EOL .
			"				map: map" . $employCount . "," . PHP_EOL .
			"				position: place.geometry.location" . PHP_EOL .
			"			});" . PHP_EOL .
			"			map" . $employCount . ".setCenter(marker.getPosition());" . PHP_EOL .
			"			google.maps.event.addListener(marker, 'click', function() {" . PHP_EOL .
			"				infowindow" . $employCount . ".setContent('<div><h3>' + place.name + '</h3>' + " . PHP_EOL . 
			"				'<p><i class=\"fa fa-map-marker\"></i>' + place.formatted_address + '</p>' + " . PHP_EOL .
			"				'<i class=\"fa fa-globe\"></i><a href=' + place.website + ' target=_blank>' + place.website + '</a>' + " . PHP_EOL . 
			"				'<p><i class=\"fa fa-phone\"></i>' + place.international_phone_number + '</p></div>');" . PHP_EOL .
			"				infowindow" . $employCount . ".open(map" . $employCount . ", this);" . PHP_EOL .
			"			});" . PHP_EOL .
			"		}" . PHP_EOL .
			"	});" . PHP_EOL .
			"" . 
			"	var map1" . $employCount . " = new google.maps.Map(document.createElement('div'));" . PHP_EOL .
			"	var service1" . $employCount . " = new google.maps.places.PlacesService(map1" . $employCount . ");" . PHP_EOL .
			"	service1" . $employCount . ".getDetails({" . PHP_EOL .
			"		placeId: '" . $employmentPlaceId2 . "'" . PHP_EOL .
			"	}, function(place, status) {" . PHP_EOL .
			"		if (status === google.maps.places.PlacesServiceStatus.OK) {" . PHP_EOL .
			"			document.getElementById('employ-local-office-" . $employCount . "').href = place.url;" . PHP_EOL .
			"		}" . PHP_EOL .
			"	});" . PHP_EOL .
			"" . PHP_EOL;
		}
	}
	$mapScript .= "}";
	$employCompanyMapScript = $dom->createElement('script', $mapScript);
	$dom->appendChild($employCompanyMapScript);

	return $dom->saveHTML();
}

function getAbout() {
	global $aboutLines;
	global $linkedInUrl;
	$dom = new DOMDocument('1.0', 'utf-8');

	$split = $dom->createElement('hr');
	$split->setAttribute('class', 'split');
	$dom->appendChild($split);

	$aboutTitle = $dom->createElement('h1', $aboutLines[0]);
	$dom->appendChild($aboutTitle);

	$flexDiv = $dom->createElement('div');
	$flexDiv->setAttribute('class', 'flex');
	$dom->appendChild($flexDiv);

	$imageDiv = $dom->createElement('div');
	$imageDiv->setAttribute('class', 'flex-child image-div');
	$flexDiv->appendChild($imageDiv);

	$image = $dom->createElement('img');
	$image->setAttribute('class', 'image');
	$image->setAttribute('alt', $aboutLines[1]);
	$image->setAttribute('title', $aboutLines[1]);
	$image->setAttribute('src', $aboutLines[2]);
	$imageDiv->appendChild($image);

	$aboutDiv = $dom->createElement('div');
	$aboutDiv->setAttribute('class', 'flex-child about-child left-align');
	$flexDiv->appendChild($aboutDiv);

	$linkedInUrl = $aboutLines[3];

	unset($aboutLines[0]);
	unset($aboutLines[1]);
	unset($aboutLines[2]);
	unset($aboutLines[3]);
	$aboutLines = array_values($aboutLines);

	foreach($aboutLines as $key => $lines) {
		$array = explode(SEMICOLON, $lines);
		$aboutKey[$key] = trim($array[0]);
		$aboutValue[$key] = trim($array[1]);

		$aboutH2 = $dom->createElement('h2', $aboutKey[$key]);
		$aboutDiv->appendChild($aboutH2);

		$aboutH4 = $dom->createElement('h4', $aboutValue[$key]);
		$aboutDiv->appendChild($aboutH4);
	}
	return $dom->saveHTML();
}

function getCareerFocus() {
	global $careerLines;
	$dom = new DOMDocument('1.0', 'utf-8');
	$careerFocusTitle = $dom->createElement('h2', $careerLines[0]);
	$dom->appendChild($careerFocusTitle);

	unset($careerLines[0]);
	$careerLines = array_values($careerLines);

	foreach($careerLines as $key => $lines) {
		$array = explode(SEMICOLON, $lines);
		$careerFocus[$key] = trim($array[0]);

		$careerFocusH4 = $dom->createElement('h4', $careerFocus[$key]);
		$dom->appendChild($careerFocusH4);
	}
	return $dom->saveHTML();
}

function getEducation() {
	global $educationLines;
	$dom = new DOMDocument('1.0', 'utf-8');
	$educationTitle = $dom->createElement('h2', $educationLines[0]);
	$dom->appendChild($educationTitle);

	$educationCollege = $dom->createElement('h3', $educationLines[1]);
	$dom->appendChild($educationCollege);

	$educationMajor = $dom->createElement('h4', $educationLines[2]);
	$dom->appendChild($educationMajor);

	$educationMinors = $dom->createElement('h4', $educationLines[3]);
	$dom->appendChild($educationMinors);

	$educationGraduation = $dom->createElement('p', $educationLines[4]);
	$dom->appendChild($educationGraduation);

	return $dom->saveHTML();
}

function getAwards() {
	global $awardsLines;
	$dom = new DOMDocument('1.0', 'utf-8');
	$awardDiv = $dom->createElement('div');
	$awardDiv->setAttribute('class', 'awards-div');
	$dom->appendChild($awardDiv);

	$awardTitle = $dom->createElement('h2', $awardsLines[0]);
	$awardDiv->appendChild($awardTitle);

	unset($awardsLines[0]);
	$awardsLines = array_values($awardsLines);

	foreach($awardsLines as $key => $lines) {
		$array = explode(SEMICOLON, $lines);
		$awardName[$key] = trim($array[0]);
		$awardDescription[$key] = trim($array[1]);

		$awardH3 = $dom->createElement('h3', $awardName[$key]);
		$awardDiv->appendChild($awardH3);

		$awardH4 = $dom->createElement('h4', $awardDescription[$key]);
		$awardDiv->appendChild($awardH4);
	}
	return $dom->saveHTML();
}

/*
  This function will build out the Qualifications section of the resume.
  It uses the array built from earlier and parses it for info.

  It will build HTML similar to the following:
	<div class="qualification-parent flex">
	  	<div class="qualification-child">
	  		<div class="rating-div">
	  			<h2>Servers</h2>
	  			<div class="flex">
	  				<h3 class="rating-name">Apache Tomcat</h4>
	  				<h4 class="right-align">Proficient</h4>
	  			</div>
	  			<div class="outside-bar">
	  				<div style="height:100%; width:70%">
	  					<div class="inside-bar"></div>
	  				</div>
	  			</div>
		  	</div>
	  	</div>
	</div>
*/
function getQualifications() {
	global $qualificationsLines;
	$dom = new DOMDocument('1.0', 'utf-8');

	$qualificationDiv = $dom->createElement('div');
	$qualificationDiv->setAttribute('id', preg_replace('/\s+/', '', strtolower($qualificationsLines[0][0])));
	$qualificationDiv->setAttribute('class', 'resume-child-odd');
	$dom->appendChild($qualificationDiv);

	$qualificationTitle = $dom->createElement('h1', $qualificationsLines[0][0]);
	$qualificationDiv->appendChild($qualificationTitle);

	$hr = $dom->createElement('hr');
	$hr->setAttribute('class', 'split');
	$qualificationDiv->appendChild($hr);

	unset($qualificationsLines[0]);
	$qualificationsLines = array_values($qualificationsLines);

	foreach($qualificationsLines as $outerKey => $lines) {
		if($qualificationsLines[$outerKey][0] != '') {
			if($outerKey === 0 || strpos($qualificationsLines[$outerKey][0], 'Break') !== false) {
				$qualificationParent = $dom->createElement('div');
				$qualificationParent->setAttribute('class', 'qualification-parent flex');
				$qualificationDiv->appendChild($qualificationParent);
			} else if(strpos($qualificationsLines[$outerKey][0], 'Extra') !== false) {

				$expandInput = $dom->createElement('input');
				$expandInput->setAttribute('id', 'expand-input');
				$expandInput->setAttribute('name', 'qualification-extra');
				$expandInput->setAttribute('type', 'radio');
				$qualificationDiv->appendChild($expandInput);

				$collapseInput = $dom->createElement('input');
				$collapseInput->setAttribute('id', 'collapse-input');
				$collapseInput->setAttribute('name', 'qualification-extra');
				$collapseInput->setAttribute('checked', 'true');
				$collapseInput->setAttribute('type', 'radio');
				$qualificationDiv->appendChild($collapseInput);

				$expandLabel = $dom->createElement('label', '+');
				$expandLabel->setAttribute('class', 'expand-button button');
				$expandLabel->setAttribute('for', 'expand-input');
				$qualificationDiv->appendChild($expandLabel);

				$div = $dom->createElement('div');
				$qualificationDiv->appendChild($div);

				$qualificationParent = $dom->createElement('div');
				$qualificationParent->setAttribute('class', 'qualification-extra flex');
				$div->appendChild($qualificationParent);
			} 
			if(strpos($qualificationsLines[$outerKey][0], 'Break') === false && strpos($qualificationsLines[$outerKey][0], 'Extra') === false) {
				$qualificationChild = $dom->createElement('div');
				$qualificationChild->setAttribute('class', 'flex-child');
				$qualificationParent->appendChild($qualificationChild);

				$ratingParent = $dom->createElement('div');
				$ratingParent->setAttribute('class', 'rating-div');
				$qualificationChild->appendChild($ratingParent);

				$ratingTitle = $dom->createElement('h2', $qualificationsLines[$outerKey][0]);
				$ratingParent->appendChild($ratingTitle);

				foreach($lines as $key => $line) {
					if($qualificationsLines[$outerKey][0] !== $line) {
						$array = explode(SEMICOLON, $line);
						$qualificationName[$key] = trim($array[0]);
						$qualificationAmount[$key] = trim($array[1]);
						$qualificationStatus[$key] = trim($array[2]);

						$ratingBar = $dom->createElement('div');
						$ratingBar->setAttribute('class', 'flex');
						$ratingParent->appendChild($ratingBar);

						$ratingName = $dom->createElement('h3', $qualificationName[$key]);
						$ratingName->setAttribute('class', 'rating-name');
						$ratingBar->appendChild($ratingName);

						$ratingStatus = $dom->createElement('h4', $qualificationStatus[$key]);
						$ratingStatus->setAttribute('class', 'right-align');
						$ratingBar->appendChild($ratingStatus);

						$outsideBar = $dom->createElement('div');
						$outsideBar->setAttribute('class', 'outside-bar');
						$ratingParent->appendChild($outsideBar);

						$insideBarDiv = $dom->createElement('div');
						$insideBarDiv->setAttribute('style', 'height:' . '100%; width:' . $qualificationAmount[$key]);
						$outsideBar->appendChild($insideBarDiv);

						$insideBar = $dom->createElement('div');
						$insideBar->setAttribute('class', 'inside-bar');
						$insideBarDiv->appendChild($insideBar);
					}
				}
			}
			if(strpos($qualificationsLines[$outerKey][0], 'Break') === false && strpos($qualificationsLines[$outerKey][0], 'Extra') !== false) {

				$collapseLabel = $dom->createElement('label', '-');
				$collapseLabel->setAttribute('class', 'collapse-button button');
				$collapseLabel->setAttribute('for', 'collapse-input');
				$div->appendChild($collapseLabel);
			}
		}
	}
	return $dom->saveHTML();
}

/*
  This function will build out the Employment History section of the resume.
  It uses the array built from earlier and parses it for info.

  It will build HTML similar to the following:
	<div class="employ-div flex"> 
		<h2>InnoWake</h2>
		<div class="employ-details flex">
			<div class="employ-desc">
				<h3>Software Developer</h3>
				<h4 class="justify">Helped work on the modernization effort to move TXDMV from a legacy environment with a Main Frame to a new Java based web system. Assisted with both the batch/reporting side as well as the front end side of the modernization. Developed an application in Java that could connect to an SFTP or FTPS server, extract files from the server, parse the files extracted, validate data on the files, and upload changes to the files as well as create log files on the server.</h4>
			</div>
			<h4 class="gray">September 2014 – Present (11 months)</h4>
		</div>
	</div>
*/
function getEmployment() {
	global $employmentLines;
	$dom = new DOMDocument('1.0', 'utf-8');

	$employmentDiv = $dom->createElement('div');
	$employmentDiv->setAttribute('id', preg_replace('/\s+/', '', strtolower($employmentLines[0])));
	$employmentDiv->setAttribute('class', 'resume-child-even');
	$dom->appendChild($employmentDiv);

	$employmentTitle = $dom->createElement('h1', $employmentLines[0]);
	$employmentDiv->appendChild($employmentTitle);

	$hr = $dom->createElement('hr');
	$hr->setAttribute('class', 'split');
	$employmentDiv->appendChild($hr);

	unset($employmentLines[0]);
	$employmentLines = array_values($employmentLines);
	$employCount = 1;

	foreach($employmentLines as $key => $line) {
		if(strpos($line, 'Break') === false) {
			$array = explode(SEMICOLON, $line);
			$employmentPlaceId1 = trim($array[0]);
			$employmentPlaceId2 = trim($array[1]);
			$employmentTitle = trim($array[2]);
			$employmentLocation = trim($array[3]);
			$employmentTime = explode(COLON, trim($array[4]));
			$employmentTech = explode(COLON, trim($array[5]));
			$employmentMeth = explode(COLON, trim($array[6]));
			$employmentProd = explode(COLON, trim($array[7]));
			$employmentDvos = explode(COLON, trim($array[8]));
			$employmentDesc = trim($array[9]);
			$employmentName = trim($array[10]);

			$employCompanyMapId = 'map-' . $employCount++;

			$employDiv = $dom->createElement('div');
			$employDiv->setAttribute('class', 'employ-div flex');
			$employmentDiv->appendChild($employDiv);

			$employCompanyNonJS = $dom->createElement('h2', $employmentName);
			$employCompanyNonJS->setAttribute('class', 'employ-company-div non-javascript');
			$employDiv->appendChild($employCompanyNonJS);

			$employCompanyDiv = $dom->createElement('div');
			$employCompanyDiv->setAttribute('class', 'employ-company-div javascript');
			$employDiv->appendChild($employCompanyDiv);

			$employCompany = $dom->createElement('h2');
			$employCompany->setAttribute('id', 'employ-company-title-' . $employCount);
			$employCompanyDiv->appendChild($employCompany);

			$employCompanyMapDiv = $dom->createElement('div');
			$employCompanyMapDiv->setAttribute('class', 'employ-map-div');
			$employCompanyDiv->appendChild($employCompanyMapDiv);

			$employCompanyMap = $dom->createElement('div');
			$employCompanyMap->setAttribute('id', $employCompanyMapId);
			$employCompanyMap->setAttribute('class', 'width-height-100');
			$employCompanyMapDiv->appendChild($employCompanyMap);

			$employMapCaption = $dom->createElement('p');
			$employMapCaption->setAttribute('class', 'javascript');
			$employCompanyDiv->appendChild($employMapCaption);

			$employHQ = $dom->createElement('a');
			$employHQ->setAttribute('id', 'employ-company-HQ-' . $employCount);
			$employMapCaption->appendChild($employHQ);

			$employMap = $dom->createElement('a');
			$employMap->setAttribute('id', 'employ-company-map-url-' . $employCount);
			$employMap->setAttribute('title', 'Click to see company HQ on Google Maps');
			$employMap->setAttribute('target', '_blank');
			$employMapCaption->appendChild($employMap);

			$employMapIcon = $dom->createElement('i');
			$employMapIcon->setAttribute('class', 'fa fa-external-link');
			$employMap->appendChild($employMapIcon);

			$employWebsite = $dom->createElement('a');
			$employWebsite->setAttribute('id', 'employ-company-website-' . $employCount);
			$employWebsite->setAttribute('title', 'Click to view company website');
			$employWebsite->setAttribute('target', '_blank');
			$employMapCaption->appendChild($employWebsite);

			$employWebsiteIcon = $dom->createElement('i');
			$employWebsiteIcon->setAttribute('class', 'fa fa-link');
			$employWebsite->appendChild($employWebsiteIcon);

			$employDetails = $dom->createElement('div');
			$employDetails->setAttribute('class', 'employ-details flex');
			$employDiv->appendChild($employDetails);

			$employDescDiv = $dom->createElement('div');
			$employDescDiv->setAttribute('class', 'employ-desc');
			$employDetails->appendChild($employDescDiv);

			$employTitle = $dom->createElement('h3', $employmentTitle);
			$employTitle->setAttribute('class', 'flex-child');
			$employDescDiv->appendChild($employTitle);

			$employLocationDiv = $dom->createElement('div');
			$employLocationDiv->setAttribute('class', 'flex-child');
			$employDescDiv->appendChild($employLocationDiv);

			$employLocation = $dom->createElement('h3', $employmentLocation);
			$employLocation->setAttribute('class', 'right-align float-right');
			$employLocationDiv->appendChild($employLocation);

			$employPinLink = $dom->createElement('a');
			$employPinLink->setAttribute('id', 'employ-local-office-' . $employCount);
			$employPinLink->setAttribute('title', 'Click to see company local office on Google Maps');
			$employPinLink->setAttribute('target', '_blank');
			$employLocationDiv->appendChild($employPinLink);

			$employPin = $dom->createElement('i');
			$employPin->setAttribute('class', 'right-align float-right fa fa-2x fa-map-marker employ-pin');
			$employPinLink->appendChild($employPin);

			$employDesc = $dom->createElement('h4', $employmentDesc);
			$employDesc->setAttribute('class', 'justify');
			$employDescDiv->appendChild($employDesc);

			$employInfo = $dom->createElement('div');
			$employInfo->setAttribute('class', 'employ-info-div');
			$employDetails->appendChild($employInfo);

			$date1 = new DateTime($employmentTime[0]);
			$startDate = $date1->format('M') . ". " . $date1->format('Y');

			$date2 = new DateTime($employmentTime[1]);
			$endDate = trim($employmentTime[1]) == "now" ? "Present" : $date2->format('M') . ". " . $date2->format('Y');
			$interval = $date1->diff($date2);

			$employmentTimeStr = $startDate . " - " . $endDate . " (" . ($interval->y > 0 ? $interval->y . " year, " : "") . $interval->m . " months)";

			$employTime = $dom->createElement('p', $employmentTimeStr);
			$employInfo->appendChild($employTime);

			$employExtraDiv1 = $dom->createElement('div');
			$employExtraDiv1->setAttribute('class', 'flex');
			$employInfo->appendChild($employExtraDiv1);

			$employTech = $dom->createElement('h5', $employmentTech[0]);
			$employTech->setAttribute('class', 'no-bottom split-further');
			$employExtraDiv1->appendChild($employTech);

			$employMeth = $dom->createElement('h5', $employmentMeth[0]);
			$employMeth->setAttribute('class', 'no-bottom employ-tech');
			$employExtraDiv1->appendChild($employMeth);

			$employExtraDiv2 = $dom->createElement('div');
			$employExtraDiv2->setAttribute('class', 'flex');
			$employInfo->appendChild($employExtraDiv2);

			$employTech2 = $dom->createElement('h5', $employmentTech[1]);
			$employTech2->setAttribute('class', 'no-top gray-text split-further');
			$employExtraDiv2->appendChild($employTech2);

			$employMeth2 = $dom->createElement('h5', $employmentMeth[1]);
			$employMeth2->setAttribute('class', 'no-top gray-text employ-tech');
			$employExtraDiv2->appendChild($employMeth2);

			$employExtraDiv3 = $dom->createElement('div');
			$employExtraDiv3->setAttribute('class', 'flex');
			$employInfo->appendChild($employExtraDiv3);

			$employBlankDiv1 = $dom->createElement('div');
			$employBlankDiv1->setAttribute('class', 'split-further');
			$employExtraDiv3->appendChild($employBlankDiv1);

			foreach ($employmentProd as $prodKey => $value) {
				$employProd = $dom->createElement('h5', $employmentProd[$prodKey]);
				if($prodKey == 0) {
					$employProd->setAttribute('class', 'no-margin');
				} else {
					$employProd->setAttribute('class', 'no-margin gray-text');
				}
				$employBlankDiv1->appendChild($employProd);
			}

			$employBlankDiv2 = $dom->createElement('div');
			$employBlankDiv2->setAttribute('class', 'employ-tech');
			$employExtraDiv3->appendChild($employBlankDiv2);

			foreach ($employmentDvos as $dvosKey => $value) {
				$employDvos = $dom->createElement('h5', $employmentDvos[$dvosKey]);
				if($dvosKey == 0) {
					$employDvos->setAttribute('class', 'no-margin');
				} else {
					$employDvos->setAttribute('class', 'no-margin gray-text');
				}
				$employBlankDiv2->appendChild($employDvos);
			}
		}
	}
	return $dom->saveHTML();
}

/*
  This function will build out the Projects section of the resume.
  It uses the array built from earlier and parses it for info.

  It will build HTML similar to the following:
	<div id="projects" class="resume-child-odd">
		<h1>Projects</h1>
		<hr class="split">
        <div class="flex">
            <div class="figure fade">
				<img src="img/Logo-Small.png" alt="project-logo"/>
				<div class="description">
					<h2>Piquelarius Picture House</h2>
					<p>I designed this website for a film company based out of Los Angeles. They currently produce short films, and the website helps them to reach a larger audience.</p>
					<a href="http://www.piquelarius.com" class="info" target="_blank">View Site</a>
				</div>
            </div>
        </div>
	</div>
*/

function getProjects() {
	global $projectsLines;
	$dom = new DOMDocument('1.0', 'utf-8');

	$projectDiv = $dom->createElement('div');
	$projectDiv->setAttribute('id', preg_replace('/\s+/', '', strtolower($projectsLines[0])));
	$projectDiv->setAttribute('class', 'resume-child-odd');
	$dom->appendChild($projectDiv);

	$projectTitle = $dom->createElement('h1', $projectsLines[0]);
	$projectDiv->appendChild($projectTitle);

	$hrSplit = $dom->createElement('hr');
	$hrSplit->setAttribute('class', 'split');
	$projectDiv->appendChild($hrSplit);

	$projectFlexDiv = $dom->createElement('div');
	$projectFlexDiv->setAttribute('class', 'flex');
	$projectDiv->appendChild($projectFlexDiv);

	unset($projectsLines[0]);
	$projectsLines = array_values($projectsLines);

	foreach($projectsLines as $key => $line) {
		if(strpos($line, 'Break') === false) {
			$array = explode(SEMICOLON, $line);
			$projectLogo = trim($array[0]);
			$projectName = trim($array[1]);
			$projectDescription = trim($array[2]);
			$projectUrl = trim($array[3]);

			$projectInnerDiv = $dom->createElement('div');
			$projectInnerDiv->setAttribute('class', 'figure fade');
			$projectFlexDiv->appendChild($projectInnerDiv);

			$projectImage = $dom->createElement('img');
			$projectImage->setAttribute('alt', 'project-logo');
			$projectImage->setAttribute('src', $projectLogo);
			$projectInnerDiv->appendChild($projectImage);

			$projectDescriptionDiv = $dom->createElement('div');
			$projectDescriptionDiv->setAttribute('class', 'description');
			$projectInnerDiv->appendChild($projectDescriptionDiv);

			$projectNameHeader = $dom->createElement('h2', $projectName);
			$projectDescriptionDiv->appendChild($projectNameHeader);

			$projectDescriptionParagraph = $dom->createElement('p', $projectDescription);
			$projectDescriptionDiv->appendChild($projectDescriptionParagraph);

			$projectUrlAnchor = $dom->createElement('a', 'View Site');
			$projectUrlAnchor->setAttribute('class', 'info');
			$projectUrlAnchor->setAttribute('target', '_blank');
			$projectUrlAnchor->setAttribute('href', $projectUrl);
			$projectUrlAnchor->setAttribute('title', 'Click to visit site');
			$projectDescriptionDiv->appendChild($projectUrlAnchor);
		}
	}

	return $dom->saveHTML();
}

function getQualificationsLines() {
	global $qualificationsLines;
	$i = 1;
	foreach($qualificationsLines as $outerKey => $outerValue) {
		foreach($outerValue as $innerKey => $innerValue) {
			$increment = False;
			if($innerValue != 'Break' && $innerValue != 'Extra' && trim($innerValue) != '') {
				$finalQualificationsLines[$i][$innerKey] = $innerValue;
				$increment = True;
			}
		}
		$i = $increment ? $i + 1 : $i;
	}
	return $finalQualificationsLines;
}

function getName() {
	global $aboutLines;
	return $aboutLines[1];
}

function getLinkedInUrl() {
	global $linkedInUrl;
	return $linkedInUrl;
}

function getAboutLines() {
	global $aboutLines;
	return $aboutLines;
}

function getCareerLines() {
	global $careerLines;
	return $careerLines;
}

function getEducationLines() {
	global $educationLines;
	return $educationLines;
}

function getAwardsLines() {
	global $awardsLines;
	return $awardsLines;
}

function getEmploymentLines() {
	global $employmentLines;
	return $employmentLines;
}

function getProjectsLines() {
	global $projectsLines;
	return $projectsLines;
}

?>