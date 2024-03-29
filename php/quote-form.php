<?php
/*
Name: 			Contact Form
Written by: 	Okler Themes - (http://www.okler.net)
Theme Version:	7.5.0
*/

namespace PortoContactForm;

session_cache_limiter('nocache');
header('Expires: ' . gmdate('r', 0));

header('Content-type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'php-mailer/src/PHPMailer.php';
require 'php-mailer/src/SMTP.php';
require 'php-mailer/src/Exception.php';

// Step 1 - Enter your email address below.
$email = 'daphneavril@outlook.com';
// $email = 'admin@rumaenergies.co.za';

// If the e-mail is not working, change the debug option to 2 | $debug = 2;
$debug = 0;

// If contact form don't has the subject input change the value of subject here
$subject = (isset($_POST['subject'])) ? $_POST['subject'] : 'Quotation Request';

$message = '';

$fields = array(
	0 => array(
		'text' => 'Name',
		'val' => $_POST['name']
	),
	1 => array(
		'text' => 'Email',
		'val' => $_POST['email']
	),
	2 => array(
		'text' => 'Phone',
		'val' => $_POST['phone']
	),
	3 => array(
		'text' => 'Delivery Address',
		'val' => $_POST['address']
	),
	4 => array(
		'text' => 'Do you own a filling station?',
		'val' => $_POST['radios']
	),
	5 => array(
		'text' => 'What is your industry?',
		'val' => $_POST['industry']
	),
	6 => array(
		'text' => 'Bulk Petrol',
		'val' => $_POST['bulk-petrol']
	),
	7 => array(
		'text' => 'Bulk Diesel',
		'val' => $_POST['bulk-diesel']
	),
	8 => array(
		'text' => 'Bulk Jet A1',
		'val' => $_POST['bulk-jet-a1']
	),
	9 => array(
		'text' => 'Bulk	IL Paraffin',
		'val' => $_POST['bulk-il-paraffin']
	),
	10 => array(
		'text' => 'Bulk AVGAS',
		'val' => $_POST['bulk-avgas']
	),
	11 => array(
		'text' => 'Bulk LP GAS',
		'val' => $_POST['bulk-lpg']
	),
	12 => array(
		'text' => 'Additional Information',
		'val' => $_POST['message']
	)
);

foreach ($fields as $field) {
	$message .= $field['text'] . ": " . htmlspecialchars($field['val'], ENT_QUOTES) . "<br>\n";
}




// foreach($_POST as $label => $value) {
// 	$label = ucwords($label);

// 	// Use the commented code below to change label texts. On this example will change "Email" to "Email Address"

// 	// if( $label == 'Email' ) {               
// 	// 	$label = 'Email Address';              
// 	// }

// Radio buttons
// if (isset($_POST['radio'])) {
// 	$value = "Do you own a filling station? " . $_POST['radio'];
// }

// if (is_array($value)) {
// 	// Store new value
// 	$value = implode(', ', $value);
// }

// 	$message .= $label.": " . htmlspecialchars($value, ENT_QUOTES) . "<br>\n";
// }

$mail = new PHPMailer(true);

try {

	$mail->SMTPDebug = $debug;                                 // Debug Mode

	// Step 2 (Optional) - If you don't receive the email, try to configure the parameters below:

	//$mail->IsSMTP();                                         // Set mailer to use SMTP
	//$mail->Host = 'mail.yourserver.com';				       // Specify main and backup server
	//$mail->SMTPAuth = true;                                  // Enable SMTP authentication
	//$mail->Username = 'user@example.com';                    // SMTP username
	//$mail->Password = 'secret';                              // SMTP password
	//$mail->SMTPSecure = 'tls';                               // Enable encryption, 'ssl' also accepted
	//$mail->Port = 587;   								       // TCP port to connect to

	$mail->AddAddress($email);	 						       // Add another recipient

	//$mail->AddAddress('person2@domain.com', 'Person 2');     // Add a secondary recipient
	//$mail->AddCC('person3@domain.com', 'Person 3');          // Add a "Cc" address. 
	//$mail->AddBCC('person4@domain.com', 'Person 4');         // Add a "Bcc" address. 

	// From - Name
	$fromName = (isset($_POST['name'])) ? $_POST['name'] : 'Website User';
	$mail->SetFrom($email, $fromName);

	// Repply To
	if (isset($_POST['email'])) {
		$mail->AddReplyTo($_POST['email'], $fromName);
	}

	$mail->IsHTML(true);                                       // Set email format to HTML

	$mail->CharSet = 'UTF-8';

	$mail->Subject = $subject;
	$mail->Body    = $message;

	$mail->Send();
	$arrResult = array('response' => 'success');
} catch (Exception $e) {
	$arrResult = array('response' => 'error', 'errorMessage' => $e->errorMessage());
} catch (\Exception $e) {
	$arrResult = array('response' => 'error', 'errorMessage' => $e->getMessage());
}

if ($debug == 0) {
	echo json_encode($arrResult);
}
