<?php
// get required includes
require_once(ROOT_PATH.'connect/mysql.php');
require_once(ROOT_PATH.'admin/modules/email/error_messages.php');

// ------------------------------------------------------------
// GRIDVIEW JAVASCRIPT
// ------------------------------------------------------------
// buttons
$send_to_selected_js = "return confirm('E-MAIL selected users?');";
$send_with_credentials_js = "return confirm('Send E-MAIL with Credentials to SELECTED users?');";
$send_to_all_js = "return confirm('Send E-MAIL to ALL users?');";
$send_to_premium_js = "return confirm('Send E-MAIL to ALL Premium Members?');";
$send_to_all_with_credetials_js = "return confirm('Send E-MAIL to ALL users with Credentials?');";
// dropdown menu 
$send_to_selected_role_js = "if(confirm('E-MAIL ALL users in selected ROLE?'))form.submit();else return false;";
$send_to_selected_role_WC_js = "if(confirm('E-MAIL ALL users in selected ROLE with Credetials?'))form.submit();else return false;";
$send_to_subscribers_js = "if(confirm('Send E-MAIL to SELECTED SUBSCRIBERS?'))form.submit();else return false;";
// declare variables
$msg = '';

// ------------------------------------------------------------
// SEND EMAIL TO SELECTED USERS
// ------------------------------------------------------------
if(isset($_POST['btnSendToSelected']) && isset($_POST['checked']))
{
    $checked = array_map('intval',$_POST['checked']);
	$email_list = implode(", ", $checked);
	
	$get_emails = mysqli_query($conn, "SELECT Email FROM users WHERE UserId IN ($email_list)")
	or die($dataaccess_error);
	
	$emails = '';
	while($row = mysqli_fetch_array($get_emails))
	{
		$emails .= $row['Email'].',';
	}
	
	$email_list = rtrim($emails, ",");
	
	if(!empty($email_list))
	{
		$from_address = stripslashes($_POST['txbFrom']);
		$to = BULK_MAIL_TO;
		$bcc = $email_list;
		$subject = stripslashes($_POST['txbSubject']);
		$body = stripslashes( $_POST['FCKeditor1'] );
		$body_type = $_POST['rgpBodyTextType'];
		$priority = $_POST['rgpPriority'];
		
		if($body_type == 'html')
		{
			$message = '
			<html>
			<head>
				<title>'.$subject.'</title>
			</head>
			<body>
				'.$body.'
			</body> 
			</html>
			';
		}
		elseif($body_type == 'plain')
		{
			$message = $body;
		}
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/'.$body_type.'; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$subject.' <'.$from_address.'>' . "\r\n";
		$headers .= 'Bcc: '.$bcc.'' . "\r\n";
		$headers .= 'X-Priority: '.$priority.'' . "\r\n";
		
		$send_mail = mail($to, $subject, $message, $headers);
		
		if($send_mail)
		{
			$msg = $confirmEmail_msg;
		}
		else
		{
			$msg = $msg_send_error;
		}
	}
	else
	{
		$msg = $msg_not_found_error;
	}
}
elseif(isset($_POST['btnSendToSelected']) && !isset($_POST['checked']))
{
	$msg = $msg_error;
}

// ------------------------------------------------------------
// SEND EMAIL TO ALL USERS
// ------------------------------------------------------------
if(isset($_POST['btnSendToAll']))
{
	$get_emails = mysqli_query($conn, "SELECT Email FROM users")
	or die($dataaccess_error);
	
	$emails = '';
	while($row = mysqli_fetch_array($get_emails))
	{
		$emails .= $row['Email'].',';
	}
	
	$email_list = rtrim($emails, ",");
	
	if(!empty($email_list))
	{
		$from_address = stripslashes($_POST['txbFrom']);
		$to = BULK_MAIL_TO;
		$bcc = $email_list;
		$subject = stripslashes($_POST['txbSubject']);
		$body = stripslashes( $_POST['FCKeditor1'] );
		$body_type = $_POST['rgpBodyTextType'];
		$priority = $_POST['rgpPriority'];
		
		if($body_type == 'html')
		{
			$message = '
			<html>
			<head>
				<title>'.$subject.'</title>
			</head>
			<body>
				'.$body.'
			</body> 
			</html>
			';
		}
		elseif($body_type == 'plain')
		{
			$message = $body;
		}
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/'.$body_type.'; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$subject.' <'.$from_address.'>' . "\r\n";
		$headers .= 'Bcc: '.$bcc.'' . "\r\n";
		$headers .= 'X-Priority: '.$priority.'' . "\r\n";
		
		$send_mail = mail($to, $subject, $message, $headers);
		
		if($send_mail)
		{
			$msg = $confirmEmail_msg;
		}
		else
		{
			$msg = $msg_send_error;
		}
	}
	else
	{
		$msg = $msg_not_found_error;
	}
}

