<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
	$name = strip_tags(trim($_POST["name"]));
	$body = trim($_POST["email-body"]);

	$pattern = "/^[A-Za-z.' -]*$/";
	if(!isset($email) OR empty($email) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    	http_response_code(400);
		echo "Please enter a valid email address!";	
		exit();
	} 
	else if(!isset($name) OR empty($name) OR !preg_match($pattern, $name)) {
    	http_response_code(400);
		echo "Please enter a valid name!";
		exit();
	}
	else if(!isset($body) OR empty($body)) {
    	http_response_code(400);
		echo "Please enter a valid email body!";
		exit();
	}

	$break = PHP_EOL . "<br>" . PHP_EOL . "<br>" . PHP_EOL;
	$to = "clucius@chandlerlucius.com";
	$subject = "Contact from website";

	$body_content = "<html><body>" . PHP_EOL;
    $body_content .= "<b>Name:</b> " . remove_injection($name) . $break;
    $body_content .= "<b>Email:</b> " . remove_injection($email) . $break;
    $body_content .= "<b>Message:</b> " . $break . remove_injection($body) . PHP_EOL;
	$body_content .= "</body></html>";

    $email_headers = "From: " . remove_injection($name) . " <" . remove_injection($email) . ">" . PHP_EOL;
    $email_headers .= "Sender: " . remove_injection($email) . PHP_EOL;
    $email_headers .= "Reply-To: " . remove_injection($name) . " <" . remove_injection($email) . ">" . PHP_EOL;
	$email_headers .= "Delivered-to: " . remove_injection($to) . PHP_EOL; 
	$email_headers .= "MIME-Version: 1.0" . PHP_EOL; 
	$email_headers .= "Content-Type: text/html; charset=iso-8859-1" . PHP_EOL; 
	$email_headers .= "X-Mailer: PHP/" . phpversion();

    if (mail($to, $subject, $body_content, $email_headers)) {
        http_response_code(200);
    	echo "Thank You! Your message has been sent.";
		exit();
    } else {
        http_response_code(500);
        echo "There was an error sending your message. Please try again later.";
		exit();
    }
} else {
    http_response_code(403);
    echo "There was a issue with your submission, please try again later.";
	exit();
}

function remove_injection($input) {
	$bad_chars = array("content-type","bcc:","to:","cc:","href");
	return str_replace($bad_chars, "", $input);
}
?>