<?php
if(!isset($_POST['et_builder_submit_button']))
{
	//This page should not be accessed directly. Need to submit the form.
	echo "error; you need to submit the form!";
}
  
$name = $_POST['et_pb_contact_name_2'];
$visitor_email = $_POST['et_pb_contact_email_2'];
$message = $_POST['et_pb_contact_message_2'];

//Validate first
if(empty($name)||empty($visitor_email)) 
{
    echo "Name and email are mandatory!";
    exit;
}
if(IsInjected($visitor_email))
{
    echo "Bad email value!";
    exit;
}

$email_from = 'hi@cloudtherapy.org';

$email_subject = "New Form submission";

$email_body = "You have received a new message from the user $name.\n".
                            "Here is the message:\n $message".
    
$to = "hi@cloudtherapy.org";//<== update the email address
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $visitor_email \r\n";

//Send the email!
mail($to,$email_subject,$email_body,$headers);
//done. redirect to thank-you page.
header('Location: thank-you.html');

// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}
        
?>