<?php

if(ENABLE_PREMIUM_MEMBERSHIP == 0)
{
	echo $premium_not_enabled;
}


$is_active_title = '';
$premium_level_title = '';
$premium_types_title = '';
$premium_start_title = '';
$premium_end_title = '';
$current_server_time_title = '';
$premium_amount_title = '';
$is_pending_title = '';
$pending_date_title = '';
$is_cancelled_title = '';
$cancelled_date_title = '.';
$is_end_of_term_title = '';
$eot_date_title = '';

$membership_types = '';


$sent_id = mysqli_real_escape_string($conn, $_GET['uid']);

if(isset($sent_id) && !empty($sent_id) && is_numeric($sent_id) && $sent_id > 0)
{
	$user_id = $sent_id;
	
	$get_premium_details = mysqli_query($conn, "SELECT NOW() as CurrentServerTime, IsPremium, PremiumType, PremiumStartDate, PremiumEndDate, PremiumAmount, IsPending, PendingDate, IsCancelled, CancelledDate, IsEndOfTerm, EndOfTermDate, PremiumLevel FROM users WHERE UserId = $user_id LIMIT 1")
	or die($dataaccess_error);
	
	if(mysqli_num_rows($get_premium_details) == 1)
	{
		$row = mysqli_fetch_array($get_premium_details);
		$current_server_time = $row['CurrentServerTime'];
		$is_premium = $row['IsPremium'];
		if($is_premium == 1){$checked1 = 'checked="checked"';}else{$checked1 = '';}
		$membership_type = $row['PremiumType'];
		$premium_start_date = $row['PremiumStartDate'];
		$premium_end_date = $row['PremiumEndDate'];
		$premium_amount = $row['PremiumAmount'];
		$is_pending = $row['IsPending'];
		if($is_pending == 1){$checked4 = 'checked="checked"';}else{$checked4 = '';}
		$pending_date = $row['PendingDate'];
		$is_cancelled = $row['IsCancelled'];
		if($is_cancelled == 1){$checked2 = 'checked="checked"';}else{$checked2 = '';}
		$cancelled_date = $row['CancelledDate'];
		$is_end_of_term = $row['IsEndOfTerm'];
		if($is_end_of_term == 1){$checked3 = 'checked="checked"';}else{$checked3 = '';}
		$eot_date = $row['EndOfTermDate'];
		$premium_level = $row['PremiumLevel'];
	}
}

$get_membership_types = mysqli_query($conn, "SELECT TypesId, Type FROM membership_types WHERE IsEnabled = 1 ORDER BY OrdinalPosition")
or die($dataaccess_error);

if(mysqli_num_rows($get_membership_types) > 0)
{
	while($row = mysqli_fetch_array($get_membership_types))
	{
		$value_id = $row["TypesId"];
		$value_label = $row["Type"];
		$membership_types .= '<option value="'.$value_label.'">'.$value_label.'</option>';
	}
}
?>