// ------------------------------------------------------------
// SEND EMAIL TO ALL USERS IN SELECTED ROLE
// ------------------------------------------------------------
if(isset($_POST['ddlSendToSelected']) && $_POST['ddlSendToSelected'] != 'Send To Role')
{
	$selected_role = mysqli_real_escape_string($conn, $_POST['ddlSendToSelected']);
	
	$get_user_ids = mysqli_query($conn, "SELECT UserId FROM users_in_roles WHERE RoleName = '$selected_role'")
	or die($dataaccess_error);
	
	$emails = '';
	while($row = mysqli_fetch_array($get_user_ids))
	{
		$user_ids = $row['UserId'];
		$get_emails = mysqli_query($conn, "SELECT Email FROM users WHERE UserId IN ($user_ids)")
		or die($dataaccess_error);
		
		$row = mysqli_fetch_array($get_emails);
		$emails .= $row['Email'].',';
	}
	
	$email_list = rtrim($emails, ",");
	
	if(!empty($email_list))
	{
		$from_address = stripslashes($_POST['txbFrom']);
		$to = BULK_MAIL_TO;
		$bcc = $email_list;
		$subject = stripslashes($_POST['txbSubject']);
		$body = stripslashes( $_POST['FCKeditor1'] );
		$body_type = $_POST['rgpBodyTextType'];
		$priority = $_POST['rgpPriority'];
		
		if($body_type == 'html')
		{
			$message = '
			<html>
			<head>
				<title>'.$subject.'</title>
			</head>
			<body>
				'.$body.'
			</body> 
			</html>
			';
		}
		elseif($body_type == 'plain')
		{
			$message = $body;
		}
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/'.$body_type.'; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$subject.' <'.$from_address.'>' . "\r\n";
		$headers .= 'Bcc: '.$bcc.'' . "\r\n";
		$headers .= 'X-Priority: '.$priority.'' . "\r\n";
		
		$send_mail = mail($to, $subject, $message, $headers);
		
		if($send_mail)
		{
			$msg = $confirmEmail_msg;
		}
		else
		{
			$msg = $msg_send_error;
		}
	}
	else
	{
		$msg = $msg_not_found_error;
	}
}

