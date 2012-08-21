<?php
/**
 * Theme Name:     Webhooks to email
 * Description:    Send PadiAct leads details via webhooks to an email address of your choice
 * Author:         Alex Stoia
 * Author URI:     http://padiact.com/
 * Version:        1.0.0
 */


$send_to_email="your@email.com"; // replace with your email address
$email_subject="Padiact Webhooks Request"; // replace with email subject line
$email_from_name="PadiAct Lead";
$email_from_email="other@email.com"; //replace with an email address of your domain
$email_body="";

/**
 * Check if the request is from padiact
 * data comes from PadiAct in the following format: 
 * { "data": { "email": "claudiu@paditrack.com", "name": "Claudiu" }, "from": "padiact" }
 */
if(isset($_POST['from']) and  $_POST['from']=="padiact")
{
	$email=$_POST['data']['email']; unset($_POST['data']['email']);
	
	/**
	 * Create email body
	 */
	$email_body="Email:".$email."\n";
	foreach($_POST['data'] as $field_key => $field_value){
		$email_body.=$field_key.": ".$field_value."\n";
	}
	

	$headers =	"From: " . $email_from_name . " <" . $email_from_email . ">" ;
	
	mail($send_to_email, $email_subject, $email_body, $headers);
}
?>
