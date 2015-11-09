<?php
//------------------------------------------------------------
// PREMIUM NEW MEMBERS IN LAST 24 HRS
//------------------------------------------------------------
// premium member count
$count_premium_24 = mysqli_query($conn, "SELECT COUNT(UserId) AS PremiumCount24 FROM users WHERE IsPremium = 1 AND PremiumStartDate BETWEEN SYSDATE() - INTERVAL 1 DAY AND SYSDATE()") 
or die($dataaccess_error);

if(mysqli_num_rows($count_premium_24) > 0)
{
	$row = mysqli_fetch_array($count_premium_24);
	$premium_count_24 = $row['PremiumCount24'];
	echo $premium_count_24;
}
else
{
	echo '0';	
}
?>