// ------------------------------------------------------------
// SEND EMAIL TO SELECTED SUBSCRIBERS
// ------------------------------------------------------------
if(isset($_POST['ddlSendToSubscribers']) && $_POST['ddlSendToSubscribers'] != 'Send To Subscribers')
{
	$selected_subscribers = mysqli_real_escape_string($conn, $_POST['ddlSendToSubscribers']);
	
	// if selection = Newsletter
	if($selected_subscribers == 'Newsletter')
	{
		$get_user_ids = mysqli_query($conn, "SELECT UserId FROM profiles WHERE Newsletter = 1")
		or die($dataaccess_error);
		
		$emails = '';
		while($row = mysqli_fetch_array($get_user_ids))
		{
			$user_ids = $row['UserId'];
			$get_emails = mysqli_query($conn, "SELECT Email FROM users WHERE UserId IN ($user_ids)")
			or die($dataaccess_error);
			
			$row = mysqli_fetch_array($get_emails);
			$emails .= $row['Email'].',';
		}
		
		$email_list = rtrim($emails, ",");
		
		if(!empty($email_list))
		{
			$from_address = stripslashes($_POST['txbFrom']);
			$to = BULK_MAIL_TO;
			$bcc = $email_list;
			$subject = stripslashes($_POST['txbSubject']);
			$body = stripslashes( $_POST['FCKeditor1'] );
			$body_type = $_POST['rgpBodyTextType'];
			$priority = $_POST['rgpPriority'];
			
			if($body_type == 'html')
			{
				$message = '
				<html>
				<head>
					<title>'.$subject.'</title>
				</head>
				<body>
					'.$body.'
				</body> 
				</html>
				';
			}
			elseif($body_type == 'plain')
			{
				$message = $body;
			}
			
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/'.$body_type.'; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: '.$subject.' <'.$from_address.'>' . "\r\n";
			$headers .= 'Bcc: '.$bcc.'' . "\r\n";
			$headers .= 'X-Priority: '.$priority.'' . "\r\n";
			
			$send_mail = mail($to, $subject, $message, $headers);
			
			if($send_mail)
			{
				$msg = $confirmEmail_msg;
			}
			else
			{
				$msg = $msg_send_error;
			}
		}
		else
		{
			$msg = $msg_not_found_error;
		}
	}
	
	// if selection = Promotional Offer
	if($selected_subscribers == 'Promotional Offer')
	{
		$get_user_ids = mysqli_query($conn, "SELECT UserId FROM profiles WHERE Promotion = 1")
		or die($dataaccess_error);
		
		$emails = '';
		while($row = mysqli_fetch_array($get_user_ids))
		{
			$user_ids = $row['UserId'];
			$get_emails = mysqli_query($conn, "SELECT Email FROM users WHERE UserId IN ($user_ids)")
			or die($dataaccess_error);
			
			$row = mysqli_fetch_array($get_emails);
			$emails .= $row['Email'].',';
		}
		
		$email_list = rtrim($emails, ",");
		
		if(!empty($email_list))
		{
			$from_address = stripslashes($_POST['txbFrom']);
			$to = BULK_MAIL_TO;
			$bcc = $email_list;
			$subject = stripslashes($_POST['txbSubject']);
			$body = stripslashes( $_POST['FCKeditor1'] );
			$body_type = $_POST['rgpBodyTextType'];
			$priority = $_POST['rgpPriority'];
			
			if($body_type == 'html')
			{
				$message = '
				<html>
				<head>
					<title>'.$subject.'</title>
				</head>
				<body>
					'.$body.'
				</body> 
				</html>
				';
			}
			elseif($body_type == 'plain')
			{
				$message = $body;
			}
			
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/'.$body_type.'; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: '.$subject.' <'.$from_address.'>' . "\r\n";
			$headers .= 'Bcc: '.$bcc.'' . "\r\n";
			$headers .= 'X-Priority: '.$priority.'' . "\r\n";
			
			$send_mail = mail($to, $subject, $message, $headers);
			
			if($send_mail)
			{
				$msg = $confirmEmail_msg;
			}
			else
			{
				$msg = $msg_send_error;
			}
		}
		else
		{
			$msg = $msg_not_found_error;
		}
	}
}

// ------------------------------------------------------------
// SEND EMAIL TO ALL PREMIUM MEMBERS
// ------------------------------------------------------------
if(isset($_POST['btnSendToPremium']))
{
	$get_emails = mysqli_query($conn, "SELECT Email FROM users WHERE IsPremium = 1")
	or die($dataaccess_error);
	
	$emails = '';
	while($row = mysqli_fetch_array($get_emails))
	{
		$emails .= $row['Email'].',';
	}
	
	$email_list = rtrim($emails, ",");
	
	if(!empty($email_list))
	{
		$from_address = stripslashes($_POST['txbFrom']);
		$to = BULK_MAIL_TO;
		$bcc = $email_list;
		$subject = stripslashes($_POST['txbSubject']);
		$body = stripslashes( $_POST['FCKeditor1'] );
		$body_type = $_POST['rgpBodyTextType'];
		$priority = $_POST['rgpPriority'];
		
		if($body_type == 'html')
		{
			$message = '
			<html>
			<head>
				<title>'.$subject.'</title>
			</head>
			<body>
				'.$body.'
			</body> 
			</html>
			';
		}
		elseif($body_type == 'plain')
		{
			$message = $body;
		}
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/'.$body_type.'; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$subject.' <'.$from_address.'>' . "\r\n";
		$headers .= 'Bcc: '.$bcc.'' . "\r\n";
		$headers .= 'X-Priority: '.$priority.'' . "\r\n";
		
		$send_mail = mail($to, $subject, $message, $headers);
		
		if($send_mail)
		{
			$msg = $confirmemail_msg;
		}
		else
		{
			$msg = $msg_send_error;
		}
	}
	else
	{
		$msg = $msg_not_found_error;
	}
}
?>