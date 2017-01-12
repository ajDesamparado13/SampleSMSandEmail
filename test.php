<?php
require './assets/phpMailer/PHPMailerAutoLoad.php';


function send_email($recipient,$subject,$message)
{
/* SEND EMAIL THROUGH GMAIL SMTP USING PHPMailer*/

/* INITIALIZE PHPMailer*/
$mail=new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug=0;
$mail->Debugoutput='html';
$mail->Host="smtp.gmail.com";
$mail->Port=587;
$mail->SMTPSecure='tls';
$mail->SMTPAuth=true;

/* SET Mail Authentication*/
$mail->Username='aominedaiki9k@gmail.com';
$mail->Password="09224773759";
$mail->setFrom('aominedaiki9k@gmail.com','Aomine Daiki');

/* SET MAIL */
$mail->AddAddress($recipient);
$mail->IsHTML(true);
$mail->Subject=$subject;
$mail->Body=$message;



	if(!$mail->send())
	{
	echo " Email not sent,System encountered an error:".$mail->ErrorInfo;	
	}
	else
	{
		echo "Message Sent!";
	}
};

/*
SMS Gateway or SMS API Used:https://www.itexmo.com/php_api/api.php
APICODE:ALLEN983712_U21G8


*/


/* using CURL-LESS Method
use the SMS API by NON-CURL Method
*/
function itexmo($number,$message,$apicode){
$url = 'https://www.itexmo.com/php_api/api.php';
$itexmo = array('1' => $number, '2' => $message, '3' => $apicode);
$param = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($itexmo),
    ),
);
$context  = stream_context_create($param);
return file_get_contents($url, false, $context);}


/* using CURL
use the SMS API by CURL Method

function itexmo($number,$message,$apicode){
			$ch = curl_init();
			$itexmo = array('1' => $number, '2' => $message, '3' => $apicode);
			curl_setopt($ch, CURLOPT_URL,"https://www.itexmo.com/php_api/api.php");
			curl_setopt($ch, CURLOPT_POST, 1);
			 curl_setopt($ch, CURLOPT_POSTFIELDS, 
			          http_build_query($itexmo));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			return curl_exec ($ch);
			curl_close ($ch);
}*/

function send_message($number,$message)
{
	$result=itexmo($number,$message,"EVAND773759_WUET2");
	if ($result == ""){
	echo "iTexMo: No response from server!!!
	Please check the METHOD used (CURL or CURL-LESS). If you are using CURL then try CURL-LESS and vice versa.	
	Please CONTACT US for help. ";	
	}else if ($result == 0){
	echo "Message Sent!";
	}
	else{	
	echo "Error Num ". $result . " was encountered!";
	}
}

/*FUNCTION to print the form of sending the message*/
function print_form()
{
	echo'
	<form action="" method="post">
     <ul>
      <li>
       <label for="phoneNumber">Recipient</label>
       <input type="text" name="phoneNumber" id="phoneNumber" placeholder="09#########" />
	   </li>     
      <li>
	  <li>
       <label for="email">Recipient</label>
       <input type="text" name="email" id="email" placeholder="johnDoe@gmail.com" />
	   </li>     
      <li>
	   <li>
       <label for="subject">Subject</label>
       <input type="text" name="subject" id="subject" placeholder="Foo foo bar" />
	   </li>     
      <li>
       <label for="smsMessage">Message</label>
       <textarea name="smsMessage" id="smsMessage" cols="45" rows="15"></textarea>
      </li>
     <li><input type="submit" name="sendMessage" id="sendMessage" value="Send Message" /></li>
    </ul>
	
   </form>
	';
}
?>
<!DOCTYPE html>
 <head>
   <meta charset="utf-8" /> 
   <style>
    body {
     margin: 0;
     padding: 3em 0;
     color: #fff;
     background: #0080d2;
     font-family: Georgia, Times New Roman, serif;
    }
 
    #container {
     width: 600px;
     background: #fff;
     color: #555;
     border: 3px solid #ccc;
     -webkit-border-radius: 10px;
     -moz-border-radius: 10px;
     -ms-border-radius: 10px;
     border-radius: 10px;
     border-top: 3px solid #ddd;
     padding: 1em 2em;
     margin: 0 auto;
     -webkit-box-shadow: 3px 7px 5px #000;
     -moz-box-shadow: 3px 7px 5px #000;
     -ms-box-shadow: 3px 7px 5px #000;
     box-shadow: 3px 7px 5px #000;
    }
 
    ul {
     list-style: none;
     padding: 0;
    }
 
    ul > li {
     padding: 0.12em 1em
    }
 
    label {
     display: block;
     float: left;
     width: 130px;
    }
 
    input, textarea {
     font-family: Georgia, Serif;
    }
   </style>
  </head>
  <body>
   <div id="container">
    <h1>Sending SMS with PHP</h1>
	<?php
	
	if (isset($_POST['smsMessage']) && isset($_POST['phoneNumber'])) {
	  send_message($_POST['phoneNumber'],$_POST['smsMessage']);
	  if(isset($_POST['email']))
	  send_email($_POST['email'],$_POST['subject'],$_POST['smsMessage']);
	}
	else {
	  print_form();
	}
	
	?>
    
  </div>
 </body>
</html>