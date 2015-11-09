<?php
$latestLogins = mysqli_query($conn, "SELECT UserId, UserName, LastLoginDate FROM users WHERE LastLoginDate != '0000-00-00 00:00:00' ORDER BY LastLoginDate DESC LIMIT 5")
or die($dataaccess_error);

if(mysqli_num_rows($latestLogins) > 0)
{
	while($row = mysqli_fetch_array($latestLogins))
	{
		echo '<li><a href=""><span class="col1">'.$row["UserName"].'</span><span class="col2">'.$row["LastLoginDate"].'</span></a></li>';
	}
}
else
{
	$noresults = 'No results found...';
	echo $noresults;
}
?>