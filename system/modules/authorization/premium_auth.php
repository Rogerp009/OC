<?php


$get_premium_info = mysqli_query($conn, "SELECT NOW() as CurrentTime, IsPremium, PremiumType, PremiumStartDate, PremiumEndDate, IsCancelled, CancelledDate, IsEndOfTerm, PremiumLevel FROM users WHERE UserName = '$premium_user_name' Limit 1") 
or die($dataaccess_error);

if(mysqli_num_rows($get_premium_info) == 1 )
{
	$row = mysqli_fetch_array($get_premium_info);
	$current_time = $row['CurrentTime'];
	$is_premium = $row['IsPremium'];
	$premium_type = $row['PremiumType'];
	$premium_start_date = $row['PremiumStartDate'];
	$premium_end_date = $row['PremiumEndDate'];
	$is_cancelled = $row['IsCancelled'];
	$cancelled_date = $row['CancelledDate'];
	$is_end_of_term = $row['IsEndOfTerm'];
	$user_premium_level = $row['PremiumLevel'];

	if($is_premium == 1 && strtotime($premium_end_date) < strtotime($current_time) || $is_premium == 0 && $premium_end_date != '0000-00-00 00:00:00' && strtotime($premium_end_date) < strtotime($current_time))
	{		
		$update_user_account = mysqli_query($conn, "UPDATE users SET IsPremium = 0, PremiumLevel = 0 WHERE UserName = '$premium_user_name'") 
		or die($dataaccess_error);
	}
	
	if($is_cancelled == 1 && strtotime($premium_end_date) < strtotime($current_time))
	{
		$update_user_account = mysqli_query($conn, "UPDATE users SET IsPremium = 0, PremiumType = 'Free Membership', PremiumStartDate = '0000-00-00 00:00:00', PremiumEndDate = '0000-00-00 00:00:00', PremiumAmount = 0.00, IsCancelled = 0, CancelledDate = '0000-00-00 00:00:00', IsEndOfTerm = 0, PremiumLevel = 0 WHERE UserName = '$premium_user_name'") 
		or die($dataaccess_error);
	}

	if($is_end_of_term == 1 && strtotime($premium_end_date) < strtotime($current_time))
	{
		$update_user_account = mysqli_query($conn, "UPDATE users SET IsPremium = 0, PremiumType = 'Free Membership', PremiumStartDate = '0000-00-00 00:00:00', PremiumEndDate = '0000-00-00 00:00:00', PremiumAmount = 0.00, IsCancelled = 0, CancelledDate = '0000-00-00 00:00:00', IsEndOfTerm = 0, PremiumLevel = 0 WHERE UserName = '$premium_user_name'") 
		or die($dataaccess_error);
	}
}
?>