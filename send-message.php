<?php
	if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['subject']) || empty($_POST['phone']) || empty($_POST['email']) || empty($_POST['message'])){
		session_start();
		$_SESSION['validation_error'] = 'Please Give All Information';
		header("Location: contact-us.php");
	}else{
		if(!is_numeric($_POST['phone'])){
			session_start();
			$_SESSION['validation_error'] = 'Please Give A Valid Number';
			header("Location: contact-us.php");
		}else{
			if(isset($_POST['submit'])){
			 	$user_first_name = $_POST['first_name'];
			 	$user_last_name = $_POST['last_name'];
			 	$phone = $_POST['phone'];
			 	$user_email = $_POST['email'];
			 	$subject = $_POST['subject'];
			 	$user_message = $_POST['message'];

			 	$email_from = $user_email;
			 	$email_subject = $subject;
			 	$email_body = "Name: $user_first_name $user_last_name \n".
			 				"Phone No: $phone \n".
			 				"Email Id: $user_email \n".
			 				"User Message: $user_message. \n";
			 	$to_email = "shakhawat@bijoytech.com";
			 	$headers = "From: $email_from \r\n";
			 	$headers .= "Reply-To: $user_email\r\n";

			 	$secretKey = "6Lec0MwZAAAAAKpbCf-xAcXAW9UJXAM9otqz6ItJ";
			 	$responsekey = $_POST['g-recaptcha-response'];
			 	$UserIP = $_SERVER['REMOTE_ADDR'];
			 	$url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responsekey&remoteip=$UserIP";

			 	$response = file_get_contents($url);
			 	$response = json_decode($response);

				if($response->success){
					mail($to_email, $email_subject, $email_body, $headers);
					session_start();
					$_SESSION['success'] = 'Mail Send Successfully';
					header("Location: contact-us.php");
				}else{
					session_start();
					$_SESSION['error'] = 'Invalid Captcha, Please Try Again';
					header("Location: contact-us.php");
				}
			}
		}
		
	}
	
?>