<?php
	// ------------------------------------------------------------
	// MESSAGES, ERROR MESSAGES AND ERROR CODES
	// ------------------------------------------------------------	
	// form error variables
	$emptyField_error = 0;
	$passwordMatch_error = 0;
	$emailValidate_error = 0;
	$pwMinRequirements_error = 0;
	
	// general banner error message
	
	// form error messages
	$password_error = "<li>PASSWORD and CONFIRM PASSWORD must match!</li>";
	$passwordLength_error = "<li>PASSWORD is TOO SHORT!</li>";
	$passwordNumber_error = "<li>PASSWORD MUST CONTAIN a NUMBER!</li>";
	$passwordSpecialChar_error = "<li>PASSWORD MUST CONTAIN a SPECIAL CHARACTER!</li>";
	$userName_error = "<li>USER NAME OR E-MAIL already EXIST!</li>";
	$checkUser_error = "<div class='msgBox1 noBorder'>ERROR: Oops! CHECK user FAILED!</div>";
	$createUser_error = "<div class='msgBox1 noBorder'>ERROR: Oops! CREATE user FAILED!</div>";
	$addUserToRole_error = "<div class='msgBox1 noBorder'>ERROR: Oops! ADDING user to default ROLE FAILED!</div>";
	$email_error = "<li>INCORRECT E-MAIL address!</li>";
	$emailMx_error = "<li>Oops! NOT a VALID E-MAIL address!</li>";
	
	// empty field error messages
	$EmptyUn_msg = "<li>Please enter your USER NAME!</li>";
	$EmptyCheckUn_msg = "<li>Please enter the desired USER NAME to CHECK for!</li>";
	$EmptyPw_msg = "<li>Please enter your PASSWORD!</li>";
	$EmptyConfirmPw_msg = "<li>Please confirm your PASSWORD!</li>";
	$EmptyEmail_msg = "<li>Please enter your E-MAIL!</li>";
	$EmptyQuestion_msg = "<li>Please enter your SECURITY QUESTION!</li>";
	$EmptyAnswer_msg = "<li>Please enter your SECURITY ANSWER!</li>";
	
	// confirmation messages
	$confirmEmail_msg = "<div class='msgBox3 noBorder'>THANK YOU! A CONFIRMATION E-MAIL has been sent to the NEW USER.</div>";
	$userNameAvailable_msg = "<li>User Name is AVAILABLE!</li>";
	$userNameNotAvailable_msg = "<li>User Name is ALREADY TAKEN!</li>";
	$userCreate_success_msg = "<div class='msgBox3 noBorder'>SUCCESS: USER ACCOUNT has been Created SUCCESSFULLY!</div>";
?>