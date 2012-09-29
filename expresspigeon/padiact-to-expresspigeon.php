<?php
/**
 * Theme Name:     Webhooks integration for ExpressPigeon email service provider
 * Description:    Send PadiAct leads directly to ExpressPigeon
 * Author:         Claudiu Murariu
 * Author URI:     http://padiact.com/
 * Version:        1.0.0
 */
 
/**
 * Check if the request is from padiact
*/ 
if(isset($_POST['from']) and  $_POST['from']=="padiact")
{
	//specify your list unique ID
	//replace XXXX with your own ID. Get it from your Express Pigeon account
    $expressPigeonFields = 'guid=XXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXX'; 
    
	$email=$_POST['data']['email']; unset($_POST['data']['email']);
    $expressPigeonFields.= '&email='.$email;

    //template for extra fields. Below is an example for first name. 
    //PadiAct allows for up to 4 extra fields (field1, field2, field3, field4)
    //Contact support@padiact.com for help
    if (isset($_POST['data']['field1']))
    {
       $field1=$_POST['data']['field1']; unset ($_POST['data']['field1']);
       $expressPigeonFields.= '&first_name='.$field1;
       //when field invalid by your standards just do
       //echo "<error>Reason for error</error>";
       //and the error will be displayed to user when subscribing
    }
    
        
    /**
	* Send data to ExpressPigeon
	*/
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);  
    curl_setopt($ch, CURLOPT_POSTFIELDS, $expressPigeonFields);
    curl_setopt($ch, CURLOPT_URL, 'https://expresspigeon.com/subscription/add_contact');
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  // this line makes it work under https
     
    
    $result = curl_exec($ch);
    curl_close($ch);
    /**
	* End sending data
	*/
}
?>

